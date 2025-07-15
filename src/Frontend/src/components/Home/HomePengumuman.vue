<template>
  <!-- Container utama dibuat fleksibel untuk mengisi parent-nya -->
  <div class="w-full h-full flex flex-col bg-white">
    <!-- Header Section (dibuat lebih ringkas) -->
    <div
      class="text-center p-6 border-b border-gray-200"
      data-aos="fade-up"
    >
      <h2 class="text-2xl font-bold text-gray-800">
        Pengumuman
      </h2>
      <p class="text-sm text-gray-500 mt-1">
        Informasi dan jadwal terkini
      </p>
    </div>

    <!-- Loading State -->
    <div
      v-if="loading"
      class="flex-grow flex flex-col items-center justify-center p-4 text-center"
    >
      <div class="w-10 h-10 border-4 border-pink-200 border-t-pink-500 rounded-full animate-spin" />
      <p class="mt-4 text-gray-600">
        Memuat pengumuman...
      </p>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="flex-grow flex items-center justify-center p-4 text-center"
    >
      <div class="bg-red-50 border border-red-200 rounded-xl p-6 w-full max-w-sm text-red-700">
        <p class="font-semibold">
          Oops! Terjadi Kesalahan
        </p>
        <p class="mt-1 text-sm text-red-600">
          {{ error }}
        </p>
      </div>
    </div>

    <!-- No Announcements State -->
    <div
      v-else-if="announcements.length === 0"
      class="flex-grow flex items-center justify-center p-4 text-center"
    >
      <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 w-full max-w-sm">
        <!-- SVG Icon Inlined -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="w-10 h-10 text-gray-400 mx-auto mb-3 opacity-75"
        >
          <path d="M20 17H4V16C4 12.6863 6.68629 10 10 10V9C10 6.23858 12.2386 4 15 4H16C18.7614 4 21 6.23858 21 9V16.9999L20 17ZM12 21C12.5523 21 13 20.5523 13 20H11C11 20.5523 11.4477 21 12 21Z" />
        </svg>
        <p class="font-medium text-gray-700">
          Belum Ada Pengumuman
        </p>
        <p class="text-sm text-gray-500 mt-1">
          Silakan periksa kembali nanti.
        </p>
      </div>
    </div>

    <!-- Announcements List (Responsive: Horizontal Scroll on Mobile, Vertical on Desktop) -->
    <div
      v-else
      id="announcement-scroll-container"
      class="flex-grow overflow-y-hidden overflow-x-auto lg:overflow-y-auto lg:overflow-x-hidden scrollbar-thin scrollbar-thumb-pink-300 scrollbar-track-pink-50 scrollbar-thumb-rounded-full"
    >
      <div class="flex p-4 gap-4 lg:flex-col lg:gap-3">
        <div
          v-for="(announcement, index) in announcements"
          :key="announcement.id"
          class="flex-shrink-0 w-80 lg:w-full bg-white border border-gray-200 p-4 rounded-xl shadow-sm hover:shadow-md hover:border-pink-200 transition-all duration-300 cursor-pointer"
          data-aos="fade-up"
          data-aos-anchor="#announcement-scroll-container"
          :data-aos-delay="index * 50"
          @click="goToAnnouncementDetail(announcement.id)"
        >
          <div class="flex items-start justify-between gap-4">
            <div class="flex-shrink-0">
              <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                <!-- SVG Icon Inlined -->
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="currentColor"
                  class="w-5 h-5 text-pink-500"
                >
                  <path d="M20 17H4V16C4 12.6863 6.68629 10 10 10V9C10 6.23858 12.2386 4 15 4H16C18.7614 4 21 6.23858 21 9V16.9999L20 17ZM12 21C12.5523 21 13 20.5523 13 20H11C11 20.5523 11.4477 21 12 21Z" />
                </svg>
              </div>
            </div>
            <div class="flex-grow min-w-0">
              <h4 class="text-base font-semibold text-gray-800 leading-tight truncate">
                {{ announcement.judul }}
              </h4>
              <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                {{ announcement.isi }}
              </p>
            </div>
            <div class="flex-shrink-0 text-right">
              <span :class="getTagClasses(announcement.created_at)">
                {{ getAnnouncementLabel(announcement.created_at) }}
              </span>
              <p class="text-xs text-gray-400 mt-2">
                {{ formatDate(announcement.created_at) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, nextTick } from 'vue';
import { useRouter } from 'vue-router';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Import composable dan service
import { useAnnouncements } from '../../services/useAnnouncements';
import { formatDate, getAnnouncementType, getAnnouncementLabel } from '../../services/dateFormatter';

// Router untuk navigasi
const router = useRouter();

// Menggunakan composable
const { announcements, loading, error, fetchAnnouncements } = useAnnouncements();

// Fungsi untuk navigasi
const goToAnnouncementDetail = (announcementId: number | string) => {
  router.push(`/pengumuman/${announcementId}`);
};

// Fungsi untuk mendapatkan kelas tag dinamis
const getTagClasses = (date: string) => {
  const type = getAnnouncementType(date);
  const baseClasses = 'font-medium px-2.5 py-0.5 rounded-full text-xs';
  const typeClasses = {
    success: 'bg-green-100 text-green-800', // Baru
    warning: 'bg-yellow-100 text-yellow-800', // Akan Datang
    info: 'bg-pink-100 text-pink-800', // Berlangsung
  };
  return `${baseClasses} ${typeClasses[type] || typeClasses.info}`;
};

// Lifecycle hooks
onMounted(async () => {
  await fetchAnnouncements();

  nextTick(() => {
    AOS.init({
      duration: 600,
      easing: 'ease-out-cubic',
      once: true,
      offset: 20,
    });
  });
});
</script>

<style>
/* Plugin `tailwind-scrollbar` dan `@tailwindcss/line-clamp`
  diasumsikan sudah terpasang di konfigurasi Tailwind Anda.
*/
</style>
