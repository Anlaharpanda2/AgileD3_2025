<script setup>
import { ref, onMounted } from 'vue'
import api from '../api.js'

const nadya = ref([])
onMounted(async () => {
  try {
    const res = await api.get('/nadyaroute')
    nadya.value = res.data
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
})
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