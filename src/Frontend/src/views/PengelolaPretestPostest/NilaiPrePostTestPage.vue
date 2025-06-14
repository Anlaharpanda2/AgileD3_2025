<template>
  <DefaultLayout>
    <div class="nilai-prepost-test-page">
      <div class="card-header">
        <h2>Data Nilai Pretest & Postest</h2>
      </div>
      <p>Berikut adalah daftar nilai peserta pretest dan postest.</p>

      <table class="nilai-table" v-if="nilaiList.length > 0">
        <thead>
          <tr>
            <th>Nama Peserta</th>
            <th>Jenis</th>
            <th>Nilai</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="nilai in nilaiList" :key="nilai.id">
            <td>{{ nilai.nama_peserta }}</td>
            <td class="jenis">{{ nilai.jenis }}</td>
            <td>{{ nilai.nilai }}</td>
            <td>{{ formatDate(nilai.created_at) }}</td>
          </tr>
        </tbody>
      </table>

      <p v-else>Tidak ada data nilai tersedia.</p>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import api from '@/api'; // Menggunakan konfigurasi axios yang telah disiapkan

const nilaiList = ref([]);

// Ambil data nilai pretest & posttest dari API
const fetchNilai = async () => {
  try {
    const response = await api.get('/nilai-prepost');
    nilaiList.value = response.data;
  } catch (error) {
    console.error('Error fetching nilai:', error);
  }
};

// Format tanggal agar lebih rapi ditampilkan
const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('id-ID', options);
};

// Ambil data saat komponen dimuat
onMounted(() => {
  fetchNilai();
});
</script>


<style scoped>
.nilai-prepost-test-page {
  background: #fff;
  border-radius: 16px;
  max-width: 800px;
  margin: 40px auto;
  padding: 36px 28px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
}

.card-header {
  background: #e0f7fa;
  border-radius: 12px 12px 0 0;
  padding: 18px 0 10px 0;
  margin-bottom: 18px;
  text-align: center;
}

.card-header h2 {
  color: #1e8e86;
  margin: 0;
  font-weight: 700;
  font-size: 1.6em;
  letter-spacing: 1px;
}

p {
  text-align: center;
  color: #555;
  margin-bottom: 24px;
  font-size: 1.1em;
}

.nilai-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 1em;
  color: #333;
}

.nilai-table thead tr {
  background: #69C5C2;
  color: white;
  text-align: left;
}

.nilai-table th,
.nilai-table td {
  padding: 12px 16px;
  border: 1px solid #ddd;
  vertical-align: middle;
}

.nilai-table tbody tr:hover {
  background-color: #f0f7f7;
  cursor: default;
}

/* Accent 'jenis' column */
.nilai-table td.jenis {
  text-transform: capitalize;
  font-weight: 600;
  color: #1e8e86;
}

/* Responsive adjustments */
@media (max-width: 640px) {
  .nilai-prepost-test-page {
    padding: 20px 16px;
  }
  .nilai-table th,
  .nilai-table td {
    padding: 8px 10px;
    font-size: 0.9em;
  }
}
</style>