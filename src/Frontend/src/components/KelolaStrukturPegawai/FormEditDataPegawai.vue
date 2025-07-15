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
                  Edit Data Pegawai
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Perbarui informasi pegawai
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
                  Informasi Personal Pegawai
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
                  />
                </el-form-item>
                <el-form-item
                  label="ID Pegawai"
                  prop="idPegawai"
                >
                  <el-input
                    v-model="form.idPegawai"
                    placeholder="Masukkan ID Pegawai"
                    size="large"
                    class="modern-input"
                  />
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
                  />
                </el-form-item>
                <el-form-item
                  label="Nomor HP"
                  prop="noHp"
                >
                  <el-input
                    v-model="form.noHp"
                    placeholder="Masukkan nomor HP"
                    size="large"
                    class="modern-input"
                  />
                </el-form-item>
                <el-form-item
                  label="Jabatan"
                  prop="jabatan"
                >
                  <el-input
                    v-model="form.jabatan"
                    placeholder="Masukkan jabatan"
                    size="large"
                    class="modern-input"
                  />
                </el-form-item>
                <el-form-item
                  label="Status"
                  prop="status"
                >
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
const statusOptions = ['aktif', 'nonaktif'];

const form = reactive({
  id: null,
  idPegawai: '',
  nama: '',
  alamat: '',
  email: '',
  jabatan: '',
  noHp: '',
  status: '',
});

const applyInitialData = (data: Record<string, unknown>) => {
  if (data) {
    form.id = data.id || null;
    Object.assign(form, data);
  }
};

watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });

const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  idPegawai: [{ required: true, message: 'ID Pegawai wajib diisi', trigger: 'blur' }],
  email: [
    { required: true, message: 'Email wajib diisi', trigger: 'blur' },
    { type: 'email', message: 'Format email tidak valid', trigger: ['blur', 'change'] },
  ],
  jabatan: [{ required: true, message: 'Jabatan wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
};

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

const submitForm = () => {
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }

    try {
      const response = await api.put(`/kelola/struktur-pegawai/${form.id}`, form);
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
:deep(.modern-input .el-input__wrapper),
:deep(.modern-select .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner) {
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  padding: 8px 12px;
}

:deep(.modern-input .el-input__wrapper:hover),
:deep(.modern-select .el-input__wrapper:hover),
:deep(.modern-textarea .el-textarea__inner:hover) {
  border-color: #60a5fa; /* pink-400 */
}

:deep(.modern-input.is-focus .el-input__wrapper),
:deep(.modern-select.is-focus .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner:focus) {
  border-color: #3b82f6; /* pink-500 */
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

:deep(.el-form-item) {
  margin-bottom: 0;
}

:deep(.el-form-item__label) {
  font-size: 0.875rem;
  font-weight: 500;
  color: #374151;
  margin-bottom: 0.5rem;
}

:deep(.el-input),
:deep(.el-select),
:deep(.el-textarea) {
  width: 100%;
}
</style>
