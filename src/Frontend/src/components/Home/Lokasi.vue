<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import {
  ElButton,
  ElCard,
  ElIcon,
  ElInput,
  ElMessage,
  ElLoading
} from 'element-plus'
import {
  Location,
  Edit,
  Loading
} from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css'

// Import your API instance
import api from '../../api.js' // Assuming api.js exports an Axios instance

// Data lokasi
const locationInfo = ref({
  name: 'Memuat data...', // Default loading state text
  address: 'Memuat data...',
  lat: -6.175110993816788, // Default fallback coordinates (e.g., Monas)
  lng: 106.82914107499008,
  isEditing: false
})

// Loading states
const isLoading = ref(true)
const isSaving = ref(false)
const searchQuery = ref(''); // For the search input field

// State for map
const mapContainer = ref(null)
let map = null
let marker = null

// Load Leaflet library dynamically
const loadLeaflet = () => {
  return new Promise((resolve, reject) => {
    // Check if Leaflet is already loaded to prevent multiple loads
    if (window.L) {
      resolve(window.L)
      return
    }

    // Load CSS
    const cssLink = document.createElement('link')
    cssLink.rel = 'stylesheet'
    cssLink.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css'
    cssLink.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY='
    cssLink.crossOrigin = ''
    document.head.appendChild(cssLink)

    // Load JS
    const script = document.createElement('script')
    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js'
    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo='
    script.crossOrigin = ''
    script.async = true
    script.defer = true
    script.onload = () => {
      // Fix for default markers to ensure they display correctly
      delete window.L.Icon.Default.prototype._getIconUrl
      window.L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
      })
      resolve(window.L)
    }
    script.onerror = () => reject(new Error('Gagal memuat Leaflet'))
    document.head.appendChild(script)
  })
}

// Initialize map
const initMap = async () => {
  try {
    // Ensure Leaflet library is loaded before initializing map
    await loadLeaflet()
    
    // Check if map container is available in the DOM
    if (!mapContainer.value) {
      console.warn('Map container element not found.')
      return
    }

    // If map already exists, do not re-initialize (important for avoiding errors)
    if (map) {
      console.log('Map already initialized.')
      return
    }

    // Create map instance, attaching to the ref'd DOM element
    map = window.L.map(mapContainer.value, {
      zoomControl: true,
      scrollWheelZoom: true,
      doubleClickZoom: true,
      boxZoom: true,
      keyboard: true,
      dragging: true,
      touchZoom: true
    }).setView([locationInfo.value.lat, locationInfo.value.lng], 15) // Set initial view

    // Add OpenStreetMap tile layer
    window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19
    }).addTo(map)

    // Create custom marker icon for view mode (pink)
    const viewIcon = window.L.divIcon({
      html: `
        <div style="
          width: 30px;
          height: 30px;
          background: #ec4899; /* Pink color */
          border: 3px solid white;
          border-radius: 50%;
          box-shadow: 0 2px 8px rgba(0,0,0,0.3);
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
        ">
          <div style="
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
          "></div>
        </div>
      `,
      className: 'custom-marker', // Class for general styling
      iconSize: [30, 30],
      iconAnchor: [15, 15] // Anchor point for the icon
    })

    // Add initial marker to the map
    marker = window.L.marker([locationInfo.value.lat, locationInfo.value.lng], {
      icon: viewIcon, // Start with view icon
      draggable: false // Not draggable by default
    }).addTo(map)

    // Add click listener to the map for placing marker in edit mode
    map.on('click', (e) => {
      // Only allow clicks to update location if in edit mode
      if (locationInfo.value.isEditing) {
        updateLocationFromClick(e.latlng)
      }
    })

    // Add marker drag listener to update location after dragging
    marker.on('dragend', (e) => {
      // Only allow dragging to update location if in edit mode
      if (locationInfo.value.isEditing) {
        updateLocationFromClick(e.target.getLatLng())
      }
    })

  } catch (error) {
    console.error('Error initializing Leaflet map:', error)
    ElMessage.error(`Gagal memuat peta: ${error.message}`)
  }
}

// Update location from map click or marker drag
const updateLocationFromClick = async (latlng) => {
  const lat = latlng.lat
  const lng = latlng.lng

  // Update marker position and center map
  marker.setLatLng([lat, lng])
  map.panTo([lat, lng])

  // Update location data in the reactive ref
  locationInfo.value.lat = lat
  locationInfo.value.lng = lng

  // Reverse geocoding using Nominatim API (OpenStreetMap)
  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`,
      {
        headers: {
          'User-Agent': 'VueLocationPicker/1.0' // Required for Nominatim
        }
      }
    )
    
    if (response.ok) {
      const data = await response.json()
      
      if (data && data.display_name) {
        locationInfo.value.address = data.display_name
        
        // Attempt to get a more specific place name if available
        if (data.name) {
          locationInfo.value.name = data.name
        } else if (data.address) {
          // Fallback to various address components for the name
          const placeName = data.address.building || 
                             data.address.shop || 
                             data.address.amenity || 
                             data.address.tourism ||
                             data.address.office ||
                             (data.address.house_number ? `${data.address.house_number} ${data.address.road || ''}` : '')
          if (placeName) {
            locationInfo.value.name = placeName.trim()
          }
        }
      }
      
      ElMessage.success('Lokasi berhasil diperbarui dari peta!')
    } else {
      throw new Error('Failed to get address information from Nominatim')
    }
  } catch (error) {
    console.error('Geocoding error:', error)
    ElMessage.warning('Coordinates updated successfully, but failed to get address.')
  }
}

// Function to fetch location data from backend
// Fungsi baru: menyesuaikan format response berupa array
const fetchLocation = async () => {
  isLoading.value = true;
  try {
    // 1. Panggil API
    const result = await api.get('/data/lokasi');
    // Jika result adalah objek penuh axios: 
    //    const resp = result.data;
    // Jika result sudah data array (wrapper): 
    //    const resp = result;
    const resp = Array.isArray(result) ? result : result.data ?? [];

    console.log('🛠️ [fetchLocation] resp =', resp);

    // 2. Tangani response berupa array
    const arr = Array.isArray(resp) ? resp : [];

    if (arr.length === 0) {
      console.warn('⚠️ [fetchLocation] Array lokasi kosong:', arr);
      ElMessage.warning('Data lokasi dari API kosong.');
      return;
    }

    // 3. Ambil item pertama
    const item = arr[0];
    locationInfo.value.name    = item.nama_lokasi;
    locationInfo.value.address = item.alamat;
    locationInfo.value.lat     = parseFloat(item.latitude);
    locationInfo.value.lng     = parseFloat(item.longitude);

    // 4. Update map & marker jika sudah inisialisasi
    if (map && marker) {
      marker.setLatLng([locationInfo.value.lat, locationInfo.value.lng]);
      map.setView([locationInfo.value.lat, locationInfo.value.lng], 15);
    }
    
  } catch (err: any) {
    // Tangani semua error (HTTP/CORS/parsing) di sini
    console.error('❌ [fetchLocation] error =', err);
    if (err.response) {
      ElMessage.error(`Gagal mengambil data lokasi: server respons ${err.response.status}.`);
    } else {
      ElMessage.error(`Error saat memproses data lokasi: ${err.message}`);
    }
  } finally {
    isLoading.value = false;
  }
};




// Function to save location data to backend
const saveLocation = async () => {
  isSaving.value = true;
  try {
    const payload = {
      nama_lokasi: locationInfo.value.name,
      alamat: locationInfo.value.address,
      latitude: locationInfo.value.lat,
      longitude: locationInfo.value.lng,
    };
    const response = await api.post('/data/lokasi', payload);
    if (response.data && response.data.message) {
      ElMessage.success(response.data.message);
    } else {
      ElMessage.success('Location saved successfully!');
    }
    locationInfo.value.isEditing = false; // Exit edit mode on successful save
    // Ensure marker state is reset to non-draggable if still in edit mode due to this toggle
    if (marker && marker.dragging.enabled()) {
      marker.setIcon(window.L.divIcon({
        html: `
          <div style="
            width: 30px;
            height: 30px;
            background: #ec4899; /* Pink color for view mode */
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
          ">
            <div style="
              width: 8px;
              height: 8px;
              background: white;
              border-radius: 50%;
            "></div>
          </div>
        `,
        className: 'custom-marker',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
      }))
      marker.dragging.disable();
    }

  } catch (error) {
    console.error('Error saving location data:', error);
    if (error.response && error.response.data && error.response.data.errors) {
      // Display specific validation errors from backend
      const errorMessages = Object.values(error.response.data.errors).flat().join('; ');
      ElMessage.error(`Failed to save location: ${errorMessages}`);
    } else {
      ElMessage.error('Failed to save location. Please try again.');
    }
  } finally {
    isSaving.value = false;
  }
}

// Toggle edit mode
const toggleEditLocation = () => {
  if (locationInfo.value.isEditing) {
    // If currently in edit mode and edit button is clicked again, it means 'Cancel'
    locationInfo.value.isEditing = false; 
    ElMessage.info('Edit mode deactivated without saving.');
    // Reset marker to view icon and disable dragging if it was left in edit mode
    if (marker) {
      marker.setIcon(window.L.divIcon({
        html: `
          <div style="
            width: 30px;
            height: 30px;
            background: #ec4899; /* Pink color for view mode */
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
          ">
            <div style="
              width: 8px;
              height: 8px;
              background: white;
              border-radius: 50%;
            "></div>
          </div>
        `,
        className: 'custom-marker',
        iconSize: [30, 30],
        iconAnchor: [15, 15]
      }));
      marker.dragging.disable();
    }
  } else {
    // If currently in view mode, enter edit mode
    locationInfo.value.isEditing = true;
    ElMessage.info('Edit mode active. Click on the map or drag the marker to select a new location.');
    // Make marker draggable and update icon to edit style (green)
    if (marker) {
      marker.setIcon(window.L.divIcon({
        html: `
          <div style="
            width: 30px;
            height: 30px;
            background: #10b981; /* Green color for edit mode */
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: move; /* Indicate draggable */
          ">
            <div style="
              width: 8px;
              height: 8px;
              background: white;
              border-radius: 50%;
            "></div>
          </div>
        `,
        className: 'custom-marker-edit', // Class for edit styling
        iconSize: [30, 30],
        iconAnchor: [15, 15]
      }))
      marker.dragging.enable() // Enable dragging
    }
    // Invalidate map size to ensure it re-renders correctly after potential container resizing
    if (map) {
      map.invalidateSize();
    }
  }
}

// Search location by name using Nominatim
const searchLocation = async (query) => {
  if (!query.trim()) {
    ElMessage.warning('Please enter a location name to search.')
    return
  }

  // Ensure map is in edit mode for search functionality to be useful
  if (!locationInfo.value.isEditing) {
    ElMessage.warning('Activate edit mode to search and update location.')
    return;
  }

  try {
    const response = await fetch(
      `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&addressdetails=1`,
      {
        headers: {
          'User-Agent': 'VueLocationPicker/1.0' // Required for Nominatim
        }
      }
    )

    if (response.ok) {
      const data = await response.json()
      
      if (data && data.length > 0) {
        const place = data[0]
        const lat = parseFloat(place.lat)
        const lng = parseFloat(place.lon)
        
        // Update location data in the reactive ref
        locationInfo.value.lat = lat
        locationInfo.value.lng = lng
        locationInfo.value.address = place.display_name
        locationInfo.value.name = place.name || query // Use found name or search query

        // Update map view and marker position if map is initialized
        if (map && marker) {
          marker.setLatLng([lat, lng])
          map.setView([lat, lng], 15) // Center map on new location with zoom
        }
        
        ElMessage.success('Location found and map updated!')
      } else {
        ElMessage.warning('Location not found.')
      }
    } else {
      throw new Error(`Error: ${response.status} ${response.statusText}`)
    }
  } catch (error) {
    console.error('Search error:', error)
    ElMessage.error(`Location search failed: ${error.message}`)
  }
}

// Lifecycle hook: initialize AOS and map, then fetch location data
onMounted(async () => {
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true, // Only run animation once
    offset: 100, // Offset (in px) from the top of the screen to trigger animation
    delay: 0 // Delay (in ms) before animation starts
  })

  // First, fetch the initial location data
  await fetchLocation();

  // Then, ensure DOM is updated and initialize the map using the fetched data
  await nextTick();
  await initMap();
})
</script>

<template>
  <div class="location-container">
    <div class="section-header" data-aos="fade-up">
      <h2 class="section-title">Lokasi Kami</h2>
      <p class="section-subtitle">
        Temukan lokasi pusat layanan kami di sini
      </p>
    </div>
    
    <ElCard class="location-card" data-aos="zoom-in" data-aos-delay="100">
      <!-- v-loading applied to the div wrapping card content to cover it during loading -->
      <div v-loading="isLoading" class="loading-overlay">
        <div class="location-header">
          <h3>{{ locationInfo.name }}</h3>
          <ElButton 
            :icon="Edit" 
            circle 
            @click="toggleEditLocation" 
            class="edit-button"
            :type="locationInfo.isEditing ? 'primary' : 'default'"
            :loading="isSaving"
          >
            <template #loading>
              <ElIcon class="is-loading"><Loading /></ElIcon>
            </template>
          </ElButton>
        </div>
        
        <div class="location-details">
          <!-- Map Container: ALWAYS RENDERED, position it where appropriate -->
          <div class="map-container" :class="{ 'interactive-map': locationInfo.isEditing }">
            <div ref="mapContainer" class="leaflet-map"></div>
          </div>

          <!-- Edit Mode UI: Conditionally rendered -->
          <div v-if="locationInfo.isEditing" class="location-edit-mode mt-4">
            <div class="edit-instructions">
              <p>🗺️ Klik pada peta atau drag marker untuk memilih lokasi baru</p>
            </div>
            
            <ElInput
              v-model="locationInfo.name"
              placeholder="Nama Lokasi"
              class="mb-3"
            />
            
            <ElInput
              v-model="locationInfo.address"
              type="textarea"
              :rows="2"
              placeholder="Alamat Lokasi"
              class="mb-3"
            />
            
            <div class="coordinates-display">
              <span>📍 Koordinat: {{ locationInfo.lat.toFixed(6) }}, {{ locationInfo.lng.toFixed(6) }}</span>
            </div>
            
            <!-- Search input for location search -->
            <ElInput
              placeholder="Cari lokasi baru..."
              v-model="searchQuery"
              class="mb-3"
              @keyup.enter="searchLocation(searchQuery)"
            >
              <template #append>
                <ElButton :icon="Location" @click="searchLocation(searchQuery)">Cari</ElButton>
              </template>
            </ElInput>

            <div class="edit-actions">
              <ElButton type="primary" @click="saveLocation" :loading="isSaving">Simpan</ElButton>
              <ElButton @click="locationInfo.isEditing = false">Batal</ElButton>
            </div>
          </div>
          
          <!-- View Mode UI: Conditionally rendered -->
          <div v-else class="mt-4">
            <p class="location-address">
              <ElIcon><Location /></ElIcon> {{ locationInfo.address }}
            </p>
          </div>
        </div>
      </div>
    </ElCard>
  </div>
</template>

<style scoped>
/* Header Section */
.section-header {
  text-align: center;
  margin-bottom: 4rem;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 1rem;
}

.section-subtitle {
  font-size: 1.1rem;
  color: #64748b;
  font-weight: 400;
  max-width: 600px;
  margin: 0 auto;
}

/* Location Card Styles */
.location-card {
  border-radius: 20px;
  padding: 2.5rem 2rem;
  border: none;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  height: 100%;
}

/* Loading Overlay */
.loading-overlay {
  position: relative; /* Needed for v-loading directive */
  min-height: 200px; /* Ensure content doesn't collapse during loading */
}

.location-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.location-header h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1e293b;
}

.location-address {
  font-size: 1rem;
  color: #475569;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
}

.location-address .el-icon {
  font-size: 1.25rem;
  color: #ec4899;
  margin-top: 0.15rem;
}

/* Map Container */
.map-container {
  width: 100%;
  height: 300px; /* Fixed height for the map */
  overflow: hidden;
  border-radius: 12px;
  border: 2px solid #e2e8f0;
  margin-bottom: 1rem; /* Add margin below map */
}

.leaflet-map {
  width: 100%;
  height: 100%;
  border-radius: 10px;
}

.interactive-map {
  cursor: crosshair;
  border-color: #ec4899; /* Pink border when in edit mode */
  transition: border-color 0.3s ease;
}

/* Edit Mode Styles */
.location-edit-mode .el-input,
.location-edit-mode .el-textarea {
  margin-bottom: 1rem;
}

.edit-instructions {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  color: white;
  padding: 1rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
  text-align: center;
}

.edit-instructions p {
  margin: 0;
  font-weight: 500;
}

.coordinates-display {
  background: #f8fafc;
  padding: 0.75rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  font-family: 'Courier New', monospace;
  font-size: 0.9rem;
  color: #475569;
  border-left: 4px solid #ec4899;
}

.edit-actions {
  margin-top: 1.5rem;
  display: flex;
  gap: 1rem;
  justify-content: center;
}

/* Custom marker styles */
/* Using :deep() to target Leaflet's dynamically created elements */
:deep(.custom-marker) {
  border: none !important;
  background: transparent !important;
}

:deep(.custom-marker-edit) {
  border: none !important;
  background: transparent !important;
}

/* Utilities */
.mb-3 {
  margin-bottom: 1rem;
}

.mt-4 {
  margin-top: 1.5rem;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .section-title {
    font-size: 2rem;
  }

  .section-subtitle {
    font-size: 1rem;
  }

  .location-card {
    padding: 2rem 1.5rem;
  }
}

@media (max-width: 768px) {
  .section-title {
    font-size: 1.8rem;
  }

  .section-subtitle {
    font-size: 0.95rem;
  }

  .location-card {
    padding: 1.5rem 1rem;
  }

  .location-header {
    flex-direction: column;
    gap: 1rem;
    align-items: flex-start;
  }

  .edit-actions {
    flex-direction: column;
  }

  .coordinates-display {
    font-size: 0.8rem;
  }
}

/* Animation for edit mode button */
.edit-button {
  transition: all 0.3s ease;
}

.edit-button:hover {
  transform: scale(1.1);
}

/* Leaflet map loading state overlay */
/* This will show "Memuat peta..." until Leaflet finishes rendering */
.leaflet-map::before {
  content: "Memuat peta...";
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%; /* Ensure it covers the whole map container */
  color: #64748b;
  font-style: italic;
  position: absolute; /* Position relative to .map-container */
  top: 0;
  left: 0;
  background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent overlay */
  z-index: 2; /* Ensure it's above the map tiles initially */
  pointer-events: none; /* Allow clicks to pass through once loaded */
  opacity: 1;
  transition: opacity 0.5s ease;
}

/* Hide the loading overlay once Leaflet tiles are loaded */
/* This needs to be handled via JavaScript after map.whenReady() or a similar event */
/* For simplicity, we can rely on Leaflet's rendering to eventually cover this */
/* Or, you can add a class to mapContainer once map is ready and hide this pseudo-element */
</style>
