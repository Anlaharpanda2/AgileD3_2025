<template>
  <!-- Modal Overlay, diklik untuk menutup form -->
  <div class="modal-overlay" @click.self="$emit('close')">
    <div class="form-import">
      <!-- Header dengan tombol close terintegrasi secara flex -->
      <div class="form-import-header">
        <h3 class="header-title">Impor Data Excel</h3>
        <button class="close-btn-integrated" @click="$emit('close')">
          <img src="/import/close.svg" alt="Import Icon" class="w-6 h-6" />
        </button>
      </div>

      <el-upload
        class="upload-area"
        drag
        ref="upload"
        :file-list="fileList"
        :auto-upload="false"
        :before-upload="beforeUpload"
        :on-remove="handleRemove"
        :on-change="handleChange"
      >
        <i class="el-icon-upload">
          <img src="/import/import.svg" alt="Import Icon" class="w-6 h-6" />
        </i>
        <div class="upload-text">
          <p v-if="!fileList.length">Drag & Drop file Excel di sini atau <span class="text-primary-color font-semibold">klik untuk memilih</span></p>
          <p v-else>📄 {{ fileList[0].name }}</p>
        </div>
        <div class="upload-tip">(.xls, .xlsx) Maksimal 1 file</div>
      </el-upload>
      <div class="btn-group">
        <el-button
          @click="resetAndSelectNewFile"
          class="btn-reupload"
          v-if="fileList.length"
        >
          Pilih File Lain
        </el-button>
        <el-button
          type="primary"
          :loading="loading"
          :disabled="!fileList.length"
          @click="submitFile"
          class="btn-import"
        >
          Impor File
        </el-button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { ElMessage, ElNotification } from 'element-plus'
import api from '@/api.js'

const fileList = ref<File[]>([])
const loading = ref(false)

/**
 * Validasi sebelum upload file
 */
const beforeUpload = (file: File) => {
  const isExcel = /\.(xls|xlsx)$/i.test(file.name)
  if (!isExcel) {
    ElMessage.error('File harus berformat .xls atau .xlsx')
  }

  if (fileList.value.length >= 1) {
    fileList.value = []
  }

  return isExcel
}

/**
 * Tangani perubahan file
 */
const handleChange = (file: any, fileListRaw: any[]) => {
  // Ambil file terakhir, bisa .raw jika <el-upload> atau langsung File jika <input>
  const lastFile = fileListRaw.slice(-1)[0]
  fileList.value = [lastFile.raw || lastFile]
}

/**
 * Hapus file
 */
const handleRemove = () => {
  fileList.value = []
}

/**
 * Kirim file ke API
 */
const submitFile = async () => {
  if (!fileList.value.length) return
  loading.value = true

  const file = fileList.value[0] // aman karena sudah handle .raw di atas
  const formData = new FormData()
  formData.append('file', file)

  try {
    await api.post('/kelola/pelatihan/impor', formData)

    ElNotification({
      title: 'Berhasil',
      message: 'Data berhasil diimpor!',
      type: 'success',
      duration: 3000
    })

    fileList.value = []
    // emit event jika perlu
    // emit('close')
  } catch (err: any) {
    const errorMessage = err.response?.data?.error || 'Terjadi kesalahan saat mengimpor data.'
    ElMessage.error(errorMessage)
    console.error('Import error:', err)
  } finally {
    loading.value = false
  }
}

/**
 * Reset dan pilih ulang file baru
 */
const resetAndSelectNewFile = () => {
  fileList.value = []
}
</script>


<style scoped>
/* Warna utama */
.primary-color {
  color: #69C5C2;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.7); /* Latar belakang lebih gelap untuk fokus */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  animation: fadeIn 0.3s ease;
}

.form-import {
  background: #ffffff;
  border-radius: 1.5rem; /* Sudut lebih membulat */
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3); /* Bayangan lebih dalam */
  max-width: 600px;
  width: 90%;
  padding: 2.5rem; /* Padding lebih besar */
  animation: popup 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Animasi popup yang lebih dinamis */
  display: flex; /* Menggunakan flexbox untuk tata letak internal */
  flex-direction: column;
  gap: 1.5rem; /* Jarak antar elemen */
}

/* Animasi Popup */
@keyframes popup {
  from {
    transform: scale(0.85) translateY(20px);
    opacity: 0;
  }
  to {
    transform: scale(1) translateY(0);
    opacity: 1;
  }
}
@keyframes fadeIn {
  from {
    background: rgba(0, 0, 0, 0);
  }
  to {
    background: rgba(0, 0, 0, 0.7);
  }
}

/* Header Form Import */
.form-import-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 1rem;
  border-bottom: 1px solid #e0e0e0;
}

.header-title {
  font-size: 1.75rem; /* Ukuran judul lebih besar */
  font-weight: bold;
  color: #333333;
  margin: 0; /* Pastikan tidak ada margin default */
}

/* Tombol Close terintegrasi */
.close-btn-integrated {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem; /* Berikan padding untuk area klik yang lebih besar */
  font-size: 1.5rem;
  color: #69C5C2; /* Warna utama untuk ikon close */
  transition: transform 0.2s ease, color 0.2s ease;
}
.close-btn-integrated:hover {
  transform: scale(1.3); /* Efek putar dan sedikit membesar */
  color: #5AAEA8; /* Warna sedikit lebih gelap saat hover */
}

/* Area Upload */
.upload-area {
  border: 2px dashed #69C5C2; /* Warna primary */
  border-radius: 1rem; /* Sudut lebih membulat */
  padding: 2rem;
  text-align: center;
  transition: border-color 0.3s ease, background-color 0.3s ease;
  cursor: pointer;
}
.upload-area:hover {
  border-color: #5AAEA8; /* Warna primary dark saat hover */
  background-color: #F8FCFB; /* Latar belakang sangat ringan */
}

/* El Icon Upload (ikon awan) */
.upload-area .el-icon-upload {
  font-size: 3rem; /* Ukuran ikon lebih besar */
  color: #69C5C2; /* Warna primary */
  margin-bottom: 0.5rem;
  display: block; /* Pastikan ikon di tengah secara horizontal */
}
/* Menyembunyikan ikon default Element Plus dan menggantinya dengan SVG */
.upload-area .el-icon-upload::before {
  content: none !important;
}
.upload-area .el-icon-upload svg {
  display: block; /* Pastikan SVG tampil sebagai blok untuk properti margin/padding */
  margin: 0 auto; /* Tengah secara horizontal */
}


.upload-text {
  font-size: 1.1rem; /* Ukuran font lebih besar */
  color: #404040; /* Warna teks lebih gelap */
  margin-top: 0.8rem;
  line-height: 1.4;
}

.upload-tip {
  font-size: 0.9rem; /* Ukuran font lebih besar */
  color: #808080; /* Warna teks lebih gelap */
  margin-top: 0.5rem;
}

/* Grup Tombol */
.btn-group {
  display: flex;
  justify-content: flex-end; /* Pindahkan tombol ke kanan */
  gap: 1rem; /* Jarak antar tombol */
  margin-top: 1rem;
}

.btn-reupload,
.btn-import {
  flex: 0 0 auto; /* Jangan biarkan tombol mengisi seluruh lebar */
  padding: 0.75rem 1.5rem; /* Padding lebih besar */
  font-weight: 600; /* Font lebih tebal */
  border-radius: 0.75rem; /* Sudut membulat */
  height: auto; /* Hapus height tetap */
  transition: all 0.3s ease; /* Transisi untuk semua properti */
  text-transform: uppercase; /* Teks uppercase */
  letter-spacing: 0.5px;
}

/* Tombol Pilih File Lain (Re-upload) */
.btn-reupload {
  background-color: transparent;
  border: 1px solid #B0E0DF; /* Border warna primary light */
  color: #69C5C2; /* Warna teks primary */
}
.btn-reupload:hover {
  background-color: rgba(105, 197, 194, 0.1); /* Background primary transparan saat hover */
  border-color: #69C5C2; /* Border primary saat hover */
  box-shadow: 0 4px 10px rgba(105, 197, 194, 0.15); /* Bayangan primary */
}

/* Tombol Impor File */
.btn-import {
  background: linear-gradient(to right, #88D3D1, #69C5C2); /* Gradien warna primary */
  border: none;
  color: white;
  box-shadow: 0 4px 12px rgba(105, 197, 194, 0.3); /* Bayangan kuat */
}
.btn-import:hover {
  background: linear-gradient(to right, #69C5C2, #5AAEA8); /* Gradien lebih gelap saat hover */
  box-shadow: 0 6px 16px rgba(105, 197, 194, 0.4); /* Bayangan lebih kuat saat hover */
  transform: translateY(-2px); /* Efek terangkat */
}
.btn-import:disabled {
  background: #C0C0C0 !important; /* Warna abu-abu saat disabled */
  cursor: not-allowed;
  box-shadow: none;
  transform: none;
}
</style>