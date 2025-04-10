<script setup>
import { ref, onMounted } from 'vue'
import api from '../api.js'

const mahasiswas = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/mahasiswa')
    mahasiswas.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
})
</script>

<template>
  <div class="page">
    <h1>📘 Daftar Mahasiswa</h1>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="mhs in mahasiswas" :key="mhs.nim">
            <td>{{ mhs.nim }}</td>
            <td>{{ mhs.name }}</td>
            <td>{{ mhs.email }}</td>
            <td>{{ mhs.alamat }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.page {
  padding: 40px;
  background-color: #f8edeb;
  min-height: 100vh;
  font-family: 'Segoe UI', sans-serif;
}

h1 {
  text-align: center;
  color: #2b2d42;
  margin-bottom: 30px;
}

.table-wrapper {
  max-width: 1000px;
  margin: 0 auto;
  overflow-x: auto;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 16px;
}

th {
  background-color: #ffb5a7;
  color: #fff;
  padding: 15px;
  text-align: left;
}

td {
  padding: 15px;
  border-bottom: 1px solid #eee;
  color: #333;
}

tr:hover {
  background-color: #ffe5d9;
}
</style>
