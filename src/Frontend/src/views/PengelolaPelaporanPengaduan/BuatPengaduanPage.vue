<template>
  <DefaultLayout>
    <div class="buat-pengaduan-page">
      <div class="card-header">
        <h2>Sampaikan Pengaduan Anda</h2>
      </div>
      <p>Silakan klik tombol di bawah untuk membuat pengaduan baru.</p>
      <button class="btn-buat" @click="showForm = true">Buat Pengaduan</button>
      <PelaporanPengaduan v-if="showForm" @close="showForm = false" />
    </div>
  </DefaultLayout>
</template>

<script setup>
import { ref } from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import PelaporanPengaduan from './PelaporanPengaduan.vue'

const showForm = ref(false)
</script>

<style scoped>
.buat-pengaduan-page {
  background: #fff;
  border-radius: 16px;
  max-width: 600px;
  margin: 40px auto;
  padding: 36px 28px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
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
</style>