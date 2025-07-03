<template>
  <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4" @click.self="$emit('close')">
    <transition name="modal" appear>
      <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full max-h-[95vh] flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700
 px-6 py-4 sm:px-8 sm:py-6 rounded-t-xl">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <!-- Icon for header (using Heroicons/Lucide-like SVG) -->
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-xl sm:text-2xl font-bold text-white">Tambah Data Fasilitas</h2>
                <p class="text-pink-100 text-xs sm:text-sm">Isi form untuk menambahkan data fasilitas baru</p>
              </div>
            </div>
            <button
              @click="$emit('close')"
              class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
              aria-label="Tutup"
            >
              <!-- Close icon -->
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Form Body -->
        <div class="flex-grow overflow-y-auto p-6 sm:p-8">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-position="top"
            class="space-y-6"
          >
            <!-- Fasilitas Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Fasilitas info icon -->
                  <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">Informasi Fasilitas</h3>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item label="Nama Fasilitas" prop="nama_fasilitas">
                  <el-input
                    v-model="form.nama_fasilitas"
                    placeholder="Masukkan nama fasilitas"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                
                <el-form-item label="Kategori" prop="kategori">
                  <el-input
                    v-model="form.kategori"
                    placeholder="Contoh: Ruangan, Peralatan"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                
                <el-form-item label="Status" prop="status">
                  <el-select
                    v-model="form.status"
                    placeholder="Pilih status"
                    size="large"
                    class="w-full modern-select"
                    clearable
                  >
                    <el-option
                      v-for="option in statusOptions"
                      :key="option"
                      :label="capitalize(option)"
                      :value="option"
                    />
                  </el-select>
                </el-form-item>
              </div>
              <el-form-item label="Deskripsi" prop="deskripsi" class="mt-4">
                <el-input
                  v-model="form.deskripsi"
                  type="textarea"
                  placeholder="Masukkan deskripsi fasilitas"
                  :rows="3"
                  class="modern-textarea"
                />
              </el-form-item>
              <el-form-item label="Jumlah" prop="jumlah">
                  <el-input
                    v-model="form.jumlah"
                    type="number"
                    placeholder="Masukkan jumlah fasilitas"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200">
              <button
                @click="$emit('close')"
                type="button"
                class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl font-medium hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-sm"
              >
                <div class="flex items-center justify-center space-x-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                  <span>Batal</span>
                </div>
              </button>
              <button
                @click="submitForm"
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl font-medium focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
              >
                <div class="flex items-center justify-center space-x-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  <span>Simpan Data</span>
                </div>
              </button>
            </div>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

/* Modern Input Styles */
/* Apply styles to Element Plus input wrapper */
:deep(.modern-input .el-input__wrapper),
:deep(.modern-select .el-input__wrapper),
:deep(.modern-date .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner) {
  border-radius: 12px; /* Rounded corners for all inputs */
  border: 1px solid #e5e7eb; /* Light gray border */
  transition: all 0.2s ease; /* Smooth transition for hover/focus */
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Subtle shadow */
  padding: 8px 12px; /* Adjust padding for a better look */
}

/* Hover state for inputs */
:deep(.modern-input .el-input__wrapper:hover),
:deep(.modern-select .el-input__wrapper:hover),
:deep(.modern-date .el-input__wrapper:hover),
:deep(.modern-textarea .el-textarea__inner:hover) {
  border-color: #f472b6; /* Softer pink on hover */
}

/* Focus state for inputs */
:deep(.modern-input.is-focus .el-input__wrapper),
:deep(.modern-select.is-focus .el-input__wrapper),
:deep(.modern-date.is-focus .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner:focus) {
  border-color: #f472b6; /* Softer pink on focus */
  box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.15); /* Softer pink ring shadow */
}

/* Remove Element Plus default form item margin to control spacing with Tailwind gap */
:deep(.el-form-item) {
  margin-bottom: 0;
}

/* Adjust label style for better spacing and appearance */
:deep(.el-form-item__label) {
  font-size: 0.875rem; /* text-sm */
  font-weight: 500; /* font-medium */
  color: #374151; /* gray-700 */
  margin-bottom: 0.5rem; /* space-y-2 equivalent */
}

/* Ensure full width for Element Plus components within the grid */
:deep(.el-input),
:deep(.el-select),
:deep(.el-date-picker),
:deep(.el-textarea) {
  width: 100%;
}
</style>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { ElNotification } from 'element-plus';
import api from '../../api.js'; // Pastikan path ini benar

const emit = defineEmits(['close']);

const formRef = ref(null);
const statusOptions = ['tersedia', 'tidak tersedia', 'dalam perbaikan'];

// Form fields definition
const fields = [
  { key: 'nama_fasilitas', label: 'Nama Fasilitas', component: 'el-input', type: 'text' },
  { key: 'deskripsi', label: 'Deskripsi', component: 'el-input', type: 'textarea' },
  { key: 'kategori', label: 'Kategori', component: 'el-input', type: 'text' },
  { key: 'jumlah', label: 'Jumlah', component: 'el-input', type: 'number' },
  { key: 'status', label: 'Status', component: 'el-select', type: '' },
];

// Reactive form state
const form = reactive({
  nama_fasilitas: '',
  deskripsi: '',
  kategori: '',
  jumlah: null,
  status: '',
});

// Form validation rules
const rules = {
  nama_fasilitas: [{ required: true, message: 'Nama fasilitas wajib diisi', trigger: 'blur' }],
  deskripsi: [{ required: true, message: 'Deskripsi wajib diisi', trigger: 'blur' }],
  kategori: [{ required: true, message: 'Kategori wajib diisi', trigger: 'blur' }],
  jumlah: [
    { required: true, message: 'Jumlah wajib diisi', trigger: 'change' },
    {
      validator: (rule: any, value: any, callback: any) => {
        const number = Number(value);
        if (value === '' || value === null || value === undefined) {
          callback(new Error('Jumlah wajib diisi'));
        } else if (isNaN(number)) {
          callback(new Error('Jumlah harus berupa angka'));
        } else if (number <= 0) {
          callback(new Error('Jumlah harus lebih besar dari 0'));
        } else {
          callback();
        }
      },
      trigger: 'blur',
    },
  ],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
};

// Helper function to capitalize strings
const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

// Form submission logic
const submitForm = () => {
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({
        title: 'Validasi gagal',
        message: 'Periksa input form Anda.',
        type: 'warning',
      });
      return;
    }

    const payload = {
      ...form,
      jumlah: Number(form.jumlah),
    };

    // Lanjutkan proses submit di sini, misalnya kirim ke API:
    try {
      await api.post('/kelola/fasilitas', payload);
      ElNotification({
        title: 'Berhasil',
        message: 'Data fasilitas berhasil ditambahkan.',
        type: 'success',
        duration: 1500,
      });
      setTimeout(() => {
          window.location.reload();
        }, 1500);
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: 'Terjadi kesalahan saat menyimpan data.',
        type: 'error',
      });
    }
  }); // <- penutup validate
}; // <- penutup submitForm

</script>
