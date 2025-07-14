<template>
  <SimpleLayout>
    <div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">
      <div class="max-w-4xl mx-auto">
        <!-- Tombol Kembali -->
        <button
          @click="goBack"
          class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200"
        >
          <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
          Kembali
        </button>

        <!-- Kontainer Utama -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <!-- Loading Skeleton -->
          <div v-if="isLoading" class="p-8 animate-pulse">
            <div class="h-8 bg-gray-200 rounded w-3/4 mb-4"></div>
            <div class="space-y-4">
              <div class="h-4 bg-gray-200 rounded w-full"></div>
              <div class="h-4 bg-gray-200 rounded w-5/6"></div>
              <div class="h-4 bg-gray-200 rounded w-full"></div>
            </div>
          </div>

          <!-- Info/Error Message -->
          <div v-else-if="error" class="p-8 text-center">
            <div class="w-16 h-16 mx-auto text-yellow-400">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="mt-4 text-xl font-semibold text-gray-800">Informasi</h3>
            <p class="mt-2 text-gray-500">{{ error }}</p>
            <button
              v-if="error.includes('Anda belum terdaftar')"
              @click="router.push('/Daftar/Pelatihan')"
              class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500"
            >
              Silakan lakukan pendaftaran terlebih dahulu
            </button>
          </div>

          <!-- Profile Content -->
          <div v-else-if="profileData" class="transition-opacity duration-500 cursor-pointer hover:shadow-2xl" @click="goToProfileDetail">
            <!-- Profile Header -->
            <div class="p-8 bg-gradient-to-br from-pink-50 to-rose-100">
              <div class="flex flex-col sm:flex-row items-center text-center sm:text-left">
                <div class="relative mb-4 sm:mb-0 sm:mr-6">
                  <div class="w-24 h-24 rounded-full flex items-center justify-center bg-gradient-to-br from-pink-400 to-pink-600 text-white font-bold text-4xl shadow-lg ring-4 ring-white">
                    {{ getInitials(profileData.nama) }}
                  </div>
                </div>
                <div class="flex-1">
                  <h2 class="text-3xl font-bold text-gray-800">{{ profileData.nama }}</h2>
                  <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold text-pink-800 bg-pink-200 rounded-full">{{ profileData.jenis_bimtek }}</span>
                </div>
              </div>
            </div>

            <!-- Profile Details -->
            <div class="p-8">
              <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-3">Ringkasan Status Pelatihan</h3>
              <ul class="space-y-5">
                <li class="flex items-center">
                  <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  </div>
                  <div>
                    <span class="text-sm text-gray-500">Status Pendaftaran</span>
                    <p class="font-medium text-gray-800" :class="statusClass(profileData.status_pendaftaran)">{{ profileData.status_pendaftaran }}</p>
                  </div>
                </li>
                <li class="flex items-center">
                  <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  </div>
                  <div>
                    <span class="text-sm text-gray-500">Tanggal Pendaftaran</span>
                    <p class="font-medium text-gray-800">{{ formatDate(profileData.created_at) }}</p>
                  </div>
                </li>
                 <li class="flex items-center">
                  <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                  </div>
                  <div>
                    <span class="text-sm text-gray-500">Keterangan</span>
                    <p class="font-medium text-gray-800">{{ profileData.keterangan || '-' }}</p>
                  </div>
                </li>
              </ul>
              <div class="mt-6 text-center text-sm text-gray-500">
                Klik kartu ini untuk melihat detail lengkap.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api.js';
import SimpleLayout from '@/layouts/SimpleLayout.vue';

const router = useRouter();
const profileData = ref(null);
const isLoading = ref(true);
const error = ref(null);

const fetchProfileData = async (nik) => {
  isLoading.value = true;
  error.value = null;
  try {
    const response = await api.get(`/profile/masyarakat/${nik}`);
    if (response.data) {
      profileData.value = response.data;
    } else {
      throw new Error('Data profil tidak ditemukan.');
    }
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Terjadi kesalahan saat mengambil data.';
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

const getInitials = (name) => {
  if (!name) return '?';
  const parts = name.split(' ');
  let initials = parts[0] ? parts[0][0] : '';
  if (parts.length > 1 && parts[parts.length - 1]) {
    initials += parts[parts.length - 1][0];
  }
  return initials.toUpperCase();
};

const formatDate = (dateString) => {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};

const statusClass = (status) => {
  switch (status.toLowerCase()) {
    case 'diterima':
      return 'text-green-600';
    case 'ditolak':
      return 'text-red-600';
    case 'diproses':
      return 'text-yellow-600';
    default:
      return 'text-gray-800';
  }
};

const goToProfileDetail = () => {
  if (profileData.value) {
    router.push(`/masyarakat/${profileData.value.nik}`);
  }
};

const goBack = () => {
  router.go(-1);
};

onMounted(() => {
  const savedNIK = localStorage.getItem('savedNIK');
  if (savedNIK) {
    fetchProfileData(savedNIK);
  } else {
    isLoading.value = false;
    error.value = 'Anda belum terdaftar dalam program ini. Silakan daftar atau login terlebih dahulu untuk melihat status.';
  }
});
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
