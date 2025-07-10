<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import {
  ElIcon
} from 'element-plus'
import {
  ArrowRight
} from '@element-plus/icons-vue'
import { 
  GraduationCap, 
  Shield 
} from 'lucide-vue-next'

// Router Vue untuk navigasi
const router = useRouter()

// Data untuk fitur utama
const mainFeatures = ref([
  {
    title: 'Pelatihan',
    description: 'Bergabunglah dalam program pelatihan pemberdayaan perempuan untuk meningkatkan keterampilan dan kemampuan diri.',
    icon: GraduationCap,
    color: '#ec4899',
    bgColor: 'rgba(236, 72, 153, 0.1)',
    route: '/daftar/pelatihan',
    button:'Ikut Pelatihan'
  },
  {
    title: 'Pengaduan',
    description: 'Laporkan kasus kekerasan terhadap perempuan dan anak melalui sistem pengaduan yang aman dan terpercaya.',
    icon: Shield,
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

      <!-- Features Grid -->
      <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6 lg:gap-8 max-w-4xl mx-auto">
        <div
          v-for="(feature, index) in mainFeatures"
          :key="index"
          class="transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
          data-aos="zoom-in"
          :data-aos-delay="index * 100"
        >
          <div
            class="bg-white rounded-2xl p-4 sm:p-6 md:p-8 text-center cursor-pointer border-2 border-transparent hover:border-pink-200 shadow-lg h-full flex flex-col justify-between min-h-[280px] sm:min-h-[320px] md:min-h-[360px]"
            @click="navigateToFeature(feature.route)"
          >
            <!-- Icon -->
            <div class="flex-shrink-0">
              <div 
                class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 rounded-full mx-auto mb-4 flex items-center justify-center transition-transform duration-300 hover:scale-110"
                :style="{
                  backgroundColor: feature.bgColor,
                  color: feature.color
                }"
              >
                <component
                  :is="feature.icon"
                  :size="32"
                  class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12"
                />
              </div>
            </div>

            <!-- Content -->
            <div class="flex-grow flex flex-col justify-center">
              <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800 mb-2 sm:mb-3">
                {{ feature.title }}
              </h3>
              <p class="text-xs sm:text-sm md:text-base text-gray-600 leading-relaxed mb-4 sm:mb-6">
                {{ feature.description }}
              </p>
            </div>

            <!-- Button -->
            <div class="flex-shrink-0">
              <button class="w-full bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg text-xs sm:text-sm md:text-base flex items-center justify-center gap-2">
                {{ feature.button }}
                <ElIcon class="text-sm sm:text-base">
                  <ArrowRight />
                </ElIcon>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* Tambahan style jika diperlukan */
@media (max-width: 470px) {
  .grid-cols-2 > div {
    min-height: 260px;
  }
}

@media (min-width: 471px) and (max-width: 640px) {
  .grid-cols-2 > div {
    min-height: 300px;
  }
}
</style>