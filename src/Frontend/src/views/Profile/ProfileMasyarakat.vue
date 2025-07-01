<template>
  <DefaultLayout2>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
      <!-- Hero Section dengan Glassmorphism -->
      <div class="relative overflow-hidden bg-gradient-to-r from-pink-500 via-pink-400 to-pink-300">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
          <div class="absolute top-0 left-0 w-72 h-72 bg-white opacity-10 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
          <div class="absolute top-0 right-0 w-72 h-72 bg-pink-200 opacity-20 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-1000"></div>
          <div class="absolute -bottom-8 left-20 w-72 h-72 bg-gray-200 opacity-15 rounded-full mix-blend-multiply filter blur-xl animate-pulse delay-2000"></div>
        </div>

        <!-- Header Content -->
        <div class="relative z-10 px-4 py-8 sm:px-6 lg:px-8">
          <!-- Back Button -->
          <div class="mb-8">
            <button 
              @click="goBack" 
              class="group inline-flex items-center px-6 py-3 rounded-full bg-white/90 backdrop-blur-sm text-pink-600 font-semibold shadow-lg hover:bg-white hover:shadow-xl transition-all duration-300 hover:scale-105"
            >
              <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Kembali
            </button>
          </div>

          <!-- Title Section -->
          <div class="text-center text-white">
            <h1 class="text-4xl sm:text-5xl font-bold mb-4 drop-shadow-lg">
              Detail Peserta Pelatihan
            </h1>
            <p class="text-xl text-pink-100 font-light">
              Informasi lengkap data peserta
            </p>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="relative -mt-16 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
          <template v-if="pesertaData">
            <!-- Profile Card dengan Glassmorphism -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 p-8 mb-8 hover:shadow-3xl transition-all duration-500">
              <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
                <!-- Profile Photo -->
                <div class="relative group">
                  <div class="relative" @click="triggerFileInput">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 p-1 shadow-2xl ">
                      <img
                        :src="pesertaData.photo_url || '/table/profile.svg'"
                        alt="Foto Peserta"
                        class="w-full h-full rounded-full object-cover"
                        @error="handleImageError"
                      />
                    </div>
                  </div>
                  <input type="file" ref="fileInput" accept="image/*" class="hidden" @change="uploadPhoto" />
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center lg:text-left atur">
                  <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ pesertaData.nama }}</h2>
                  <p class="text-gray-600 text-lg mb-4">NIK: {{ pesertaData.nik }}</p>
                  
                  <!-- Badges -->
                  <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm  bg-gradient-to-r from-pink-500 to-pink-600 text-white shadow-lg">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                      </svg>
                      {{ pesertaData.jenis_bimtek }}
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm  bg-gray-100 text-gray-700 border border-gray-200">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                      </svg>
                      Angkatan {{ pesertaData.angkatan }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Information Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
              <!-- Informasi Pelatihan -->
              <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-pink-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                  <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                      </svg>
                    </div>
                    Informasi Pelatihan
                  </h3>
                </div>
                <div class="p-6 space-y-4">
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Jenis Pelatihan</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.jenis_bimtek }}</span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Angkatan</span>
                    <span class="text-gray-501 ">{{ pesertaData.angkatan }}</span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Mulai Kegiatan</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.kegiatan_dimulai }}</span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Berakhir</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.kegiatan_berakhir }}</span>
                  </div>
                  <div class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Tempat Kegiatan</span>
                    <span class="text-gray-501 ">{{ pesertaData.tempat_kegiatan }}</span>
                  </div>
                </div>
              </div>

              <!-- Data Pribadi -->
              <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-pink-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                  <h3 class="text-lg font-bold text-gray-501 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                      </svg>
                    </div>
                    Data Pribadi
                  </h3>
                </div>
                <div class="p-6 space-y-4">
                  <div class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Tempat, Tanggal Lahir</span>
                    <span class="text-gray-501 ">{{ pesertaData.tempat_tanggal_lahir }}</span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Pendidikan</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.pendidikan }}</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Status</span>
                    <span class="px-3 py-1 rounded-full text-sm " :class="getStatusClass(pesertaData.status)">
                      {{ pesertaData.status }}
                    </span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Nomor Telepon</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.nomor_telefon }}</span>
                  </div>
                  <div class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Alamat</span>
                    <span class="text-gray-501 ">{{ pesertaData.alamat }}</span>
                  </div>
                </div>
              </div>

              <!-- Informasi Usaha -->
              <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-pink-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                  <h3 class="text-lg font-bold text-gray-501 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                      </svg>
                    </div>
                    Informasi Usaha
                  </h3>
                </div>
                <div class="p-6 space-y-4">
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Jenis Usaha</span>
                    <span class="text-gray-501  text-right">{{ pesertaData.jenis_usaha }}</span>
                  </div>
                  <div class="flex justify-between items-start">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Penghasilan/Bulan</span>
                    <span class="text-pink-600 font-bold text-lg">{{ pesertaData.penghasilan_perbulan }}</span>
                  </div>
                </div>  
              </div>

              <!-- Informasi Pendaftaran -->
              <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-pink-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                  <h3 class="text-lg font-bold text-gray-501 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                      </svg>
                    </div>
                    Informasi Pendaftaran
                  </h3>
                </div>
                <div class="p-6 space-y-4">
                  <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Status</span>
                    <span class="px-4 py-2 rounded-full text-sm font-bold capitalize" :class="{
                      'bg-green-100 text-green-800 border border-green-200': pesertaData.status_pendaftaran === 'Diterima',
                      'bg-red-100 text-red-800 border border-red-200': pesertaData.status_pendaftaran === 'Ditolak',
                      'bg-yellow-100 text-yellow-800 border border-yellow-200': pesertaData.status_pendaftaran === 'Diproses',
                    }">
                      {{ pesertaData.status_pendaftaran }}
                    </span>
                  </div>
                  <div class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Keterangan</span>
                    <p class="text-gray-501 font-medium">{{ pesertaData.keterangan }}</p>
                  </div>
                </div>
              </div>

              <!-- Informasi Sistem -->
              <div v-if="pesertaData.created_at || pesertaData.updated_at" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <div class="bg-gradient-to-r from-pink-50 to-gray-50 px-6 py-4 border-b border-gray-100">
                  <h3 class="text-lg font-bold text-gray-501 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    Informasi Sistem
                  </h3>
                </div>
                <div class="p-6 space-y-4">
                  <div v-if="pesertaData.created_at" class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Dibuat Pada</span>
                    <span class="text-gray-501 ">{{ formatDate(pesertaData.created_at) }}</span>
                  </div>
                  <div v-if="pesertaData.updated_at" class="flex flex-col space-y-2">
                    <span class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Diperbarui Pada</span>
                    <span class="text-gray-501 ">{{ formatDate(pesertaData.updated_at) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </template>

          <!-- Loading State -->
          <template v-else>
            <div class="flex flex-col items-center justify-center min-h-96 bg-white rounded-3xl shadow-2xl border border-gray-100">
              <div class="relative">
                <div class="w-16 h-16 border-4 border-gray-200 border-t-pink-500 rounded-full animate-spin"></div>
                <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-t-pink-300 rounded-full animate-spin animate-reverse delay-150"></div>
              </div>
              <p class="mt-6 text-gray-600 text-lg font-medium">Memuat data peserta...</p>
              <div class="mt-2 flex space-x-1">
                <div class="w-2 h-2 bg-pink-400 rounded-full animate-bounce"></div>
                <div class="w-2 h-2 bg-pink-400 rounded-full animate-bounce delay-100"></div>
                <div class="w-2 h-2 bg-pink-400 rounded-full animate-bounce delay-200"></div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </DefaultLayout2>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import api from '../../api'
import DefaultLayout2 from "../../layouts/Layout2.vue";

interface Peserta {
  id: number
  nama: string
  nik: string
  jenis_bimtek: string
  kegiatan_dimulai: string
  kegiatan_berakhir: string
  tempat_kegiatan: string
  angkatan: number
  tempat_tanggal_lahir: string
  pendidikan: string
  status: 'kawin' | 'lajang' | 'janda'
  alamat: string
  jenis_usaha: string
  penghasilan_perbulan: string
  nomor_telefon: string
  status_pendaftaran: string
  keterangan: string
  created_at?: string
  updated_at?: string
  photo?: string
  photo_url?: string
}

const route = useRoute()
const router = useRouter()
const pesertaData = ref<Peserta | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)
const uploading = ref(false)
const nik = route.params.id

onMounted(async () => {
  try {
    const res = await api.get(`/profile/masyarakat/${nik}`)
    pesertaData.value = res.data
    console.log('Data peserta:', res.data)
  } catch (err) {
    console.error('Gagal memuat data peserta:', err)
  }
})

const goBack = () => {
  router.back()
}

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement
  img.src = '/table/profile.svg'
  img.alt = 'Foto tidak tersedia'
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const getStatusClass = (status: string) => {
  const statusMap: { [key: string]: string } = {
    'kawin': 'bg-blue-100 text-blue-800 border border-blue-200',
    'lajang': 'bg-green-100 text-green-800 border border-green-200',
    'janda': 'bg-purple-100 text-purple-800 border border-purple-200'
  }
  return statusMap[status] || 'bg-gray-100 text-gray-800 border border-gray-200'
}

const formatDate = (dateString: string) => {
  if (!dateString) return '-'

  const date = new Date(dateString)

  // Konversi ke zona waktu Indonesia Barat (WIB = UTC+7)
  const options: Intl.DateTimeFormatOptions = {
    timeZone: 'Asia/Jakarta',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false,
  }

  return date.toLocaleString('id-ID', options) + ' WIB'
}


const uploadPhoto = async (event: Event) => {
  const input = event.target as HTMLInputElement
  const file = input.files?.[0]

  if (!file) {
    ElMessage.error('File tidak ditemukan.')
    return
  }

  // Validasi ukuran file (maksimal 5MB)
  if (file.size > 5 * 1024 * 1024) {
    ElMessage.error('Ukuran file terlalu besar. Maksimal 5MB.')
    return
  }

  // Validasi tipe file
  const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']
  if (!allowedTypes.includes(file.type)) {
    ElMessage.error('Format file harus JPEG, PNG, JPG, atau WebP.')
    return
  }

  uploading.value = true

  const formData = new FormData()
  formData.append('photo', file)
  formData.append('_method', 'PATCH')

  try {
    const id = pesertaData.value?.id
    const res = await api.post(`/profile/masyarakat/${nik}/ubah-foto`, formData)

    ElMessage.success('Foto berhasil diperbarui')
    
    if (res?.data?.data?.photo_url) {
      pesertaData.value!.photo_url = res.data.data.photo_url
    } else if (res?.data?.photo_url) {
      pesertaData.value!.photo_url = res.data.photo_url
    } else {
      const refreshRes = await api.get(`/peserta/${id}`)
      pesertaData.value = refreshRes.data
    }
    
    input.value = ''
  } catch (err: any) {
    console.error('Upload error:', err)
    const errorMsg = err.response?.data?.message || 'Gagal mengunggah foto.'
    ElMessage.error(errorMsg)
  } finally {
    uploading.value = false
  }
}
</script>

<style scoped>
.atur{
  padding-right: 150px;
}
@keyframes animate-reverse {
  from {
    transform: rotate(360deg);
  }
  to {
    transform: rotate(0deg);
  }
}

.animate-reverse {
  animation-direction: reverse;
}

.shadow-3xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Custom hover effects */
@media (hover: hover) {
  .hover\:scale-105:hover {
    transform: scale(1.05);
  }
}
@media (max-width: 1070px) {
  .atur{
    padding-right:0;
  }
}
/* Mobile optimizations */
@media (max-width: 640px) {
  .grid-cols-1.lg\:grid-cols-2.xl\:grid-cols-3 {
    grid-template-columns: 1fr;
  }
  .atur{
    padding-right:0;
  }
}
</style>