<template>
  <header
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-out"
    :class="{ 
      'bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100': isScrolled, 
      'bg-transparent': !isScrolled 
    }"
  >
    <div class="max-w-screen-xl mx-auto px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        
        <!-- Logo Section -->
        <div class="flex items-center space-x-3">
          <div class="w-9 h-9 flex items-center justify-center bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
              <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
              <polyline points="14 2 14 8 20 8"/>
              <path d="M12 18v-6"/>
              <path d="M9 15h6"/>
            </svg>
          </div>
          <h1 
            class="text-lg font-semibold transition-colors duration-300"
            :class="isScrolled ? 'text-gray-900' : 'text-white'"
          >
            PEPSIKU BURGER
          </h1>
        </div>

        <!-- Navigation -->
        <nav class="hidden lg:block">
          <el-menu
            mode="horizontal"
            :ellipsis="false"
            class="nav-menu"
            :class="{ 'scrolled': isScrolled }"
          >
<template v-for="item in navigationMenu" :key="item.name">
  <!-- Item tanpa anak -->
  <el-menu-item v-if="!item.children" :index="item.to">
    <router-link :to="item.to" class="flex items-center w-full">
      <component :is="item.icon" class="w-4 h-4 mr-2" />
      <span>{{ item.name }}</span>
    </router-link>
  </el-menu-item>

  <!-- Item dengan anak -->
  <el-sub-menu v-else :index="item.name">
    <template #title>
      <div
        class="flex items-center w-full cursor-pointer"
        @click.stop="handleParentClick(item)"
      >
        <component :is="item.icon" class="w-4 h-4 mr-2" />
        <span>{{ item.name }}</span>
      </div>
    </template>

    <el-menu-item
      v-for="child in item.children"
      :key="child.name"
      :index="child.to"
    >
      <router-link :to="child.to" class="flex items-center w-full">
        <component :is="child.icon" class="w-4 h-4 mr-2" />
        {{ child.name }}
      </router-link>
    </el-menu-item>
  </el-sub-menu>
</template>

          </el-menu>
        </nav>

        <!-- Profile -->
        <div class="flex items-center">
          <button class="w-9 h-9 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
            <Avatar 
              class="w-9 h-9 rounded-full ring-1 transition-all duration-300" 
              :class="isScrolled ? 'ring-gray-200' : 'ring-white/30'"
            />
          </button>
        </div>

      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted, shallowRef } from 'vue'
// Import komponen dari Element Plus
import { ElMenu, ElMenuItem, ElSubMenu } from 'element-plus'
// Import ikon dari Lucide
import { Home, FileText, BookUser, MessageSquare, Pencil, ClipboardCheck, Database, FileQuestion, MessageCircle, Users2, UserCog } from 'lucide-vue-next'
// Asumsi path komponen Avatar
import Avatar from '@/components/layouts/Avatar.vue'
import { useRouter } from 'vue-router'
const router = useRouter()

function handleParentClick(item) {
  if (item.to) {
    router.push(item.to)
  }
}

// DATA MENU (Struktur data sudah diubah)
const navigationMenu = shallowRef([
  { name: 'BERANDA', href: '#', icon: Home },
  { name: 'TEST', to: '/data/pelati', icon: FileText, children: [
    { name: 'Pretest', to: '/data/pelatihan', icon: Pencil },
    { name: 'Posttest', href: '#', icon: ClipboardCheck },
    { name: 'Data Nilai', href: '#', icon: Database },
  ]},
  { name: 'PELATIHAN', icon: BookUser, children: [
    { name: 'Data Pendaftar', href: '#', icon: Users2 },
    { name: 'Data Peserta', href: '#', icon: UserCog },
  ]},
  { name: 'PENGADUAN', icon: MessageSquare, children: [
    { name: 'Data Pengaduan', href: '#', icon: FileQuestion },
    { name: 'Data Konsultasi', href: '#', icon: MessageCircle },
  ]},
]);

const isScrolled = ref(false)

// Handle scroll event
const handleScroll = () => {
  isScrolled.value = window.scrollY > 20
}

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
/* Base menu styling - clean and minimal */
.nav-menu {
  background-color: transparent !important;
  border-bottom: none !important;
}

/* Menu items - simple and clean */
:deep(.nav-menu .el-menu-item),
:deep(.nav-menu .el-sub-menu__title) {
  color: rgba(255, 255, 255, 0.9);
  font-weight: 500;
  font-size: 14px;
  transition: all 0.2s ease;
  border-bottom: none !important;
  padding: 0 16px;
}

:deep(.nav-menu.scrolled .el-menu-item),
:deep(.nav-menu.scrolled .el-sub-menu__title) {
  color: #4b5563;
}

/* Hover states - subtle and elegant */
:deep(.nav-menu .el-menu-item:hover),
:deep(.nav-menu .el-sub-menu__title:hover) {
  background-color: rgba(255, 255, 255, 0.1) !important;
  color: #ffffff !important;
}

:deep(.nav-menu.scrolled .el-menu-item:hover),
:deep(.nav-menu.scrolled .el-sub-menu__title:hover) {
  background-color: #f9fafb !important;
  color: #111827 !important;
}

/* Active states - pink accent */
:deep(.nav-menu .el-menu-item.is-active),
:deep(.nav-menu .el-sub-menu.is-active .el-sub-menu__title) {
  color: #ec4899 !important;
  background-color: rgba(236, 72, 153, 0.1) !important;
}

/* Dropdown menu - clean white */
:deep(.el-popper.el-menu--horizontal) {
  background: #ffffff !important;
  border: 1px solid #e5e7eb !important;
  border-radius: 8px !important;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
  padding: 4px !important;
  margin-top: 4px !important;
}

/* Dropdown items */
:deep(.el-menu--horizontal .el-menu-item) {
  color: #374151 !important;
  padding: 8px 12px !important;
  margin: 2px 0 !important;
  border-radius: 6px !important;
  transition: all 0.2s ease !important;
}

:deep(.el-menu--horizontal .el-menu-item:hover) {
  background-color: #ec4899 !important;
  color: #ffffff !important;
}

:deep(.el-menu--horizontal .el-menu-item.is-active) {
  background-color: #ec4899 !important;
  color: #ffffff !important;
}
</style>