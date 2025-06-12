<template>
  <v-menu min-width="220px" transition="slide-y-transition">
    <template v-slot:activator="{ props }">
      <v-btn
        icon
        v-bind="props"
        class="avatar-button"
        aria-label="Profil Pengguna"
      >
        <v-avatar :color="isNotLogin ? 'grey-lighten-1' : 'primary'" size="32" class="avatar-gradient elevation-2">
          <span class="text-white font-weight-bold" style="font-size: 14px;">{{ userInitials }}</span>
        </v-avatar>
      </v-btn>
    </template>
    <v-card class="user-card elevation-6 rounded-lg">
      <v-card-text class="pa-5">
        <div class="mx-auto text-center">
          <v-avatar :color="isNotLogin ? 'grey-lighten-1' : 'primary'" size="80" class="avatar-gradient elevation-3 mb-3">
            <span class="text-h4 text-white font-weight-bold">{{ userInitials }}</span>
          </v-avatar>
          <h3 class="text-subtitle-1 font-weight-medium mb-1 text-grey-darken-4">
            {{ isNotLogin ? 'Selamat Datang, Tamu!' : user.fullName }}
          </h3>
          <p v-if="isOperator || isPegawai" class="text-caption text-grey-darken-1">
            {{ user.email }}
          </p>
          <p v-else-if="isMasyarakat" class="text-caption text-grey-darken-1">
            NIK: {{ user.nik }}
          </p>
          <v-divider class="my-4"></v-divider>
          <template v-if="!isNotLogin">
            <v-btn
              variant="flat"
              rounded
              color="light-blue-lighten-5"
              class="mb-2 text-capitalize font-weight-regular button-hover-scale"
              block
              aria-label="Edit Akun"
            >
              Edit Akun
            </v-btn>
            <v-btn
              variant="flat"
              rounded
              color="red-lighten-5"
              @click="handleLogout"
              class="text-capitalize font-weight-regular button-hover-scale"
              block
              aria-label="Logout"
            >
              Logout
            </v-btn>
          </template>
          <template v-else>
            <v-btn
              variant="flat"
              rounded
              color="green-lighten-5"
              @click="router.push('/login/masyarakat')"
              class="text-capitalize font-weight-regular button-hover-scale"
              block
              aria-label="Login"
            >
              Login
            </v-btn>
          </template>
        </div>
      </v-card-text>
    </v-card>
  </v-menu>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()
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
const loadUserData = () => {
  user.value.role = localStorage.getItem('role') || '';
  user.value.fullName = localStorage.getItem('savedName') || 'Tamu';
  user.value.email = localStorage.getItem('email') || '';
  user.value.nik = localStorage.getItem('savedNIK') || '';
};
onMounted(() => {
  loadUserData();
});
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
    let redirectToPath = '/login/masyarakat'; 
    if (currentRole === 'operator') {
      redirectToPath = '/login/operator';
    } else if (currentRole === 'pegawai') {
      redirectToPath = '/login/pegawai';
    } else if (currentRole === 'masyarakat') {
      redirectToPath = '/login/masyarakat';
    }
    router.push(redirectToPath);
  } catch (error) {
    console.error('Gagal logout:', error); 
  }
}
</script>
<style scoped>
:root {
  font-family: 'Inter', sans-serif;
}
.avatar-button {
  min-width: 0 !important;
  padding: 0 !important;
  width: 32px !important; 
  height: 32px !important;
  border-radius: 50% !important;
  transition: transform 0.2s ease-in-out; 
}
.avatar-button:hover {
  transform: scale(1.1); 
}
.avatar-gradient {
  background: linear-gradient(45deg, #64c1be, #69C5C2); 
}
.user-card {
  border-radius: 12px !important; 
  overflow: hidden; 
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important; 
}
.button-hover-scale {
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.button-hover-scale:hover {
  transform: translateY(-2px); 
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.text-caption {
  font-size: 0.8rem !important;
}
</style>
