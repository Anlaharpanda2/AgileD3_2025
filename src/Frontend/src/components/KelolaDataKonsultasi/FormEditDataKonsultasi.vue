<template>
  <!-- Template tetap sama seperti sebelumnya -->
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { ElNotification, ElForm } from 'element-plus';
import type { PropType } from 'vue';
import api from '../../api.js';

// Interface untuk tipe data konsultasi
interface KonsultasiData {
  id?: number;
  nik: string;
  nama: string;
  jenis_kelamin: string;
  kasus: string;
  alamat: string;
  umur: number;
  status: string;
  saksi: string;
}

// Deklarasi props dengan tipe yang tepat
const props = defineProps({
  initialData: Object as PropType<KonsultasiData>,
});

const emit = defineEmits(['close']);
const formRef = ref<InstanceType<typeof ElForm> | null>(null);
const statusOptions = ['active', 'inactive'];

// Fungsi capitalize dipindahkan ke bagian atas sebelum digunakan
const capitalize = (s: string): string => s.charAt(0).toUpperCase() + s.slice(1);

const fields = [
  { key: 'nama', label: 'Nama', component: 'el-input', type: 'text' },
  { key: 'nik', label: 'NIK', component: 'el-input', type: 'text' },
  { key: 'jenis_kelamin', label: 'Jenis Kelamin', component: 'el-select', type: '' },
  { key: 'kasus', label: 'Kasus', component: 'el-input', type: 'text' },
  { key: 'alamat', label: 'Alamat', component: 'el-input', type: 'textarea' },
  { key: 'umur', label: 'Umur', component: 'el-input', type: 'number' },
  { key: 'status', label: 'Status', component: 'el-select', type: '' },
  { key: 'saksi', label: 'Saksi', component: 'el-input', type: 'text' },
];

const form = reactive<KonsultasiData>({
  id: undefined,
  nik: '',
  nama: '',
  jenis_kelamin: '',
  kasus: '',
  alamat: '',
  umur: 0,
  status: '',
  saksi: '',
});

const applyInitialData = (data: KonsultasiData | undefined) => {
  if (data) {
    Object.assign(form, data);
  }
};

watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });

// Rules validation
const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  jenis_kelamin: [{ required: true, message: 'Jenis kelamin wajib diisi', trigger: 'change' }],
  kasus: [{ required: true, message: 'Kasus wajib diisi', trigger: 'blur' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  umur: [
    { required: true, message: 'Umur wajib diisi', trigger: 'change' },
    {
      validator: (rule: unknown, value: number, callback: (error?: Error) => void) => {
        if (value <= 0) {
          callback(new Error('Umur harus lebih besar dari 0'));
        } else {
          callback();
        }
      },
      trigger: 'blur',
    },
  ],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
  saksi: [{ required: true, message: 'Saksi wajib diisi', trigger: 'blur' }],
};

const submitForm = async () => {
  if (!formRef.value) return;
  
  try {
    const isValid = await formRef.value.validate();
    if (!isValid) {
      ElNotification({
        title: 'Validasi gagal',
        message: 'Periksa input form Anda.',
        type: 'warning'
      });
      return;
    }

    const response = await api.put(`/kelola/konsultasi/${form.id}`, form);
    ElNotification({
      title: 'Berhasil',
      message: response.data?.message || 'Data berhasil diupdate!',
      type: 'success',
      duration: 3000,
    });
    emit('close');
    window.location.reload();
  } catch (error: any) {
    console.error('Error submitting form:', error);
    ElNotification({
      title: 'Gagal',
      message: error.response?.data?.message || 'Gagal memperbarui data. Terjadi kesalahan jaringan atau server.',
      type: 'error',
      duration: 0,
    });
  }
};
</script>

<style scoped>
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

