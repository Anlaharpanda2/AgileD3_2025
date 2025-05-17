<script setup>
import { ref, onMounted } from 'vue'
import api from '../../api.js'

const pendaftar = ref([])

// Fungsi ambil data
const loadData = async () => {
  try {
    const res = await api.get('/pendaftar') // sesuaikan dengan route di Laravel
    pendaftar.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
}

onMounted(loadData)

// Fungsi hapus data
const hapusPendaftar = async (nik) => {
  if (confirm('Yakin ingin menghapus data dengan NIK ' + nik + '?')) {
    try {
      await api.post(`/pendaftar/${nik}/hapus`) // pakai POST seperti di route Laravel-mu
      alert('Data berhasil dihapus')
      loadData() // refresh tabel
    } catch (error) {
      console.error('Gagal menghapus data:', error)
      alert('Gagal menghapus data')
    }
  }
}
</script>

<template>
  <div class="page">
    <h1>📋 Daftar Pendaftar</h1>
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
            <th>Tanggal</th>
            <th>Tempat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in pendaftar" :key="item.nik">
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
            <td>
              <button class="btn-hapus" @click="hapusPendaftar(item.nik)">Hapus</button>
            </td>
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
  font-size: 14px;
}

th {
  background-color: #ffb5a7;
  color: #fff;
  padding: 10px;
  text-align: center;
}

td {
  padding: 10px;
  border-bottom: 1px solid #eee;
  color: #333;
  text-align: center;
}

tr:hover {
  background-color: #ffe5d9;
}

.btn-hapus {
  background-color: #e74c3c;
  color: white;
  padding: 5px 10px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.btn-hapus:hover {
  background-color: #c0392b;
}
</style>
