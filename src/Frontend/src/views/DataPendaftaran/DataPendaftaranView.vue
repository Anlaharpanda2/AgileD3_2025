<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '../../api.js'

// STATE UTAMA
const pendaftars = ref([])
const loading = ref(true)
const fileInput = ref(null)
const searchQuery = ref('') // ⬅️ Tambahkan di sini

// FILTER BERDASARKAN PENCARIAN
const filteredPendaftars = computed(() =>
  pendaftars.value.filter((item) =>
    item.peserta?.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
)

// FETCH DATA DARI API
const fetchPendaftars = async () => {
  loading.value = true
  try {
    const res = await api.get('/pendaftar')
    pendaftars.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data pendaftar:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchPendaftars()
})

import { useRouter } from 'vue-router'
const router = useRouter()

const goToExportPage = () => {
  router.push('/pendaftar/ekspor') // akan menuju EksporPendaftar.vue
}


const triggerImport = () => {
  fileInput.value.click()
}

const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  const formData = new FormData()
  formData.append('file', file)

  try {
    const res = await api.post('/pendaftar/impor', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    await fetchPendaftars()
    event.target.value = ''
  } catch (error) {
    console.error('Gagal mengimpor data:', error)
  }
}
</script>



<template>
  <div class="page">
    <h1>Daftar Pendaftar</h1>
    <div class="top-bar">
  <div class="search-bar">
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Cari nama pendaftar..."
    />
  </div>
  <div class="actions">
    <button @click="goToExportPage">Ekspor</button>
    <button @click="triggerImport">Impor</button>
  </div>
</div>


    <div class="table-wrapper">
      <input type="file" ref="fileInput" @change="handleFileUpload" style="display: none;" />
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
          <tr v-for="item in filteredPendaftars" :key="item.id">
            <td >{{ item.nik }}</td>
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
/* Your existing styles remain unchanged */

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

.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 20px;
  gap: 10px;
}

/* Search Bar */
.search-bar input {
  padding: 5px;
  width: 250px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-sie: 15px;
}

/* Action Buttons */
.actions {
  display: flex;
  gap: 8px;
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

/* Table Container */
.table-wrapper {
  max-width: 100%;
  overflow-x: auto;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

/* Table Styling */
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

/* Optional: status badge styling if needed */
.status {
  padding: 6px 12px;
  border-radius: 6px;
  font-weight: bold;
  font-size: 12px;
  display: inline-block;
  margin-right: 5px;
}

.action-cell {
  white-space: nowrap;
}


</style>