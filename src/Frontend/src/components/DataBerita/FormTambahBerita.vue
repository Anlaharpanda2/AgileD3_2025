<template>
  <div class="form-overlay">
    <transition name="popup">
      <div
        v-if="isMounted"
        class="form-popup"
      >
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">
            Form Tambah Berita
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

              <!-- Tanggal Buat dan Update biasanya otomatis dari backend, tapi kita tampilkan readonly -->
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
                <el-form-item
                  label="Gambar"
                  prop="gambar"
                  required
                >
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
                        Hanya JPG dan PNG. Maksimal 1 file.
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
import { reactive, ref, onMounted } from 'vue'
import api from '../../api.js'
import { ElNotification } from 'element-plus'

const emit = defineEmits(['close'])

const formRef = ref(null)

const isMounted = ref(false)
onMounted(() => {
  isMounted.value = true
})

const form = reactive({
  judul: '',
  isi: '',
  jenis_konten: '',
  created_at: '',
  updated_at: '',
  gambar: null,
})

const fileList = ref([])

const rules = {
  judul: [{ required: true, message: 'Judul wajib diisi', trigger: 'blur' }],
  isi: [{ required: true, message: 'Isi berita wajib diisi', trigger: 'blur' }],
  jenis_konten: [{ required: true, message: 'Jenis konten wajib dipilih', trigger: 'change' }],
  gambar: [{ required: true, message: 'Gambar wajib diupload', trigger: 'change' }],
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
  form.gambar = file.raw || null
  fileList.value = fileListParam.slice(-1)
}

const onRemove = () => {
  form.gambar = null
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
      if (form.gambar) payload.append('foto', form.gambar)

      const response = await api.post('/kelola/berita', payload, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Berita berhasil ditambahkan',
        type: 'success',
        duration: 3000,
      })
      window.location.reload()
      emit('close')
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menambahkan berita',
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