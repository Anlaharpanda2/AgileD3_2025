<template>
  <div class="w-full">
    <!-- Header Section -->
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-4xl font-bold text-slate-800 mb-4">Lokasi Kami</h2>
      <p class="text-lg text-slate-600 font-normal max-w-2xl mx-auto">
        Temukan lokasi pusat layanan kami di sini
      </p>
    </div>
    
    <!-- Location Card -->
    <ElCard class="rounded-3xl p-10 border-0 shadow-xl h-full" data-aos="zoom-in" data-aos-delay="100">
      <div v-loading="isLoading" class="relative min-h-[200px]">
        <!-- Location Header -->
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-2xl font-bold text-slate-800 location-name">{{ locationInfo.name }}</h3>
          <ElButton 
            :icon="Edit" 
            circle 
            @click="toggleEditLocation" 
            class="transition-transform hover:scale-110"
            :type="locationInfo.isEditing ? 'primary' : 'default'"
            :loading="isSaving"
          >
            <template #loading>
              <ElIcon class="is-loading"><Loading /></ElIcon>
            </template>
          </ElButton>
        </div>
        
        <div class="location-details">
          <!-- Map Container -->
          <div 
            class="w-full h-[300px] overflow-hidden rounded-xl border-2 mb-4 transition-colors"
            :class="locationInfo.isEditing ? 'border-pink-500 cursor-crosshair' : 'border-slate-200'"
          >
            <div ref="mapContainer" class="w-full h-full rounded-lg map-loading"></div>
          </div>

          <!-- Edit Mode UI -->
          <div v-if="locationInfo.isEditing" class="mt-6">
            <div class="bg-gradient-to-r from-pink-500 to-purple-600 text-white p-4 rounded-lg mb-6 text-center">
              <p class="m-0 font-medium">🗺️ Klik pada peta atau drag marker untuk memilih lokasi baru</p>
            </div>
            
            <ElInput
              v-model="locationInfo.name"
              placeholder="Nama Lokasi"
              class="mb-4"
            />
            
            <ElInput
              v-model="locationInfo.address"
              type="textarea"
              :rows="2"
              placeholder="Alamat Lokasi"
              class="mb-4"
            />
            
            <div class="bg-slate-50 p-3 rounded-lg mb-4 font-mono text-sm text-slate-600 border-l-4 border-pink-500">
              <span>📍 Koordinat: {{ locationInfo.lat.toFixed(6) }}, {{ locationInfo.lng.toFixed(6) }}</span>
            </div>

            <!-- Edit Actions -->
            <div class="mt-6 flex gap-4 justify-center">
              <ElButton type="primary" @click="saveLocation" :loading="isSaving">Simpan</ElButton>
              <ElButton @click="locationInfo.isEditing = false">Batal</ElButton>
            </div>
          </div>
          
          <!-- View Mode UI -->
          <div v-else class="mt-6">
            <p class="text-base text-slate-600 leading-relaxed mb-6 flex items-start gap-2 location-address">
              <span class="text-xl text-pink-500 mt-1">📍</span>
              {{ locationInfo.address }}
            </p>
          </div>
        </div>
      </div>
    </ElCard>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick, watch, onUnmounted } from 'vue';
import {
  ElButton,
  ElCard,
  ElIcon,
  ElInput,
  ElMessage,
} from 'element-plus';
import {
  Edit,
  Loading
} from '@element-plus/icons-vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import api from '../../api.js'; // Pastikan path ini benar

// --- Deklarasi Global untuk Leaflet agar TypeScript mengenali window.L ---
declare global {
  interface Window {
    L: typeof import('leaflet');
  }
}

// --- Interfaces ---
interface LocationInfo {
  name: string;
  address: string;
  lat: number;
  lng: number;
  isEditing: boolean;
}

interface LocationBackendItem {
  id: number;
  nama_lokasi: string;
  alamat: string;
  latitude: string; 
  longitude: string; 
  [key: string]: any;
}

interface NominatimResponse {
  display_name: string;
  name?: string;
  address?: {
    building?: string;
    shop?: string;
    amenity?: string;
    tourism?: string;
    office?: string;
    house_number?: string;
    road?: string;
    [key: string]: any;
  };
  [key: string]: any;
}

// --- Data Reaktif ---
const DEFAULT_LAT = -6.175110993816788; // Default Latitude (Monas, Jakarta)
const DEFAULT_LNG = 106.82914107499008; // Default Longitude (Monas, Jakarta)

const locationInfo = ref<LocationInfo>({
  name: 'Memuat data...',
  address: 'Memuat data...',
  lat: DEFAULT_LAT,
  lng: DEFAULT_LNG,
  isEditing: false
});

const isLoading = ref(true);
const isSaving = ref(false);

// --- State Peta ---
const mapContainer = ref<HTMLElement | null>(null);
let map: L.Map | null = null;
let marker: L.Marker | null = null;

// --- Fungsi Helper untuk Peta dan Geocoding (sebelumnya di services) ---

/**
 * Memuat library Leaflet secara dinamis (CSS dan JS).
 */
const loadLeaflet = (): Promise<typeof import('leaflet')> => {
  return new Promise((resolve, reject) => {
    if (window.L) {
      resolve(window.L as typeof import('leaflet'));
      return;
    }

    const cssLink = document.createElement('link');
    cssLink.rel = 'stylesheet';
    cssLink.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    cssLink.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
    cssLink.crossOrigin = '';
    document.head.appendChild(cssLink);

    const script = document.createElement('script');
    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
    script.crossOrigin = '';
    script.async = true;
    script.defer = true;
    script.onload = () => {
      // Baris ini dihapus karena tidak lagi diperlukan di Leaflet 1.9.4
      // delete window.L.Icon.Default.prototype._getIconUrl;
      window.L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
        iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
      });
      resolve(window.L as typeof import('leaflet'));
    };
    script.onerror = () => reject(new Error('Gagal memuat Leaflet script.'));
    document.head.appendChild(script);
  });
};

/**
 * Membuat ikon marker Leaflet kustom.
 */
const createCustomMarkerIcon = (isEdit: boolean): L.DivIcon => {
  if (typeof window === 'undefined' || !window.L) {
    console.error("Leaflet (window.L) is not loaded. Please ensure loadLeaflet() is called first.");
    throw new Error("Leaflet library not loaded.");
  }
  const color = isEdit ? '#10b981' : '#ec4899';
  const cursor = isEdit ? 'cursor: grab;' : '';
  return window.L.divIcon({
    html: `
      <div style="
        width: 30px;
        height: 30px;
        background: ${color};
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        ${cursor}
      ">
        <div style="
          width: 8px;
          height: 8px;
          background: white;
          border-radius: 50%;
        "></div>
      </div>
    `,
    className: isEdit ? 'custom-marker-edit' : 'custom-marker',
    iconSize: [30, 30],
    iconAnchor: [15, 15]
  });
};

/**
 * Melakukan reverse geocoding menggunakan Nominatim API.
 */
async function reverseGeocode(lat: number, lng: number): Promise<{ name: string; address: string } | null> {
  const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
  try {
    const response = await fetch(url, {
      headers: { 'User-Agent': 'VueLocationApp/1.0 (your-email@example.com)' }
    });
    if (!response.ok) {
      throw new Error(`Nominatim API response was not OK: ${response.statusText}`);
    }
    const data: NominatimResponse = await response.json();
    if (data && data.display_name) {
      let placeName = '';
      if (data.name) {
        placeName = data.name;
      } else if (data.address) {
        placeName = data.address.building || data.address.shop || data.address.amenity || data.address.tourism || data.address.office || (data.address.house_number ? `${data.address.house_number} ${data.address.road || ''}` : '');
        if (placeName) { placeName = placeName.trim(); } else { placeName = data.display_name.split(',')[0].trim(); }
      } else {
        placeName = data.display_name.split(',')[0].trim();
      }
      return { name: placeName, address: data.display_name };
    }
    return null;
  } catch (error) {
    console.error('Error in Nominatim reverse geocoding:', error);
    return null;
  }
}

// --- Fungsi Peta ---

/**
 * Inisialisasi peta Leaflet.
 */
const initMap = async () => {
  try {
    if (!mapContainer.value) {
      console.warn('Map container is not available. Retrying initMap...');
      return;
    }
    // Perbaikan: Pastikan locationInfo.value ada sebelum diakses
    if (!locationInfo.value) {
      console.error('LocationInfo.value is null/undefined when initializing map. Cannot proceed.');
      ElMessage.error('Gagal memuat peta: Data lokasi tidak valid atau kosong.');
      return;
    }

    const L = await loadLeaflet();
    
    if (map) { // Cek variabel map, bukan map.value karena map adalah let global
      map.remove();
      map = null;
    }

    map = L.map(mapContainer.value as HTMLElement, {
      zoomControl: true,
      scrollWheelZoom: true,
      doubleClickZoom: true,
      boxZoom: true,
      keyboard: true,
      dragging: true,
      touchZoom: true
    }).setView([locationInfo.value.lat, locationInfo.value.lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 19
    }).addTo(map as L.Map); // Type assertion untuk Leaflet

    marker = L.marker([locationInfo.value.lat, locationInfo.value.lng], {
      icon: createCustomMarkerIcon(locationInfo.value.isEditing),
      draggable: locationInfo.value.isEditing
    }).addTo(map as L.Map); // Type assertion untuk Leaflet

    map.on('click', async (e: L.LeafletMouseEvent) => {
      if (locationInfo.value.isEditing) {
        await _handleMapInteraction(e.latlng);
      }
    });

    marker.on('dragend', async (e: L.LeafletEvent) => {
      if (locationInfo.value.isEditing) {
        await _handleMapInteraction((e.target as L.Marker).getLatLng());
      }
    });

    console.log('Leaflet map initialized successfully.');

  } catch (error: any) {
    console.error('Error initializing Leaflet map:', error);
    ElMessage.error(`Gagal memuat peta: ${error.message || 'Tidak diketahui'}`);
  }
};

/**
 * Fungsi internal untuk menangani interaksi peta (klik atau drag marker).
 */
const _handleMapInteraction = async (latlng: L.LatLng) => {
  const lat = latlng.lat;
  const lng = latlng.lng;

  if (marker) {
    marker.setLatLng([lat, lng]);
  }
  if (map) {
    map.panTo([lat, lng]);
  }

  locationInfo.value.lat = lat;
  locationInfo.value.lng = lng;

  try {
    const addressDetails = await reverseGeocode(lat, lng);
    if (addressDetails) {
      locationInfo.value.name = addressDetails.name;
      locationInfo.value.address = addressDetails.address;
      ElMessage.success('Lokasi berhasil diperbarui dari peta!');
    } else {
      ElMessage.warning('Koordinat berhasil diperbarui, tetapi gagal mendapatkan alamat.');
      locationInfo.value.name = 'Lokasi Baru'; // Fallback
      locationInfo.value.address = 'Alamat tidak ditemukan'; // Fallback
    }
  } catch (error) {
    console.error('Reverse geocoding error after map interaction:', error);
    ElMessage.warning('Koordinat berhasil diperbarui, tetapi terjadi kesalahan saat mendapatkan alamat.');
    locationInfo.value.name = 'Lokasi Baru'; // Fallback
    locationInfo.value.address = 'Gagal mendapatkan alamat'; // Fallback
  }
};

/**
 * Memperbarui posisi marker dan tampilan peta secara programatis.
 */
const updateMapAndMarkerPosition = (lat: number, lng: number) => {
  if (map && marker) {
    marker.setLatLng([lat, lng]);
    map.setView([lat, lng], map.getZoom()); // Pertahankan zoom saat ini
  }
};

/**
 * Mengatur status draggable marker.
 */
const setMarkerDraggable = (draggable: boolean) => {
  if (marker) {
    if (draggable) {
      marker.dragging?.enable();
    } else {
      marker.dragging?.disable();
    }
  }
};

/**
 * Memperbarui ikon marker berdasarkan mode edit.
 */
const updateMarkerIcon = (isEdit: boolean) => {
  if (marker) {
    marker.setIcon(createCustomMarkerIcon(isEdit));
  }
};

/**
 * Memaksa peta untuk menghitung ulang ukurannya.
 */
const invalidateMapSize = () => {
  if (map) {
    map.invalidateSize();
  }
};


// --- Fungsi Data Lokasi (sebelumnya di useLocationData) ---

/**
 * Fetch location data from backend
 */
const fetchLocation = async () => {
  isLoading.value = true;
  try {
    const result = await api.get('/data/lokasi');
    const rawData = Array.isArray(result) ? result : result.data?.data || result.data || result;
    const arr = Array.isArray(rawData) ? rawData : [];

    if (arr.length === 0) {
      console.warn('⚠️ Data lokasi dari API kosong. Menggunakan koordinat default.');
      ElMessage.warning('Data lokasi dari API kosong.');
      locationInfo.value.name = 'Lokasi Default';
      locationInfo.value.address = 'Alamat Default (silakan edit)';
      locationInfo.value.lat = DEFAULT_LAT; 
      locationInfo.value.lng = DEFAULT_LNG;
      return;
    }

    const item: LocationBackendItem = arr[0];
    locationInfo.value.name = item.nama_lokasi;
    locationInfo.value.address = item.alamat;
    
    const parsedLat = parseFloat(item.latitude);
    const parsedLng = parseFloat(item.longitude);

    if (!isNaN(parsedLat) && !isNaN(parsedLng)) {
      locationInfo.value.lat = parsedLat;
      locationInfo.value.lng = parsedLng;
    } else {
      console.warn('⚠️ Koordinat lokasi tidak valid dari API. Menggunakan koordinat default.');
      ElMessage.warning('Koordinat lokasi tidak valid dari API. Menggunakan koordinat default.');
      locationInfo.value.lat = DEFAULT_LAT;
      locationInfo.value.lng = DEFAULT_LNG;
    }
    
    // Perbaikan: Panggil updateMapAndMarkerPosition di sini setelah data diperbarui
    // Ini memastikan peta segera bergerak ke lokasi yang diambil dari API.
    if (map && marker) { // Pastikan map dan marker sudah diinisialisasi
      updateMapAndMarkerPosition(locationInfo.value.lat, locationInfo.value.lng);
    }

  } catch (err: any) {
    console.error('❌ Error fetching location:', err);
    const msg = `Gagal mengambil data lokasi: ${err.response?.status ? `server respons ${err.response.status}.` : err.message || 'Error tidak diketahui.'}`;
    ElMessage.error(msg);
    locationInfo.value.name = 'Error Memuat Lokasi';
    locationInfo.value.address = 'Gagal memuat data. Silakan coba lagi.';
    locationInfo.value.lat = DEFAULT_LAT; 
    locationInfo.value.lng = DEFAULT_LNG;
  } finally {
    isLoading.value = false;
  }
};

/**
 * Save location data to backend
 */
const saveLocation = async () => {
  isSaving.value = true;
  try {
    const payload = {
      nama_lokasi: locationInfo.value.name,
      alamat: locationInfo.value.address,
      latitude: locationInfo.value.lat.toString(),
      longitude: locationInfo.value.lng.toString(),
    };
    const response = await api.post('/data/lokasi', payload);
    
    if (response.data && response.data.message) {
      ElMessage.success(response.data.message);
    } else {
      ElMessage.success('Location saved successfully!');
    }
    
    locationInfo.value.isEditing = false;
    // Perbarui tampilan marker setelah save (non-edit mode)
    if (marker) {
      marker.setIcon(createCustomMarkerIcon(false));
      marker.dragging?.disable(); // Pastikan drag dinonaktifkan
    }

  } catch (error: any) {
    console.error('Error saving location data:', error);
    let errorMessage = 'Gagal menyimpan lokasi. Silakan coba lagi.';
    if (error.response && error.response.data && error.response.data.errors) {
      const errorMessages = Object.values(error.response.data.errors).flat().join('; ');
      errorMessage = `Gagal menyimpan lokasi: ${errorMessages}`;
    } else if (error.message) {
      errorMessage = `Gagal menyimpan lokasi: ${error.message}`;
    }
    ElMessage.error(errorMessage);
  } finally {
    isSaving.value = false;
  }
};

// --- Fungsi Toggle Mode Edit Lokasi ---
const toggleEditLocation = () => {
  locationInfo.value.isEditing = !locationInfo.value.isEditing;
  
  if (locationInfo.value.isEditing) {
    ElMessage.info('Edit mode active. Klik pada peta atau drag marker untuk memilih lokasi baru.');
  } else {
    ElMessage.info('Edit mode deactivated without saving.');
  }
  
  // Perbarui draggable marker dan ikon secara langsung
  setMarkerDraggable(locationInfo.value.isEditing);
  updateMarkerIcon(locationInfo.value.isEditing);
  
  // Perbaikan: panggil invalidateSize setiap kali mode edit berubah untuk memastikan peta merespons perubahan ukuran container
  invalidateMapSize(); 
};

// --- Lifecycle Hook ---
onMounted(async () => {
  // Inisialisasi AOS
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100,
    delay: 0
  });

  // 1. Ambil data lokasi dari backend
  await fetchLocation(); // fetchLocation sekarang langsung mengupdate locationInfo dan memanggil updateMapAndMarkerPosition

  // 2. Pastikan DOM sudah diperbarui (ref mapContainer siap)
  await nextTick();
  
  // 3. Inisialisasi peta Leaflet jika belum diinisialisasi.
  //    Logika `if (!mapContainer.value || map) return` di initMap akan mencegah inisialisasi ulang.
  await initMap();
});

// --- Cleanup saat komponen di-unmount ---
onUnmounted(() => {
  if (map) {
    map.remove();
    map = null;
    marker = null;
  }
});
</script>

<style scoped>
/* Custom marker styles */
:deep(.custom-marker),
:deep(.custom-marker-edit) {
  border: none !important;
  background: transparent !important;
}

/* Map loading state */
.map-loading::before {
  content: "Memuat peta...";
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  width: 100%;
  color: #64748b;
  font-style: italic;
  position: absolute;
  top: 0;
  left: 0;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
  pointer-events: none;
  opacity: 1;
  transition: opacity 0.5s ease;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .text-4xl {
    font-size: 2rem; /* @apply text-3xl; */
  }
  
  .text-lg {
    font-size: 1.125rem; /* @apply text-base; */
  }
  
  .p-10 {
    padding: 2rem; /* @apply p-8; */
  }
}

@media (max-width: 768px) {
  .text-4xl {
    font-size: 1.875rem; /* @apply text-3xl; */
  }
  
  .text-lg {
    font-size: 0.875rem; /* @apply text-sm; */
  }
  
  .p-10 {
    padding: 1.5rem; /* @apply p-6; */
  }
  
  .flex-gap-4 {
    flex-direction: column; /* @apply flex-col; */
  }
  
  .text-sm {
    font-size: 0.75rem; /* @apply text-xs; */
  }
}
/* New media query for < 470px */
@media (max-width: 470px) {
  .location-name, /* Targeting the h3 element */
  .location-address /* Targeting the p element */
   {
    display: none;
  }
}
</style>
