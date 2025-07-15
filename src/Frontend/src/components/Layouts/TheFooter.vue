<template>
  <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-300 mt-16 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
      <div class="absolute top-0 left-0 w-96 h-96 bg-pink-500 rounded-full filter blur-3xl" />
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl" />
    </div>
    
    <div class="relative max-w-7xl mx-auto px-9 py-16">
      <!-- Main Footer Content -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 mb-12">
        <!-- Brand Section -->
        <div class="lg:col-span-2">
          <div class="mb-8">
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4 shadow-lg overflow-hidden">
                <img 
                  src="/Header/Logo.png" 
                  alt="DP3AP2KB Logo" 
                  class="w-10 h-10 object-contain"
                  @error="handleImageError"
                >
              </div>
              <h3 class="text-3xl font-black bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">
                DP3AP2KB
              </h3>
            </div>
            <p class="text-slate-300 text-base leading-relaxed mb-4 max-w-md">
              Dinas Pemberdayaan Perempuan dan Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana
            </p>
            <div class="relative">
              <p class="text-pink-300 italic text-sm font-medium bg-slate-800/50 backdrop-blur-sm px-4 py-3 rounded-lg border border-pink-500/20">
                "Membangun Indonesia yang Adil Gender dan Ramah Anak"
              </p>
            </div>
          </div>
          
          <!-- Social Media -->
          <div class="flex space-x-4">
            <a 
              v-for="social in socialLinks" 
              :key="social.name"
              :href="social.href"
              :class="social.hoverColor"
              class="group relative w-12 h-12 bg-slate-700/80 backdrop-blur-sm rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:shadow-lg border border-slate-600/50"
            >
              <!-- eslint-disable-next-line vue/no-v-html -->
              <svg
                class="w-6 h-6 text-slate-300 group-hover:text-white transition-colors duration-300"
                fill="currentColor"
                viewBox="0 0 24 24"
                v-html="social.iconSvg"
              />
              <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                {{ social.name }}
              </div>
            </a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 lg:col-span-2">
          <div
            v-for="column in footerColumns"
            :key="column.title"
            class="space-y-6"
          >
            <h4 class="text-white font-bold text-lg mb-6 relative">
              {{ column.title }}
              <span class="absolute -bottom-1 left-0 w-8 h-1 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full" />
            </h4>
            <ul class="space-y-4">
              <li
                v-for="link in column.links"
                :key="link.name"
              >
                <a 
                  :href="link.href"
                  class="text-slate-400 hover:text-pink-300 transition-all duration-300 flex items-center group hover:translate-x-1"
                >
                  <div class="w-1.5 h-1.5 bg-pink-400 rounded-full mr-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                  <span class="relative">
                    {{ link.name }}
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-pink-400 transition-all duration-300 group-hover:w-full" />
                  </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Bottom Footer -->
      <div class="border-t border-slate-700/50 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <p class="text-slate-400 text-sm">
          &copy; 2025 DP3AP2KB. Semua hak dilindungi undang-undang.
        </p>
        <p class="text-slate-400 text-sm flex items-center">
          Dikembangkan dengan 
          <svg
            class="w-4 h-4 mx-2 text-pink-400 animate-pulse"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
          </svg>
          untuk Indonesia yang lebih baik
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'

// Footer data
const footerColumns = ref([
  {
    title: 'Layanan',
    links: [
      { name: 'Program Pelatihan', href: '/info/pelatihan' },
      { name: 'Pengaduan Online', href: '/info/pengaduan' },
      { name: 'Konsultasi', href: '/info/konsultasi' },
      { name: 'Pendampingan', href: '/info/pendampingan' }
    ]
  },
  {
    title: 'Dukungan',
    links: [
      { name: 'Pusat Bantuan', href: '/bantuan' },
      { name: 'FAQ', href: '/faq' },
      { name: 'Hubungi Kami', href: '/kontak' },
      { name: 'Feedback', href: '/feedback' }
    ]
  }
])

const socialLinks = ref([
  {
    name: 'Instagram',
    href: 'https://instagram.com/dp3ap2kb',
    hoverColor: 'hover:bg-gradient-to-br hover:from-purple-500 hover:to-pink-500',
    iconSvg: `<path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987c6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-2.458 0-4.467-2.01-4.467-4.468s2.009-4.467 4.467-4.467c2.458 0 4.468 2.009 4.468 4.467S10.907 16.988 8.449 16.988zM12.017 7.046c-2.761 0-5.033 2.272-5.033 5.033s2.272 5.033 5.033 5.033s5.033-2.272 5.033-5.033S14.778 7.046 12.017 7.046z"/>`
  },
  {
    name: 'Facebook',
    href: 'https://facebook.com/dp3ap2kb',
    hoverColor: 'hover:bg-blue-600',
    iconSvg: `<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>`
  },
  {
    name: 'Telegram',
    href: 'https://t.me/dp3ap2kb',
    hoverColor: 'hover:bg-blue-500',
    iconSvg: `<path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>`
  },
  {
    name: 'WhatsApp',
    href: 'https://wa.me/628123456789',
    hoverColor: 'hover:bg-green-500',
    iconSvg: `<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>`
  }
])

// Handle image error
const handleImageError = (event) => {
  // Fallback to gradient background if image fails to load
  event.target.style.display = 'none'
  event.target.parentElement.innerHTML = `
    <svg class="w-7 h-7 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9Z"/>
    </svg>
  `
  event.target.parentElement.classList.add('bg-gradient-to-br', 'from-pink-500', 'to-purple-600')
  event.target.parentElement.classList.remove('bg-white')
}
</script>

<style scoped>
/* Custom animations */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Smooth scrolling untuk link anchor */
html {
  scroll-behavior: smooth;
}

/* Custom backdrop blur support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}
</style>