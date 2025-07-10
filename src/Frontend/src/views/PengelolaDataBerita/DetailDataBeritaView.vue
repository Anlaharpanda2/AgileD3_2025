<template>
  <SimpleLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Loading State -->
      <div
        v-if="loading"
        class="flex justify-center items-center py-20"
      >
        <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-pink-500" />
      </div>

      <!-- Error State -->
      <div
        v-else-if="error"
        class="max-w-6xl mx-auto px-6 py-12"
      >
        <div class="bg-red-50 border border-red-200 rounded-xl p-8 text-center">
          <div class="text-red-600 mb-4">
            <svg
              class="w-16 h-16 mx-auto"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
              />
            </svg>
          </div>
          <h3 class="text-xl font-medium text-red-800 mb-3">
            Terjadi Kesalahan
          </h3>
          <p class="text-red-600 mb-6">
            {{ error }}
          </p>
          <button
            class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-3 rounded-lg transition-colors duration-200"
            @click="fetchBeritaDetail"
          >
            Coba Lagi
          </button>
        </div>
      </div>

      <!-- Content -->
      <div
        v-else-if="berita"
        class="max-w-7xl mx-auto px-6 py-8"
      >
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl shadow-lg overflow-hidden mb-8">
          <div class="px-8 py-10 text-white">
            <div class="flex items-center justify-between">
              <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-3 mb-4">
                  <button
                    class="inline-flex items-center px-4 py-2
  bg-gray-100 text-gray-700 rounded-lg
  shadow-sm hover:bg-gray-200 transition-all duration-200
  font-medium text-sm"
                    @click="goBack"
                  >
                    <el-icon
                      class="mr-1.5"
                      :size="18"
                      color="#6B7280"
                    >
                      <ArrowLeft />
                    </el-icon>
                    Kembali
                  </button>
                </div>
                <h1 class="text-4xl font-bold mb-6 break-words">
                  {{ berita.judul }}
                </h1> <div class="flex items-center space-x-8 text-pink-100">
                  <div class="flex items-center">
                    <svg
                      class="w-6 h-6 mr-3"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                      />
                    </svg>
                    <span>Dibuat: {{ formatDate(berita.created_at) }}</span>
                  </div>
                  <div
                    v-if="berita.updated_at !== berita.created_at"
                    class="flex items-center"
                  >
                    <svg
                      class="w-6 h-6 mr-3"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                      />
                    </svg>
                    <span>Diperbarui: {{ formatDate(berita.updated_at) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
          <!-- Main Content - Takes 3 columns -->
          <div class="lg:col-span-3">
            <!-- Featured Image -->
            <div class="mb-8">
              <div
                v-if="berita.foto"
                class="relative group rounded-xl overflow-hidden shadow-lg"
              >
                <img 
                  :src="berita.foto" 
                  :alt="berita.judul"
                  class="w-full h-96 object-cover group-hover:scale-105 transition-transform duration-300"
                  @error="handleImageError"
                >
                <button 
                  class="absolute inset-0 bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center transition-all duration-200"
                  @click="openImageModal"
                >
                  <div class="bg-white bg-opacity-90 p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <svg
                      class="w-8 h-8 text-gray-700"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                      />
                    </svg>
                  </div>
                </button>
              </div>
              <div
                v-else
                class="w-full h-96 bg-gray-200 rounded-xl shadow-lg flex items-center justify-center"
              >
                <svg
                  class="w-24 h-24 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                  />
                </svg>
              </div>
            </div>

            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
              <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg
                  class="w-7 h-7 mr-3 text-pink-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
                Isi Berita
              </h2>
              <div class="prose prose-lg max-w-none">
                <div class="text-gray-700 leading-relaxed text-lg text-content-wrapper whitespace-pre-line">
                  {{ berita.isi }}
                </div>
              </div>
            </div>

            <!-- Article Info -->
            <div class="bg-white rounded-xl shadow-lg p-8">
              <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg
                  class="w-6 h-6 mr-3 text-pink-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                Informasi Detail
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                  <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">ID Berita</span>
                    <span class="font-semibold text-gray-800">#{{ berita.id }}</span>
                  </div>
                  <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Jenis Konten</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                      {{ berita.jenis_konten.charAt(0).toUpperCase() + berita.jenis_konten.slice(1) }}
                    </span>
                  </div>
                </div>
                <div class="space-y-4">
                  <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Status</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                      Aktif
                    </span>
                  </div>
                  <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Terakhir Update</span>
                    <div class="text-right">
                      <div class="font-semibold text-gray-800">
                        {{ formatDate(berita.updated_at) }}
                      </div>
                      <div class="text-sm text-gray-500">
                        {{ formatTime(berita.updated_at) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar - Takes 1 column -->
          <div class="lg:col-span-1">
            <!-- Recommended News -->
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
              <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <svg
                  class="w-6 h-6 mr-3 text-pink-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"
                  />
                </svg>
                Berita Terbaru
              </h3>
              
              <!-- Loading untuk rekomendasi -->
              <div
                v-if="loadingRecommended"
                class="flex justify-center py-8"
              >
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-pink-500" />
              </div>
              
              <!-- List rekomendasi berita -->
              <div
                v-else-if="recommendedNews.length > 0"
                class="space-y-4"
              >
                <div 
                  v-for="news in recommendedNews" 
                  :key="news.id"
                  class="group cursor-pointer p-4 rounded-lg hover:bg-gray-50 transition-colors duration-200 border border-gray-100"
                  @click="goToBerita(news.id)"
                >
                  <div class="flex space-x-3">
                    <div
                      v-if="news.foto"
                      class="flex-shrink-0"
                    >
                      <img 
                        :src="news.foto" 
                        :alt="news.judul"
                        class="w-16 h-16 object-cover rounded-lg"
                        @error="handleRecommendedImageError"
                      >
                    </div>
                    <div
                      v-else
                      class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center"
                    >
                      <svg
                        class="w-8 h-8 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                      </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-semibold text-gray-800 group-hover:text-pink-600 transition-colors duration-200 line-clamp-2 leading-tight mb-2">
                        {{ news.judul }}
                      </h4>
                      <div class="flex items-center space-x-2 text-xs text-gray-500">
                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-pink-100 text-pink-700 font-medium">
                          {{ news.jenis_konten }}
                        </span>
                        <span>{{ formatDateShort(news.created_at) }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Empty state untuk rekomendasi -->
              <div
                v-else
                class="text-center py-8 text-gray-500"
              >
                <svg
                  class="w-12 h-12 mx-auto mb-3 text-gray-300"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"
                  />
                </svg>
                <p class="text-sm">
                  Tidak ada berita lain
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions Footer -->
        <div class="bg-white rounded-xl shadow-lg mt-8 px-8 py-6">
          <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
              <button
                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200"
                @click="shareBerita"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"
                  />
                </svg>
                Bagikan
              </button>
              <button
                class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200"
                @click="printBerita"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"
                  />
                </svg>
                Cetak
              </button>
            </div>
            <div class="flex items-center space-x-4">
              <button
                class="inline-flex items-center px-8 py-3 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition-colors duration-200 font-semibold"
                @click="editBerita"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
                Edit Berita
              </button>
              <button
                class="inline-flex items-center px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 font-semibold"
                @click="goBack"
              >
                <svg
                  class="w-5 h-5 mr-2"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                  />
                </svg>
                Kembali
              </button>
            </div>
          </div>
        </div>

        <!-- Image Modal -->
        <div
          v-if="showImageModal"
          class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4"
          @click="closeImageModal"
        >
          <div class="relative max-w-5xl max-h-full">
            <img
              :src="berita.foto"
              :alt="berita.judul"
              class="max-w-full max-h-full object-contain rounded-lg"
            >
            <button
              class="absolute top-4 right-4 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full"
              @click="closeImageModal"
            >
              <svg
                class="w-8 h-8"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../../api.js'
import SimpleLayout from '../../layouts/SimpleLayout.vue'
import { ArrowLeft } from '@element-plus/icons-vue'

const route = useRoute()
const router = useRouter()
const berita = ref(null)
const loading = ref(true)
const error = ref(null)
const showImageModal = ref(false)
const recommendedNews = ref([])
const loadingRecommended = ref(false)

// Methods
// ... (kode lainnya) ...

const fetchBeritaDetail = async () => {
  try {
    loading.value = true
    error.value = null

    const response = await api.get(`kelola/berita/${route.params.id}`)

    console.log('API Response for detail:', response.data)

    let fetchedData = null;
    if (response.data && response.data.data) {
      fetchedData = response.data.data;
    } else if (response.data && response.data.id) {
      fetchedData = response.data;
    } else if (response.data) {
      fetchedData = response.data;
    }

    if (fetchedData) {
      if (fetchedData.jenis_konten === 'pengumuman') {
        // Jika jenis_konten adalah 'pengumuman', arahkan ke rute pengumuman
        router.replace(`/pengumuman/${fetchedData.id}`);
        // Penting: Set berita ke null agar komponen tidak menampilkan data yang salah
        berita.value = null;
        return; // Hentikan eksekusi lebih lanjut
      }
      berita.value = fetchedData;
    } else {
      throw new Error('Data berita tidak ditemukan');
    }
  } catch (err) {
    console.error('Error fetching berita detail:', err);
    error.value = err.response?.data?.message || err.message || 'Gagal memuat detail berita';
    // Jika terjadi error (misalnya 404), kosongkan berita
    berita.value = null;
  } finally {
    loading.value = false;
  }
};


const fetchRecommendedNews = async () => {
  console.trace('fetchRecommendedNews dipanggil dari:');
  try {
    loadingRecommended.value = true
    const response = await api.get('/kelola/berita')

    // Data API langsung mengembalikan array, jadi langsung gunakan 'response'
    if (Array.isArray(response) && response.length > 0) {
      const filteredNews = response
        .filter(news =>
          news.id !== parseInt(route.params.id) &&
          news.jenis_konten !== 'pengumuman' // Hanya tampilkan berita, buang pengumuman
        )
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        .slice(0, 5) // Ambil 5 berita terbaru

      recommendedNews.value = filteredNews
      console.log('Berita Rekomendasi yang sudah difilter:', recommendedNews.value);
    } else {
      // Jika response bukan array atau array kosong
      console.warn("Expected an array for recommended news, but got:", response);
      recommendedNews.value = []
    }
  } catch (err) {
    console.error('Error fetching recommended news:', err)
    // Penanganan error yang lebih spesifik
    if (err.response) {
      console.error('Data error (recommended):', err.response.data);
      console.error('Status error (recommended):', err.response.status);
    } else if (err.request) {
      console.error('No response received (recommended):', err.request);
    } else {
      console.error('Error setting up request (recommended):', err.message);
    }
    recommendedNews.value = []
  } finally {
    loadingRecommended.value = false
  }
}

// ... (kode lainnya) ...

const formatDate = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatDateShort = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleDateString('id-ID', {
    day: 'numeric',
    month: 'short'
  })
}

const formatTime = (dateString) => {
  if (!dateString) return '-'
  const date = new Date(dateString)
  return date.toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

const handleImageError = (event) => {
  console.error('Error loading main image:', event.target.src);
  // Set src ke gambar placeholder yang sudah ada di proyek Anda
  event.target.src = '/img/no-image-available.png'; // <-- Sesuaikan path placeholder utama Anda
  // Opsional: tambahkan class untuk memastikan placeholder terlihat bagus
  event.target.classList.add('object-contain', 'p-4', 'bg-gray-200'); // Menambahkan background untuk placeholder
  event.target.classList.remove('object-cover', 'group-hover:scale-105'); // Hapus class asli yang mungkin mengganggu placeholder
};

const handleRecommendedImageError = (event) => {
  console.error('Error loading recommended news image:', event.target.src);
  // Set src ke gambar placeholder kecil
  event.target.src = '/img/no-image-small.png'; // <-- Sesuaikan path placeholder kecil Anda
  event.target.classList.add('object-contain', 'p-2', 'bg-gray-100');
  event.target.classList.remove('object-cover');
};
const openImageModal = () => {
  showImageModal.value = true
}

const closeImageModal = () => {
  showImageModal.value = false
}

const goBack = () => {
  router.go(-1)
}

const goToBerita = (id) => {
  // Penting: gunakan router.push untuk navigasi agar watcher terpicu
  router.push(`/berita/${id}`)
}

const editBerita = () => {
  router.push(`/admin/berita/edit/${berita.value.id}`)
}

const shareBerita = () => {
  if (navigator.share) {
    navigator.share({
      title: berita.value.judul,
      text: berita.value.isi.substring(0, 100) + '...',
      url: window.location.href
    })
  } else {
    // Fallback for browsers that don't support Web Share API
    navigator.clipboard.writeText(window.location.href).then(() => {
      alert('Link berhasil disalin ke clipboard!')
    })
  }
}

const printBerita = () => {
  window.print()
}

// Lifecycle
onMounted(() => {
  console.log('onMounted dipicu.');
  // onMounted sekarang hanya menjalankan watcher yang sudah `immediate: true`
  // sehingga fetch data akan otomatis dipanggil
})

// Watcher untuk route.params.id
watch(() => route.params.id, (newId, oldId) => {
  if (newId !== oldId || !berita.value) { // Tambahkan !berita.value agar data awal juga ter-fetch
    console.log(`route.params.id berubah dari ${oldId} ke ${newId}. Memuat ulang data.`);
    fetchBeritaDetail();
    fetchRecommendedNews();
  }
}, { immediate: true }); // `immediate: true` memastikan ini berjalan saat komponen dimuat pertama kali

</script>

<style scoped>
.prose :deep(p),
.prose :deep(li),
.prose :deep(div) {
  word-wrap: break-word; /* Older browsers */
  overflow-wrap: break-word; /* Modern browsers */
}

/* Jika Anda ingin menerapkan ini langsung ke div isi berita tanpa bergantung pada .prose */
.text-content-wrapper { /* Tambahkan kelas ini pada div yang menampilkan isi berita */
    word-wrap: break-word;
    overflow-wrap: break-word;
}
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media print {
  .no-print {
    display: none !important;
  }
}
</style>