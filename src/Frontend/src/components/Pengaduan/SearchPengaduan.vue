<template>
  <SimpleLayout>
    <div class="container mx-auto p-4">
      <el-card class="box-card shadow-lg rounded-lg bg-white">
        <template #header>
          <div class="flex items-center justify-between mb-4">
            <span class="text-2xl font-semibold text-gray-800">Cari Pengaduan</span>
          </div>
        </template>

        <el-form @submit.prevent="handleSearch">
          <el-form-item label="Kode Pengaduan (6 digit)">
            <el-input
              v-model="searchCode"
              placeholder="Masukkan kode pengaduan"
              maxlength="6"
              class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
              @keyup.enter="handleSearch"
            />
          </el-form-item>
          <el-button
            type="primary"
            :disabled="isSearching"
            class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
            @click="handleSearch"
          >
            {{ isSearching ? 'Mencari...' : 'Cari' }}
          </el-button>
        </el-form>

        <div
          v-if="isSearching"
          class="text-center text-pink-500 mt-8"
        >
          <p class="text-lg">
            Mencari pengaduan...
          </p>
        </div>

        <div
          v-else-if="error"
          class="text-center text-red-500 mt-8"
        >
          <p>{{ error }}</p>
        </div>

        <!-- Card Pengaduan -->
        <div
          v-else-if="pengaduanData"
          class="mt-8"
        >
          <div
            class="pengaduan-card bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2 hover:scale-105 overflow-hidden"
            @click="navigateToPengaduan"
          >
            <!-- Header Card -->
            <div class="card-header bg-gradient-to-r from-pink-50 to-white p-6 border-b border-gray-100">
              <div class="flex justify-between items-start">
                <div class="flex-1">
                  <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full flex items-center justify-center">
                      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                      </svg>
                    </div>
                    <div>
                      <h3 class="text-xl font-bold text-gray-800">
                        {{ pengaduanData.kasus }}
                      </h3>
                      <p class="text-sm text-gray-600 font-medium">
                        Kode: {{ pengaduanData.kode_pengaduan }}
                      </p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                  <div class="status-badge" :class="getStatusBadgeClass(pengaduanData.status)">
                    {{ pengaduanData.status }}
                  </div>
                  <div class="text-xs text-gray-500">
                    {{ formatDate(pengaduanData.waktu_kejadian) }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Content Card -->
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="info-item">
                  <div class="info-icon bg-pink-100 text-pink-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-500">Nama Pelapor</p>
                    <p class="font-semibold text-gray-800">{{ pengaduanData.nama_pelapor }}</p>
                  </div>
                </div>
                <div class="info-item">
                  <div class="info-icon bg-pink-100 text-pink-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-500">Lokasi</p>
                    <p class="font-semibold text-gray-800 truncate">{{ pengaduanData.alamat }}</p>
                  </div>
                </div>
              </div>

              <div class="mb-6">
                <p class="text-sm font-medium text-gray-500 mb-2">Deskripsi Singkat</p>
                <p class="text-gray-700 line-clamp-2 leading-relaxed">{{ pengaduanData.deskripsi }}</p>
              </div>

              <!-- Action Button -->
              <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                  </svg>
                  Lihat Detail
                </div>
                <div class="action-arrow text-pink-500">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          v-else-if="searchAttempted && !pengaduanData"
          class="text-center text-gray-500 mt-8"
        >
          <p class="text-lg">
            Pengaduan dengan kode tersebut tidak ditemukan.
          </p>
        </div>
      </el-card>
    </div>
  </SimpleLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import { AxiosError } from 'axios';
import api from '../../api.js';
import SimpleLayout from '@/layouts/SimpleLayout.vue';

interface Pengaduan {
  id: string | number;
  kode_pengaduan: string;
  nama_pelapor: string;
  nama_korban?: string;
  deskripsi: string;
  alamat: string;
  waktu_kejadian: string;
  kasus: string;
  no_hp: string;
  saksi?: string;
  status: string;
  lampiran_url?: string;
}

const router = useRouter();
const searchCode = ref('');
const pengaduanData = ref<Pengaduan | null>(null);
const isSearching = ref(false);
const error = ref<string | null>(null);
const searchAttempted = ref(false);

const handleSearch = async () => {
  error.value = null;
  pengaduanData.value = null;
  searchAttempted.value = true;

  if (searchCode.value.length !== 6 || !/^[0-9]+$/.test(searchCode.value)) {
    error.value = 'Kode pengaduan harus 6 digit angka.';
    ElMessage.error(error.value);
    return;
  }

  isSearching.value = true;
  try {
    const response = await api.post('/kelola/pengaduan/cari', {
      kode_pengaduan: searchCode.value
    });
    pengaduanData.value = response.data;
  } catch (err: unknown) {
    if (err instanceof AxiosError && err.response) {
      if (err.response.status === 404) {
        error.value = 'Pengaduan tidak ditemukan.';
      } else if (err.response.data && err.response.data.message) {
        error.value = err.response.data.message;
      } else {
        error.value = 'Terjadi kesalahan saat mencari pengaduan.';
      }
    } else if (err instanceof Error) {
      error.value = err.message;
    } else {
      error.value = 'Terjadi kesalahan yang tidak diketahui.';
    }
    ElMessage.error(error.value);
  } finally {
    isSearching.value = false;
  }
};

const navigateToPengaduan = () => {
  if (pengaduanData.value && pengaduanData.value.id) {
    router.push(`/pengaduan/status/${pengaduanData.value.id}`);
  }
};

const getStatusBadgeClass = (status: string) => {
  switch (status?.toLowerCase()) {
    case 'selesai':
      return 'bg-green-100 text-green-700 border border-green-200';
    case 'proses':
      return 'bg-yellow-100 text-yellow-700 border border-yellow-200';
    case 'pending':
      return 'bg-blue-100 text-blue-700 border border-blue-200';
    default:
      return 'bg-gray-100 text-gray-700 border border-gray-200';
  }
};

const formatDate = (dateString: string) => {
  try {
    return new Date(dateString).toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric'
    });
  } catch {
    return dateString;
  }
};
</script>

<style scoped>
.pengaduan-card {
  transition: all 0.3s ease;
}

.pengaduan-card:hover {
  transform: translateY(-8px) scale(1.02);
}

.pengaduan-card:hover .action-arrow {
  transform: translateX(4px);
}

.card-header {
  background: linear-gradient(135deg, #fdf2f8 0%, #ffffff 100%);
}

.status-badge {
  @apply px-3 py-1 text-xs font-semibold rounded-full;
}

.info-item {
  @apply flex items-center gap-3;
}

.info-icon {
  @apply w-8 h-8 rounded-full flex items-center justify-center;
}

.action-arrow {
  transition: transform 0.3s ease;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 4px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #ec4899;
  border-radius: 2px;
}

::-webkit-scrollbar-thumb:hover {
  background: #db2777;
}

/* Focus styles */
.pengaduan-card:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
}

/* Loading animation */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>