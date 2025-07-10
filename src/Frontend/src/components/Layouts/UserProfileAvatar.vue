<template>
  <!-- Profile Dropdown -->
  <div
    class="relative"
    @click.stop
  >
    <!-- Avatar Button -->
    <button
      class="relative group focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-50 rounded-full transition-all duration-300"
      :aria-label="'Profil ' + (isNotLogin ? 'Tamu' : user.fullName)"
      @click="toggleDropdown"
    >
      <div 
        class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl"
        :class="isNotLogin ? 'bg-gradient-to-br from-gray-400 to-gray-500' : 'bg-gradient-to-br from-pink-400 to-pink-600'"
      >
        {{ userInitials }}
      </div>
      <!-- Online Status Indicator -->
      <div 
        v-if="!isNotLogin"
        class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full shadow-sm"
      />
    </button>

    <!-- Dropdown Menu -->
    <teleport to="body">
      <div
        v-show="isDropdownOpen"
        class="fixed inset-0 z-[9999]"
        @click="closeDropdown"
      >
        <!-- Background dengan animasi terpisah -->
        <transition name="backdrop">
          <div 
            v-show="isDropdownOpen"
            class="absolute inset-0 bg-black/20 backdrop-blur-sm"
          />
        </transition>
        
        <!-- Dropdown Card dengan animasi terpisah -->
        <transition name="dropdown">
          <div
            v-show="isDropdownOpen"
            class="absolute right-4 top-16 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
            @click.stop
          >
            <!-- Header Section -->
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-5 text-white relative overflow-hidden">
              <div class="absolute inset-0 bg-white/10 backdrop-blur-sm" />
              <div class="relative z-10 text-center">
                <!-- Large Avatar -->
                <div 
                  class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 ring-4 ring-white/30"
                  :class="isNotLogin ? 'bg-gradient-to-br from-gray-400 to-gray-500' : 'bg-gradient-to-br from-pink-400 to-pink-500'"
                >
                  {{ userInitials }}
                </div>
                
                <!-- User Info -->
                <h3 class="text-base font-bold mb-1">
                  {{ isNotLogin ? 'Selamat Datang, Tamu!' : user.fullName }}
                </h3>
                
                <p class="text-pink-100 text-sm opacity-90">
                  <span v-if="isOperator || isPegawai">{{ user.email }}</span>
                  <span v-else-if="isMasyarakat">NIK: {{ user.nik }}</span>
                  <span v-else>Pengunjung</span>
                </p>
              </div>
              
              <!-- Decorative Elements -->
              <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10" />
              <div class="absolute bottom-0 left-0 w-16 h-16 bg-white/10 rounded-full -ml-8 -mb-8" />
            </div>

            <!-- Menu Section -->
            <div class="p-4 space-y-2">
              <template v-if="!isNotLogin">
                <!-- Profile Button -->
                <button
                  class="w-full flex items-center p-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 rounded-xl transition-all duration-300 group"
                  @click="goToDetailMasyarakat"
                >
                  <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-pink-200 transition-colors duration-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5 text-pink-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                  </div>
                  <div class="flex-1 text-left">
                    <div class="font-medium">
                      Profil Saya
                    </div>
                    <div class="text-xs text-gray-500">
                      Lihat dan edit profil
                    </div>
                  </div>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-gray-400 group-hover:text-pink-500 transition-colors duration-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </button>

                <!-- Divider -->
                <div class="border-t border-gray-100 my-2" />

                <!-- Logout Button -->
                <button
                  class="w-full flex items-center p-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-300 group"
                  @click="handleLogout"
                >
                  <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5 text-red-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                  </div>
                  <div class="flex-1 text-left">
                    <div class="font-medium">
                      Keluar
                    </div>
                    <div class="text-xs text-gray-500">
                      Logout dari akun
                    </div>
                  </div>
                </button>
              </template>

              <!-- Guest Login Button -->
              <template v-else>
                <button
                  class="w-full flex items-center p-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-xl transition-all duration-300 group"
                  @click="router.push('/login/masyarakat')"
                >
                  <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-300">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="w-5 h-5 text-green-600"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                  </div>
                  <div class="flex-1 text-left">
                    <div class="font-medium">
                      Masuk
                    </div>
                    <div class="text-xs text-gray-500">
                      Login ke akun Anda
                    </div>
                  </div>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4 text-gray-400 group-hover:text-green-500 transition-colors duration-300"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </button>
              </template>
            </div>

            <!-- Footer -->
            <div class="px-4 pb-4">
              <div class="text-center">
                <p class="text-xs text-gray-400">
                  {{ isNotLogin ? 'Silakan login untuk akses penuh' : `Masuk sebagai ${user.role}` }}
                </p>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isDropdownOpen = ref(false)

const user = ref({
  role: '', 
  fullName: 'Tamu', 
  email: '', 
  nik: '', 
})

const isNotLogin = computed(() => {
  return localStorage.getItem('isLoggedIn') !== 'true';
});

const userInitials = computed(() => {
  if (isNotLogin.value) {
    return '??'; 
  }
  if (user.value.fullName) {
    const parts = user.value.fullName.split(' ');
    let initials = '';
    if (parts.length > 0 && parts[0].length > 0) {
      initials += parts[0][0].toUpperCase();
    }
    if (parts.length > 1 && parts[parts.length - 1].length > 0) {
      initials += parts[parts.length - 1][0].toUpperCase();
    } else if (parts.length === 1 && parts[0].length > 1) {
      initials += parts[0][1].toUpperCase();
    }
    return initials || '?';
  }
  return '?'; 
})

const isOperator = computed(() => user.value.role === 'operator');
const isPegawai = computed(() => user.value.role === 'pegawai');
const isMasyarakat = computed(() => user.value.role === 'masyarakat');

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
}

const closeDropdown = () => {
  isDropdownOpen.value = false;
}

const loadUserData = () => {
  user.value.role = localStorage.getItem('role') || '';
  user.value.fullName = localStorage.getItem('savedName') || 'Tamu';
  user.value.email = localStorage.getItem('email') || '';
  user.value.nik = localStorage.getItem('savedNIK') || '';
};

onMounted(() => {
  loadUserData();
  // Close dropdown when clicking outside
  document.addEventListener('click', closeDropdown);
});

onUnmounted(() => {
  document.removeEventListener('click', closeDropdown);
});

function goToDetailMasyarakat() {
  const savedNik = localStorage.getItem('savedNIK')
  if (savedNik) {
    router.push({
      name: 'DetailMasyarakat',
      params: { id: savedNik }
    })
  } else {
    console.warn('NIK belum tersedia di localStorage')
  }
  closeDropdown();
}

const handleLogout = async () => {
  try {
    const currentRole = user.value.role;
    localStorage.removeItem('isLoggedIn');
    localStorage.removeItem('role');
    localStorage.removeItem('userId');
    localStorage.removeItem('token');
    localStorage.removeItem('savedusername');
    localStorage.removeItem('savedpassword');
    localStorage.removeItem('savedName');
    localStorage.removeItem('email'); 
    localStorage.removeItem('savedNIK');
    localStorage.removeItem('Ttl');
    
    let redirectToPath = '/login/masyarakat'; 
    if (currentRole === 'operator') {
      redirectToPath = '/login/operator';
    } else if (currentRole === 'pegawai') {
      redirectToPath = '/login/pegawai';
    } else if (currentRole === 'masyarakat') {
      redirectToPath = '/login/masyarakat';
    }
    
    closeDropdown();
    router.push(redirectToPath);
  } catch (error) {
    console.error('Gagal logout:', error); 
  }
}
</script>

<style scoped>
/* Background Animation - Langsung muncul tanpa delay */
.backdrop-enter-active {
  transition: opacity 0.15s ease-out;
}

.backdrop-leave-active {
  transition: opacity 0.2s ease-in;
}

.backdrop-enter-from,
.backdrop-leave-to {
  opacity: 0;
}

.backdrop-enter-to,
.backdrop-leave-from {
  opacity: 1;
}

/* Dropdown Content Animation - Smooth popup effect */
.dropdown-enter-active {
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.dropdown-leave-active {
  transition: all 0.2s ease-in;
}

.dropdown-enter-from {
  opacity: 0;
  transform: translateY(-20px) scale(0.9);
}

.dropdown-enter-to {
  opacity: 1;
  transform: translateY(0) scale(1);
}

.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}

.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px) scale(0.95);
}
</style>