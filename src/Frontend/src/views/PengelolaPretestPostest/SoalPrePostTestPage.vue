<template>
  <DefaultLayout>
    <div class="soal-prepost-test-page">
      <div class="card-header">
        <h2>Kelola Soal Pre/Post Test</h2>
      </div>

      <!-- ✅ Notifikasi -->
      <p v-if="successMessage" class="success-msg">{{ successMessage }}</p>

      <p>Silakan klik tombol di bawah untuk menambahkan soal baru.</p>
      <button class="btn-buat" @click="showForm = true">Tambah Soal</button>

      <!-- Form Tambah/Edit Soal -->
      <SoalForm
        v-if="showForm"
        :initialData="editData"
        @close="resetForm"
        @saved="handleSaved"
      />

      <div class="soal-list">
        <h3>Daftar Soal</h3>
        <table v-if="soalList.length" class="soal-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Pertanyaan</th>
              <th>Jenis</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(soal, index) in soalList" :key="soal.id">
              <td>{{ index + 1 }}</td>
              <td>{{ soal.pertanyaan }}</td>
              <td>{{ soal.jenis }}</td>
              <td>
                <button class="edit-btn" @click="editSoal(soal)">Edit</button>
                <button class="hapus-btn" @click="deleteSoal(soal.id)">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
        <p v-else>Tidak ada soal.</p>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import SoalForm from '@/components/SoalForm.vue';
import api from '@/api';

const showForm = ref(false);
const editData = ref(null);
const successMessage = ref('');
const soalList = ref([]);

// Reset form state
const resetForm = () => {
  showForm.value = false;
  editData.value = null;
};

// Fetch questions
const fetchSoal = async () => {
  try {
    const data = await api.get('/soal-prepost');
    soalList.value = Array.isArray(data) ? data : [];
  } catch (error) {
    console.error('❌ Gagal mengambil data soal:', error);
    soalList.value = [];
  }
};

// On save
const handleSaved = (message = 'Soal berhasil disimpan') => {
  resetForm();
  fetchSoal();
  successMessage.value = message;
  setTimeout(() => {
    successMessage.value = '';
  }, 3000);
};

// Edit
const editSoal = (soal) => {
  try {
    const pilihan = typeof soal.pilihan === 'string'
      ? JSON.parse(soal.pilihan)
      : soal.pilihan;

    editData.value = { ...soal, pilihan };
    showForm.value = true;
  } catch (err) {
    console.error('❌ Gagal memuat soal untuk edit:', err);
  }
};

// Delete
const deleteSoal = async (id) => {
  try {
    await api.delete(`/soal-prepost/${id}`);
    fetchSoal();
    successMessage.value = '✅ Soal berhasil dihapus';
    setTimeout(() => (successMessage.value = ''), 3000);
  } catch (error) {
    console.error('❌ Gagal menghapus soal:', error);
  }
};

onMounted(() => {
  fetchSoal();
});
</script>

<style scoped>
.soal-prepost-test-page {
  width: 100%;
  min-height: 100vh;
  padding: 40px 60px;
  background-color: #f9f9f9;
  box-sizing: border-box;
}

.card-header {
  background: #e0f7fa;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 24px;
}

.card-header h2 {
  color: #1e8e86;
  margin: 0;
  font-weight: 700;
  font-size: 2rem;
  letter-spacing: 1px;
  text-align: center;
}

.success-msg {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  padding: 12px;
  border-radius: 6px;
  margin: 20px auto;
  max-width: 800px;
  font-weight: bold;
  text-align: center;
}

.btn-buat {
  background: #69C5C2;
  color: #fff;
  border: none;
  padding: 12px 28px;
  border-radius: 8px;
  font-size: 1.1em;
  margin: 20px 0;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-buat:hover {
  background: #1e8e86;
}

.soal-list {
  margin-top: 30px;
}
.soal-list h3 {
  margin-bottom: 16px;
  font-size: 1.3rem;
  font-weight: bold;
}

.soal-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
}
.soal-table th,
.soal-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}
.soal-table th {
  background-color: #f0f0f0;
  font-weight: bold;
}

.edit-btn {
  background-color: #1976d2;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 4px;
  margin-right: 6px;
  cursor: pointer;
}
.edit-btn:hover {
  background-color: #115293;
}
.hapus-btn {
  background-color: #ff4d4d;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 4px;
  cursor: pointer;
}
.hapus-btn:hover {
  background-color: #c70000;
}
</style>
