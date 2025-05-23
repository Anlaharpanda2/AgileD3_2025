<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api.js'

const pesertas = ref([])
const router = useRouter()

onMounted(async () => {
  try {
    const res = await api.get('/peserta')
    pesertas.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
})

const goToTambah = () => {
  router.push('/tambah')
}
</script>

<template>
  <div class="page">
    <h1>📘 Daftar Peserta Pelatihan</h1>

    <div class="action-bar">
      <button @click="goToTambah">➕ Tambah Peserta</button>
    </div>

    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>TTL</th>
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
          <tr v-if="pesertas.length === 0">
            <td colspan="11" class="text-center">Belum ada data peserta.</td>
          </tr>
          <tr v-for="p in pesertas" :key="p.nik">
            <td>{{ p.nik }}</td>
            <td>{{ p.peserta }}</td>
            <td>{{ p.tempat_tanggal_lahir }}</td>
            <td>{{ p.jenis_kelamin }}</td>
            <td>{{ p.alamat }}</td>
            <td>{{ p.pendidikan }}</td>
            <td>{{ p.pekerjaan }}</td>
            <td>{{ p.email }}</td>
            <td>{{ p.pelatihan }}</td>
            <td>{{ p.tanggal_pelatihan }}</td>
            <td>{{ p.tempat_pelatihan }}</td>
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
  margin-bottom: 20px;
}

.action-bar {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.action-bar button {
  background-color: #ffb5a7;
  border: none;
  padding: 10px 20px;
  font-weight: bold;
  color: #fff;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s;
}

.action-bar button:hover {
  background-color: #f29387;
}

.table-wrapper {
  max-width: 100%;
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
  font-size: 14px;
}

th {
  background-color: #ffb5a7;
  color: #fff;
  padding: 10px;
  text-align: left;
}

td {
  padding: 10px;
  border-bottom: 1px solid #eee;
  color: #333;
  vertical-align: top;
}

tr:hover {
  background-color: #ffe5d9;
}

.text-center {
  text-align: center;
  color: #999;
  font-style: italic;
}
</style>
