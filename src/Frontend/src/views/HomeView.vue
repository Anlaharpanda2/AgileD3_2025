<script setup>
import { ref, onMounted } from 'vue'
import api from '../api.js' // Path dari views ke api.js

const users = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/users') // GET dari Laravel API
    users.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
})
</script>

<template>
  <div>
    <h1>Daftar Pengguna</h1>
    <ul>
      <li v-for="user in users" :key="user.id">
        {{ user.name }}
      </li>
    </ul>
  </div>
</template>
