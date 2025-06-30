<script setup lang="ts">
import { ref } from 'vue'
import {
  ElRow,
  ElCol,
  ElIcon
} from 'element-plus'
import {
  Female
} from '@element-plus/icons-vue'
</script>

<template>
  <!-- Tentang Kami -->
  <section class="py-16 md:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <ElRow :gutter="40" align="middle">
        <ElCol :xs="24" :md="12" data-aos="fade-right">
          <div class="md:pr-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              Tentang Kami
            </h2>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
              Dinas Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga Berencana (DP3AP2KB)
              berkomitmen untuk menciptakan masyarakat yang adil gender, melindungi hak-hak anak,
              dan mendukung program keluarga berencana yang berkelanjutan.
            </p>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
              Melalui berbagai program inovatif dan pelayanan terintegrasi, kami berupaya
              memberdayakan perempuan untuk berperan aktif dalam pembangunan, melindungi
              anak dari segala bentuk kekerasan, dan mendukung keluarga Indonesia yang sejahtera.
            </p>
            
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:gap-8 mt-8 sm:mt-12">
              <div class="text-center">
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-pink-500 mb-2">
                  5000+
                </h3>
                <p class="text-sm sm:text-base text-gray-600 font-medium">
                  Wanita Diberdayakan
                </p>
              </div>
              <div class="text-center">
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-pink-500 mb-2">
                  15+
                </h3>
                <p class="text-sm sm:text-base text-gray-600 font-medium">
                  Kabupaten Kota
                </p>
              </div>
            </div>
          </div>
        </ElCol>
        
        <!-- Illustration - Hidden on mobile <470px -->
        <ElCol :xs="24" :md="12" data-aos="fade-left" class="hidden sm:block">
          <div class="flex items-center justify-center h-96 mt-12 md:mt-0">
            <div class="w-70 h-70 bg-gradient-to-br from-pink-100 to-purple-100 rounded-full flex items-center justify-center animate-pulse">
              <ElIcon size="140" color="#ec4899">
                <Female />
              </ElIcon>
            </div>
          </div>
        </ElCol>
      </ElRow>
    </div>
  </section>
</template>

<style scoped>
/* Custom animation for pulse effect */
@keyframes pulse {
  0%, 100% { 
    transform: scale(1); 
  }
  50% { 
    transform: scale(1.05); 
  }
}

.animate-pulse {
  animation: pulse 2s ease-in-out infinite;
}

/* Custom width/height for illustration */
.w-70 {
  width: 17.5rem;
}

.h-70 {
  height: 17.5rem;
}

/* Ensure illustration is hidden on very small screens */
@media (max-width: 470px) {
  .sm\:block {
    display: none !important;
  }
}
</style>