<template>
  <Layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
      <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-500 rounded-full mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Formulir Pengaduan Masyarakat</h1>
          <p class="text-gray-600 max-w-2xl mx-auto">
            Sampaikan laporan Anda dengan lengkap dan jelas. Tim kami akan menindaklanjuti setiap pengaduan yang masuk.
          </p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
          <!-- Form Header -->
          <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-8 py-6">
            <h2 class="text-xl font-semibold text-white flex items-center">
              <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
              Data Pengaduan
            </h2>
          </div>

          <!-- Form Body -->
          <div class="p-8">
            <el-form
              :model="form"
              :rules="rules"
              ref="formRef"
              label-position="top"
              class="space-y-6"
            >
              <!-- Informasi Pelapor Section -->
              <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-pink-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                  </svg>
                  Informasi Pelapor
                </h3>
                
                <el-row :gutter="20">
                  <el-col :span="24" :md="12">
                    <el-form-item label="Nama Pelapor" prop="nama_pelapor" required>
                      <el-input 
                        v-model="form.nama_pelapor" 
                        placeholder="Masukkan nama lengkap Anda"
                        size="large"
                        class="modern-input"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24" :md="12">
                    <el-form-item label="Nomor HP" prop="no_hp">
                      <el-input 
                        v-model="form.no_hp" 
                        placeholder="Contoh: 08123456789"
                        size="large"
                        class="modern-input"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24">
                    <el-form-item label="Alamat Pelapor" prop="alamat">
                      <el-input 
                        v-model="form.alamat" 
                        type="textarea" 
                        placeholder="Masukkan alamat lengkap Anda"
                        :rows="3"
                        class="modern-textarea"
                      />
                    </el-form-item>
                  </el-col>
                </el-row>
              </div>

              <!-- Detail Kejadian Section -->
              <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-pink-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                  </svg>
                  Detail Kejadian
                </h3>
                
                <el-row :gutter="20">
                  <el-col :span="24" :md="12">
                    <el-form-item label="Nama Korban" prop="nama_korban">
                      <el-input 
                        v-model="form.nama_korban" 
                        placeholder="Nama korban (jika ada)"
                        size="large"
                        class="modern-input"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24" :md="12">
                    <el-form-item label="Jenis Kasus" prop="kasus">
                      <el-input 
                        v-model="form.kasus" 
                        placeholder="Contoh: Kekerasan, KDRT, dll"
                        size="large"
                        class="modern-input"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24" :md="12">
                    <el-form-item label="Waktu Kejadian" prop="waktu_kejadian">
                      <el-date-picker
                        v-model="form.waktu_kejadian"
                        type="datetime"
                        placeholder="Pilih tanggal dan waktu kejadian"
                        style="width: 100%;"
                        size="large"
                        class="modern-date-picker"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24" :md="12">
                    <el-form-item label="Nama Saksi" prop="saksi">
                      <el-input 
                        v-model="form.saksi" 
                        placeholder="Nama saksi (jika ada)"
                        size="large"
                        class="modern-input"
                      />
                    </el-form-item>
                  </el-col>
                  <el-col :span="24">
                    <el-form-item label="Deskripsi Kejadian" prop="deskripsi" required>
                      <el-input 
                        v-model="form.deskripsi" 
                        type="textarea" 
                        placeholder="Jelaskan kronologi kejadian secara detail..."
                        :rows="5"
                        class="modern-textarea"
                      />
                    </el-form-item>
                  </el-col>
                </el-row>
              </div>

              <!-- Lampiran Section -->
              <div class="bg-gray-50 rounded-xl p-6 border-l-4 border-pink-500">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                  </svg>
                  Lampiran Bukti
                </h3>
                
                <el-form-item label="Upload File" prop="lampiran">
                  <div class="w-full">
                    <div class="flex items-center justify-center w-full">
                      <label for="file-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                          <svg class="w-8 h-8 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                          </svg>
                          <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                          </p>
                          <p class="text-xs text-gray-500">PNG, JPG, PDF (MAX. 10MB)</p>
                        </div>
                        <input id="file-upload" type="file" class="hidden" @change="onFileChange" accept="image/*,.pdf" />
                      </label>
                    </div>
                    <div v-if="form.lampiran" class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                      <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-green-700">{{ form.lampiran.name }}</span>
                      </div>
                    </div>
                  </div>
                </el-form-item>
              </div>

              <!-- Submit Buttons -->
              <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button
                  type="button"
                  @click="resetForm"
                  class="flex-1 sm:flex-none px-8 py-3 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition-colors duration-200 flex items-center justify-center"
                >
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                  </svg>
                  Reset Form
                </button>
                <button
                  type="button"
                  @click="submitForm"
                  :disabled="isSubmitting"
                  class="flex-1 px-8 py-3 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-xl font-medium hover:from-pink-600 hover:to-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl"
                >
                  <svg v-if="!isSubmitting" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                  <svg v-else class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  {{ isSubmitting ? 'Mengirim...' : 'Kirim Pengaduan' }}
                </button>
              </div>
            </el-form>
          </div>
        </div>

        <!-- Success Message -->
        <div v-if="showSuccessMessage" class="mt-8 bg-green-50 border border-green-200 rounded-xl p-6 text-center">
          <div class="inline-flex items-center justify-center w-12 h-12 bg-green-500 rounded-full mb-4">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h3 class="text-lg font-semibold text-green-800 mb-2">Pengaduan Berhasil Dikirim!</h3>
          <p class="text-green-600">Tim kami akan segera menindaklanjuti laporan Anda. Terima kasih atas partisipasi Anda.</p>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import Layout from '../../layouts/Layout.vue'
import api from '../../api.js'
import { ElNotification } from 'element-plus'
import { useRouter } from 'vue-router'

const router = useRouter()
const formRef = ref(null)
const isSubmitting = ref(false)
const showSuccessMessage = ref(false)

const form = reactive({
  nama_pelapor: '',
  nama_korban: '',
  deskripsi: '',
  alamat: '',
  waktu_kejadian: null,
  kasus: '',
  no_hp: '',
  saksi: '',
  lampiran: null,
})

const rules = {
  nama_pelapor: [{ required: true, message: 'Nama pelapor wajib diisi', trigger: 'blur' }],
  deskripsi: [{ required: true, message: 'Deskripsi kejadian wajib diisi', trigger: 'blur' }],
}

function onFileChange(e) {
  const file = e.target.files[0]
  if (file) {
    // Validasi ukuran file (10MB)
    if (file.size > 10 * 1024 * 1024) {
      ElNotification({
        title: 'File Terlalu Besar',
        message: 'Ukuran file maksimal 10MB',
        type: 'warning',
        duration: 3000,
      })
      e.target.value = ''
      return
    }
    form.lampiran = file
  }
}

function formatDateTime(dt) {
  if (!dt) return ''
  const d = new Date(dt)
  const pad = n => n.toString().padStart(2, '0')
  return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`
}

function resetForm() {
  formRef.value?.resetFields()
  Object.keys(form).forEach(key => {
    if (key === 'lampiran') {
      form[key] = null
    } else if (key === 'waktu_kejadian') {
      form[key] = null
    } else {
      form[key] = ''
    }
  })
  showSuccessMessage.value = false
  
  // Reset file input
  const fileInput = document.getElementById('file-upload')
  if (fileInput) fileInput.value = ''
}

function submitForm() {
  formRef.value.validate(async valid => {
    if (!valid) {
      ElNotification({
        title: 'Validasi Gagal',
        message: 'Periksa kembali form yang Anda isi',
        type: 'warning',
        duration: 3000,
      })
      return
    }

    isSubmitting.value = true

    try {
      const formData = new FormData()

      Object.keys(form).forEach(key => {
        if (form[key] !== null && form[key] !== '') {
          if (key === 'waktu_kejadian') {
            formData.append(key, formatDateTime(form[key]))
          } else {
            formData.append(key, form[key])
          }
        }
      })

      formData.append('status', 'diproses')

      const response = await api.post('kelola/pengaduan', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })

      console.log('RESPON:', response.data)

      const createdId = response?.data?.id
      if (!createdId) {
        throw new Error('ID tidak ditemukan di response')
      }

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Pengaduan berhasil dikirim',
        type: 'success',
        duration: 2000,
      })

      showSuccessMessage.value = true
      resetForm()

      setTimeout(() => {
        router.push({
          name: 'KonfirmasiPengaduan',
          query: { id: createdId }
        })
      }, 2000)

    } catch (error) {
      console.error('ERROR:', error)
      ElNotification({
        title: 'Gagal',
        message: error?.message || error?.response?.data?.message || 'Gagal mengirim pengaduan',
        type: 'error',
        duration: 5000,
      })
    } finally {
      isSubmitting.value = false
    }
  })
}

</script>

<style scoped>
/* Custom styles untuk Element Plus components */
:deep(.el-input__wrapper) {
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

:deep(.el-input__wrapper:hover) {
  border-color: #ec4899;
}

:deep(.el-input__wrapper.is-focus) {
  border-color: #ec4899;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

:deep(.el-textarea__inner) {
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

:deep(.el-textarea__inner:hover) {
  border-color: #ec4899;
}

:deep(.el-textarea__inner:focus) {
  border-color: #ec4899;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

:deep(.el-date-editor) {
  border-radius: 0.75rem;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

:deep(.el-date-editor:hover) {
  border-color: #ec4899;
}

:deep(.el-date-editor.is-active) {
  border-color: #ec4899;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

:deep(.el-form-item__label) {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
}

:deep(.el-form-item__error) {
  color: #ef4444;
  font-size: 0.875rem;
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-gradient-to-br {
  animation: fadeInUp 0.6s ease-out;
}

/* Custom scrollbar */
:deep(.el-scrollbar__wrap) {
  scrollbar-width: thin;
  scrollbar-color: #ec4899 #f3f4f6;
}

:deep(.el-scrollbar__wrap::-webkit-scrollbar) {
  width: 6px;
}

:deep(.el-scrollbar__wrap::-webkit-scrollbar-track) {
  background: #f3f4f6;
  border-radius: 3px;
}

:deep(.el-scrollbar__wrap::-webkit-scrollbar-thumb) {
  background: #ec4899;
  border-radius: 3px;
}
</style>