<template>
  <div class="form-overlay">
    <transition name="popup">
      <div
        v-if="isMounted"
        class="form-popup"
      >
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">
            Form Edit Data Berita
          </h3>
        </div>

        <div class="form-body">
          <el-form
            ref="formRef"
            :model="form"
            :rules="rules"
            label-width="140px"
            label-position="top"
            class="p-4"
          >
            <el-row :gutter="20">
              <el-col
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item
                  label="Judul Berita"
                  prop="judul"
                  required
                >
                  <el-input
                    v-model="form.judul"
                    type="text"
                    placeholder="Judul Berita"
                    clearable
                  />
                </el-form-item>
              </el-col>

              <el-col
                :span="24"
                class="mb-3"
              >
                <el-form-item
                  label="Isi Berita"
                  prop="isi"
                  required
                >
                  <el-input
                    v-model="form.isi"
                    type="textarea"
                    placeholder="Isi Berita"
                    rows="6"
                    clearable
                  />
                </el-form-item>
              </el-col>

              <el-col
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item
                  label="Jenis Konten"
                  prop="jenis_konten"
                  required
                >
                  <el-select
                    v-model="form.jenis_konten"
                    placeholder="Pilih Jenis Konten"
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
              </el-col>

              
              <el-col
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item label="Tanggal Buat">
                  <el-input
                    v-model="form.created_at"
                    readonly
                    placeholder="Tanggal Buat"
                  />
                </el-form-item>
              </el-col>
              <el-col
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item label="Tanggal Update">
                  <el-input
                    v-model="form.updated_at"
                    readonly
                    placeholder="Tanggal Update"
                  />
                </el-form-item>
              </el-col>

              <el-col
                :span="24"
                class="mb-3"
              >
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
                    class="upload-demo"
                    drag
                    accept=".jpg,.jpeg,.png"
                    :before-upload="beforeUpload"
                    :on-remove="onRemove"
                    :file-list="fileList"
                    :limit="1"
                    :auto-upload="false"
                    :on-change="handleChange"
                  >
                    <i class="el-icon-upload" />
                    <div class="el-upload__text">
                      Drop file gambar di sini, atau klik untuk upload
                    </div>
                    <template #tip>
                      <div class="el-upload__tip">
                        Hanya JPG dan PNG. Maksimal 1 file. (Kosongkan jika tidak ingin mengubah gambar)
                      </div>
                    </template>
                  </el-upload>
                </el-form-item>
              </el-col>
            </el-row>

            <el-form-item class="d-flex justify-content-end gap-3 mt-4">
              <el-button
                class="btn-cancel"
                @click="$emit('close')"
              >
                Batal
              </el-button>
              <el-button
                type="primary"
                class="btn-submit"
                @click="submitForm"
              >
                Simpan
              </el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { reactive, ref, watch, computed, onMounted } from 'vue'
import api from '../../api.js';
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object,
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const isMounted = ref(false)
onMounted(() => {
  isMounted.value = true
})

// Reactive form dengan default fallback
const form = reactive({
  judul: '',
  isi: '',
  jenis_konten: '',
  created_at: '',
  updated_at: '',
  foto: null, // for new image file
  currentFoto: '', // for existing image path
})

const fileList = ref([])

// Computed property to get current image URL
const currentImageUrl = computed(() => {
  if (!form.currentFoto) return null
  
  const baseUrl = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'
  
  // If it's already a full URL, return as is
  if (form.currentFoto.startsWith('http://') || form.currentFoto.startsWith('https://')) {
    return form.currentFoto
  }
  
  // If it starts with storage/, construct the URL
  if (form.currentFoto.startsWith('storage/')) {
    return `${baseUrl}/${form.currentFoto}`
  }
  
  // If it starts with /, it's an absolute path
  if (form.currentFoto.startsWith('/')) {
    return `${baseUrl}${form.currentFoto}`
  }
  
  // If it's just the filename, assume it's in storage/berita/
  return `${baseUrl}/storage/berita/${form.currentFoto}`
})

// Watch for initialData changes
watch(() => props.initialData, (newVal) => {
  if (newVal) {
    Object.assign(form, {
      judul: newVal.judul || '',
      isi: newVal.isi || '',
      jenis_konten: newVal.jenis_konten || '',
      created_at: newVal.created_at || '',
      updated_at: newVal.updated_at || '',
      currentFoto: newVal.foto || newVal.gambar || '', // Handle both foto and gambar fields
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
      
      // Only append image if a new one is selected
      if (form.foto) {
        payload.append('foto', form.foto)
      }

      // Use PUT method with _method override for Laravel
      payload.append('_method', 'PUT')

      // Assuming we have an ID from initialData
      const response = await api.post(`/kelola/berita/${props.initialData.id}`, payload, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })

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
.background {
  background: #69C5C2;
}
.form-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(2px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}
.form-popup {
  width: 100%;
  max-width: 850px;
  max-height: 95vh;
  background-color: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  animation: popupIn 0.3s ease;
  overflow: hidden;
}
.form-body {
  overflow-y: auto;
  padding: 1rem;
}
.btn-submit {
  background-color: #69C5C2;
  border: none;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-submit:hover {
  background-color: #1e8e86;
}
.btn-cancel {
  background-color: #eeeeee;
  color: #333;
  padding: 0.5rem 1.2rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-cancel:hover {
  background-color: #dddddd;
}
.current-image {
  border: 1px solid #ddd;
  padding: 10px;
  border-radius: 4px;
  background-color: #f9f9f9;
}
@keyframes popupIn {
  from {
    opacity: 0;
    transform: scale(0.92);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
