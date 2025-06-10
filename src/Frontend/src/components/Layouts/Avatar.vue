<template>
  <v-menu min-width="200px">
    <template v-slot:activator="{ props }">
      <v-btn
        icon
        v-bind="props"
        class="p-0 m-0"
        style="min-width: 0; padding: 0; width: 23px; height: 23px; border-radius: 50%;">
        <v-avatar color="brown" size="23">
          <span style="font-size: 10px;">{{ user.initials }}</span>
        </v-avatar>
      </v-btn>
    </template>

    <v-card>
      <v-card-text>
        <div class="mx-auto text-center">
          <v-avatar color="brown">
            <span class="text-h5">{{ user.initials }}</span>
          </v-avatar>
          <h3>{{ user.fullName }}</h3>
          <p class="text-caption mt-1">{{ user.email }}</p>
          <v-divider class="my-3"></v-divider>
          <v-btn variant="text" rounded> Edit Akun </v-btn>
          <v-divider class="my-3"></v-divider>
          <v-btn variant="text" @click="handleLogout" rounded> Logout </v-btn>
        </div>
      </v-card-text>
    </v-card>
  </v-menu>
</template>

<script setup>
import { useRouter } from 'vue-router'
import api from '../../api';
const router = useRouter()

const user = {
  initials: 'AH',
  fullName: 'Anla Harpanda',
  email: 'Anla@harpanda.com',
}

const handleLogout = async () => {
  try {
    localStorage.removeItem('isLoggedIn')
    localStorage.removeItem('role')
    localStorage.removeItem('userId')
    localStorage.removeItem('token')
    localStorage.removeItem('savedusername')
    localStorage.removeItem('savedpassword')
    localStorage.removeItem('savedNama')
    localStorage.removeItem('savedNIK')
    router.push('/login/masyarakat')
  } catch (error) {
    console.error('Gagal logout:', error)
  }
}
</script>

