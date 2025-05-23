<script setup>
import { ref, onMounted } from 'vue'
import api from '../../api.js'

const pendaftars = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get('/pendaftar')
    pendaftars.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data pendaftar:', error)
  } finally {
    loading.value = false
  }
})

const exportExcel = () => {
  window.open('http://localhost:8000/api/pendaftar/ekspor', '_blank')
}
</script>

<template>
  <div class="page">
    <h1>Ekspor Data Pendaftar</h1>
    <div class="actions">
      <button @click="exportExcel">Unduh Excel</button>
    </div>
    <div class="table-wrapper">
      <p v-if="loading">Memuat data...</p>
      <table v-else>
        <thead>
          <tr>
            <th>Nik</th>
            <th>Peserta</th>
            <th>Tempat_Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th>Email</th>
            <th>Pelatihan</th>
            <th>Tanggal Pelatihan</th>
            <th>Tempat Pelatihan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in pendaftars" :key="item.id">
            <td>{{ item.nik }}</td>
            <td>{{ item.peserta }}</td>
            <td>{{ item.tempat_tanggal_lahir }}</td>
            <td>{{ item.jenis_kelamin }}</td>
            <td>{{ item.alamat }}</td>
            <td>{{ item.pendidikan }}</td>
            <td>{{ item.pekerjaan }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.pelatihan }}</td>
            <td>{{ item.tanggal_pelatihan }}</td>
            <td>{{ item.tempat_pelatihan }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
.page {
  padding: 25px;
  background-color: #f8f9fa;
  min-height: 100vh;
  font-family: 'Segoe UI', sans-serif;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
}

.actions {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.actions button {
  background-color: #ff006e;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.2s ease-in-out;
}

.actions button:hover {
  background-color: #d90429;
}

.table-wrapper {
  max-width: 100%;
  overflow-x: auto;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

th {
  background-color: #ff006e;
  color: white;
  padding: 12px;
  text-align: left;
  white-space: nowrap;
}

td {
  padding: 12px;
  border-bottom: 1px solid #eee;
  color: #333;
}

tr:nth-child(even) {
  background-color: #f5f5f5;
}
</style>
