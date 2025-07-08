<script setup lang="ts">
import { ref, onMounted } from 'vue'
import {
  ElCard,
  ElRow,
  ElCol,
  ElIcon,
  ElDivider
} from 'element-plus'
import {
  Phone,
  Location,
  Message,
  ChatDotRound
} from '@element-plus/icons-vue'
import AOS from 'aos'
import 'aos/dist/aos.css'

// Data informasi kontak
const contactInfo = ref({
  address: 'Jl. Sudirman No. 123, Jakarta Pusat 10270',
  phone: '(021) 1234-5678',
  email: 'info@dp3ap2kb.go.id',
  whatsapp: '+62812-3456-7890'
})

// Lifecycle hook: saat komponen dimount
onMounted(() => {
  // Refresh AOS untuk memastikan animasi berjalan setelah refresh
  AOS.refresh()
  
  // Inisialisasi AOS dengan konfigurasi yang lebih stabil
  AOS.init({
    duration: 600,
    easing: 'ease-out-cubic',
    once: false, // Memungkinkan animasi berjalan ulang
    offset: 50,
    delay: 100,
    disable: false,
    startEvent: 'DOMContentLoaded',
    initClassName: 'aos-init',
    animatedClassName: 'aos-animate',
    useClassNames: false,
    disableMutationObserver: false,
    debounceDelay: 50,
    throttleDelay: 99
  })
})
</script>

<template>
  <section class="py-12 bg-gradient-to-br from-gray-50 via-white to-pink-50 md:py-16">
    <div class="container mx-auto px-4 max-w-7xl">
      <!-- Section Header -->
      <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="500">
        <h2 class="text-3xl font-bold bg-black bg-clip-text text-transparent mb-4 md:text-4xl">
          Hubungi Kami
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto">
          Dapatkan informasi lebih lanjut atau sampaikan pertanyaan Anda.
        </p>
      </div>

      <!-- Contact Card -->
      <div class="flex justify-center" data-aos="fade-up" data-aos-delay="200">
        <div class="w-full max-w-4xl">
          <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Card Header with gradient -->
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
              <h3 class="text-xl font-semibold text-white">Informasi Kontak</h3>
            </div>
            
            <!-- Card Content -->
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                  <!-- Contact Item: Address -->
                  <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-pink-50 transition-all duration-300">
                    <div class="flex-shrink-0">
                      <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                        <ElIcon size="20px" color="white">
                          <Location />
                        </ElIcon>
                      </div>
                    </div>
                    <div class="min-w-0">
                      <h4 class="font-semibold text-gray-800 mb-1">Alamat</h4>
                      <p class="text-sm text-gray-600">{{ contactInfo.address }}</p>
                    </div>
                  </div>
                  
                  <!-- Contact Item: Phone -->
                  <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-pink-50 transition-all duration-300">
                    <div class="flex-shrink-0">
                      <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                        <ElIcon size="20px" color="white">
                          <Phone />
                        </ElIcon>
                      </div>
                    </div>
                    <div class="min-w-0">
                      <h4 class="font-semibold text-gray-800 mb-1">Telepon</h4>
                      <a href="tel:02112345678" class="text-sm text-gray-600 hover:text-pink-600 transition-colors">{{ contactInfo.phone }}</a>
                    </div>
                  </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                  <!-- Contact Item: Email -->
                  <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-pink-50 transition-all duration-300">
                    <div class="flex-shrink-0">
                      <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                        <ElIcon size="20px" color="white">
                          <Message />
                        </ElIcon>
                      </div>
                    </div>
                    <div class="min-w-0">
                      <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                      <a href="mailto:info@dp3ap2kb.go.id" class="text-sm text-gray-600 hover:text-pink-600 transition-colors break-all">{{ contactInfo.email }}</a>
                    </div>
                  </div>
                  
                  <!-- Contact Item: WhatsApp -->
                  <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-pink-50 transition-all duration-300">
                    <div class="flex-shrink-0">
                      <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center">
                        <ElIcon size="20px" color="white">
                          <ChatDotRound />
                        </ElIcon>
                      </div>
                    </div>
                    <div class="min-w-0">
                      <h4 class="font-semibold text-gray-800 mb-1">WhatsApp</h4>
                      <a href="https://wa.me/6281234567890" target="_blank" class="text-sm text-gray-600 hover:text-pink-600 transition-colors">{{ contactInfo.whatsapp }}</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* Ensure smooth scrolling and proper initialization */
html {
  scroll-behavior: smooth;
}

/* Custom animations for enhanced visual appeal */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.8;
  }
}

/* Enhanced icon sizing and spacing */
.el-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 28px;
  min-height: 28px;
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .space-y-6 > * + * {
    margin-top: 1rem;
  }
  
  .gap-4 {
    gap: 0.75rem;
  }
}

/* Ensure AOS animations work properly after page refresh */
[data-aos] {
  pointer-events: none;
}

[data-aos].aos-animate {
  pointer-events: auto;
}

/* Custom gradient text support for older browsers */
.bg-clip-text {
  -webkit-background-clip: text;
  background-clip: text;
}

/* Enhanced shadow and hover effects */
.shadow-2xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

/* Improved link styling */
a {
  transition: all 0.3s ease;
}

a:hover {
  text-decoration: none;
}
</style>