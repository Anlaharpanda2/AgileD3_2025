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
    <h1>📘 Data Nadya</h1>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Kolom1</th>
            <th>Kolom2</th>
            <th>Kolom3</th>
            <th>Kolom4</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="mhs in nadya" :key="mhs.contoh1">
            <td>{{ mhs.contoh1}}</td>
            <td>{{ mhs.contoh2 }}</td>
            <td>{{ mhs.contoh3 }}</td>
            <td>{{ mhs.contoh4 }}</td>
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
</style>
