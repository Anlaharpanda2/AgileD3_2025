<template>
  <div
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
    @click.self="$emit('close')"
  >
    <transition
      name="popup"
      appear
    >
      <div class="w-full max-w-4xl max-h-[95vh] bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                <svg
                  class="w-5 h-5 text-white"
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
              </div>
              <div>
                <h3 class="text-xl font-semibold text-white">
                  Form Terima Data Pendaftar
                </h3>
                <p class="text-pink-100 text-sm">
                  Lengkapi informasi kegiatan dan validasi data
                </p>
              </div>
            </div>
            <button 
              class="w-8 h-8 bg-white/20 hover:bg-white/30 rounded-full flex items-center justify-center transition-all duration-200"
              @click="$emit('close')"
            >
              <svg
                class="w-4 h-4 text-white"
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

        <!-- Body -->
        <div class="overflow-y-auto max-h-[calc(95vh-120px)]">
          <div class="p-6">
            <el-form
              ref="formRef"
              :model="form"
              :rules="rules"
              label-width="140px"
              label-position="top"
              class="space-y-6"
            >
              <!-- Form Fields Grid -->
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div
                  v-for="field in fields"
                  :key="field.key"
                  class="space-y-2"
                >
                  <el-form-item
                    :label="field.label"
                    :prop="field.key"
                    class="form-item-modern"
                  >
                    <template #label>
                      <label class="text-sm font-medium text-gray-700 mb-2 block">
                        {{ field.label }}
                        <span class="text-pink-500 ml-1">*</span>
                      </label>
                    </template>
                    
                    <!-- Input Components with External Icons -->
                    <div class="flex items-center space-x-3">
                      <!-- Field Icons - External -->
                      <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg
                          v-if="field.component === ElDatePicker"
                          class="w-5 h-5 text-pink-500"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                          />
                        </svg>
                        <svg
                          v-else-if="field.key === 'tempat_kegiatan'"
                          class="w-5 h-5 text-pink-500"
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
                        <svg
                          v-else-if="field.key === 'angkatan'"
                          class="w-5 h-5 text-pink-500"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"
                          />
                        </svg>
                      </div>
                      
                      <!-- Input Field -->
                      <div class="flex-1">
                        <el-date-picker
                          v-if="field.component === ElDatePicker"
                          :id="field.key"
                          v-model="form[field.key]"
                          :type="field.type"
                          :placeholder="`Masukkan ${field.label.toLowerCase()}`"
                          :name="field.key"
                          clearable
                          class="w-full modern-input"
                        />
                        <el-input
                          v-else-if="field.component === ElInput"
                          :id="field.key"
                          v-model="form[field.key]"
                          :type="field.type"
                          :placeholder="`Masukkan ${field.label.toLowerCase()}`"
                          :name="field.key"
                          clearable
                          class="w-full modern-input"
                        />
                        <el-select
                          v-else-if="field.component === ElSelect"
                          :id="field.key"
                          v-model="form[field.key]"
                          :placeholder="`Pilih ${field.label.toLowerCase()}`"
                          :name="field.key"
                          clearable
                          class="w-full modern-select"
                        >
                          <el-option
                            v-for="option in statusOptions"
                            :key="option"
                            :label="capitalize(option)"
                            :value="option"
                          />
                        </el-select>
                      </div>
                    </div>
                  </el-form-item>
                </div>
              </div>

              <!-- Info Card -->
              <div class="bg-gradient-to-r from-pink-50 to-gray-50 border border-pink-100 rounded-xl p-4 mt-6">
                <div class="flex items-start space-x-3">
                  <div class="w-8 h-8 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg
                      class="w-4 h-4 text-pink-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-sm font-medium text-gray-800 mb-1">
                      Informasi Penting
                    </h4>
                    <p class="text-xs text-gray-600 leading-relaxed">
                      Pastikan semua data yang dimasukkan sudah benar. Tanggal berakhir kegiatan harus setelah tanggal mulai kegiatan.
                    </p>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-100">
                <el-button 
                  class="modern-btn-cancel order-2 sm:order-1" 
                  size="large"
                  @click="$emit('close')"
                >
                  <svg
                    class="w-4 h-4 mr-2"
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
                  Batal
                </el-button>
                <el-button 
                  type="primary" 
                  class="modern-btn-submit order-1 sm:order-2" 
                  size="large"
                  @click="submitForm"
                >
                  <svg
                    class="w-4 h-4 mr-2"
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
                  Simpan Perubahan
                </el-button>
              </div>
            </el-form>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { ElNotification, FormInstance, ElInput, ElDatePicker, ElSelect } from 'element-plus';
import api from '../../api.js';
import { AxiosError } from 'axios'; 

const props = defineProps({
  initialData: {
    type: Object,
    required: true
  },
})

const emit = defineEmits(['close']); 

const formRef = ref<FormInstance | null>(null); 
const statusOptions = ['kawin', 'lajang', 'janda']; 

const fields = [
  { key: 'kegiatan_dimulai', label: 'Kegiatan Dimulai', component: ElDatePicker, type: 'date' },
  { key: 'kegiatan_berakhir', label: 'Kegiatan Berakhir', component: ElDatePicker, type: 'date' },
  { key: 'tempat_kegiatan', label: 'Tempat Kegiatan', component: ElInput, type: 'text' },
  { key: 'angkatan', label: 'Angkatan', component: ElInput, type: 'number' },
];

const form = reactive({
  id: null,
  kegiatan_dimulai: null,
  kegiatan_berakhir: null,
  tempat_kegiatan: '',
  angkatan: null,
});

const applyInitialData = (data: Record<string, unknown>) => {
  if (data) {
    form.id = data.id || null;
    fields.forEach(field => {
      if (field.key in data) {
        if (field.component === 'el-date-picker' && typeof data[field.key] === 'string') {
          form[field.key] = new Date(data[field.key]);
        } else if (field.type === 'number' && typeof data[field.key] === 'string') {
          form[field.key] = Number(data[field.key]);
        } else {
          form[field.key] = data[field.key];
        }
      }
    });
  }
};

watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });

const rules = {
  kegiatan_dimulai: [
    {
      type: 'date',
      required: true,
      message: 'Tanggal Mulai Kegiatan wajib diisi',
      trigger: 'change',
    }
  ],
  kegiatan_berakhir: [
    {
      type: 'date',
      required: true,
      message: 'Tanggal Berakhir Kegiatan wajib diisi',
      trigger: 'change',
    },
    {
       
       
       
       
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      validator: (rule: any, value: any, callback: (error?: Error) => void) => {
        if (!value || !(value instanceof Date)) {
          callback();
          return;
        }
        if (form.kegiatan_dimulai && value < form.kegiatan_dimulai) {
          callback(new Error('Tanggal Berakhir harus setelah Tanggal Mulai'));
        } else {
          callback();
        }
      },
      trigger: 'change',
    }
  ],
  tempat_kegiatan: [
    {
      required: true,
      message: 'Tempat kegiatan wajib diisi',
      trigger: 'blur',
    }
  ],
  angkatan: [
    {
      required: true,
      message: 'Angkatan wajib diisi',
      trigger: 'blur',
    },
    {
       
       
       
       
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      validator: (rule: any, value: any, callback: (error?: Error) => void) => {
        const number = Number(value);
        if (value === '' || value === null || value === undefined) {
          callback(new Error('Angkatan wajib diisi'));
        } else if (isNaN(number)) {
          callback(new Error('Angkatan harus berupa angka'));
        } else if (number <= 0) {
          callback(new Error('Angkatan harus lebih besar dari 0'));
        } else {
          callback();
        }
      },
      trigger: 'blur',
    }
  ]
};

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

const submitForm = () => {
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }

    const payload = {
      ...form,
      kegiatan_dimulai: form.kegiatan_dimulai instanceof Date
        ? `${form.kegiatan_dimulai.getFullYear()}-${String(form.kegiatan_dimulai.getMonth() + 1).padStart(2, '0')}-${String(form.kegiatan_dimulai.getDate()).padStart(2, '0')}`
        : form.kegiatan_dimulai,
      kegiatan_berakhir: form.kegiatan_berakhir instanceof Date
        ? `${form.kegiatan_berakhir.getFullYear()}-${String(form.kegiatan_berakhir.getMonth() + 1).padStart(2, '0')}-${String(form.kegiatan_berakhir.getDate()).padStart(2, '0')}`
        : form.kegiatan_berakhir,
      angkatan: Number(form.angkatan), 
    };

    try {
      console.log('Kirim JSON untuk update:', JSON.stringify(payload));
      const response = await api.patch(`/kelola/pendaftaran/${form.id}/accept`, payload);
      console.log('Full response:', response);

      ElNotification({
        title: 'Berhasil',
        message: response?.data?.message ?? 'Data berhasil diupdate!',
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
          message: error.response?.data?.message ?? 'Gagal memperbarui data. Terjadi kesalahan jaringan atau server.',
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
/* Popup Animation */
.popup-enter-active, .popup-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.popup-enter-from {
  opacity: 0;
  transform: translateY(-20px) scale(0.95);
}

.popup-leave-to {
  opacity: 0;
  transform: translateY(20px) scale(0.95);
}

/* Form Item Styling */
:deep(.form-item-modern .el-form-item__label) {
  padding: 0 !important;
  margin-bottom: 8px !important;
  font-weight: 500 !important;
  color: #374151 !important;
}

:deep(.form-item-modern .el-form-item__content) {
  line-height: normal !important;
}

/* Modern Input Styling */
:deep(.modern-input .el-input__wrapper) {
  padding: 12px 16px !important;
  border-radius: 12px !important;
  border: 1.5px solid #e5e7eb !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
  transition: all 0.2s ease !important;
  background-color: #ffffff !important;
}

:deep(.modern-input .el-input__wrapper:hover) {
  border-color: #f3f4f6 !important;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.08) !important;
}

:deep(.modern-input.is-focus .el-input__wrapper) {
  border-color: #ec4899 !important;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1), 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important;
}

:deep(.modern-input .el-input__inner) {
  color: #374151 !important;
  font-weight: 400 !important;
}

:deep(.modern-input .el-input__inner::placeholder) {
  color: #9ca3af !important;
}

/* Date Picker Styling */
:deep(.el-date-editor.el-input) {
  width: 100% !important;
}

:deep(.el-date-editor .el-input__wrapper) {
  padding: 12px 16px !important;
  border-radius: 12px !important;
  border: 1.5px solid #e5e7eb !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
  transition: all 0.2s ease !important;
}

:deep(.el-date-editor .el-input__wrapper:hover) {
  border-color: #f3f4f6 !important;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.08) !important;
}

:deep(.el-date-editor.is-focus .el-input__wrapper) {
  border-color: #ec4899 !important;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1), 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important;
}

/* Select Styling */
:deep(.modern-select .el-select__wrapper) {
  padding: 12px 16px !important;
  border-radius: 12px !important;
  border: 1.5px solid #e5e7eb !important;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
  transition: all 0.2s ease !important;
}

:deep(.modern-select .el-select__wrapper:hover) {
  border-color: #f3f4f6 !important;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.08) !important;
}

:deep(.modern-select.is-focus .el-select__wrapper) {
  border-color: #ec4899 !important;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1), 0 2px 4px 0 rgba(0, 0, 0, 0.05) !important;
}

/* Button Styling */
:deep(.modern-btn-submit) {
  background: linear-gradient(135deg, #ec4899, #f97316) !important;
  border: none !important;
  border-radius: 12px !important;
  padding: 12px 24px !important;
  font-weight: 600 !important;
  color: white !important;
  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3) !important;
  transition: all 0.2s ease !important;
  min-width: 160px !important;
}

:deep(.modern-btn-submit:hover) {
  background: linear-gradient(135deg, #db2777, #ea580c) !important;
  box-shadow: 0 6px 16px rgba(236, 72, 153, 0.4) !important;
  transform: translateY(-2px) !important;
}

:deep(.modern-btn-submit:active) {
  transform: translateY(0) !important;
  box-shadow: 0 2px 8px rgba(236, 72, 153, 0.3) !important;
}

:deep(.modern-btn-cancel) {
  background-color: #f9fafb !important;
  color: #6b7280 !important;
  border: 1.5px solid #e5e7eb !important;
  border-radius: 12px !important;
  padding: 12px 24px !important;
  font-weight: 500 !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
  transition: all 0.2s ease !important;
  min-width: 120px !important;
}

:deep(.modern-btn-cancel:hover) {
  background-color: #f3f4f6 !important;
  color: #374151 !important;
  border-color: #d1d5db !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
  transform: translateY(-1px) !important;
}

:deep(.modern-btn-cancel:active) {
  transform: translateY(0) !important;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08) !important;
}

/* Error Message Styling */
:deep(.el-form-item__error) {
  color: #ef4444 !important;
  font-size: 12px !important;
  font-weight: 500 !important;
  margin-top: 4px !important;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>