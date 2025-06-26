<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import {
  ElCard,
  ElRow,
  ElCol,
  ElIcon,
  ElImage,
  ElTag,
  ElButton,
  ElLoading
} from 'element-plus'
import { ArrowRight, ArrowLeft } from '@element-plus/icons-vue'
import { useRouter } from 'vue-router'
import AOS from 'aos'
import 'aos/dist/aos.css'
import api from '../../api.js'

// Interface untuk tipe data berita
interface BeritaItem {
  id: number
  judul: string
  isi: string
  jenis_konten: string
  foto: string
  created_at: string
  updated_at: string
  deleted_at: string | null
}

// Router instance
const router = useRouter()

// State untuk data berita
const news = ref<BeritaItem[]>([])
const loading = ref(true)
const error = ref('')

// State untuk carousel - DIPERBARUI
const currentIndex = ref(0)
const carouselContainer = ref<HTMLElement | null>(null)
const isAnimating = ref(false) // Untuk mencegah spam click
const animationDuration = 600 // ms

// Computed properties
const maxIndex = computed(() => Math.max(0, news.value.length - 1))
const canGoPrev = computed(() => currentIndex.value > 0)
const canGoNext = computed(() => currentIndex.value < maxIndex.value)

// Computed untuk menampilkan 3 berita
const visibleNews = computed(() => {
  if (news.value.length === 0) return []
  
  const items = []
  const total = news.value.length
  
  // Pastikan kita menampilkan 3 item sekaligus
  for (let i = 0; i < Math.min(3, total); i++) {
    const index = currentIndex.value + i
    if (index < total) {
      const position = i === 0 ? 'left' : i === 1 ? 'center' : 'right'
      items.push({ 
        ...news.value[index], 
        position, 
        index: index,
        key: `${index}-${position}` // Unique key untuk animasi
      })
    }
  }
  
  return items
})

// Smart pagination
const paginationItems = computed(() => {
  const total = news.value.length
  const current = currentIndex.value
  const items = []
  
  if (total <= 7) {
    for (let i = 0; i < total; i++) {
      items.push({ type: 'page', value: i, active: i === current })
    }
  } else {
    items.push({ type: 'page', value: 0, active: current === 0 })
    
    if (current > 3) {
      items.push({ type: 'ellipsis', value: '...' })
    }
    
    const start = Math.max(1, current - 1)
    const end = Math.min(total - 2, current + 1)
    
    for (let i = start; i <= end; i++) {
      if (i !== 0 && i !== total - 1) {
        items.push({ type: 'page', value: i, active: i === current })
      }
    }
    
    if (current < total - 4) {
      items.push({ type: 'ellipsis', value: '...' })
    }
    
    if (total > 1) {
      items.push({ type: 'page', value: total - 1, active: current === total - 1 })
    }
  }
  
  return items
})

// Fungsi untuk mendapatkan gambar dengan fallback
const getImageSrc = (foto: string | null) => {
  if (!foto || foto === null) {
    return '/Berita/Placeholder.jpg'
  }
  return foto
}

// Fungsi untuk navigasi ke detail berita
const navigateToDetail = (beritaId: number) => {
  router.push({ name: 'DetailBerita', params: { id: beritaId } })
}

// Fungsi untuk mengambil data dari API
const fetchBerita = async () => {
  try {
    loading.value = true
    const response = await api.get('/kelola/berita')
    
    console.log('=== DEBUG API RESPONSE ===')
    console.log('Full response object:', response)
    
    let beritaData = []
    
    if (Array.isArray(response)) {
      beritaData = response
    } else if (Array.isArray(response.data)) {
      beritaData = response.data
    } else if (response.data && Array.isArray(response.data.data)) {
      beritaData = response.data.data
    } else if (response.data) {
      for (const key of Object.keys(response.data)) {
        if (Array.isArray(response.data[key])) {
          beritaData = response.data[key]
          break
        }
      }
    }
    
    // Filter berita
    const filteredBerita = beritaData.filter((item: any) => {
      return item && item.jenis_konten === 'berita'
    })
    
    news.value = filteredBerita
    error.value = ''
    
    // Reset ke awal jika currentIndex melebihi data yang ada
    if (currentIndex.value >= filteredBerita.length) {
      currentIndex.value = 0
    }
    
  } catch (err) {
    console.error('Error fetching berita:', err)
    error.value = 'Gagal memuat berita: ' + (err.message || 'Unknown error')
  } finally {
    loading.value = false
  }
}

// Metode navigasi dengan animasi smooth
const goToPrev = async () => {
  if (!canGoPrev.value || isAnimating.value) return
  
  isAnimating.value = true
  
  // Trigger animasi keluar
  const container = carouselContainer.value
  if (container) {
    container.style.transform = 'translateX(50px)'
    container.style.opacity = '0.7'
  }
  
  // Tunggu animasi selesai, lalu ubah data
  setTimeout(() => {
    currentIndex.value--
    
    // Reset posisi dan trigger animasi masuk
    if (container) {
      container.style.transform = 'translateX(-50px)'
      setTimeout(() => {
        container.style.transform = 'translateX(0)'
        container.style.opacity = '1'
        isAnimating.value = false
      }, 50)
    }
  }, animationDuration / 2)
}

const goToNext = async () => {
  if (!canGoNext.value || isAnimating.value) return
  
  isAnimating.value = true
  
  const container = carouselContainer.value
  if (container) {
    container.style.transform = 'translateX(-50px)'
    container.style.opacity = '0.7'
  }
  
  setTimeout(() => {
    currentIndex.value++
    
    if (container) {
      container.style.transform = 'translateX(50px)'
      setTimeout(() => {
        container.style.transform = 'translateX(0)'
        container.style.opacity = '1'
        isAnimating.value = false
      }, 50)
    }
  }, animationDuration / 2)
}

// Fungsi untuk langsung ke berita tertentu dengan animasi
const goToIndex = async (index: number) => {
  if (index >= 0 && index < news.value.length && !isAnimating.value && index !== currentIndex.value) {
    isAnimating.value = true
    
    const container = carouselContainer.value
    const direction = index > currentIndex.value ? -1 : 1
    
    if (container) {
      container.style.transform = `translateX(${direction * 50}px)`
      container.style.opacity = '0.7'
    }
    
    setTimeout(() => {
      currentIndex.value = index
      
      if (container) {
        container.style.transform = `translateX(${-direction * 50}px)`
        setTimeout(() => {
          container.style.transform = 'translateX(0)'
          container.style.opacity = '1'
          isAnimating.value = false
        }, 50)
      }
    }, animationDuration / 2)
  }
}

// Watch untuk smooth CSS transition
watch(currentIndex, () => {
  const container = carouselContainer.value
  if (container) {
    container.style.transition = `all ${animationDuration}ms cubic-bezier(0.4, 0, 0.2, 1)`
  }
})

// Metode untuk memformat tanggal
const formatDate = (dateString: string) => {
  const options: Intl.DateTimeFormatOptions = {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  }
  return new Date(dateString).toLocaleDateString('id-ID', options)
}

// Metode untuk memotong teks
const truncateText = (text: string, maxLength: number = 120) => {
  if (text.length <= maxLength) return text
  return text.substring(0, maxLength) + '...'
}

// Auto-slide
const autoSlide = ref(true)
const slideInterval = ref<NodeJS.Timeout | null>(null)

const startAutoSlide = () => {
  if (autoSlide.value && news.value.length > 3) { // Hanya jika ada lebih dari 3 berita
    slideInterval.value = setInterval(() => {
      if (canGoNext.value && !isAnimating.value) {
        goToNext()
      } else if (!isAnimating.value) {
        goToIndex(0) // Kembali ke awal
      }
    }, 5000)
  }
}

const stopAutoSlide = () => {
  if (slideInterval.value) {
    clearInterval(slideInterval.value)
    slideInterval.value = null
  }
}

// Lifecycle hooks
onMounted(async () => {
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100,
    delay: 0
  })
  
  await fetchBerita()
  startAutoSlide()
})

// Cleanup
import { onUnmounted } from 'vue'
onUnmounted(() => {
  stopAutoSlide()
})
</script>

<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent mb-4">
          Berita Terbaru
        </h2>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
          Informasi terkini seputar kegiatan dan program pemberdayaan
        </p>
        <div class="w-24 h-1 bg-gradient-to-r from-pink-500 to-purple-600 mx-auto mt-6 rounded-full"></div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-20">
        <div class="relative">
          <div class="w-16 h-16 border-4 border-pink-200 border-t-pink-500 rounded-full animate-spin"></div>
          <div class="w-12 h-12 border-4 border-purple-200 border-t-purple-500 rounded-full animate-spin absolute top-2 left-2"></div>
        </div>
        <p class="text-gray-600 mt-6 text-lg">Memuat berita...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-20">
        <div class="text-red-500 text-6xl mb-4">⚠️</div>
        <p class="text-red-600 text-lg mb-6">{{ error }}</p>
        <ElButton @click="fetchBerita" type="primary" size="large" class="bg-pink-500 border-pink-500 hover:bg-pink-600">
          Coba Lagi
        </ElButton>
      </div>

      <!-- Empty State -->
      <div v-else-if="news.length === 0" class="text-center py-20">
        <div class="text-gray-400 text-6xl mb-4">📰</div>
        <p class="text-gray-500 text-lg">Belum ada berita tersedia</p>
      </div>

      <!-- Carousel Container -->
      <div v-else class="relative" 
           @mouseenter="stopAutoSlide" 
           @mouseleave="startAutoSlide">
        
        <!-- Navigation Buttons -->
        <div class="absolute inset-y-0 left-0 right-0 flex items-center justify-between pointer-events-none z-20" 
             v-if="news.length > 3">
          <ElButton 
            :disabled="!canGoPrev || isAnimating"
            @click="goToPrev"
            class="pointer-events-auto -ml-6 w-12 h-12 rounded-full bg-white shadow-xl border-2 border-pink-100 hover:border-pink-300 hover:bg-pink-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300"
            circle
            size="large"
          >
            <ElIcon class="text-pink-500"><ArrowLeft /></ElIcon>
          </ElButton>
          
          <ElButton 
            :disabled="!canGoNext || isAnimating"
            @click="goToNext"
            class="pointer-events-auto -mr-6 w-12 h-12 rounded-full bg-white shadow-xl border-2 border-pink-100 hover:border-pink-300 hover:bg-pink-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300"
            circle
            size="large"
          >
            <ElIcon class="text-pink-500"><ArrowRight /></ElIcon>
          </ElButton>
        </div>

        <!-- News Cards Container -->
        <div class="overflow-hidden rounded-3xl py-8">
          <div 
            ref="carouselContainer"
            class="flex justify-center items-start gap-8 min-h-[600px] perspective-1000"
            :class="{ 'pointer-events-none': isAnimating }"
          >
            <div
              v-for="(newsItem, index) in visibleNews"
              :key="newsItem.key"
              :class="[
                'transition-all duration-700 ease-out transform-gpu',
                {
                  // Left card
                  'opacity-70 scale-90 -rotate-2 translate-x-4 z-10': newsItem.position === 'left',
                  // Center card (featured)
                  'opacity-100 scale-105 translate-y-[-20px] z-30 shadow-2xl': newsItem.position === 'center',
                  // Right card
                  'opacity-70 scale-90 rotate-2 -translate-x-4 z-10': newsItem.position === 'right',
                }
              ]"
            >
              <ElCard 
                :class="[
                  'w-80 h-[500px] rounded-2xl border-0 overflow-hidden transition-all duration-500 hover:scale-110 cursor-pointer',
                  {
                    'bg-gradient-to-br from-white to-pink-50 ring-2 ring-pink-200': newsItem.position === 'center',
                    'bg-white hover:shadow-xl': newsItem.position !== 'center'
                  }
                ]"
                shadow="hover"
                @click="navigateToDetail(newsItem.id)"
              >
                <!-- Image Section -->
                <div class="relative h-56 overflow-hidden rounded-t-2xl">
                  <ElImage
                    :src="getImageSrc(newsItem.foto)"
                    fit="cover"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                    :alt="newsItem.judul"
                    @error="() => {}"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                  <ElTag 
                    type="primary"
                    class="absolute top-4 left-4 bg-pink-500 border-pink-500 text-white font-semibold px-3 py-1 rounded-full shadow-lg"
                  >
                    Berita
                  </ElTag>
                  <div v-if="newsItem.position === 'center'" 
                       class="absolute top-4 right-4 w-8 h-8 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-bold">★</span>
                  </div>
                </div>

                <!-- Content Section -->
                <div class="p-6 h-[244px] flex flex-col">
                  <h3 :class="[
                    'font-bold mb-3 line-clamp-2 leading-tight',
                    newsItem.position === 'center' 
                      ? 'text-xl text-pink-600' 
                      : 'text-lg text-gray-800'
                  ]">
                    {{ newsItem.judul }}
                  </h3>
                  
                  <p :class="[
                    'text-gray-600 flex-grow line-clamp-3 leading-relaxed',
                    newsItem.position === 'center' ? 'text-base' : 'text-sm'
                  ]">
                    {{ truncateText(newsItem.isi, newsItem.position === 'center' ? 150 : 100) }}
                  </p>
                  
                  <!-- Footer -->
                  <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                    <span class="text-sm text-gray-500 font-medium">
                      {{ formatDate(newsItem.created_at) }}
                    </span>
                    <ElButton 
                      text 
                      :class="[
                        'font-semibold text-sm group',
                        newsItem.position === 'center' 
                          ? 'text-pink-500 hover:text-pink-600' 
                          : 'text-gray-500 hover:text-pink-500'
                      ]"
                      @click.stop="navigateToDetail(newsItem.id)"
                    >
                      Baca Selengkapnya
                      <ElIcon class="ml-1 transition-transform group-hover:translate-x-1">
                        <ArrowRight />
                      </ElIcon>
                    </ElButton>
                  </div>
                </div>
              </ElCard>
            </div>
          </div>
        </div>

        <!-- Smart Pagination -->
        <div class="flex justify-center items-center gap-2 mt-8" v-if="news.length > 3">
          <button
            v-for="(item, index) in paginationItems" 
            :key="`pagination-${index}`"
            :class="[
              'transition-all duration-300 flex items-center justify-center',
              {
                'w-3 h-3 rounded-full bg-gray-300 hover:bg-pink-400 cursor-pointer': item.type === 'page' && !item.active,
                'w-10 h-10 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold shadow-lg cursor-pointer': item.type === 'page' && item.active,
                'px-2 text-gray-400 cursor-default': item.type === 'ellipsis'
              }
            ]"
            @click="item.type === 'page' ? goToIndex(item.value) : null"
            :disabled="isAnimating"
          >
            <span v-if="item.type === 'ellipsis'">{{ item.value }}</span>
            <span v-else-if="item.type === 'page' && item.active" class="text-sm">{{ item.value + 1 }}</span>
          </button>
        </div>

        <!-- Carousel Info -->
        <div class="text-center mt-6" v-if="news.length > 3">
          <span class="text-gray-500 text-sm font-medium bg-gray-100 px-4 py-2 rounded-full">
            {{ currentIndex + 1 }} - {{ Math.min(currentIndex + 3, news.length) }} dari {{ news.length }} berita
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.perspective-1000 {
  perspective: 1000px;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Custom scrollbar untuk mobile */
@media (max-width: 768px) {
  .overflow-x-auto::-webkit-scrollbar {
    height: 4px;
  }
  
  .overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  
  .overflow-x-auto::-webkit-scrollbar-thumb {
    background: linear-gradient(to right, #ec4899, #8b5cf6);
    border-radius: 10px;
  }
}

/* Responsive adjustments */
@media (max-width: 1024px) {
  .gap-8 {
    gap: 1rem;
  }
}

@media (max-width: 768px) {
  .flex {
    flex-direction: column;
    align-items: center;
  }
  
  .w-80 {
    width: 90vw;
    max-width: 350px;
  }
  
  .translate-x-4,
  .-translate-x-4,
  .rotate-2,
  .-rotate-2 {
    transform: none !important;
  }
  
  .opacity-70 {
    opacity: 1 !important;
  }
  
  .scale-90 {
    transform: scale(1) !important;
  }
}
</style>