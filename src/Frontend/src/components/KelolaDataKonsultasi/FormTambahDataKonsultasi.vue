<template>
  <div class="form-overlay" @click.self="$emit('close')">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Tambah Data Konsultasi</h3>
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
                    v-else-if="field.key === 'status'"
                    v-model="form.status"
                    placeholder="Pilih Status"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="w-100 form-control-select"
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
/* Latar belakang gelap untuk overlay */
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

/* Kontainer popup form */
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
}

/* Header form */
.form-header {
  background: linear-gradient(45deg, #69C5C2, #4CAF50);
  color: white;
  padding: 1.5rem;
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
  font-weight: 600;
  letter-spacing: 0.5px;
}

/* Bagian isi form scrollable */
.form-body {
  overflow-y: auto;
  padding: 2rem;
}

/* Styling untuk el-input dan el-date-picker */
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

/* Styling khusus untuk el-select */
.form-control-select .el-input__wrapper {
  border-radius: 0.5rem !important;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
  transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
}
.form-control-select.is-focus .el-input__wrapper {
  border-color: #69C5C2 !important;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}

/* Tombol Submit */
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

/* Tombol Batal */
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

/* Animasi masuk */
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

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { ElNotification, ElForm } from 'element-plus';
import api from '../../api.js'; 

const props = defineProps({
  initialData: Object, 
});

const emit = defineEmits(['close']);
const formRef = ref<InstanceType<typeof ElForm> | null>(null);
const statusOptions = ['pending', 'selesai', 'ditolak'];

const fields = [
  { key: 'nama', label: 'Nama', component: 'el-input', type: 'text' },
  { key: 'nama_korban', label: 'Nama Korban', component: 'el-input', type: 'text' },
  { key: 'nik', label: 'NIK', component: 'el-input', type: 'text' },
  { key: 'jenis_kelamin', label: 'Jenis Kelamin', component: 'el-select', type: '' },
  { key: 'kasus', label: 'Kasus', component: 'el-input', type: 'text' },
  { key: 'alamat', label: 'Alamat', component: 'el-input', type: 'textarea' },
  { key: 'no_hp', label: 'No. HP', component: 'el-input', type: 'tel' },
  { key: 'saksi', label: 'Saksi', component: 'el-input', type: 'text' },
  { key: 'status', label: 'Status', component: 'el-select', type: '' },
  { key: 'umur', label: 'Umur', component: 'el-input', type: 'number' },
  { key: 'deskripsi_data_konsultasi', label: 'Deskripsi', component: 'el-input', type: 'textarea' },
];

const form = reactive({
  nama: '',
  nama_korban: '',
  nik: '',
  jenis_kelamin: '',
  kasus: '',
  alamat: '',
  no_hp: '',
  saksi: '',
  status: '',
  umur: null,
  deskripsi_data_konsultasi: ''
});

const applyInitialData = (data: any) => {
  if (data) {
    Object.assign(form, data);
  }
};

watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });

const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nama_korban: [{ required: true, message: 'Nama korban wajib diisi', trigger: 'blur' }],
  nik: [
    { required: true, message: 'NIK wajib diisi', trigger: 'blur' },
    { min: 16, max: 16, message: 'NIK harus 16 digit', trigger: 'blur' }
  ],
  jenis_kelamin: [{ required: true, message: 'Jenis kelamin wajib diisi', trigger: 'change' }],
  kasus: [{ required: true, message: 'Kasus wajib diisi', trigger: 'blur' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  no_hp: [
    { required: true, message: 'No. HP wajib diisi', trigger: 'blur' },
    { pattern: /^[0-9]+$/, message: 'Hanya angka yang diperbolehkan', trigger: 'blur' }
  ],
  saksi: [{ required: false, message: 'Saksi wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
  umur: [
    { required: true, message: 'Umur wajib diisi', trigger: 'blur' },
    { type: 'number', min: 1, message: 'Umur harus lebih dari 0', trigger: 'blur' }
  ],
  deskripsi_data_konsultasi: [{ required: true, message: 'Deskripsi wajib diisi', trigger: 'blur' }]
};

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

const submitForm = () => {
  if (!formRef.value) return;
  
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ 
        title: 'Validasi gagal', 
        message: 'Periksa input form Anda.', 
        type: 'warning' 
      });
      return;
    }
    
    try {
      const response = await api.post('/kelola/konsultasi', form);
      ElNotification({
        title: 'Berhasil',
        message: response.data?.message || 'Data konsultasi berhasil ditambahkan!',
        type: 'success',
        duration: 3000,
      });
      emit('close');
      window.location.reload();
    } catch (error: any) {
      console.error('Error submitting form:', error);
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menambahkan data. Terjadi kesalahan jaringan atau server.',
        type: 'error',
        duration: 0,
      });
    }
  });
};
</script>