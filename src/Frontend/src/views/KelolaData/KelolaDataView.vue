<template>
  <SimpleLayout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-pink-50">
      <!-- Header Section with Modern Design -->
      <div class="relative overflow-hidden bg-white/80 backdrop-blur-sm border-b border-gray-200/50">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-100/20 via-transparent to-pink-100/20" />
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-pink-500 to-pink-600 rounded-2xl shadow-lg mb-4">
              <Database class="w-8 h-8 text-white" />
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-clip-text text-transparent mb-3">
              Kelola Data
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
              Manajemen data dan pengaturan sistem dengan interface yang modern dan intuitif
            </p>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter and Search Section -->
        <div class="mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">
          <div class="flex items-center gap-4">
            <el-input
              v-model="searchQuery"
              placeholder="Cari modul data..."
              class="w-72"
              clearable
            >
              <template #prefix>
                <Search class="w-4 h-4 text-gray-400" />
              </template>
            </el-input>
            <el-select
              v-model="selectedCategory"
              placeholder="Kategori"
              class="w-48"
              clearable
            >
              <el-option
                label="Semua Kategori"
                value=""
              />
              <el-option
                label="Administrasi"
                value="admin"
              />
              <el-option
                label="Pelatihan"
                value="training"
              />
              <el-option
                label="Komunikasi"
                value="communication"
              />
            </el-select>
          </div>
          <div class="flex items-center gap-2">
            <el-switch
              v-model="isGridView"
              active-text="Grid"
              inactive-text="List"
              class="mr-2"
            />
            <el-button
              :icon="isGridView ? Grid3X3 : List"
              circle
              @click="isGridView = !isGridView"
            />
          </div>
        </div>

        <!-- Cards Grid/List -->
        <div 
          :class="[
            isGridView 
              ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6' 
              : 'space-y-4'
          ]"
        >
          <div 
            v-for="card in filteredCards" 
            :key="card.id"
            :class="[
              'group relative overflow-hidden transition-all duration-500 cursor-pointer',
              isGridView 
                ? 'bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 p-6 border border-gray-200/50' 
                : 'bg-white/80 backdrop-blur-sm rounded-xl shadow-sm hover:shadow-lg p-4 border border-gray-200/50 flex items-center'
            ]"
            @click="handleCardClick(card)"
          >
            <!-- Grid View -->
            <template v-if="isGridView">
              <!-- Background Pattern -->
              <div class="absolute inset-0 bg-gradient-to-br from-pink-50/30 via-transparent to-pink-50/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500" />
              
              <!-- Icon and Badge -->
              <div class="relative flex items-center justify-between mb-4">
                <div class="relative">
                  <div class="w-14 h-14 bg-gradient-to-r from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-110">
                    <component
                      :is="getIconComponent(card.icon)"
                      class="w-7 h-7 text-white"
                    />
                  </div>
                  <div class="absolute -top-2 -right-2 w-6 h-6 bg-pink-500 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-xs font-bold text-white">{{ card.id }}</span>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <div class="w-2 h-2 bg-green-500 rounded-full" />
                  <span class="text-xs text-gray-500">Online</span>
                </div>
              </div>
              
              <!-- Content -->
              <div class="relative">
                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors duration-300">
                  {{ card.title }}
                </h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                  {{ card.description }}
                </p>
                
                <!-- Action Button -->
                <el-button
                  type="primary"
                  class="w-full bg-gradient-to-r from-pink-500 to-pink-600 border-none hover:from-pink-600 hover:to-pink-700"
                  :loading="isLoading"
                  size="large"
                  @click.stop="handleButtonClick(card)"
                >
                  <template #icon>
                    <component
                      :is="getActionIcon(card.buttonText)"
                      class="w-4 h-4"
                    />
                  </template>
                  {{ card.buttonText }}
                </el-button>
              </div>
            </template>

            <!-- List View -->
            <template v-else>
              <div class="flex items-center flex-1">
                <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg mr-4">
                  <component
                    :is="getIconComponent(card.icon)"
                    class="w-6 h-6 text-white"
                  />
                </div>
                <div class="flex-1">
                  <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-pink-600 transition-colors duration-300">
                      {{ card.title }}
                    </h3>
                    <el-tag
                      size="small"
                      type="success"
                    >
                      ID: {{ card.id }}
                    </el-tag>
                  </div>
                  <p class="text-sm text-gray-600">
                    {{ card.description }}
                  </p>
                </div>
                <div class="flex items-center gap-3">
                  <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full" />
                    <span class="text-xs text-gray-500">Aktif</span>
                  </div>
                  <el-button
                    type="primary"
                    class="bg-gradient-to-r from-pink-500 to-pink-600 border-none hover:from-pink-600 hover:to-pink-700"
                    :loading="isLoading"
                    @click.stop="handleButtonClick(card)"
                  >
                    <template #icon>
                      <component
                        :is="getActionIcon(card.buttonText)"
                        class="w-4 h-4"
                      />
                    </template>
                    {{ card.buttonText }}
                  </el-button>
                </div>
              </div>
            </template>
          </div>
        </div>

        <!-- Empty State -->
        <div
          v-if="filteredCards.length === 0"
          class="text-center py-16"
        >
          <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <Search class="w-12 h-12 text-gray-400" />
          </div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            Tidak ada data ditemukan
          </h3>
          <p class="text-gray-600">
            Coba ubah kata kunci pencarian atau filter kategori
          </p>
        </div>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import type { Component } from 'vue'
import { useRouter } from 'vue-router'
import SimpleLayout from '@/layouts/SimpleLayout.vue'
import { ElNotification } from 'element-plus' // Import ElNotification
import { 
  Database, 
  Users, 
  Search, 
  Grid3X3, 
  List,
  FileText,
  Newspaper,
  Shield,
  MessageCircle,
  Lock,
  Building,
  User,
  PieChart,
  Clipboard,
  Book,
  Play,
  Eye,
  Wrench
} from 'lucide-vue-next'

const router = useRouter()

// Define interfaces for type safety
interface CardData {
  id: number
  title: string
  description: string
  icon: string
  buttonText: string
  buttonColor: string
  route?: string
  category?: string
}

const userRole = ref(localStorage.getItem('role') || '');
const isOperator = computed(() => userRole.value === 'operator');

// Reactive data
const cards = ref<CardData[]>([
  {
    id: 1,
    title: 'Data Pendaftaran',
    description: 'Pengelola data pendaftaran peserta dan administrasi pendaftaran',
    icon: 'document',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/pendaftaran',
    category: 'admin'
  },
  {
    id: 2,
    title: 'Berita & Pengumuman',
    description: 'Pengelola berita dan pengumuman untuk publikasi informasi',
    icon: 'newspaper',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/berita',
    category: 'communication'
  },
  {
    id: 3,
    title: 'Pengaduan',
    description: 'Pengelola pengaduan dan sistem pelaporan masalah',
    icon: 'shield',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/pengaduan',
    category: 'communication'
  },
  {
    id: 4,
    title: 'Konsultasi',
    description: 'Pengelola konsultasi dan layanan bantuan pengguna',
    icon: 'chat',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/konsultasi',
    category: 'communication'
  },
  {
    id: 5,
    title: 'Panitia Kegiatan',
    description: 'Pengelola data panitia kegiatan dan organisasi acara',
    icon: 'users',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/panitia',
    category: 'admin'
  },
  {
    id: 6,
    title: 'Akses Admin',
    description: 'Pengelola akses admin dan pengaturan hak akses pengguna',
    icon: 'lock',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/akses',
    category: 'admin'
  },
  {
    id: 7,
    title: 'Fasilitas',
    description: 'Pengelola fasilitas dan infrastruktur pendukung',
    icon: 'building',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/fasilitas',
    category: 'admin'
  },
  {
    id: 8,
    title: 'Struktur Pegawai',
    description: 'Pengelola struktur pegawai dan organisasi karyawan',
    icon: 'user',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/struktur-pegawai',
    category: 'admin'
  },
  {
    id: 9,
    title: 'Nilai Pretest & Postest',
    description: 'Melihat nilai pretest dan postest peserta pelatihan',
    icon: 'chart',
    buttonText: 'Lihat Data', // No change needed for this one
    buttonColor: 'pink',
    route: '/data/nilai',
    category: 'training'
  },
  {
    id: 10,
    title: 'Pretest & Postest',
    description: 'Pengelola pretest dan postest untuk evaluasi peserta',
    icon: 'clipboard',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/soal',
    category: 'training'
  },
  {
    id: 11,
    title: 'Peserta Pelatihan',
    description: 'Pengelola peserta pelatihan dan manajemen kursus',
    icon: 'book',
    buttonText: isOperator.value ? 'Kelola Data' : 'Lihat Data',
    buttonColor: 'pink',
    route: '/data/pelatihan',
    category: 'training'
  }
])

const isLoading = ref<boolean>(false)
const searchQuery = ref<string>('')
const selectedCategory = ref<string>('')
const isGridView = ref<boolean>(true)

// Computed properties
const filteredCards = computed(() => {
  return cards.value.filter(card => {
    const matchesSearch = card.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                         card.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchesCategory = !selectedCategory.value || card.category === selectedCategory.value
    
    return matchesSearch && matchesCategory
  })
})

// Methods
const getIconComponent = (iconName: string) => {
  const iconMap: { [key: string]: Component } = {
    'document': FileText,
    'newspaper': Newspaper,
    'shield': Shield,
    'chat': MessageCircle,
    'users': Users,
    'lock': Lock,
    'building': Building,
    'user': User,
    'chart': PieChart,
    'clipboard': Clipboard,
    'book': Book
  }
  return iconMap[iconName] || FileText
}

const getActionIcon = (buttonText: string) => {
  if (buttonText.includes('Lihat')) return Eye
  if (buttonText.includes('Kelola')) return Wrench
  return Play
}

const handleCardClick = (card: CardData) => {
  console.log(`Navigating to ${card.route}`)
  if (card.route) {
    router.push(card.route)
  }
}

const handleButtonClick = (card: CardData) => {
  isLoading.value = true
  
  // Check if the user is an operator and the button text is 'Kelola Data'
  if (!isOperator.value && card.buttonText === 'Kelola Data') {
    ElNotification({
      title: 'Akses Ditolak',
      message: 'Anda tidak memiliki izin untuk memodifikasi data ini. Hanya operator yang dapat melakukan perubahan.',
      type: 'warning',
      duration: 3000,
    });
    isLoading.value = false;
    return;
  }

  // Simulate API call or navigation
  setTimeout(() => {
    handleCardClick(card)
    isLoading.value = false
  }, 500)
}

// Lifecycle hooks
onMounted(() => {
  console.log('KelolaData component mounted')
})
</script>

<style scoped>
/* Element Plus Custom Styling */
:deep(.el-input__wrapper) {
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

:deep(.el-input__wrapper:hover) {
  border-color: #ec4899;
}

:deep(.el-input__wrapper.is-focus) {
  border-color: #ec4899;
  box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.1);
}

:deep(.el-select .el-input__wrapper) {
  border-radius: 12px;
}

:deep(.el-button--primary) {
  border-radius: 12px;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
}

:deep(.el-button--primary:hover) {
  box-shadow: 0 6px 16px rgba(236, 72, 153, 0.4);
}

:deep(.el-switch.is-checked .el-switch__core) {
  background-color: #ec4899;
  border-color: #ec4899;
}

:deep(.el-tag--success) {
  background-color: #dcfce7;
  border-color: #bbf7d0;
  color: #16a34a;
}

/* Custom Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.group {
  animation: fadeInUp 0.6s ease-out;
}

.group:nth-child(2) {
  animation-delay: 0.1s;
}

.group:nth-child(3) {
  animation-delay: 0.2s;
}

.group:nth-child(4) {
  animation-delay: 0.3s;
}

/* Line Clamp Utility */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Backdrop Blur Support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

/* Custom Scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(to bottom, #ec4899, #be185d);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(to bottom, #be185d, #9d174d);
}
</style>