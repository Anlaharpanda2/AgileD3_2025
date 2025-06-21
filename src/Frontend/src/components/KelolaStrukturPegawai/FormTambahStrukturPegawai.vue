<template>
  <div class="form-overlay" @click.self="$emit('close')">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Tambah Struktur Pegawai</h3>
        </div>
        <div class="form-body">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
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
                >
                  <component
                    :is="field.component"
                    v-model="form[field.key]"
                    :type="field.type"
                    :placeholder="field.label"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="form-control"
                    v-if="field.component !== 'el-select'"
                  />
                  <el-select
                    v-else-if="field.key === 'jabatan'"
                    v-model="form.jabatan"
                    placeholder="Pilih Jabatan"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="w-100 form-control-select"
                  >
                    <el-option
                      v-for="option in jabatanOptions"
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

<script setup>
import { reactive, ref } from 'vue'
import { ElNotification } from 'element-plus'
import api from '@/api'

const emit = defineEmits(['close'])
const formRef = ref(null)

// Opsi jabatan untuk dropdown
const jabatanOptions = ['ketua', 'wakil', 'sekretaris', 'bendahara']

// Field dan konfigurasi
const fields = [
  { key: 'nama', label: 'Nama Lengkap', component: 'el-input', type: 'text' },
  { key: 'nip', label: 'NIP', component: 'el-input', type: 'text' },
  { key: 'jabatan', label: 'Jabatan', component: 'el-select', type: '' },
  { key: 'unit_kerja', label: 'Unit Kerja', component: 'el-input', type: 'text' },
  { key: 'email', label: 'Email', component: 'el-input', type: 'email' },
  { key: 'no_hp', label: 'Nomor HP', component: 'el-input', type: 'tel' },
]

// Model form
const form = reactive({
  nama: '',
  nip: '',
  jabatan: '',
  unit_kerja: '',
  email: '',
  no_hp: '',
})

// Validasi
const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nip: [{ required: true, message: 'NIP wajib diisi', trigger: 'blur' }],
  jabatan: [{ required: true, message: 'Jabatan wajib dipilih', trigger: 'change' }],
  unit_kerja: [{ required: true, message: 'Unit Kerja wajib diisi', trigger: 'blur' }],
  email: [{ required: true, message: 'Email wajib diisi', trigger: 'blur' }],
  no_hp: [{ required: true, message: 'Nomor HP wajib diisi', trigger: 'blur' }],
}

// Kapitalisasi teks
const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1)

// Submit form ke backend
const submitForm = () => {
  formRef.value.validate(async (valid) => {
    if (!valid) {
      ElNotification({
        title: 'Validasi Gagal',
        message: 'Mohon periksa kembali isian Anda.',
        type: 'warning',
      })
      return
    }

    try {
      const response = await api.post('/kelola/struktur-pegawai', { ...form })
      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Data pegawai berhasil ditambahkan!',
        type: 'success',
        duration: 3000,
      })
      emit('close')
      window.location.reload()
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menyimpan data.',
        type: 'error',
        duration: 0,
      })
      console.error('Submit error:', error)
    }
  })
}
</script>

<style scoped>
/* Gunakan semua style overlay dan form sama seperti template sebelumnya */
.form-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}
.form-popup {
  width: 100%;
  max-width: 900px;
  max-height: 95vh;
  background: linear-gradient(145deg, #ffffff, #f0f2f5);
  border-radius: 1.25rem;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.5) inset;
  display: flex;
  flex-direction: column;
  animation: popupIn 0.4s ease-out;
  overflow: hidden;
  transform: scale(1);
  transition: transform 0.3s ease-out;
}
.form-header {
  background: linear-gradient(45deg, #69C5C2, #4CAF50);
  color: white;
  padding: 1.5rem;
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
  font-weight: 600;
  letter-spacing: 0.5px;
}
.form-body {
  overflow-y: auto;
  padding: 2rem;
}
.form-control {
  width: 100%;
  border-radius: 0.5rem;
  border: 1px solid #e0e0e0;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}
.form-control:focus-within {
  border-color: #69C5C2;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.05);
}
.form-control-select .el-input__wrapper {
  border-radius: 0.5rem !important;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
  transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
}
.form-control-select.is-focus .el-input__wrapper {
  border-color: #69C5C2 !important;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}
.btn-submit {
  background: linear-gradient(45deg, #69C5C2, #4CAF50);
  border: none;
  color: white;
  padding: 0.75rem 2rem;
  border-radius: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3);
  transition: all 0.3s ease;
}
.btn-submit:hover {
  background: linear-gradient(45deg, #4CAF50, #69C5C2);
  box-shadow: 0 6px 15px rgba(76, 175, 80, 0.45);
  transform: translateY(-2px);
}
.btn-submit:active {
  transform: translateY(0);
  box-shadow: 0 2px 5px rgba(76, 175, 80, 0.2);
}
.btn-cancel {
  background-color: #f0f2f5;
  color: #555;
  padding: 0.75rem 2rem;
  border-radius: 0.75rem;
  font-weight: 500;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.btn-cancel:hover {
  background-color: #e0e0e0;
  color: #333;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}
.btn-cancel:active {
  transform: translateY(0);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}
@keyframes popupIn {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
</style>
