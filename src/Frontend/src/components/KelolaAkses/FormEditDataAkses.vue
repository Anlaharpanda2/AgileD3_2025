<template>
  <div
    class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click.self="$emit('close')"
  >
    <transition
      name="modal"
      appear
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-xl w-full max-h-[95vh] flex flex-col overflow-hidden">
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
                  Edit Data Akses
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Perbarui informasi akses pengguna
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
            <!-- User Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- User info icon -->
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
                  Informasi Pengguna
                </h3>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <el-form-item
                  label="Nama Lengkap"
                  prop="name"
                >
                  <el-input
                    v-model="form.name"
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
                  label="Email"
                  prop="email"
                >
                  <el-input
                    v-model="form.email"
                    placeholder="Masukkan email"
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
                          d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m-4.5-1.5a2.5 2.5 0 01-5 0V12a9 9 0 109 9h-4.5z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Role"
                  prop="role"
                >
                  <el-select
                    v-model="form.role"
                    placeholder="Pilih role"
                    size="large"
                    class="w-full modern-select"
                    clearable
                  >
                    <el-option
                      v-for="option in roleOptions"
                      :key="option"
                      :label="capitalize(option)"
                      :value="option"
                    />
                  </el-select>
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
                class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700
 text-white rounded-xl font-medium focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
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

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { ElNotification, FormInstance } from 'element-plus';
import api from '../../api.js';
import { AxiosError } from 'axios';

const props = defineProps({
  initialData: {
    type: Object,
    required: true
  },
});

const emit = defineEmits(['close']);

const formRef = ref<FormInstance | null>(null);
const roleOptions = ['operator', 'pegawai', 'masyarakat'];

const form = reactive<{
  id: number | null;
  name: string;
  email: string;
  role: string;
}>({
  id: null,
  name: '',
  email: '',
  role: '',
});

const applyInitialData = (data: Record<string, unknown>) => {
  if (data) {
    form.id = data.id as number;
    form.name = data.name as string;
    form.email = data.email as string;
    form.role = data.role as string;
  }
};

watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });

const rules = {
  name: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  email: [
    { required: true, message: 'Email wajib diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: ['blur', 'change'] },
  ],
  role: [{ required: true, message: 'Role wajib diisi', trigger: 'change' }],
};

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

const submitForm = () => {
  if (!formRef.value) return;
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }

    const payload = {
      name: form.name,
      email: form.email,
      role: form.role,
    };

    try {
      console.log('Kirim JSON untuk update:', JSON.stringify(payload));
      const response = await api.put(`/kelola/akses/${form.id}`, payload);
        ElNotification({
          title: 'Berhasil',
          message: response.data.message || 'Data berhasil diupdate!',
          type: 'success',
          duration: 3000,
        });
        emit('close');
        window.location.reload();
    } catch (error) {
      if (error instanceof AxiosError) {
        console.error('Error submitting form:', error);
        ElNotification({
          title: 'Gagal',
          message: error.response?.data?.message || 'Gagal memperbarui data. Terjadi kesalahan jaringan atau server.',
          type: 'error',
          duration: 0,
        });
      } else {
        console.error('An unexpected error occurred:', error);
        ElNotification({
          title: 'Gagal',
          message: 'Terjadi kesalahan yang tidak terduga.',
          type: 'error',
          duration: 0,
        });
      }
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
