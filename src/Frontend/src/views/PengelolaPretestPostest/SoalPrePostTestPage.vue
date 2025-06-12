<template>
  <DefaultLayout>
    <div class="soal-prepost-test-page">
      <div class="card-header">
        <h2>Kelola Soal Pre/Post Test</h2>
      </div>
      <p>Silakan klik tombol di bawah untuk menambahkan soal baru.</p>
      <button class="btn-buat" @click="showForm = true">Tambah Soal</button>
      <SoalForm v-if="showForm" @close="showForm = false" />
      <div class="soal-list">
        <h3>Daftar Soal</h3>
        <ul>
          <li v-for="soal in soalList" :key="soal.id">
            {{ soal.pertanyaan }} - {{ soal.jenis }}
            <button @click="deleteSoal(soal.id)">Hapus</button>
          </li>
        </ul>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';
import SoalForm from '@/components/SoalForm.vue'; // Component for adding questions
import axios from 'axios';

const showForm = ref(false);
const soalList = ref([]);

// Fetch the list of questions from the API
const fetchSoal = async () => {
  try {
    const response = await axios.get('http://your-backend-url/api/soal-prepost');
    soalList.value = response.data;
  } catch (error) {
    console.error('Error fetching questions:', error);
  }
};

// Delete a question
const deleteSoal = async (id) => {
  try {
    await axios.delete(`http://your-backend-url/api/soal-prepost/${id}`);
    fetchSoal(); // Refresh the list after deletion
  } catch (error) {
    console.error('Error deleting question:', error);
  }
};

// Fetch questions when the component is mounted
onMounted(() => {
  fetchSoal();
});
</script>

<style scoped>
.soal-prepost-test-page {
  background: #fff;
  border-radius: 16px;
  max-width: 600px;
  margin: 40px auto;
  padding: 36px 28px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
  text-align: center;
}
.card-header {
  background: #e0f7fa;
  border-radius: 12px 12px 0 0;
  padding: 18px 0 10px 0;
  margin-bottom: 18px;
}
.card-header h2 {
  color: #1e8e86;
  margin: 0;
  font-weight: 700;
  font-size: 1.6em;
  letter-spacing: 1px;
}
.btn-buat {
  background: #69C5C2;
  color: #fff;
  border: none;
  padding: 12px 32px;
  border-radius: 8px;
  font-size: 1.1em;
  margin-top: 24px;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-buat:hover {
  background: #1e8e86;
}
.soal-list {
  margin-top: 20px;
}
.soal-list h3 {
  margin-bottom: 10px;
}
.soal-list ul {
  list-style-type: none;
  padding: 0;
}
.soal-list li {
  margin: 10px 0;
}
.soal-list button {
  background: #ff4d4d;
  color: #fff;
  border: none;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
}
.soal-list button:hover {
  background: #c70000;
}
</style>