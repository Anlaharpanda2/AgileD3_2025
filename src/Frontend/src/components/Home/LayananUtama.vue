<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

// Router Vue untuk navigasi
const router = useRouter()

// Data untuk fitur utama
// CATATAN: Properti 'icon' yang sebelumnya berisi komponen ikon telah dihapus.
// Logika untuk menampilkan ikon sekarang ditangani langsung di template dengan SVG inline.
const mainFeatures = ref([
  {
    title: 'Pelatihan',
    description: 'Bergabunglah dalam program pelatihan pemberdayaan perempuan untuk meningkatkan keterampilan dan kemampuan diri.',
    iconName: 'GraduationCap', // Nama ikon untuk seleksi di template
    color: '#ec4899',
    bgColor: 'rgba(236, 72, 153, 0.1)',
    route: '/daftar/pelatihan',
    button:'Ikut Pelatihan'
  },
  {
    title: 'Pengaduan',
    description: 'Laporkan kasus kekerasan terhadap perempuan dan anak melalui sistem pengaduan yang aman dan terpercaya.',
    iconName: 'Shield', // Nama ikon untuk seleksi di template
    color: '#8b5cf6',
    bgColor: 'rgba(139, 92, 246, 0.1)',
    route: '/pengaduan/buat',
    button:'Buat Pengaduan'
  }
])

// Metode untuk navigasi ke fitur tertentu
const navigateToFeature = (route: string) => {
  router.push(route)
}
</script>

<template>
  <!-- Fitur Utama -->
  <section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div
        class="text-center mb-12"
        data-aos="fade-up"
      >
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
          Layanan
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Akses langsung ke layanan utama untuk pemberdayaan dan perlindungan
        </p>
      </div>

      <!-- 
        Features Grid 
        CATATAN: Diubah menjadi 'grid-cols-2' agar tetap 2 kolom di mobile.
        Gap disesuaikan untuk layar yang lebih kecil.
      -->
      <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:gap-8 max-w-4xl mx-auto">
        <div
          v-for="(feature, index) in mainFeatures"
          :key="index"
          class="transform transition-all duration-500 ease-in-out hover:-translate-y-2 hover:shadow-xl"
          data-aos="zoom-in"
          :data-aos-delay="index * 100"
        >
          <div
            class="bg-white rounded-2xl p-4 sm:p-6 md:p-8 text-center cursor-pointer border-2 border-transparent hover:border-pink-200 shadow-lg h-full flex flex-col justify-between"
            @click="navigateToFeature(feature.route)"
          >
            <!-- Icon -->
            <div class="flex-shrink-0">
              <div 
                class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full mx-auto mb-4 flex items-center justify-center transition-transform duration-500 ease-in-out hover:scale-110"
                :style="{
                  backgroundColor: feature.bgColor,
                  color: feature.color
                }"
              >
                <!-- 
                  CATATAN: Ikon sekarang dirender sebagai SVG inline. Ukurannya disesuaikan untuk mobile.
                -->
                <svg v-if="feature.iconName === 'GraduationCap'" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.838l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                <svg v-if="feature.iconName === 'Shield'" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>

              </div>
            </div>

            <!-- Content -->
            <div class="flex-grow flex flex-col justify-center">
              <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-3">
                {{ feature.title }}
              </h3>
              <!-- 
                CATATAN: Deskripsi sekarang disembunyikan di layar kecil (mobile) menggunakan 'hidden sm:block'.
              -->
              <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-6 hidden sm:block">
                {{ feature.description }}
              </p>
            </div>

            <!-- Button -->
            <div class="flex-shrink-0">
              <!-- 
                CATATAN: Durasi transisi diperpanjang menjadi 500ms dan ditambahkan ease-in-out untuk animasi yang lebih halus.
                Padding dan ukuran teks disesuaikan untuk mobile.
              -->
              <button class="w-full bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-semibold py-2 px-4 sm:py-3 sm:px-6 rounded-xl transition-all duration-500 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg text-xs sm:text-sm md:text-base flex items-center justify-center gap-2">
                {{ feature.button }}
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor" class="text-base">
                  <path d="M16.172 11l-5.364-5.364l1.414-1.414L20 12l-7.778 7.778l-1.414-1.414L16.172 13H4v-2z"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* TAG STYLE INI SEKARANG KOSONG.
  Semua styling, termasuk @media query, telah dimigrasikan ke dalam 
  class utility Tailwind di dalam template.
*/
</style>
