<template>
  <!-- Modal Overlay dengan backdrop blur -->
  <div
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-300"
    @click.self="$emit('close')"
  >
    <!-- Modal Container dengan shadow yang lebih dramatis -->
    <div class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl shadow-pink-500/10 animate-in zoom-in-95 duration-300 ease-out">

      <!-- Header Section -->
      <!-- Mengurangi padding-bottom untuk proporsi yang lebih baik -->
      <div class="relative px-8 pt-8 pb-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <!-- Icon dengan background gradient -->
            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl shadow-lg shadow-pink-500/25">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
              </svg>
            </div>
            <div>
              <h3 class="text-2xl font-bold text-gray-900">Impor Data Excel</h3>
              <p class="text-sm text-gray-500 mt-1">Upload file Excel untuk mengimpor data pelatihan</p>
            </div>
          </div>

          <!-- Close Button dengan hover effect -->
          <button
            @click="$emit('close')"
            class="flex items-center justify-center w-10 h-10 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200 hover:scale-110"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Upload Section -->
      <!-- Menyesuaikan padding-top untuk proporsi yang lebih baik -->
      <div class="px-8 pb-8 pt-4">
        <el-upload
          class="w-full"
          drag
          ref="upload"
          :file-list="fileList"
          :auto-upload="false"
          :before-upload="beforeUpload"
          :on-remove="handleRemove"
          :on-change="handleChange"
        >
          <div class="upload-area-custom">
            <!-- Upload State: Empty -->
            <div v-if="!fileList.length" class="flex flex-col items-center justify-center py-12">
              <!-- Animated upload icon -->
              <div class="relative mb-6">
                <div class="flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl border-2 border-dashed border-gray-300 hover:border-pink-400 transition-all duration-300">
                  <svg class="w-8 h-8 text-gray-400 hover:text-pink-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <!-- Floating dots animation -->
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-pink-400 rounded-full animate-pulse"></div>
                <div class="absolute -bottom-1 -left-1 w-2 h-2 bg-gray-400 rounded-full animate-pulse delay-75"></div>
              </div>

              <!-- Upload text -->
              <div class="text-center space-y-2">
                <p class="text-lg font-medium text-gray-700">
                  Drag & drop file Excel di sini
                </p>
                <p class="text-gray-500">
                  atau <span class="font-semibold text-pink-600 hover:text-pink-700 cursor-pointer">klik untuk memilih file</span>
                </p>

                <!-- File format info -->
                <div class="flex items-center justify-center space-x-4 mt-6 pt-4 border-t border-gray-100">
                  <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Format: .xls, .xlsx</span>
                  </div>
                  <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Maksimal 1 file</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Upload State: File Selected -->
            <div v-else class="flex items-center justify-center py-8">
              <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-200 w-full max-w-md">
                <!-- File icon -->
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-xl">
                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>

                <!-- File info -->
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900 truncate">
                    {{ fileList[0]?.name }}
                  </p>
                  <p class="text-xs text-green-600">
                    File siap diimpor
                  </p>
                </div>

                <!-- Success checkmark -->
                <div class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full">
                  <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </el-upload>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
          <!-- Left side - Reset button (only show when file exists) -->
          <div>
            <button
              v-if="fileList.length"
              @click="resetAndSelectNewFile"
              class="inline-flex items-center space-x-2 px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 rounded-xl transition-all duration-200 hover:shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              <span>Pilih File Lain</span>
            </button>
          </div>

          <!-- Right side - Import button dan Download Format button -->
          <div class="flex items-center space-x-3">
            <!-- Tombol Unduh Format Import -->
            <a
              href="/import/format.xlsx"
              download
              class="inline-flex items-center space-x-2 px-6 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 rounded-xl transition-all duration-200 hover:shadow-sm"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              <span>Unduh Format Import</span>
            </a>

            <!-- Cancel button -->
            <button
              @click="$emit('close')"
              class="px-6 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 rounded-xl transition-all duration-200"
            >
              Batal
            </button>

            <!-- Import button -->
            <button
              @click="submitFile"
              :disabled="!fileList.length || loading"
              class="inline-flex items-center space-x-2 px-8 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 focus:from-pink-600 focus:to-pink-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed rounded-xl shadow-lg shadow-pink-500/25 hover:shadow-xl hover:shadow-pink-500/30 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 hover:scale-105 disabled:hover:scale-100 disabled:hover:shadow-lg"
            >
              <!-- Loading spinner -->
              <svg
                v-if="loading"
                class="w-4 h-4 animate-spin"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>

              <!-- Import icon -->
              <svg
                v-else
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
              </svg>

              <span>{{ loading ? 'Mengimpor...' : 'Impor File' }}</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { ElMessage, ElNotification } from 'element-plus'
import api from '../../api.js' // Pastikan path ini benar sesuai struktur proyek Anda

const fileList = ref<File[]>([])
const loading = ref(false)

/**
 * Validasi sebelum upload file
 * Memastikan hanya file .xls atau .xlsx yang bisa diunggah.
 */
const beforeUpload = (file: File) => {
  const isExcel = /\.(xls|xlsx)$/i.test(file.name)
  if (!isExcel) {
    ElMessage.error('File harus berformat .xls atau .xlsx')
  }

  // Mengatur ulang fileList jika ada lebih dari satu file yang mencoba diunggah
  // Ini memastikan hanya satu file yang bisa dipilih pada satu waktu
  if (fileList.value.length >= 1) {
    fileList.value = []
  }

  return isExcel
}

/**
 * Tangani perubahan file
 * Mengambil file terakhir yang dipilih dan menyimpannya ke fileList.
 */
const handleChange = (file: any, fileListRaw: any[]) => {
  // Ambil file terakhir, bisa .raw jika <el-upload> atau langsung File jika <input>
  const lastFile = fileListRaw.slice(-1)[0]
  fileList.value = [lastFile.raw || lastFile]
}

/**
 * Hapus file dari daftar
 * Mengosongkan fileList.
 */
const handleRemove = () => {
  fileList.value = []
}

/**
 * Kirim file ke API
 * Mengirim file yang dipilih ke endpoint API untuk proses impor.
 */
const submitFile = async () => {
  if (!fileList.value.length) return // Jangan lakukan apa-apa jika tidak ada file
  loading.value = true // Aktifkan status loading

  const file = fileList.value[0]
  const formData = new FormData()
  formData.append('file', file)

  try {
    await api.post('/kelola/pelatihan/impor', formData) // Panggil API untuk mengimpor

    ElNotification({
      title: 'Berhasil',
      message: 'Data berhasil diimpor!',
      type: 'success',
      duration: 3000
    })

    fileList.value = [] // Kosongkan daftar file setelah berhasil
    // emit event jika perlu, contoh: emit('close') untuk menutup modal
  } catch (err: any) {
    // Tangani error dari respons API atau error lainnya
    const errorMessage = err.response?.data?.error || 'Terjadi kesalahan saat mengimpor data.'
    ElMessage.error(errorMessage) // Tampilkan pesan error
    console.error('Import error:', err)
  } finally {
    loading.value = false // Nonaktifkan status loading
  }
}

/**
 * Reset dan pilih ulang file baru
 * Mengosongkan fileList untuk memungkinkan pemilihan file baru.
 */
const resetAndSelectNewFile = () => {
  fileList.value = []
}
</script>

<style scoped>
/* Custom upload area styling */
.upload-area-custom {
  @apply w-full border-2 border-dashed border-gray-200 hover:border-pink-300 rounded-2xl transition-all duration-300 cursor-pointer;
  @apply hover:bg-gradient-to-br hover:from-pink-50/50 hover:to-gray-50/50;
}

/* Override Element Plus upload styling */
:deep(.el-upload-dragger) {
  @apply border-none bg-transparent rounded-2xl;
  width: 100% !important;
  height: auto !important;
  padding: 0 !important;
}

:deep(.el-upload-dragger:hover) {
  @apply border-none bg-transparent;
}

/* Animation classes for Tailwind */
@keyframes zoom-in-95 {
  0% {
    opacity: 0;
    transform: scale(0.95);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

.animate-in {
  animation-fill-mode: both;
}

.zoom-in-95 {
  animation-name: zoom-in-95;
}

.fade-in {
  animation-name: fade-in;
}

.duration-300 {
  animation-duration: 300ms;
}

.ease-out {
  animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
}

.delay-75 {
  animation-delay: 75ms;
}
</style>
