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
                  Tambah Data Pengaduan
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Isi form untuk menambahkan data pengaduan baru
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
            <!-- Pengaduan Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Pengaduan info icon -->
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
                  Informasi Pengaduan
                </h3>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item
                  label="Nama Pelapor"
                  prop="nama_pelapor"
                >
                  <el-input
                    v-model="form.nama_pelapor"
                    placeholder="Masukkan nama pelapor"
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
                  label="Nama Korban"
                  prop="nama_korban"
                >
                  <el-input
                    v-model="form.nama_korban"
                    placeholder="Masukkan nama korban"
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
                  label="Waktu Kejadian"
                  prop="waktu_kejadian"
                >
                  <el-date-picker
                    v-model="form.waktu_kejadian"
                    type="datetime"
                    placeholder="Pilih tanggal dan waktu kejadian"
                    size="large"
                    class="w-full modern-date"
                    format="DD/MM/YYYY HH:mm"
                    value-format="YYYY-MM-DD HH:mm:ss"
                  />
                </el-form-item>
                <el-form-item
                  label="Kasus"
                  prop="kasus"
                >
                  <el-input
                    v-model="form.kasus"
                    placeholder="Contoh: Kekerasan, Penipuan"
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
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Nomor HP"
                  prop="no_hp"
                >
                  <el-input
                    v-model="form.no_hp"
                    placeholder="Masukkan nomor HP"
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
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.135a11.042 11.042 0 005.516 5.516l1.135-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Saksi (Opsional)"
                  prop="saksi"
                >
                  <el-input
                    v-model="form.saksi"
                    placeholder="Masukkan nama saksi jika ada"
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
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Status"
                  prop="status"
                >
                  <el-select
                    v-model="form.status"
                    placeholder="Pilih status pengaduan"
                    size="large"
                    class="w-full modern-select"
                    clearable
                  >
                    <el-option
                      label="Diproses"
                      value="diproses"
                    />
                    <el-option
                      label="Selesai"
                      value="selesai"
                    />
                  </el-select>
                </el-form-item>
                <el-form-item
                  label="Lampiran (Opsional)"
                  prop="lampiran"
                >
                  <input
                    type="file"
                    accept="image/*"
                    class="modern-input"
                    @change="handleFileUpload"
                  >
                  <div
                    v-if="form.lampiran_preview_url"
                    class="mt-2"
                  >
                    <p class="text-sm text-gray-500">
                      Pratinjau Lampiran:
                    </p>
                    <img
                      :src="form.lampiran_preview_url"
                      alt="Pratinjau Lampiran"
                      class="w-24 h-24 object-cover rounded-lg"
                    >
                  </div>
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
              <el-form-item
                label="Deskripsi"
                prop="deskripsi"
                class="mt-4"
              >
                <el-input
                  v-model="form.deskripsi"
                  type="textarea"
                  placeholder="Masukkan deskripsi pengaduan"
                  :rows="3"
                  class="modern-textarea"
                />
              </el-form-item>
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
import api from '../../api.js';
import { AxiosError } from 'axios';

const emit = defineEmits(['close']);

const formRef = ref<FormInstance | null>(null);

// Reactive form state
const form = reactive<{
  nama_pelapor: string;
  nama_korban: string;
  deskripsi: string;
  alamat: string;
  waktu_kejadian: Date | null;
  kasus: string;
  no_hp: string;
  saksi: string;
  status: string;
  lampiran: File | null; // Untuk menyimpan file lampiran
  lampiran_preview_url: string | null; // Untuk menampilkan preview lampiran yang baru dipilih
}>({
  nama_pelapor: '',
  nama_korban: '',
  deskripsi: '',
  alamat: '',
  waktu_kejadian: null,
  kasus: '',
  no_hp: '',
  saksi: '',
  status: '',
  lampiran: null,
  lampiran_preview_url: null,
});

// Form validation rules
const rules = {
  nama_pelapor: [{ required: true, message: 'Nama pelapor wajib diisi', trigger: 'blur' }],
  nama_korban: [{ required: true, message: 'Nama korban wajib diisi', trigger: 'blur' }],
  deskripsi: [{ required: true, message: 'Deskripsi wajib diisi', trigger: 'blur' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  waktu_kejadian: [{ type: 'date', required: true, message: 'Waktu kejadian wajib diisi', trigger: 'change' }],
  kasus: [{ required: true, message: 'Kasus wajib diisi', trigger: 'blur' }],
  no_hp: [{ required: true, message: 'Nomor HP wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
};

// Handle file upload
const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    form.lampiran = target.files[0];
    form.lampiran_preview_url = URL.createObjectURL(target.files[0]); // Tampilkan preview lampiran baru
  }
};



// Form submission logic
const submitForm = () => {
  if (!formRef.value) return;
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }

    const formData = new FormData();
    for (const key in form) {
      if (key === 'lampiran' && (form as Record<string, string | Date | File | null>)[key]) {
        formData.append(key, (form as Record<string, string | Date | File | null>)[key] as File);
      } else if (key !== 'lampiran' && key !== 'lampiran_preview_url' && (form as Record<string, string | Date | File | null>)[key] !== null) {
        if (key === 'waktu_kejadian' && (form as Record<string, string | Date | File | null>)[key] instanceof Date) {
          formData.append(key, ((form as Record<string, string | Date | File | null>)[key] as Date).toISOString().slice(0, 19).replace('T', ' ')); // Format ke YYYY-MM-DD HH:mm:ss
        } else {
          formData.append(key, (form as Record<string, string | Date | File | null>)[key] as string);
        }
      }
    }

    try {
      const response = await api.post('/kelola/pengaduan', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Data berhasil disimpan!',
        type: 'success',
        duration: 3000,
      });
      emit('close');
      window.location.reload();
    } catch (error: unknown) {
      console.error('Error submitting form:', error);
      let errorMessage = 'Gagal menyimpan data. Terjadi kesalahan jaringan atau server.';
      if (error instanceof AxiosError && error.response && error.response.data && error.response.data.message) {
        errorMessage = error.response.data.message;
      } else if (error instanceof Error) {
        errorMessage = error.message;
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
