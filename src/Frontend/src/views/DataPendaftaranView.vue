<template>
  <div class="container mt-5">
    <h3 class="mb-4 text-center">Data Pendaftaran</h3>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped shadow-sm">
        <thead class="table-dark">
          <tr>
            <th>NIK</th>
            <th>Peserta</th>
            <th>Tempat & Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th class="w-25">Alamat</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th class="w-25">Email</th>
            <th class="w-25">Pelatihan</th>
            <th class="w-25">Tanggal Pelatihan</th>
            <th class="w-25">Tempat Pelatihan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="data in pendaftar" :key="data.nik">
            <td>{{ maskData(data.nik) }}</td>
            <td>{{ data.peserta }}</td>
            <td>{{ maskData(data.tempat_tanggal_lahir) }}</td>
            <td>{{ data.jenis_kelamin }}</td>
            <td>{{ data.alamat }}</td>
            <td>{{ data.pendidikan }}</td>
            <td>{{ data.pekerjaan }}</td>
            <td>{{ maskData(data.email) }}</td>
            <td>{{ data.pelatihan }}</td>
            <td>{{ data.tanggal_pelatihan }}</td>
            <td>{{ data.tempat_pelatihan }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const pendaftar = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/pendaftar')
    pendaftar.value = response.data
  } catch (error) {
    console.error('Gagal ambil data:', error)
  }
})

const maskData = (data) => {
  if (!data) return data
  return data.replace(/./g, '•') // Ganti setiap karakter dengan titik
}
</script>

<style scoped>
.container {
  max-width: 90%;
  margin: auto;
}

h3 {
  color: #343a40;
  font-weight: 600;
}

.table-responsive {
  overflow-x: auto;
}

table {
  width: 100%;
  margin-top: 20px;
  font-size: 14px; /* Mengatur ukuran font untuk tabel agar lebih kecil */
}

th, td {
  text-align: center;
  vertical-align: middle; /* Menjaga agar teks tidak terlalu tinggi */
  padding: 10px;
}

th {
  background-color: #343a40;
  color: white;
}

td {
  background-color: #f8f9fa;
}

tbody tr:hover {
  background-color: #f1f3f5;
}

table th, table td {
  border: 1px solid #dee2e6;
  padding: 12px 15px;
}

.w-25 {
  width: 25% !important; /* Menetapkan lebar kolom menjadi 25% */
}

@media (max-width: 768px) {
  table {
    font-size: 12px; /* Ukuran font lebih kecil pada layar kecil */
  }

  /* Mengatur lebar kolom pada layar kecil */
  .w-25 {
    width: auto !important;
  }
}
</style>
