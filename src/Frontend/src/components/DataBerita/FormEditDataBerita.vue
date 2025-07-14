<template>
  <div
    class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click.self="$emit('close')"
  >
    <transition
      name="modal"
      appear
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full max-h-[95vh] flex flex-col overflow-hidden">
        <!-- Header -->
        <div
          class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700
 px-6 py-4 sm:px-8 sm:py-6 rounded-t-xl"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <!-- Icon for header -->
                <svg
                  class="w-6 h-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                  />
                </svg>
              </div>
              <div>
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                  Edit Data Berita
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Perbarui informasi berita
                </p>
              </div>
            </div>
            <button
              class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
              aria-label="Tutup"
              @click="$emit('close')"
            >
              <!-- Close icon -->
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Form Body -->
        <div class="flex-grow overflow-y-auto p-6 sm:p-8">
          <el-form
            ref="formRef"
            :model="form"
            :rules="rules"
            label-position="top"
            class="space-y-6"
          >
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item
                  label="Judul Berita"
                  prop="judul"
                  class="md:col-span-2"
                >
                  <el-input
                    v-model="form.judul"
                    placeholder="Masukkan judul berita"
                    size="large"
                    class="modern-input"
                  />
                </el-form-item>
                <el-form-item
                  label="Jenis Konten"
                  prop="jenis_konten"
                >
                  <el-select
                    v-model="form.jenis_konten"
                    placeholder="Pilih jenis konten"
                    size="large"
                    class="w-full modern-select"
                    clearable
                  >
                    <el-option
                      label="Berita"
                      value="berita"
                    />
                    <el-option
                      label="Artikel"
                      value="artikel"
                    />
                    <el-option
                      label="Pengumuman"
                      value="pengumuman"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item label="Gambar">
                  <div
                    v-if="currentImageUrl"
                    class="current-image mb-3"
                  >
                    <p class="mb-2">
                      Gambar saat ini:
                    </p>
                    <img
                      :src="currentImageUrl"
                      alt="Current Image"
                      style="max-width: 200px; height: auto; border-radius: 4px;"
                    >
                  </div>
                  
                  <el-upload
                    class="w-full"
                    drag
                    accept=".jpg,.jpeg,.png"
                    :before-upload="beforeUpload"
                    :on-remove="onRemove"
                    :file-list="fileList"
                    :limit="1"
                    :auto-upload="false"
                    :on-change="handleChange"
                  >
                    <div class="el-upload__text">
                      Drop file gambar di sini, atau <em>klik untuk upload</em>
                    </div>
                  </el-upload>
                </el-form-item>
                <el-form-item
                  label="Isi Berita"
                  prop="isi"
                  class="md:col-span-2"
                >
                  <el-input
                    v-model="form.isi"
                    type="textarea"
                    placeholder="Masukkan isi berita"
                    :rows="6"
                    class="modern-textarea"
                  />
                </el-form-item>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200">
              <button
                type="button"
                class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl font-medium hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-sm"
                @click="$emit('close')"
              >
                <div class="flex items-center justify-center space-x-2">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                  <span>Batal</span>
                </div>
              </button>
              <button
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl font-medium focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
                @click="submitForm"
              >
                <div class="flex items-center justify-center space-x-2">
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"
                    />
                  </svg>
                  <span>Simpan Perubahan</span>
                </div>
              </button>
            </div>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { reactive, ref, watch, computed } from 'vue'
import api from '../../api.js';
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object,
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const form = reactive({
  judul: '',
  isi: '',
  jenis_konten: '',
  foto: null,
  currentFoto: '',
})

const fileList = ref([])

const currentImageUrl = computed(() => {
  return props.initialData?.foto || null;
});

watch(() => props.initialData, (newVal) => {
  if (newVal) {
    Object.assign(form, {
      judul: newVal.judul || '',
      isi: newVal.isi || '',
      jenis_konten: newVal.jenis_konten || '',
      currentFoto: newVal.foto || newVal.gambar || '',
      foto: null
    })
  }
}, { immediate: true })

const rules = {
  judul: [{ required: true, message: 'Judul wajib diisi', trigger: 'blur' }],
  isi: [{ required: true, message: 'Isi berita wajib diisi', trigger: 'blur' }],
  jenis_konten: [{ required: true, message: 'Jenis konten wajib dipilih', trigger: 'change' }],
}

const beforeUpload = (file) => {
  const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png'
  if (!isJpgOrPng) {
    ElNotification({
      title: 'Error',
      message: 'Hanya file JPG dan PNG yang diperbolehkan!',
      type: 'error',
      duration: 3000,
    })
    return false
  }
  return true
}

const handleChange = (file, fileListParam) => {
  form.foto = file.raw || null
  fileList.value = fileListParam.slice(-1)
}

const onRemove = () => {
  form.foto = null
  fileList.value = []
}

const submitForm = () => {
  formRef.value.validate(async valid => {
    if (!valid) {
      ElNotification({
        title: 'Validasi gagal',
        message: 'Periksa input form anda.',
        type: 'warning',
        duration: 3000,
      })
      return
    }

    try {
      const payload = new FormData()
      payload.append('judul', form.judul)
      payload.append('isi', form.isi)
      payload.append('jenis_konten', form.jenis_konten)
      
      if (form.foto) {
        payload.append('foto', form.foto)
      }

      // Use POST request with method spoofing for file uploads
      payload.append('_method', 'PUT');

      const response = await api.post(`/kelola/berita/${props.initialData.id}`, payload);

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Data berhasil diupdate',
        type: 'success',
        duration: 3000,
      })
      window.location.reload()
      emit('close')
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal memperbarui data',
        type: 'error',
        duration: 0,
      })
    }
  })
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

:deep(.modern-input .el-input__wrapper),
:deep(.modern-select .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner) {
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  padding: 8px 12px;
}

:deep(.modern-input .el-input__wrapper:hover),
:deep(.modern-select .el-input__wrapper:hover),
:deep(.modern-textarea .el-textarea__inner:hover) {
  border-color: #f472b6;
}

:deep(.modern-input.is-focus .el-input__wrapper),
:deep(.modern-select.is-focus .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner:focus) {
  border-color: #f472b6;
  box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.15);
}

:deep(.el-form-item) {
  margin-bottom: 0;
}

:deep(.el-form-item__label) {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

:deep(.el-input),
:deep(.el-select),
:deep(.el-textarea) {
  width: 100%;
}
</style>
