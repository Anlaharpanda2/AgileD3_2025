<template>
  <SimpleLayout>
    <!-- Loading State -->
    <div
      v-if="loading"
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-gray-200 border-t-pink-500 mx-auto mb-4" />
        <p class="text-gray-600 font-medium">
          Memuat detail konfirmasi pengaduan...
        </p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-8 text-center">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg
              class="w-8 h-8 text-red-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
              />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">
            Oops! Terjadi Kesalahan
          </h3>
          <p class="text-gray-600 mb-6">
            {{ error }}
          </p>
          <button
            class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105"
            @click="fetchPengaduanDetail"
          >
            <svg
              class="w-5 h-5 inline mr-2"
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
            Coba Lagi
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div
      v-else-if="pengaduan"
      class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4"
    >
      <div class="max-w-3xl mx-auto">
        <!-- Success Animation Container -->
        <div class="text-center mb-8 animate-fade-in">
          <!-- Success Icon with Animation -->
          <div class="relative inline-flex items-center justify-center mb-6">
            <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center animate-bounce-slow shadow-lg">
              <svg
                class="w-12 h-12 text-white animate-check"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M5 13l4 4L19 7"
                />
              </svg>
            </div>
            <!-- Floating particles animation -->
            <div class="absolute inset-0 pointer-events-none">
              <div class="absolute top-0 left-0 w-2 h-2 bg-pink-400 rounded-full animate-float-1" />
              <div class="absolute top-4 right-2 w-1 h-1 bg-green-400 rounded-full animate-float-2" />
              <div class="absolute bottom-2 left-4 w-1.5 h-1.5 bg-blue-400 rounded-full animate-float-3" />
              <div class="absolute bottom-4 right-4 w-1 h-1 bg-yellow-400 rounded-full animate-float-1" />
            </div>
          </div>

          <!-- Main Success Message -->
          <h1 class="text-4xl font-bold text-gray-800 mb-4 animate-slide-up">
            Pengaduan Berhasil Diterima!
          </h1>
          <p class="text-lg text-gray-600 mb-2 animate-slide-up-delay">
            Terima kasih telah melaporkan pengaduan Anda
          </p>
          <p class="text-gray-500 animate-slide-up-delay-2">
            Tim kami akan segera menindaklanjuti laporan yang Anda sampaikan
          </p>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-scale-in">
          <!-- Card Header -->
          <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-8 py-6">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <svg
                  class="w-6 h-6 text-white mr-3"
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
                <h2 class="text-xl font-semibold text-white">
                  Status Pengaduan
                </h2>
              </div>
              <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                <span class="text-black text-sm font-medium">{{ formatDate(new Date()) }}</span>
              </div>
            </div>
          </div>

          <!-- Card Body -->
          <div class="p-8">
            <!-- Kode Pengaduan Section -->
            <div
              v-if="pengaduan && pengaduan.kode_pengaduan"
              class="flex flex-col items-center justify-center mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200"
            >
              <p class="text-sm font-semibold text-gray-700 mb-2">
                Kode Pengaduan Anda:
              </p>
              <div class="flex items-center space-x-3">
                <span class="text-3xl font-mono text-gray-900 tracking-wider font-bold">{{ pengaduan.kode_pengaduan }}</span>
                <button
                  class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors relative" 
                  title="Salin Kode Pengaduan"
                  @click="copyToClipboard(pengaduan.kode_pengaduan)"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-2M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1"
                    />
                  </svg>
                  <span
                    v-if="showCopySuccess"
                    class="absolute -top-8 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs px-2 py-1 rounded-md whitespace-nowrap animate-fade-out"
                  >Disalin!</span>
                </button>
              </div>
              <p class="text-sm text-gray-600 mt-2 text-center">
                Gunakan kode ini untuk melacak status pengaduan Anda.
              </p>
            </div>
            <!-- End Kode Pengaduan Section -->

            <!-- Status Timeline -->
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                  Status Terkini
                </h3>
                <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-3 py-1 rounded-full">
                  Sedang Diproses
                </span>
              </div>
              
              <!-- Timeline -->
              <div class="relative">
                <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200" />
                
                <!-- Current Step -->
                <div class="relative flex items-start mb-6">
                  <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center z-10">
                    <svg
                      class="w-4 h-4 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                      />
                    </svg>
                  </div>
                  <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-800">
                      Pengaduan Diterima
                    </h4>
                    <p class="text-sm text-gray-600">
                      {{ formatDateTime(new Date()) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                      Laporan Anda telah masuk ke sistem kami
                    </p>
                  </div>
                </div>

                <!-- Next Steps -->
                <div class="relative flex items-start mb-6">
                  <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center z-10 animate-pulse">
                    <svg
                      class="w-4 h-4 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-800">
                      Sedang Diproses
                    </h4>
                    <p class="text-sm text-gray-600">
                      Tim akan memverifikasi dalam 1-2 hari kerja
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                      Kami sedang meninjau kelengkapan laporan Anda
                    </p>
                  </div>
                </div>

                <div class="relative flex items-start">
                  <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center z-10">
                    <svg
                      class="w-4 h-4 text-white"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                      />
                    </svg>
                  </div>
                  <div class="ml-4 flex-1">
                    <h4 class="text-sm font-semibold text-gray-400">
                      Tindak Lanjut
                    </h4>
                    <p class="text-sm text-gray-400">
                      Menunggu proses verifikasi
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                      Anda akan dihubungi jika diperlukan informasi tambahan
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
              <div class="flex items-start">
                <svg
                  class="w-5 h-5 text-amber-500 mr-3 mt-0.5 flex-shrink-0"
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
                <div>
                  <h4 class="text-sm font-semibold text-amber-800 mb-2">
                    Informasi Penting
                  </h4>
                  <ul class="text-sm text-amber-700 space-y-1">
                    <li>• Anda akan menerima notifikasi via SMS/Email untuk update status</li>
                    <li>• Simpan nomor referensi untuk melacak progress pengaduan</li>
                    <li>• Tim akan menghubungi jika memerlukan informasi tambahan</li>
                    <li>• Pengaduan palsu akan diproses sesuai ketentuan hukum yang berlaku</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
              <button
                class="flex-1 bg-gradient-to-r from-pink-500 to-pink-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-pink-600 hover:to-pink-700 transition-all duration-300 flex items-center justify-center group shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                @click="goToTrackingPage"
              >
                <svg
                  class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
                Lihat Detail Pengaduan
              </button>
              
              <button
                class="flex-1 sm:flex-none bg-white border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:border-pink-500 hover:text-pink-600 transition-all duration-300 flex items-center justify-center group"
                @click="createNewReport"
              >
                <svg
                  class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  />
                </svg>
                Buat Pengaduan Baru
              </button>
            </div>

            <!-- Contact Information -->
            <div class="mt-8 pt-6 border-t border-gray-200">
              <h4 class="text-sm font-semibold text-gray-800 mb-4">
                Butuh Bantuan?
              </h4>
              <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div class="flex items-center text-gray-600">
                  <svg
                    class="w-4 h-4 mr-2 text-pink-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                  </svg>
                  Hotline: 0800-1234-5678
                </div>
                <div class="flex items-center text-gray-600">
                  <svg
                    class="w-4 h-4 mr-2 text-pink-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                  </svg>
                  Email: pengaduan@example.com
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fallback for empty data -->
    <div
      v-else
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="text-center">
        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
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
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          Data Tidak Ditemukan
        </h3>
        <p class="text-gray-600 mb-4">
          Detail pengaduan tidak dapat dimuat atau ditemukan.
        </p>
        <button
          class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-6 rounded-xl transition-colors"
          @click="router.push('/')"
        >
          Kembali ke Beranda
        </button>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import SimpleLayout from '../../layouts/SimpleLayout.vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../../api.js' // Pastikan Anda mengimpor instance API Anda

const router = useRouter()
const route = useRoute()

const pengaduan = ref(null) // State untuk menyimpan data pengaduan
const showCopySuccess = ref(false) // State untuk pesan sukses salin
const loading = ref(true) // State untuk indikator loading
const error = ref(null) // State untuk pesan error

const fetchPengaduanDetail = async () => {
  let pengaduanId = route.params.id; // Coba ambil dari route params
  if (!pengaduanId) {
    pengaduanId = route.query.id; // Jika tidak ada di params, coba ambil dari query
  }

  if (pengaduanId) {
    try {
      loading.value = true;
      error.value = null;
      const response = await api.get(`/kelola/pengaduan/${pengaduanId}`);
      
      // --- DEBUGGING LOGS BARU ---
      console.log('Full API response object:', response);
      console.log('response.data:', response.data);
      console.log('response.data?.data (dengan optional chaining):', response.data?.data);
      // --- AKHIR DEBUGGING LOGS ---

      // Perbaikan di sini: Langsung gunakan response.data karena objek pengaduan ada di sana
      if (response.data) { // Cukup periksa apakah response.data ada
        pengaduan.value = response.data;
        console.log('Fetched pengaduan data:', pengaduan.value); // Debugging: log data yang diambil
        console.log('Kode Pengaduan:', pengaduan.value.kode_pengaduan); // Debugging: log kode_pengaduan
      } else {
        // Ini akan terpicu jika response.data kosong atau null
        throw new Error('Struktur data API tidak sesuai atau data kosong (response.data is empty).');
      }
    } catch (err) {
      console.error('Error fetching pengaduan detail:', err);
      // Tangani error dari API atau network
      error.value = err.response?.data?.message || err.message || 'Gagal memuat detail pengaduan';
    } finally {
      loading.value = false;
    }
  } else {
    // Ini akan terpicu jika pengaduanId tidak ditemukan di params maupun query
    error.value = 'ID pengaduan tidak ditemukan di URL.';
    loading.value = false;
  }
};

onMounted(() => {
  fetchPengaduanDetail();
});

function formatDate(date) {
  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }).format(date)
}

function formatDateTime(date) {
  return new Intl.DateTimeFormat('id-ID', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  }).format(date)
}

function goToTrackingPage() {
  // Pastikan pengaduan.value dan pengaduan.value.id ada sebelum navigasi
  if (pengaduan.value && pengaduan.value.id) {
    router.push({
      name: 'StatusPengaduan', // Nama route yang benar untuk detail pengaduan
      params: { id: pengaduan.value.id }
    })
  } else {
    console.warn('Tidak dapat menavigasi ke halaman detail: ID pengaduan tidak tersedia.');
    // Opsional: Tampilkan pesan ke pengguna
  }
}

function createNewReport() {
  // Navigate back to form pengaduan
  router.push({ name: 'form-pengaduan' }) // Sesuaikan dengan nama route Anda
}

const copyToClipboard = (text) => {
  if (text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    try {
      document.execCommand('copy');
      showCopySuccess.value = true;
      setTimeout(() => {
        showCopySuccess.value = false;
      }, 2000); // Pesan "Disalin!" akan hilang setelah 2 detik
    } catch (err) {
      console.error('Gagal menyalin teks:', err);
      // Fallback: Anda bisa menambahkan pesan error di UI jika gagal menyalin
    } finally {
      document.body.removeChild(textarea);
    }
  }
};
</script>

<style scoped>
/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes scaleIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes bounceGentle {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-5px);
  }
}

@keyframes checkDraw {
  0% {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
  }
  100% {
    stroke-dasharray: 50;
    stroke-dashoffset: 0;
  }
}


@keyframes float1 {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
    opacity: 1;
  }
  50% {
    transform: translateY(-20px) rotate(180deg);
    opacity: 0.7;
  }
}

@keyframes float2 {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
    opacity: 0.8;
  }
  50% {
    transform: translateY(-15px) rotate(-180deg);
    opacity: 0.4;
  }
}

@keyframes float3 {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
    opacity: 0.9;
  }
  50% {
    transform: translateY(-25px) rotate(90deg);
    opacity: 0.6;
  }
}

@keyframes fadeOut {
  0% { opacity: 1; transform: translateY(0); }
  80% { opacity: 1; transform: translateY(0); }
  100% { opacity: 0; transform: translateY(-10px); }
}

/* Animation classes */
.animate-fade-in {
  animation: fadeIn 0.8s ease-out;
}

.animate-slide-up {
  animation: slideUp 0.6s ease-out;
}

.animate-slide-up-delay {
  animation: slideUp 0.6s ease-out 0.2s both;
}

.animate-slide-up-delay-2 {
  animation: slideUp 0.6s ease-out 0.4s both;
}

.animate-scale-in {
  animation: scaleIn 0.6s ease-out 0.6s both;
}

.animate-bounce-slow {
  animation: bounceGentle 2s infinite;
}

.animate-check {
  stroke-dasharray: 50;
  stroke-dashoffset: 50;
  animation: checkDraw 0.8s ease-out 1s forwards;
}

.animate-float-1 {
  animation: float1 3s ease-in-out infinite;
}

.animate-float-2 {
  animation: float2 2.5s ease-in-out infinite 0.5s;
}

.animate-float-3 {
  animation: float3 2.8s ease-in-out infinite 1s;
}

.animate-fade-out {
  animation: fadeOut 2s forwards;
}

/* Gradient text effect */
.gradient-text {
  background: linear-gradient(135deg, #ec4899, #8b5cf6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Hover effects */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

/* Timeline line animation */
.timeline-line::before {
  content: '';
  position: absolute;
  left: 16px;
  top: 32px;
  bottom: 0;
  width: 2px;
  background: linear-gradient(to bottom, #10b981, #fbbf24, #e5e7eb);
  border-radius: 1px;
}

/* Pulse effect for current step */
@keyframes pulse-gentle {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.4);
  }
  50% {
    box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
  }
}

.animate-pulse {
  animation: pulse-gentle 2s infinite;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #ec4899;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #be185d;
}
</style>
