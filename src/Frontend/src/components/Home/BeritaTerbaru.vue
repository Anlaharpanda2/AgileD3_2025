<template>
  <div class="bg-gradient-to-br from-slate-50 via-white to-purple-50 py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Header -->
      <div class="text-center mb-16" data-aos="fade-up">
        <h2 class="text-4xl md:text-5xl font-bold bg-black bg-clip-text text-transparent mb-4">
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
      <div v-else class="relative">
        
        <!-- Desktop Navigation Buttons -->
        <div class="hidden sm:flex absolute inset-y-0 left-0 right-0 items-center justify-between pointer-events-none z-20" 
             v-if="news.length > 3">
          <ElButton
            native-type="button"
            type="default"
            :disabled="!canGoPrev || isAnimating"
            @click="goToPrev"
            :class="[
              '!pointer-events-auto', '!w-12', '!h-12', '!rounded-full', '!bg-white',
              '!shadow-xl', '!border-2', '!border-grey',
              'hover:!border-pink-300', 'hover:!bg-pink-500',
              'disabled:!opacity-50', 'disabled:!cursor-not-allowed',
              '!transition-all', '!duration-300'
            ]"
            circle
            size="large"
          >
            <ElIcon class="text-black"><ArrowLeft /></ElIcon>
          </ElButton>
          <ElButton 
            :disabled="!canGoNext || isAnimating"
            @click="goToNext"
            :class="[
              '!pointer-events-auto', '!w-12', '!h-12', '!rounded-full', '!bg-white',
              '!shadow-xl', '!border-2', '!border-gray',
              'hover:!border-pink-300', 'hover:!bg-pink-500',
              'disabled:!opacity-50', 'disabled:!cursor-not-allowed',
              '!transition-all', '!duration-300'
            ]"
            circle
            size="large"
          >
            <ElIcon class="text-black"><ArrowRight /></ElIcon>
          </ElButton>
        </div>

        <!-- News Cards Container -->
        <div class="overflow-hidden rounded-3xl pt-15">
          <!-- Desktop View (3 cards) -->
          <div 
            ref="carouselContainer"
            class="hidden sm:flex justify-center items-start gap-8 perspective-1000 relative"
            :class="{ 'pointer-events-none': isAnimating }"
          >
            <div
              v-for="(newsItem, index) in visibleNewsDesktop"
              :key="`desktop-${newsItem.key}`"
              :class="[
                'transition-all duration-700 ease-out transform-gpu',
                {
                  // Left card
                  'shadow-lg opacity-90 scale-90 -rotate-2 translate-x-4 z-10': newsItem.position === 'left',
                  // Center card (featured)
                  'opacity-100 scale-105 translate-y-[-20px] z-30 shadow-2xl': newsItem.position === 'center',
                  // Right card
                  'shadow-lg opacity-80 scale-90 rotate-2 -translate-x-4 z-10': newsItem.position === 'right',
                }
              ]"
            >
              <ElCard 
                :class="[
                  'w-80 h-[500px] rounded-2xl border-0 overflow-visible transition-all duration-300 cursor-pointer group',
                  {
                    'bg-gradient-to-br from-white to-pink-50 ring-2 ring-pink-200 hover:scale-102 hover:translate-y-[-10px] hover:shadow-5xl hover:z-50': newsItem.position === 'center',
                    'bg-white hover:shadow-xl hover:scale-105': newsItem.position !== 'center'
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
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    :alt="newsItem.judul"
                    @error="() => {}"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent group-hover:from-black/30"></div>
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
                        'font-semibold text-sm group-btn',
                        newsItem.position === 'center' 
                          ? 'text-pink-500 hover:text-pink-600' 
                          : 'text-gray-500 hover:text-pink-500'
                      ]"
                      @click.stop="navigateToDetail(newsItem.id)"
                    >
                      Baca Selengkapnya
                      <ElIcon class="ml-1 transition-transform group-btn-hover:translate-x-1">
                        <ArrowRight />
                      </ElIcon>
                    </ElButton>
                  </div>
                </div>
              </ElCard>
            </div>
          </div>

          <!-- Mobile View (1 card with swipe) -->
          <div 
            ref="mobileCarouselContainer"
            class="block sm:hidden relative overflow-hidden"
            @touchstart="handleTouchStart"
            @touchmove="handleTouchMove"
            @touchend="handleTouchEnd"
          >
            <div 
              class="flex transition-transform duration-500 ease-out"
              :style="{ transform: `translateX(${mobileTranslateX}px)` }"
            >
              <div
                v-for="(newsItem, index) in news"
                :key="`mobile-${newsItem.id}`"
                class="flex-shrink-0 w-full flex justify-center px-4"
              >
                <ElCard 
                  class="w-full max-w-sm h-[500px] rounded-2xl border-0 overflow-hidden bg-gradient-to-br from-white to-pink-50 ring-2 ring-pink-200 shadow-2xl cursor-pointer"
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
                    <div class="absolute top-4 right-4 w-8 h-8 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center">
                      <span class="text-white text-sm font-bold">★</span>
                    </div>
                  </div>

                  <!-- Content Section -->
                  <div class="p-6 h-[244px] flex flex-col">
                    <h3 class="text-xl font-bold mb-3 line-clamp-2 leading-tight text-pink-600">
                      {{ newsItem.judul }}
                    </h3>
                    
                    <p class="text-base text-gray-600 flex-grow line-clamp-3 leading-relaxed">
                      {{ truncateText(newsItem.isi, 150) }}
                    </p>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                      <span class="text-sm text-gray-500 font-medium">
                        {{ formatDate(newsItem.created_at) }}
                      </span>
                      <ElButton 
                        text 
                        class="font-semibold text-sm group text-pink-500 hover:text-pink-600"
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
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex justify-center items-center gap-2 mt-8" v-if="news.length > 3">
          <button
            v-for="(item, index) in paginationItemsDesktop" 
            :key="`desktop-pagination-${index}`"
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
            <span v-else-if="item.type === 'page' && item.active" class="text-sm">{{ Math.floor(item.value / 3) + 1 }}</span>
          </button>
        </div>

        <!-- Mobile Pagination (Dots) -->
        <div class="flex sm:hidden justify-center items-center gap-2 mt-8" v-if="news.length > 1">
          <button
            v-for="(newsItem, index) in news" 
            :key="`mobile-pagination-${index}`"
            :class="[
              'transition-all duration-300',
              {
                'w-3 h-3 rounded-full bg-gray-300 hover:bg-pink-400 cursor-pointer': index !== mobileCurrentIndex,
                'w-10 h-3 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 shadow-lg cursor-pointer': index === mobileCurrentIndex,
              }
            ]"
            @click="goToMobileIndex(index)"
          >
          </button>
        </div>

        <!-- Desktop Carousel Info -->
        <div class="hidden sm:block text-center mt-6" v-if="news.length > 3">
          <span class="text-gray-500 text-sm font-medium bg-gray-100 px-4 py-2 rounded-full">
            Halaman {{ Math.floor(currentIndex / 3) + 1 }} dari {{ Math.ceil(news.length / 3) }}
          </span>
        </div>

        <!-- Mobile Carousel Info -->
        <div class="block sm:hidden text-center mt-6" v-if="news.length > 1">
          <span class="text-gray-500 text-sm font-medium bg-gray-100 px-4 py-2 rounded-full">
            {{ mobileCurrentIndex + 1 }} dari {{ news.length }} berita
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import {
  ElCard,
  ElIcon,
  ElImage,
  ElTag,
  ElButton,
} from 'element-plus';
import { ArrowRight, ArrowLeft } from '@element-plus/icons-vue';
import { useRouter } from 'vue-router';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Impor composables dan services yang sudah di-refactor
import { useBeritaData } from '../../composables/useBeritaData';
import { useBeritaCarousel } from '../../composables/useBeritaCarousel';
import { formatDate } from '../../services/dateFormatter';
import { truncateText } from '../../composables/textFormatter';
import { getImageSrc } from '../../composables/imageService';

// Router instance
const router = useRouter();

// Menggunakan composable untuk data berita
const { news, loading, error, fetchBerita } = useBeritaData();

// Ref untuk container carousel
const carouselContainer = ref<HTMLElement | null>(null);
const mobileCarouselContainer = ref<HTMLElement | null>(null);

// State untuk desktop carousel (manual implementation tanpa auto-slide)
const currentIndex = ref(0);
const isAnimating = ref(false);

// Desktop carousel functions dengan navigasi 3 slide
const canGoPrev = computed(() => currentIndex.value > 0);
const canGoNext = computed(() => currentIndex.value < news.value.length - 3);

const visibleNewsDesktop = computed(() => {
  if (news.value.length === 0) return [];
  
  const items = [];
  const startIndex = currentIndex.value;
  
  for (let i = 0; i < 3; i++) {
    const newsIndex = startIndex + i;
    if (newsIndex < news.value.length) {
      const position = i === 0 ? 'left' : i === 1 ? 'center' : 'right';
      items.push({
        ...news.value[newsIndex],
        position,
        key: `${news.value[newsIndex].id}-${position}`
      });
    }
  }
  
  return items;
});

const paginationItemsDesktop = computed(() => {
  const totalPages = Math.ceil(news.value.length / 3);
  const currentPage = Math.floor(currentIndex.value / 3);
  const items = [];
  
  if (totalPages <= 7) {
    for (let i = 0; i < totalPages; i++) {
      items.push({
        type: 'page',
        value: i * 3,
        active: i === currentPage
      });
    }
  } else {
    if (currentPage <= 3) {
      for (let i = 0; i <= 4; i++) {
        items.push({
          type: 'page',
          value: i * 3,
          active: i === currentPage
        });
      }
      items.push({ type: 'ellipsis', value: '...' });
      items.push({
        type: 'page',
        value: (totalPages - 1) * 3,
        active: totalPages - 1 === currentPage
      });
    } else if (currentPage >= totalPages - 4) {
      items.push({
        type: 'page',
        value: 0,
        active: 0 === currentPage
      });
      items.push({ type: 'ellipsis', value: '...' });
      for (let i = totalPages - 5; i < totalPages; i++) {
        items.push({
          type: 'page',
          value: i * 3,
          active: i === currentPage
        });
      }
    } else {
      items.push({
        type: 'page',
        value: 0,
        active: 0 === currentPage
      });
      items.push({ type: 'ellipsis', value: '...' });
      for (let i = currentPage - 1; i <= currentPage + 1; i++) {
        items.push({
          type: 'page',
          value: i * 3,
          active: i === currentPage
        });
      }
      items.push({ type: 'ellipsis', value: '...' });
      items.push({
        type: 'page',
        value: (totalPages - 1) * 3,
        active: totalPages - 1 === currentPage
      });
    }
  }
  
  return items;
});

const goToPrev = () => {
  if (canGoPrev.value && !isAnimating.value) {
    isAnimating.value = true;
    currentIndex.value = Math.max(0, currentIndex.value - 3);
    setTimeout(() => {
      isAnimating.value = false;
    }, 700);
  }
};

const goToNext = () => {
  if (canGoNext.value && !isAnimating.value) {
    isAnimating.value = true;
    currentIndex.value = Math.min(news.value.length - 3, currentIndex.value + 3);
    setTimeout(() => {
      isAnimating.value = false;
    }, 700);
  }
};

const goToIndex = (index: number) => {
  if (index >= 0 && index <= news.value.length - 3 && !isAnimating.value) {
    isAnimating.value = true;
    currentIndex.value = index;
    setTimeout(() => {
      isAnimating.value = false;
    }, 700);
  }
};

// Mobile carousel state
const mobileCurrentIndex = ref(0);
const mobileTranslateX = ref(0);
const mobileStartX = ref(0);
const mobileCurrentX = ref(0);
const mobileIsDragging = ref(false);

// Mobile touch handlers
const handleTouchStart = (e: TouchEvent) => {
  mobileStartX.value = e.touches[0].clientX;
  mobileCurrentX.value = mobileTranslateX.value;
  mobileIsDragging.value = true;
};

const handleTouchMove = (e: TouchEvent) => {
  if (!mobileIsDragging.value) return;
  
  const currentX = e.touches[0].clientX;
  const diffX = currentX - mobileStartX.value;
  const containerWidth = mobileCarouselContainer.value?.clientWidth || 0;
  
  // Apply some resistance at the edges
  let newTranslateX = mobileCurrentX.value + diffX;
  
  // Limit translation to prevent going beyond bounds
  const maxTranslate = 0;
  const minTranslate = -(news.value.length - 1) * containerWidth;
  
  if (newTranslateX > maxTranslate) {
    newTranslateX = maxTranslate + (newTranslateX - maxTranslate) * 0.3;
  } else if (newTranslateX < minTranslate) {
    newTranslateX = minTranslate + (newTranslateX - minTranslate) * 0.3;
  }
  
  mobileTranslateX.value = newTranslateX;
};

const handleTouchEnd = (e: TouchEvent) => {
  if (!mobileIsDragging.value) return;
  
  mobileIsDragging.value = false;
  
  const endX = e.changedTouches[0].clientX;
  const diffX = endX - mobileStartX.value;
  const containerWidth = mobileCarouselContainer.value?.clientWidth || 0;
  const threshold = containerWidth * 0.25; // 25% of container width for easier swipe
  
  if (Math.abs(diffX) > threshold) {
    if (diffX > 0 && mobileCurrentIndex.value > 0) {
      // Swipe right - go to previous
      mobileCurrentIndex.value--;
    } else if (diffX < 0 && mobileCurrentIndex.value < news.value.length - 1) {
      // Swipe left - go to next
      mobileCurrentIndex.value++;
    }
  }
  
  // Snap to current position with smooth animation
  goToMobileIndex(mobileCurrentIndex.value);
};

const goToMobileIndex = (index: number) => {
  if (index < 0 || index >= news.value.length) return;
  
  mobileCurrentIndex.value = index;
  const containerWidth = mobileCarouselContainer.value?.clientWidth || 0;
  mobileTranslateX.value = -index * containerWidth;
};

// Fungsi untuk navigasi ke detail berita
const navigateToDetail = (beritaId: number) => {
  router.push({ name: 'DetailBerita', params: { id: beritaId } });
};

// Lifecycle hook
onMounted(async () => {
  // Ambil data berita
  await fetchBerita();

  // Inisialisasi AOS
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 100,
    delay: 0
  });

  // Initialize mobile carousel position
  setTimeout(() => {
    goToMobileIndex(0);
  }, 100); // Small delay to ensure DOM is ready
});
</script>

<style scoped>
/* Hover effect yang lebih subtle untuk card center */
.group {
  position: relative;
}

.group:hover {
  z-index: 999 !important;
}

/* Shadow 3xl untuk hover effect yang lebih smooth */
.hover\:shadow-3xl:hover {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* Pastikan container parent memiliki overflow visible untuk card center */
.perspective-1000 {
  perspective: 1000px;
  overflow: visible !important;
}

/* Container carousel harus memiliki padding yang cukup untuk hover effect */
.hidden.sm\\:flex {
  padding-top: 2rem;
  padding-bottom: 2rem;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Button hover effect yang terpisah */
.group-btn:hover .group-btn-hover {
  transform: translateX(0.25rem);
}

/* Custom scrollbar untuk mobile */
@media (max-width: 468px) {
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

/* Mobile specific styles */
@media (max-width: 469px) {
  .py-16 {
    padding-top: 2rem;
    padding-bottom: 2rem;
  }
  
  .text-4xl {
    font-size: 2rem;
  }
  
  .text-5xl {
    font-size: 2.5rem;
  }
  
  .mb-16 {
    margin-bottom: 2rem;
  }
  
  .max-w-7xl {
    padding-left: 1rem;
    padding-right: 1rem;
  }
}
</style>