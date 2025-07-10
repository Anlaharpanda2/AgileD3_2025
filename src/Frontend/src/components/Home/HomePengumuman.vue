<template>
  <div class="bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div
        class="text-center mb-15 md:mb-16"
        data-aos="fade-up"
      >
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
          Pengumuman
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Informasi penting dan jadwal kegiatan terkini
        </p>
      </div>

      <!-- Loading State -->
      <div
        v-if="loading"
        class="flex justify-center items-center py-12"
      >
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-pink-500" />
      </div>

      <!-- Error State -->
      <div
        v-else-if="error"
        class="text-center py-12"
      >
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-md mx-auto shadow-sm">
          <p class="text-red-600 font-medium">
            {{ error }}
          </p>
        </div>
      </div>

      <!-- No Announcements State -->
      <div
        v-else-if="announcements.length === 0"
        class="text-center py-12"
      >
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 max-w-md mx-auto shadow-sm">
          <ElIcon class="text-5xl text-gray-400 mb-4 opacity-75">
            <Bell />
          </ElIcon>
          <p class="text-gray-600 font-medium">
            Belum ada pengumuman tersedia saat ini.
          </p>
        </div>
      </div>

      <!-- Announcements List -->
      <div
        v-else
        data-aos="fade-up"
        data-aos-delay="200"
      >
        <!-- Desktop Layout (unchanged) -->
        <div class="hidden md:block max-w-2xl mx-auto">
          <div 
            class="h-[500px] overflow-y-auto scrollbar-thin scrollbar-thumb-pink-300 scrollbar-track-gray-100 space-y-4 pr-3 py-1 scroll-left"
          >
            <ElCard
              v-for="(announcement, index) in announcements"
              :key="announcement.id"
              class="border-0 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 rounded-2xl cursor-pointer"
              shadow="never"
              data-aos="slide-right"
              :data-aos-delay="index * 100"
              @click="goToAnnouncementDetail(announcement.id)"
            >
              <div>
                <div class="flex items-start justify-between gap-4">
                  <!-- Icon Placeholder -->
                  <div class="flex-shrink-0 mt-1">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                      <ElIcon class="text-xl text-pink-500">
                        <Bell />
                      </ElIcon>
                    </div>
                  </div>

                  <!-- Announcement Content -->
                  <div class="flex-grow min-w-0">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1 leading-tight">
                      {{ announcement.judul }}
                    </h4>
                    <p class="text-gray-600 text-sm mb-2 line-clamp-2">
                      {{ announcement.isi }}
                    </p>
                    <span class="text-sm text-gray-500">
                      {{ formatDate(announcement.created_at) }}
                    </span>
                  </div>

                  <!-- Tag -->
                  <div class="flex-shrink-0 mt-1">
                    <ElTag 
                      :type="getAnnouncementType(announcement.created_at)"
                      class="font-medium px-3 py-1 rounded-full text-xs"
                      size="small"
                    >
                      {{ getAnnouncementLabel(announcement.created_at) }}
                    </ElTag>
                  </div>
                </div>
              </div>
            </ElCard>
          </div>
          
          <!-- Desktop Scroll Hint -->
          <div
            v-if="announcements.length > 3"
            class="text-center mt-6"
          >
            <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
              <span>Gulir untuk melihat pengumuman lainnya</span>
              <svg
                class="w-5 h-5 text-gray-400 animate-bounce"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 14l-7 7m0 0l-7-7m7 7V3"
                />
              </svg>
            </p>
          </div>
        </div>

        <!-- Mobile Layout (swipe horizontal) -->
        <div class="md:hidden">
          <div 
            ref="swipeContainer"
            class="flex overflow-x-auto gap-4 pb-4 px-1 snap-x snap-mandatory scrollbar-hide touch-pan-x"
            @touchstart="handleTouchStart"
            @touchmove="handleTouchMove"
            @touchend="handleTouchEnd"
          >
            <div
              v-for="(announcement, index) in announcements"
              :key="announcement.id"
              class="flex-none w-[85vw] max-w-sm snap-center"
              data-aos="fade-up"
              :data-aos-delay="index * 100"
            >
              <ElCard
                class="border-0 shadow-md hover:shadow-lg transition-all duration-300 rounded-2xl cursor-pointer h-full"
                shadow="never"
                @click="goToAnnouncementDetail(announcement.id)"
              >
                <div class="h-full">
                  <div class="flex flex-col h-full gap-3">
                    <!-- Header with Icon and Tag -->
                    <div class="flex items-center justify-between">
                      <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                        <ElIcon class="text-xl text-pink-500">
                          <Bell />
                        </ElIcon>
                      </div>
                      <ElTag 
                        :type="getAnnouncementType(announcement.created_at)"
                        class="font-medium px-3 py-1 rounded-full text-xs"
                        size="small"
                      >
                        {{ getAnnouncementLabel(announcement.created_at) }}
                      </ElTag>
                    </div>

                    <!-- Content -->
                    <div class="flex-grow">
                      <h4 class="text-lg font-semibold text-gray-900 mb-2 leading-tight">
                        {{ announcement.judul }}
                      </h4>
                      <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                        {{ announcement.isi }}
                      </p>
                    </div>

                    <!-- Date -->
                    <div class="pt-2 border-t border-gray-100">
                      <span class="text-xs text-gray-500">
                        {{ formatDate(announcement.created_at) }}
                      </span>
                    </div>
                  </div>
                </div>
              </ElCard>
            </div>
          </div>

          <!-- Mobile Indicators -->
          <div
            v-if="announcements.length > 1"
            class="flex justify-center mt-4 gap-2"
          >
            <div
              v-for="(announcement, index) in announcements"
              :key="index"
              class="w-2 h-2 rounded-full transition-all duration-300"
              :class="currentSlide === index ? 'bg-pink-500 w-6' : 'bg-gray-300'"
            />
          </div>

          <!-- Mobile Swipe Hint -->
          <div
            v-if="announcements.length > 1"
            class="text-center mt-4"
          >
            <p class="text-sm text-gray-500 flex items-center justify-center gap-2">
              <span>Geser untuk melihat pengumuman lainnya</span>
              <svg
                class="w-4 h-4 text-gray-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5l7 7-7 7"
                />
              </svg>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, nextTick, ref } from 'vue';
import { useRouter } from 'vue-router';
import { ElCard, ElIcon, ElTag } from 'element-plus';
import { Bell } from '@element-plus/icons-vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

// Impor composable dan service
import { useAnnouncements } from '../../services/useAnnouncements';
import { formatDate, getAnnouncementType, getAnnouncementLabel } from '../../services/dateFormatter';

// Router untuk navigasi
const router = useRouter();

// Menggunakan composable
const { announcements, loading, error, fetchAnnouncements } = useAnnouncements();

// Mobile swipe functionality
const swipeContainer = ref<HTMLElement | null>(null);
const currentSlide = ref(0);

// Touch handling variables
let startX = 0;
let scrollLeft = 0;
let isScrolling = false;

// Function untuk navigasi ke detail pengumuman
const goToAnnouncementDetail = (announcementId: number | string) => {
  router.push(`/pengumuman/${announcementId}`);
};

const handleTouchStart = (e: TouchEvent) => {
  if (!swipeContainer.value) return;
  startX = e.touches[0].clientX;
  scrollLeft = swipeContainer.value.scrollLeft;
  isScrolling = true;
};

const handleTouchMove = (e: TouchEvent) => {
  if (!isScrolling || !swipeContainer.value) return;
  const currentX = e.touches[0].clientX;
  const diff = startX - currentX;
  swipeContainer.value.scrollLeft = scrollLeft + diff;
};

const handleTouchEnd = () => {
  if (!swipeContainer.value) return;
  isScrolling = false;
  
  // Calculate which slide we're closest to
  const containerWidth = swipeContainer.value.clientWidth;
  const scrollLeft = swipeContainer.value.scrollLeft;
  const slideWidth = containerWidth * 0.85; // 85vw
  
  currentSlide.value = Math.round(scrollLeft / slideWidth);
  
  // Ensure currentSlide is within bounds
  if (currentSlide.value < 0) currentSlide.value = 0;
  if (currentSlide.value >= announcements.value.length) {
    currentSlide.value = announcements.value.length - 1;
  }
};

// Watch scroll position to update current slide indicator
const updateCurrentSlide = () => {
  if (!swipeContainer.value) return;
  
  const containerWidth = swipeContainer.value.clientWidth;
  const scrollLeft = swipeContainer.value.scrollLeft;
  const slideWidth = containerWidth * 0.85;
  
  currentSlide.value = Math.round(scrollLeft / slideWidth);
};

// Lifecycle hook
onMounted(async () => {
  await fetchAnnouncements();

  nextTick(() => {
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
      offset: 100,
      delay: 0
    });

    // Add scroll listener for mobile indicator
    if (swipeContainer.value) {
      swipeContainer.value.addEventListener('scroll', updateCurrentSlide, { passive: true });
    }
  });
});
</script>

<style scoped>
/* Existing styles */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

.el-card:hover {
  border-color: rgba(236, 72, 153, 0.2);
}

.scrollbar-thin {
  scrollbar-width: thin;
}

.scroll-left::-webkit-scrollbar {
  width: 8px;
}

.scroll-left::-webkit-scrollbar-track {
  background: #f3f4f6;
  border-radius: 4px;
}

.scroll-left::-webkit-scrollbar-thumb {
  background: #f9a8d4;
  border-radius: 4px;
  border: 1px solid #f3f4f6;
}

.scroll-left::-webkit-scrollbar-thumb:hover {
  background: #f472b6;
}

.scroll-left {
  direction: rtl;
}

.scroll-left > * {
  direction: ltr;
}

/* Hide scrollbar for mobile swipe */
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

/* Smooth scrolling for snap */
.snap-x {
  scroll-snap-type: x mandatory;
}

.snap-center {
  scroll-snap-align: center;
}

/* Touch optimization */
.touch-pan-x {
  touch-action: pan-x;
}

:deep(.el-tag--success) {
  background-color: rgba(34, 197, 94, 0.1);
  border-color: rgba(34, 197, 94, 0.2);
  color: rgb(22, 163, 74);
}

:deep(.el-tag--warning) {
  background-color: rgba(245, 158, 11, 0.1);
  border-color: rgba(245, 158, 11, 0.2);
  color: rgb(217, 119, 6);
}

:deep(.el-tag--info) {
  background-color: rgba(236, 72, 153, 0.1);
  border-color: rgba(236, 72, 153, 0.2);
  color: rgb(219, 39, 119);
}

.overflow-y-auto {
  scroll-behavior: smooth;
}

.scrollbar-thin {
  scrollbar-width: thin;
  scrollbar-color: #f9a8d4 #f3f4f6;
}

@media (prefers-reduced-motion: no-preference) {
  .el-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-4px) !important;
    transition: all 0.1s ease-in-out !important;
  }
}

/* Mobile specific optimizations */
@media (max-width: 767px) {
  .el-card:hover {
    transform: none !important;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
  }
}
</style>