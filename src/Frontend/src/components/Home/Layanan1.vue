<template>
  <el-card shadow="never" class="card-container">
    <div class="card-inner">
      <img :src="image" class="card-image" />

      <div class="card-content">
        <h3 class="card-title">{{ title }}</h3>
        <p class="card-description">{{ description }}</p>
      </div>

      <div class="card-actions">
        <el-button type="primary" @click="handleSubmit" round class="submit-btn">
          Ikut Pelatihan
        </el-button>
      </div>
    </div>
  </el-card>

  <!-- Form Tambah Data hanya muncul jika showForm true -->
  <FormTambahDataPendaftaran v-if="showForm" @close="showForm = false" />
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { ElMessage } from 'element-plus'
import FormTambahDataPendaftaran from './FormTambahDataPendaftaran.vue'

const image = '/Home/1.jpeg'
const title = 'Pelatihan'
const description =
  'meningkatkan kualitas hidup perempuan melalui pengembangan keterampilan, pemberdayaan ekonomi, dan penguatan peran sosial'

const showForm = ref(false)

function handleSubmit() {
  showForm.value = true
}
</script>

<style scoped>
/* (semua style tetap sama dengan punyamu, tidak diubah) */
.card-container {
  width: 300px;
  margin: 2.5rem auto;
  border: none;
  background: transparent;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-inner {
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  background: white;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-container:hover .card-inner {
  transform: translateY(-6px);
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.card-image {
  width: 100%;
  height: 150px;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.card-container:hover .card-image {
  transform: scale(1.05);
}

.card-content {
  padding: 1.25rem 1.25rem 0;
}

.card-title {
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  color: #333;
}

.card-description {
  color: #666;
  font-size: 0.96rem;
  line-height: 1.5;
}

.card-actions {
  padding: 1rem 1.25rem 1.5rem;
  text-align: right;
}

.submit-btn {
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(64, 158, 255, 0.3);
}

.submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(64, 158, 255, 0.45);
}
</style>
