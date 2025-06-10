<template>
  <div>
    <div v-if="pengaduans.length">
      <div class="card-list">
        <div v-for="item in pengaduans" :key="item.id_pengaduan" class="card">
          <div class="card-header">
            <b>{{ item.jenis_kasus }}</b>
            <span class="status" :class="item.status">{{ item.status }}</span>
          </div>
          <div class="card-body">
            <div><b>Deskripsi:</b> {{ item.deskripsi_laporan }}</div>
            <div><b>Tanggal Pengaduan:</b> {{ formatDate(item.tanggal_pengaduan) }}</div>
            <div><b>Waktu Kejadian:</b> {{ formatDateTime(item.waktu_kejadian) }}</div>
            <div><b>Jenis Pengaduan:</b> {{ item.jenis_pengaduan }}</div>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center mt-4" style="font-weight:bold;">
      Anda belum membuat laporan
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api.js'
const pengaduans = ref([])
const nik = localStorage.getItem('nik') || '' 
onMounted(async () => {
  if (!nik) return
  const res = await api.get('/pengaduan', { params: { nik } })
  pengaduans.value = res.data
})
function formatDate(dt) {
  if (!dt) return '-'
  const d = new Date(dt)
  const pad = n => n.toString().padStart(2, '0')
  return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`
}
function formatDateTime(dt) {
  if (!dt) return '-'
  const d = new Date(dt)
  const pad = n => n.toString().padStart(2, '0')
  return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`
}
</script>
<style scoped>
.card-list {
  display: flex;
  flex-wrap: wrap;
  gap: 18px;
  margin-top: 24px;
}
.card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  padding: 18px 20px;
  min-width: 260px;
  max-width: 340px;
  flex: 1 1 260px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.status {
  padding: 2px 10px;
  border-radius: 8px;
  font-size: 0.95em;
  color: #fff;
  text-transform: capitalize;
}
.status.dikirim { background: #f39c12; }
.status.diproses { background: #3498db; }
.status.selesai { background: #27ae60; }
.card-body {
  font-size: 0.98em;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
</style>