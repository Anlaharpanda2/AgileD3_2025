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
                <!-- Icon for header (using Heroicons/Lucide-like SVG) -->
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
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
              <div>
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                  Tambah Data Konsultasi
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Isi form untuk menambahkan data konsultasi baru
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
            <!-- Personal Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Personal info icon -->
                  <svg
                    class="w-5 h-5 text-pink-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                  Informasi Personal
                </h3>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item
                  label="Nama Lengkap"
                  prop="nama"
                >
                  <el-input
                    v-model="form.nama"
                    placeholder="Masukkan nama lengkap"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="NIK"
                  prop="nik"
                >
                  <el-input
                    v-model="form.nik"
                    placeholder="Masukkan NIK"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Jenis Kelamin"
                  prop="jenis_kelamin"
                >
                  <el-select
                    v-model="form.jenis_kelamin"
                    placeholder="Pilih jenis kelamin"
                    size="large"
                    class="w-full modern-select"
                    clearable
                  >
                    <el-option
                      v-for="option in jenisKelaminOptions"
                      :key="option"
                      :label="capitalize(option)"
                      :value="option"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item
                  label="Nomor Telepon"
                  prop="no_telepon"
                >
                  <el-input
                    v-model="form.no_telepon"
                    placeholder="Contoh: 081234567890"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
              </div>
              <el-form-item
                label="Alamat"
                prop="alamat"
                class="mt-4"
              >
                <el-input
                  v-model="form.alamat"
                  type="textarea"
                  placeholder="Masukkan alamat lengkap"
                  :rows="3"
                  class="modern-textarea"
                />
              </el-form-item>
            </div>

            <!-- Training Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Training info icon -->
                  <svg
                    class="w-5 h-5 text-pink-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                  </svg>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                  Informasi Konsultasi
                </h3>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item
                  label="Topik"
                  prop="topik"
                >
                  <el-input
                    v-model="form.topik"
                    placeholder="Masukkan topik konsultasi"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Tanggal Konsultasi"
                  prop="tanggal_konsultasi"
                >
                  <el-date-picker
                    v-model="form.tanggal_konsultasi"
                    type="date"
                    placeholder="Pilih tanggal konsultasi"
                    size="large"
                    class="w-full modern-date"
                    format="DD/MM/YYYY"
                    value-format="YYYY-MM-DD"
                  />
                </el-form-item>
                <el-form-item
                  label="Status"
                  prop="status"
                  class="md:col-span-2"
                >
                  <el-input
                    v-model="form.status"
                    placeholder="Masukkan status konsultasi"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                      </svg>
                    </template>
                  </el-input>
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

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { ElNotification, FormInstance } from 'element-plus';
import api from '../../api.js'; // Pastikan path ini benar

// Removed props as FormTambahDataKonsultasi does not use initialData
const emit = defineEmits(['close']);

const formRef = ref<FormInstance | null>(null);
const jenisKelaminOptions = ['laki-laki', 'perempuan'];

// Form fields definition (copied from FormTambahDataKonsultasi.vue)


// Reactive form state (copied from FormTambahDataKonsultasi.vue)
const form = reactive({
  nik: '',
  nama: '',
  jenis_kelamin: '',
  tanggal_konsultasi: null,
  topik: '',
  status: '',
  alamat: '',
  no_telepon: '',
});

// Removed applyInitialData and watch as they are not relevant for a "tambah" form

// Form validation rules (copied from FormTambahDataKonsultasi.vue)
const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  jenis_kelamin: [{ required: true, message: 'Jenis kelamin wajib diisi', trigger: 'change' }],
  tanggal_konsultasi: [{ type: 'date', required: true, message: 'Tanggal konsultasi wajib diisi', trigger: 'change' }],
  topik: [{ required: true, message: 'Topik wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'blur' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  no_telepon: [{ required: true, message: 'Nomor telepon wajib diisi', trigger: 'blur' }],
};

// Helper function to capitalize strings (copied from FormTambahDataKonsultasi.vue)
const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

// Form submission logic (copied from FormTambahDataKonsultasi.vue)
const submitForm = () => {
  if (!formRef.value) return;
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }
    const payload = {
      ...form,
      tanggal_konsultasi: form.tanggal_konsultasi ? `${(form.tanggal_konsultasi as Date).getFullYear()}-${String((form.tanggal_konsultasi as Date).getMonth() + 1).padStart(2, '0')}-${String((form.tanggal_konsultasi as Date).getDate()).padStart(2, '0')}` : null,
    };
    try {
      console.log('Kirim JSON:', JSON.stringify(payload));
      const response = await api.post('/kelola/konsultasi', payload); // This is the POST request for adding data
        ElNotification({
          title: 'Berhasil',
          message: response.data.message || 'Data berhasil disimpan!',
          type: 'success',
          duration: 3000,
        });
        emit('close');
        window.location.reload();
     
    } catch (error) {
      console.error('Error submitting form:', error);
      let errorMessage = 'Gagal menyimpan data. Terjadi kesalahan jaringan atau server.';
      if (error instanceof Error) {
        if ('response' in error && error.response && typeof error.response === 'object' && 'data' in error.response && error.response.data && typeof error.response.data === 'object' && 'message' in error.response.data) {
          errorMessage = error.response.data.message as string;
        } else {
          errorMessage = error.message;
        }
      }
      ElNotification({
        title: 'Gagal',
        message: errorMessage,
        type: 'error',
        duration: 0,
      });
    }
  });
};
</script>

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
