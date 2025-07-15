<template>
  <div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
      <!-- Tombol Kembali -->
      <button
        class="mb-6 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors duration-200"
        @click="goBack"
      >
        <svg
          class="w-5 h-5 mr-2"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 19l-7-7 7-7"
          />
        </svg>
        Kembali
      </button>

      <!-- Kontainer Utama -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Loading Skeleton -->
        <div
          v-if="isLoading"
          class="p-8 animate-pulse"
        >
          <div class="flex items-center mb-6">
            <div class="w-24 h-24 bg-gray-200 rounded-full mr-6" />
            <div class="flex-1">
              <div class="h-8 bg-gray-200 rounded w-3/4 mb-2" />
              <div class="h-5 bg-gray-200 rounded w-1/2" />
            </div>
          </div>
          <div class="space-y-4">
            <div class="h-4 bg-gray-200 rounded w-full" />
            <div class="h-4 bg-gray-200 rounded w-5/6" />
            <div class="h-4 bg-gray-200 rounded w-full" />
          </div>
        </div>

        <!-- Error Message -->
        <div
          v-else-if="error"
          class="p-8 text-center"
        >
          <div class="w-16 h-16 mx-auto text-red-400">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-full h-full"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <h3 class="mt-4 text-xl font-semibold text-gray-800">
            Gagal Memuat Data
          </h3>
          <p class="mt-2 text-gray-500">
            {{ error }}
          </p>
        </div>

        <!-- Profile Content -->
        <div
          v-else-if="user"
          class="transition-opacity duration-500"
        >
          <!-- Profile Header -->
          <div class="p-8 bg-gradient-to-br from-pink-50 to-rose-100">
            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left">
              <div class="relative mb-4 sm:mb-0 sm:mr-6">
                <div class="w-24 h-24 rounded-full flex items-center justify-center bg-gradient-to-br from-pink-400 to-pink-600 text-white font-bold text-4xl shadow-lg ring-4 ring-white">
                  {{ userInitials }}
                </div>
              </div>
              <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-800">
                  {{ user.name }}
                </h2>
                <span class="inline-block mt-2 px-3 py-1 text-sm font-semibold text-pink-800 bg-pink-200 rounded-full">{{ user.role }}</span>
              </div>
            </div>
          </div>

          <!-- Profile Details -->
          <div class="p-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-3">
              Detail Informasi
            </h3>
            <ul class="space-y-5">
              <li class="flex items-center">
                <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                  <svg
                    class="w-6 h-6 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  ><path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"
                  /></svg>
                </div>
                <div>
                  <span class="text-sm text-gray-500">Email</span>
                  <p class="font-medium text-gray-800">
                    {{ user.email }}
                  </p>
                </div>
              </li>
              <li class="flex items-center">
                <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                  <svg
                    class="w-6 h-6 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  ><path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"
                  /></svg>
                </div>
                <div>
                  <span class="text-sm text-gray-500">Username</span>
                  <p class="font-medium text-gray-800">
                    {{ user.username }}
                  </p>
                </div>
              </li>
              <li class="flex items-center">
                <div class="w-10 h-10 flex-shrink-0 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                  <svg
                    class="w-6 h-6 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  ><path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  /></svg>
                </div>
                <div>
                  <span class="text-sm text-gray-500">Tanggal Bergabung</span>
                  <p class="font-medium text-gray-800">
                    {{ formattedJoinDate }}
                  </p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const user = ref(null);
const isLoading = ref(true);
const error = ref(null);

const userId = route.params.id;

const fetchUserData = async () => {
  isLoading.value = true;
  error.value = null;
  try {
    const response = await axios.get(`http://localhost:8000/api/profile/admin/${userId}`);
    if (response.data.status === 'success') {
      user.value = response.data.data;
    } else {
      throw new Error(response.data.message || 'Data pengguna tidak ditemukan.');
    }
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Terjadi kesalahan saat mengambil data.';
    console.error(err);
  } finally {
    isLoading.value = false;
  }
};

const userInitials = computed(() => {
  if (!user.value || !user.value.name) return '?';
  const parts = user.value.name.split(' ');
  let initials = parts[0] ? parts[0][0] : '';
  if (parts.length > 1 && parts[parts.length - 1]) {
    initials += parts[parts.length - 1][0];
  }
  return initials.toUpperCase();
});

const formattedJoinDate = computed(() => {
  if (!user.value || !user.value.created_at) return '-';
  return new Date(user.value.created_at).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
});

const goBack = () => {
  router.go(-1);
};

onMounted(() => {
  fetchUserData();
});
</script>

<style scoped>
/* Menambahkan sedikit style tambahan jika diperlukan */
</style>
