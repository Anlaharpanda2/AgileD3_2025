<template>
  <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6">
    <!-- Backdrop with blur effect - This will only fade in/out -->
    <div
      class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity duration-300"
      @click.self="closeForm"
    ></div>

    <!-- Main Form Container - This is where the modal content animation applies -->
    <transition name="modal" appear>
      <div class="relative z-10 w-full max-w-sm sm:max-w-md" v-if="visible">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">

          <!-- Header Section -->
          <div class="relative bg-gradient-to-r from-pink-50 to-rose-50 px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
            <div class="flex items-center justify-between">
              <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-1">Pengurutan Data</h2>
                <p class="text-xs sm:text-sm text-gray-500">Atur urutan data sesuai kebutuhan</p>
              </div>

              <!-- Close Button -->
              <button
                @click="closeForm"
                class="group p-2 rounded-full hover:bg-white/60 transition-all duration-200 ease-in-out touch-manipulation"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="2"
                  stroke="currentColor"
                  class="w-5 h-5 text-gray-500 group-hover:text-pink-500 group-hover:rotate-90 transition-all duration-200"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Form Content -->
          <div class="p-4 sm:p-6 space-y-5 sm:space-y-6 max-h-[70vh] overflow-y-auto">
            <el-form
              :model="form"
              label-position="top"
              class="space-y-5 sm:space-y-6"
            >
              <!-- Column Selection -->
              <el-form-item class="mb-5 sm:mb-6">
                <template #label>
                  <div class="flex items-center space-x-2 mb-2 sm:mb-3">
                    <div class="w-2 h-2 bg-pink-400 rounded-full"></div>
                    <span class="text-sm font-semibold text-gray-700">Kolom Data</span>
                  </div>
                </template>

                <el-select
                  v-model="form.column"
                  placeholder="Pilih kolom yang akan diurutkan"
                  class="w-full modern-select"
                  filterable
                  clearable
                  size="large"
                >
                  <el-option
                    v-for="col in filteredColumns"
                    :key="col"
                    :label="formatLabel(col)"
                    :value="col"
                  />
                </el-select>
              </el-form-item>

              <!-- Sort Direction -->
              <el-form-item class="mb-5 sm:mb-6">
                <template #label>
                  <div class="flex items-center space-x-2 mb-3 sm:mb-4">
                    <div class="w-2 h-2 bg-pink-400 rounded-full"></div>
                    <span class="text-sm font-semibold text-gray-700">Arah Pengurutan</span>
                  </div>
                </template>

                <div class="space-y-2 sm:space-y-3">
                  <label class="flex items-center p-3 sm:p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-pink-200 hover:bg-pink-50/30 transition-all duration-200 group touch-manipulation">
                    <el-radio v-model="form.order" value="asc" class="mr-2 sm:mr-3">
                      <span class="sr-only">Ascending</span>
                    </el-radio>
                    <div class="flex-1">
                      <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center group-hover:from-green-200 group-hover:to-emerald-200 transition-all duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                          </div>
                        </div>
                        <div>
                          <div class="font-semibold text-gray-800 text-sm">Naik</div>
                          <div class="text-xs text-gray-500">A-Z • 0-9 • Terlama</div>
                        </div>
                      </div>
                    </div>
                  </label>

                  <label class="flex items-center p-3 sm:p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-pink-200 hover:bg-pink-50/30 transition-all duration-200 group touch-manipulation">
                    <el-radio v-model="form.order" value="desc" class="mr-2 sm:mr-3">
                      <span class="sr-only">Descending</span>
                    </el-radio>
                    <div class="flex-1">
                      <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="flex-shrink-0">
                          <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full flex items-center justify-center group-hover:from-blue-200 group-hover:to-indigo-200 transition-all duration-200">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                          </div>
                        </div>
                        <div>
                          <div class="font-semibold text-gray-800 text-sm">Turun</div>
                          <div class="text-xs text-gray-500">Z-A • 9-0 • Terbaru</div>
                        </div>
                      </div>
                    </div>
                  </label>
                </div>
              </el-form-item>
            </el-form>
          </div>

          <!-- Action Buttons -->
          <div class="bg-gray-50/50 px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-100">
            <div class="flex flex-col-reverse sm:flex-row space-y-reverse space-y-2 sm:space-y-0 sm:space-x-3 justify-end">
              <button
                @click="cancelSort"
                class="w-full sm:w-auto px-4 sm:px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 touch-manipulation"
              >
                Batal
              </button>
              <button
                @click="applySort"
                class="w-full sm:w-auto px-4 sm:px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-pink-500 to-rose-500 rounded-lg hover:from-pink-600 hover:to-rose-600 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 touch-manipulation"
              >
                Terapkan
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { reactive, computed } from 'vue';

const props = defineProps<{
  visible: boolean;
  columns: string[];
  data: any[];
}>();

const emits = defineEmits<{
  (e: 'apply-sort', payload: { column: string; order: 'asc' | 'desc' }): void;
  (e: 'cancel-sort'): void;
  (e: 'update:visible', value: boolean): void;
}>();

const form = reactive({
  column: '',
  order: 'asc' as 'asc' | 'desc',
});

// Filter out unwanted columns including 'deleted_at'
const excludedColumns = ['photo', 'deleted_at', 'photo_url', 'angkatan', 'tempat_kegiatan', 'kegiatan_berakhir', 'kegiatan_dimulai'];

const filteredColumns = computed(() => {
  return props.columns.filter(col =>
    !excludedColumns.some(excluded =>
      col.toLowerCase().includes(excluded.toLowerCase())
    )
  );
});

function formatLabel(key: string): string {
  // Ensure excluded columns are not formatted or displayed
  if (excludedColumns.includes(key.toLowerCase())) {
    return '';
  }

  return key
    .split('_')
    .map(w => w.charAt(0).toUpperCase() + w.slice(1))
    .join(' ');
}

function closeForm(): void {
  // Only emits the update:visible event, does not reset form state
  emits('update:visible', false);
}

function applySort(): void {
  if (!form.column) {
    console.warn("Kolom pengurutan belum dipilih.");
    return;
  }
  props.data.sort((a, b) => {
    const valueA = a[form.column];
    const valueB = b[form.column];

    const isDate = !isNaN(Date.parse(valueA)) && !isNaN(Date.parse(valueB));
    const isNumber = !isNaN(parseFloat(valueA)) && !isNaN(parseFloat(valueB));

    if (isDate) {
      return form.order === 'asc'
        ? new Date(valueA).getTime() - new Date(valueB).getTime()
        : new Date(valueB).getTime() - new Date(valueA).getTime();
    } else if (isNumber) {
      return form.order === 'asc'
        ? parseFloat(valueA) - parseFloat(valueB)
        : parseFloat(valueB) - parseFloat(valueA);
    } else {
      return form.order === 'asc'
        ? String(valueA).localeCompare(String(valueB))
        : String(valueB).localeCompare(String(valueA));
    }
  });
  emits('apply-sort', { column: form.column, order: form.order });
  closeForm(); // Close form, but state is preserved
}

function cancelSort(): void {
  emits('cancel-sort');
  // Only reset form state when "Batal" is clicked
  form.column = '';
  form.order = 'asc';
  closeForm();
}
</script>

<style scoped>
/* Modal Transition - Applies to the modal content only */
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

/* Overrides untuk Element Plus tanpa @apply */
:deep(.modern-select .el-input__wrapper) {
  border-width: 2px;
  border-color: #e5e7eb; /* gray-200 */
  border-radius: 0.75rem; /* rounded-xl */
  padding-left: 1rem; /* px-4 */
  padding-right: 1rem; /* px-4 */
  padding-top: 0.75rem; /* py-3 */
  padding-bottom: 0.75rem; /* py-3 */
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
  transition: all 0.2s ease-in-out;
}

:deep(.modern-select .el-input__wrapper:hover) {
  border-color: #fbcfe8; /* pink-300 */
}

:deep(.modern-select .el-input__wrapper.is-focused) {
  border-color: #f472b6; /* pink-400 */
  box-shadow: 0 0 0 4px rgba(253, 224, 255, 0.5); /* ring-4 ring-pink-100 */
}

:deep(.modern-select .el-input__inner) {
  color: #374151; /* gray-700 */
  font-size: 0.875rem; /* text-sm */
  font-weight: 500; /* font-medium */
}

:deep(.el-radio__input.is-checked .el-radio__inner) {
  background-color: #ec4899; /* pink-500 */
  border-color: #ec4899; /* pink-500 */
}

:deep(.el-radio__input.is-checked + .el-radio__label) {
  color: #374151; /* gray-800 */
}

:deep(.el-radio__inner:hover) {
  border-color: #f472b6; /* pink-400 */
}

:deep(.el-select-dropdown) {
  border-radius: 0.75rem; /* rounded-xl */
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); /* shadow-2xl */
  border-width: 0; /* border-0 */
  background: white;
  margin-top: 8px;
}

:deep(.el-select-dropdown__item) {
  padding-top: 0.75rem; /* py-3 */
  padding-bottom: 0.75rem; /* py-3 */
  padding-left: 1rem; /* px-4 */
  padding-right: 1rem; /* px-4 */
  font-size: 0.875rem; /* text-sm */
  font-weight: 500; /* font-medium */
  color: #374151; /* gray-700 */
  transition: all 0.2s ease-in-out;
}

:deep(.el-select-dropdown__item.hover) {
  background-color: #fff1f2; /* pink-50 */
  color: #be185d; /* pink-700 */
}

:deep(.el-select-dropdown__item.selected) {
  background-color: #fce7f3; /* pink-100 */
  color: #9d174d; /* pink-800 */
  font-weight: 600; /* font-semibold */
}

/* Custom scrollbar for dropdown */
:deep(.el-select-dropdown .el-scrollbar__wrap) {
  scrollbar-width: thin;
  scrollbar-color: #e5e7eb transparent;
}

:deep(.el-select-dropdown .el-scrollbar__wrap::-webkit-scrollbar) {
  width: 6px;
}

:deep(.el-select-dropdown .el-scrollbar__wrap::-webkit-scrollbar-track) {
  background: transparent;
}

:deep(.el-select-dropdown .el-scrollbar__wrap::-webkit-scrollbar-thumb) {
  background-color: #e5e7eb;
  border-radius: 3px;
}

:deep(.el-select-dropdown .el-scrollbar__wrap::-webkit-scrollbar-thumb:hover) {
  background-color: #d1d5db;
}

/* Mobile responsiveness and touch optimization */
@media (max-width: 640px) {
  .modern-select {
    font-size: 16px; /* Prevent zoom on iOS */
  }

  /* Ensure modal doesn't overflow on small screens and has a good mobile animation */
  /* These styles target the modal content when it's entering or leaving */
  .modal-enter-from {
    opacity: 0;
    transform: translateY(100%); /* Start from bottom */
  }

  .modal-leave-to {
    opacity: 0;
    transform: translateY(100%); /* Exit to bottom */
  }

  /* Improve touch targets */
  .touch-manipulation {
    touch-action: manipulation;
    -webkit-tap-highlight-color: transparent;
  }

  /* Better button stacking on mobile */
  .flex-col-reverse > button {
    margin-bottom: 0.5rem;
  }
  .flex-col-reverse > button:last-child {
    margin-bottom: 0;
  }
}

/* Improve accessibility for touch devices */
@media (hover: none) and (pointer: coarse) {
  .group:hover {
    /* Disable hover effects on touch devices */
  }
}
</style>
