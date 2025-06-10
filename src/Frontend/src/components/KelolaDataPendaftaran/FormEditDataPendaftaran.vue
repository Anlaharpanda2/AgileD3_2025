<template>
  <div class="form-overlay">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Data Pendaftaran</h3>
        </div>

        <div class="form-body">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-width="140px"
            label-position="top"
            class="p-4"
          >
            <el-row :gutter="20">
              <el-col
                v-for="field in fields"
                :key="field.key"
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item
                  :label="field.label"
                  :prop="field.key"
                  required
                >
                  <component
                    v-if="field.key !== 'status'"
                    :is="field.component"
                    v-model="form[field.key]"
                    :type="field.type"
                    :placeholder="field.label"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="form-control"
                  />
                  <el-select
                    v-else
                    v-model="form.status"
                    placeholder="Pilih Status"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="w-100"
                  >
                    <el-option
                      v-for="option in statusOptions"
                      :key="option"
                      :label="capitalize(option)"
                      :value="option"
                    />
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>

            <el-form-item class="d-flex justify-content-end gap-3 mt-4">
              <el-button @click="$emit('close')" class="btn-cancel">Batal</el-button>
              <el-button type="primary" @click="submitForm" class="btn-submit">Simpan</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
/* Latar belakang gelap */
.background{
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

/* Kontainer popup form */
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
/* Bagian isi form scrollable */
.form-body {
  overflow-y: auto;
  padding: 1rem;
}

/* Tombol dengan warna hijau */
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

/* Animasi masuk */
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

<script setup>
import { reactive, ref, watch } from 'vue'
import api from '@/api.js';
import { ElNotification } from 'element-plus'

const props = defineProps({
  initialData: Object,
})

const emit = defineEmits(['close'])

const formRef = ref(null)

const statusOptions = ['kawin', 'lajang', 'janda']

const fields = [
  { key: 'nama', label: 'Nama', component: 'el-input', type: 'text' },
  { key: 'nik', label: 'NIK', component: 'el-input', type: 'text' },
  { key: 'jenis_bimtek', label: 'Jenis Bimtek', component: 'el-input', type: 'text' },
  { key: 'tanggal_kegiatan', label: 'Tanggal Kegiatan', component: 'el-date-picker', type: 'date' },
  { key: 'tempat_kegiatan', label: 'Tempat Kegiatan', component: 'el-input', type: 'text' },
  { key: 'angkatan', label: 'Angkatan', component: 'el-input', type: 'text' },
  { key: 'tempat_tanggal_lahir', label: 'Tempat Tanggal Lahir', component: 'el-input', type: 'text' },
  { key: 'pendidikan', label: 'Pendidikan', component: 'el-input', type: 'text' },
  { key: 'status', label: 'Status', component: 'el-select', type: '' },
  { key: 'alamat', label: 'Alamat', component: 'el-input', type: 'text' },
  { key: 'jenis_usaha', label: 'Jenis Usaha', component: 'el-input', type: 'text' },
  { key: 'penghasilan_perbulan', label: 'Penghasilan Perbulan', component: 'el-input', type: 'text' },
  { key: 'nomor_telefon', label: 'Nomor Telefon', component: 'el-input', type: 'tel' },
]

// Reactive form dengan default fallback
const form = reactive({
  nik: '',
  nama: '',
  jenis_bimtek: '',
  tanggal_kegiatan: null,
  tempat_kegiatan: '',
  angkatan: null,
  tempat_tanggal_lahir: '',
  pendidikan: '',
  status: '',
  alamat: '',
  jenis_usaha: '',
  penghasilan_perbulan: '',
  nomor_telefon: '',
  ...props.initialData,
})

// Jika tanggal_kegiatan berupa string, ubah ke Date (untuk el-date-picker)
if (form.tanggal_kegiatan && typeof form.tanggal_kegiatan === 'string') {
  form.tanggal_kegiatan = new Date(form.tanggal_kegiatan)
}

watch(() => props.initialData, (newVal) => {
  Object.assign(form, newVal)
  if (form.tanggal_kegiatan && typeof form.tanggal_kegiatan === 'string') {
    form.tanggal_kegiatan = new Date(form.tanggal_kegiatan)
  }
})

const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  jenis_bimtek: [{ required: true, message: 'Jenis bimtek wajib diisi', trigger: 'blur' }],
  tanggal_kegiatan: [{ type: 'date', required: true, message: 'Tanggal wajib diisi', trigger: 'change' }],
  tempat_kegiatan: [{ required: true, message: 'Tempat wajib diisi', trigger: 'blur' }],
  angkatan: [{ required: true, type: 'messege', message: 'Angkatan wajib diisi', trigger: 'blur' }],
  tempat_tanggal_lahir: [{ required: true, message: 'Tempat tanggal lahir wajib diisi', trigger: 'blur' }],
  pendidikan: [{ required: true, message: 'Pendidikan wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  jenis_usaha: [{ required: true, message: 'Jenis usaha wajib diisi', trigger: 'blur' }],
  penghasilan_perbulan: [{ required: true, message: 'Penghasilan wajib diisi', trigger: 'blur' }],
  nomor_telefon: [{ required: true, message: 'Nomor telepon wajib diisi', trigger: 'blur' }],
}

const capitalize = s => s.charAt(0).toUpperCase() + s.slice(1)

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
      // Format tanggal menjadi string 'YYYY-MM-DD' saat submit
      const payload = {
        ...form,
        tanggal_kegiatan:
          form.tanggal_kegiatan instanceof Date
            ? form.tanggal_kegiatan.toISOString().split('T')[0]
            : form.tanggal_kegiatan,
        angkatan: Number(form.angkatan),
      }

      const response = await api.put(`/kelola/Pendaftaran/${form.nik}`, payload)

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
