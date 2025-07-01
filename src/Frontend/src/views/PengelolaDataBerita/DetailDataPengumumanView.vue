<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Loading State -->
    <div v-if="loading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-pink-500 border-t-transparent"></div>
        <p class="mt-4 text-gray-600 font-medium">Memuat pengumuman...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="flex items-center justify-center min-h-screen px-4">
      <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Terjadi Kesalahan</h3>
        <p class="text-gray-600 mb-6">{{ error }}</p>
        <button 
          @click="fetchPengumuman"
          class="w-full bg-pink-500 hover:bg-pink-600 text-white font-medium py-3 px-6 rounded-xl transition-colors duration-200"
        >
          Coba Lagi
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else-if="pengumuman" class="container mx-auto px-4 py-8 max-w-7xl">
      <!-- Header Navigation -->
      <div class="mb-8">
        <button 
          @click="$router.go(-1)"
          class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-white rounded-lg transition-all duration-200 group"
        >
          <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Kembali
        </button>
      </div>

      <!-- Grid Layout: Main Content & Sidebar -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
      <article class="bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Header with Badge -->
        <div class="relative">
          <div class="absolute top-6 left-6 z-10">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-pink-500 text-white shadow-lg">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM8 16v-4h4v4H8z"/>
              </svg>
              Pengumuman
            </span>
          </div>

          <!-- Featured Image -->
          <div v-if="pengumuman.foto" class="relative h-80 bg-gradient-to-br from-gray-200 to-gray-300">
            <img 
              :src="pengumuman.foto" 
              :alt="pengumuman.judul"
              class="w-full h-full object-cover"
              @error="imageError = true"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
          </div>
          
          <!-- Fallback for no image -->
          <div v-else class="h-32 bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
            <div class="text-center">
              <svg class="w-8 h-8 text-pink-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
              </svg>
              <p class="text-pink-600 font-medium text-sm">Pengumuman Resmi</p>
            </div>
          </div>
        </div>

        <!-- Content -->
        <div class="p-8 lg:p-12">
          <!-- Title -->
          <header class="mb-8">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 leading-tight mb-4">
              {{ pengumuman.judul }}
            </h1>
            
            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
              <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Dipublikasikan {{ formatDate(pengumuman.created_at) }}</span>
              </div>
              
              <div v-if="pengumuman.updated_at !== pengumuman.created_at" class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Diperbarui {{ formatDate(pengumuman.updated_at) }}</span>
              </div>
            </div>
          </header>

          <!-- Content Body -->
          <div class="prose prose-lg prose-gray max-w-none">
            <div class="bg-gray-50 rounded-2xl p-8 border-l-4 border-pink-500">
              <p class="text-gray-800 leading-relaxed whitespace-pre-wrap text-lg">{{ pengumuman.isi }}</p>
            </div>
          </div>

          <!-- Footer Actions -->
          <footer class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
              <div class="flex items-center gap-4">
                <button class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-200">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                  </svg>
                  Bagikan
                </button>
                
                <button class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors duration-200">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                  </svg>
                  Cetak
                </button>
              </div>

              <router-link 
                to="/pengumuman"
                class="inline-flex items-center px-6 py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-xl transition-colors duration-200 font-medium"
              >
                Lihat Pengumuman Lainnya
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
              </router-link>
            </div>
          </footer>
        </div>
      </article>
      </div>

      <!-- Sidebar - Rekomendasi Pengumuman -->
      <div class="lg:col-span-1">
        <div class="sticky top-8">
          <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
              <svg class="w-5 h-5 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              Pengumuman Lainnya
            </h3>

            <!-- Loading state untuk rekomendasi -->
            <div v-if="loadingRekomendasi" class="space-y-4">
              <div v-for="i in 3" :key="i" class="animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
              </div>
            </div>

            <!-- Error state untuk rekomendasi -->
            <div v-else-if="errorRekomendasi" class="text-center py-4">
              <p class="text-gray-500 text-sm">Gagal memuat rekomendasi</p>
            </div>

            <!-- List Rekomendasi -->
            <div v-else-if="rekomendasiPengumuman.length > 0" class="space-y-4">
              <article 
                v-for="item in rekomendasiPengumuman" 
                :key="item.id"
                class="group cursor-pointer"
                @click="navigateToDetail(item.id)"
              >
                <div class="border-l-3 border-pink-500 pl-4 py-2 hover:bg-pink-50 rounded-r-lg transition-colors duration-200">
                  <h4 class="font-semibold text-gray-900 text-sm group-hover:text-pink-600 transition-colors duration-200 line-clamp-2 mb-1">
                    {{ item.judul }}
                  </h4>
                  <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ formatDateShort(item.created_at) }}
                  </div>
                </div>
              </article>
            </div>

            <!-- Empty state -->
            <div v-else class="text-center py-8">
              <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              <p class="text-gray-500 text-sm">Belum ada pengumuman lainnya</p>
            </div>

            <!-- Link ke semua pengumuman -->
            <div class="mt-6 pt-4 border-t border-gray-200">
              <router-link 
                to="/pengumuman"
                class="block w-full text-center bg-pink-500 hover:bg-pink-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
              >
                Lihat Semua Pengumuman
              </router-link>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../../api.js'

const route = useRoute()
const router = useRouter()

// Reactive data
const pengumuman = ref(null)
const loading = ref(true)
const error = ref(null)
const imageError = ref(false)

// Rekomendasi pengumuman
const rekomendasiPengumuman = ref([])
const loadingRekomendasi = ref(false)
const errorRekomendasi = ref(null)

// Fetch pengumuman data
const fetchPengumuman = async () => {
  try {
    loading.value = true
    error.value = null
    
    const response = await api.get(`kelola/berita/${route.params.id}`)
    
    // Cek apakah response memiliki data
    if (response.data) {
      const responseData = response.data
      
      // Berdasarkan console log, data langsung ada di response.data, bukan di response.data.data
      // Karena console menunjukkan response.data sudah berisi object pengumuman langsung
      let data = responseData
      
      // Jika ada property data di dalam response, gunakan itu (untuk backward compatibility)
      if (responseData.data && typeof responseData.data === 'object') {
        data = responseData.data
      }
      
      console.log('Final data to process:', data)
      console.log('Jenis konten:', data.jenis_konten)
      
      // Check if jenis_konten is pengumuman
      if (data.jenis_konten !== 'pengumuman') {
        // Redirect to berita detail if not pengumuman
        console.log('Redirecting to berita because jenis_konten is:', data.jenis_konten)
        router.replace(`/berita/${route.params.id}`)
        return
      }
      
      pengumuman.value = data
      console.log('Pengumuman data set successfully:', pengumuman.value)
    } else {
      console.error('No response data')
      error.value = 'Tidak ada data dalam response'
    }
  } catch (err) {
    console.error('Error fetching pengumuman:', err)
    console.error('Error response:', err.response)
    
    if (err.response?.status === 404) {
      error.value = 'Pengumuman tidak ditemukan'
    } else {
      error.value = 'Gagal memuat data pengumuman. Silakan coba lagi.'
    }
  } finally {
    loading.value = false
  }
}

// Fetch rekomendasi pengumuman
const fetchRekomendasiPengumuman = async () => {
  try {
    loadingRekomendasi.value = true
    errorRekomendasi.value = null
    
    console.log('Fetching rekomendasi pengumuman from kelola/berita...')
    const response = await api.get('kelola/berita')
    
    console.log('Rekomendasi response:', response)
    console.log('Rekomendasi response.data:', response.data)
    
    if (response.data) {
      let allBerita = response.data
      
      // Jika response memiliki nested data property
      if (response.data.data && Array.isArray(response.data.data)) {
        allBerita = response.data.data
        console.log('Using nested data array:', allBerita)
      } else if (Array.isArray(response.data)) {
        allBerita = response.data
        console.log('Using direct data array:', allBerita)
      }
      
      console.log('All berita:', allBerita)
      console.log('Current pengumuman ID:', route.params.id)
      
      // Filter hanya pengumuman dan exclude pengumuman yang sedang dibuka
      const pengumumanList = allBerita
        .filter(item => {
          const isPengumuman = item.jenis_konten === 'pengumuman'
          const isDifferentId = item.id !== parseInt(route.params.id)
          console.log(`Item ${item.id}: jenis=${item.jenis_konten}, isPengumuman=${isPengumuman}, isDifferentId=${isDifferentId}`)
          return isPengumuman && isDifferentId
        })
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 5) // Ambil 5 pengumuman terbaru
      
      console.log('Filtered pengumuman list:', pengumumanList)
      rekomendasiPengumuman.value = pengumumanList
    } else {
      console.log('No data in response')
    }
  } catch (err) {
    console.error('Error fetching rekomendasi:', err)
    errorRekomendasi.value = 'Gagal memuat rekomendasi'
  } finally {
    loadingRekomendasi.value = false
  }
}

// Navigate to detail pengumuman
const navigateToDetail = (id) => {
  router.push(`/pengumuman/${id}`)
}

// Format date untuk rekomendasi
const formatDateShort = (dateString) => {
  const options = { 
    day: 'numeric',
    month: 'short',
    year: 'numeric'
  }
  return new Date(dateString).toLocaleDateString('id-ID', options)
}

// Format date helper
const formatDate = (dateString) => {
  const options = { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }
  return new Date(dateString).toLocaleDateString('id-ID', options)
}

// Initialize
onMounted(() => {
  fetchPengumuman()
  fetchRekomendasiPengumuman()
})
</script>

<style scoped>
.prose {
  color: inherit;
}

.prose p {
  margin-bottom: 1rem;
}

.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
  color: inherit;
  font-weight: 600;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.border-l-3 {
  border-left-width: 3px;
}
</style>