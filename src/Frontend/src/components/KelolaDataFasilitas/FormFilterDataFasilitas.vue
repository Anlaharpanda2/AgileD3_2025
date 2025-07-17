<template>
  <Transition name="dialog-fade">
    <div
      v-if="localDialogVisible"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm p-4"
      @click.self="handleClose"
    >
      <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl shadow-gray-500/10 overflow-hidden transform transition-all duration-300 max-h-[90vh] flex flex-col">
        <div class="relative bg-gradient-to-r from-pink-50 to-rose-50 border-b border-gray-100">
          <div class="flex items-center justify-between p-6">
            <div class="flex items-center space-x-3">
              <div class="flex items-center justify-center w-10 h-10 bg-pink-100 rounded-full">
                <IconFilter class="text-pink-600 w-4 h-4" />
              </div>
              <div>
                <h2 class="text-xl font-bold text-gray-800">
                  Filter Data Fasilitas
                </h2>
                <p class="text-sm text-gray-600">
                  Pilih kolom dan masukkan kriteria filter
                </p>
              </div>
            </div>
            <button
              class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200"
              @click="handleClose"
            >
              <IconX class="w-4 h-4" />
            </button>
          </div>
          <div class="absolute bottom-0 left-6 right-6 h-px bg-gradient-to-r from-pink-200 via-pink-300 to-transparent" />
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-8">
          <div class="space-y-4">
            <div class="flex items-center space-x-2">
              <div class="w-1 h-6 bg-pink-400 rounded-full" />
              <h3 class="text-lg font-semibold text-gray-800">
                Pilih Kolom untuk Filter
              </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <label
                v-for="col in filteredColumns"
                :key="col"
                class="relative flex items-center p-4 bg-gray-50 hover:bg-pink-50 border border-gray-200 hover:border-pink-200 rounded-xl cursor-pointer transition-all duration-200 group"
                :class="{ 'bg-pink-50 border-pink-300 shadow-sm': localSelectedColumns.includes(col) }"
              >
                <input
                  v-model="localSelectedColumns"
                  type="checkbox"
                  :value="col"
                  class="sr-only"
                >
                <div
                  class="flex items-center justify-center w-8 h-8 rounded-lg mr-3 transition-all duration-200"
                  :class="localSelectedColumns.includes(col)
                    ? 'bg-pink-500 text-white'
                    : 'bg-gray-200 text-gray-600 group-hover:bg-pink-100 group-hover:text-pink-600'"
                >
                  <component
                    :is="getColumnIcon(col)"
                    class="w-4 h-4"
                  />
                </div>
                <div
                  class="flex items-center justify-center w-5 h-5 border-2 rounded-md mr-3 transition-all duration-200"
                  :class="localSelectedColumns.includes(col)
                    ? 'bg-pink-500 border-pink-500 text-white'
                    : 'border-gray-300 group-hover:border-pink-400'"
                >
                  <IconCheck
                    v-if="localSelectedColumns.includes(col)"
                    class="w-3 h-3"
                  />
                </div>
                <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                  {{ formatColumnName(col) }}
                </span>
                <div
                  v-if="localSelectedColumns.includes(col)"
                  class="absolute top-2 right-2 w-2 h-2 bg-pink-400 rounded-full animate-pulse"
                />
              </label>
            </div>
          </div>

          <div
            v-if="localSelectedColumns.length > 0"
            class="space-y-4"
          >
            <div class="flex items-center space-x-2">
              <div class="w-1 h-6 bg-pink-400 rounded-full" />
              <h3 class="text-lg font-semibold text-gray-800">
                Masukkan Nilai Filter
              </h3>
              <div class="flex items-center justify-center w-6 h-6 bg-pink-100 text-pink-600 rounded-full text-xs font-bold">
                {{ localSelectedColumns.length }}
              </div>
            </div>

            <div class="space-y-4">
              <div
                v-for="col in localSelectedColumns"
                :key="col"
                class="group"
              >
                <div class="relative">
                  <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                    <div class="flex items-center justify-center w-6 h-6 bg-pink-100 text-pink-600 rounded-md mr-2">
                      <component
                        :is="getColumnIcon(col)"
                        class="w-3 h-3"
                      />
                    </div>
                    {{ formatColumnName(col) }}
                  </label>

                  <div class="relative">
                    <input
                      v-model="localActiveFilters[col]"
                      type="text"
                      :placeholder="`Masukkan filter untuk ${formatColumnName(col).toLowerCase()}`"
                      class="w-full px-4 py-3 pr-10 text-gray-700 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-200 focus:border-pink-400 transition-all duration-200 placeholder-gray-400"
                    >
                    <button
                      v-if="localActiveFilters[col]"
                      class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                      @click="localActiveFilters[col] = ''"
                    >
                      <IconX class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div
            v-if="localSelectedColumns.length === 0"
            class="text-center py-12"
          >
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <IconFilter class="text-gray-400 w-8 h-8" />
            </div>
            <h3 class="text-lg font-medium text-gray-600 mb-2">
              Belum Ada Kolom Dipilih
            </h3>
            <p class="text-gray-500">
              Pilih kolom di atas untuk mulai membuat filter
            </p>
          </div>
        </div>

        <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4">
          <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
            <button
              :disabled="isLoading"
              class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 focus:ring-2 focus:ring-gray-200 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
              @click="handleClearFilters"
            >
              <IconTrash class="w-4 h-4 mr-2" />
              Bersihkan Filter
            </button>

            <button
              :disabled="isLoading || localSelectedColumns.length === 0"
              class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 rounded-lg focus:ring-2 focus:ring-pink-200 shadow-sm hover:shadow-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed relative overflow-hidden"
              @click="handleApplyFilters"
            >
              <div
                v-if="isLoading"
                class="absolute inset-0 flex items-center justify-center"
              >
                <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin" />
              </div>

              <span :class="{ 'opacity-0': isLoading }">
                <IconCheck class="w-4 h-4 mr-2" />
                Terapkan Filter
              </span>
            </button>
          </div>

          <div
            v-if="localSelectedColumns.length > 0"
            class="flex items-center justify-center mt-3 text-xs text-gray-500"
          >
            <IconInfo class="w-3 h-3 mr-1" />
            {{ localSelectedColumns.length }} kolom dipilih untuk filter
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script lang="ts" setup>
import { ref, watch, computed } from 'vue';

// Import icon components dari lucide-vue-next
import {
  Filter as IconFilter,
  X as IconX,
  Check as IconCheck,
  Building as IconBuilding,
  Tag as IconTag,
  Info as IconInfo,
  Users as IconUsers,
  MapPin as IconMapPin,
  AlignLeft as IconAlignLeft,
  StickyNote as IconStickyNote,
  CalendarCheck as IconCalendarCheck,
  Lightbulb as IconLightbulb,
  Wrench as IconWrench,
  Hash as IconHash,
  Plus as IconPlus,
  Edit as IconEdit,
  Columns as IconColumns,
  Trash as IconTrash
} from 'lucide-vue-next';

const props = defineProps<{
  modelValue: boolean;
  columns: string[];
  initialFilters?: { [key: string]: string | number | null };
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void;
  (e: 'update:activeFilters', filters: { [key: string]: string | number | null }): void;
}>();

const localDialogVisible = ref(props.modelValue);
const localSelectedColumns = ref<string[]>([]);
const localActiveFilters = ref<{ [key: string]: string | number | null }>({});
const isLoading = ref(false);

// Filter kolom yang tidak diinginkan
const filteredColumns = computed(() => {
  const excludedColumns = ['photo', 'deleted_at', 'photo_url'];
  return props.columns.filter(col =>
    !excludedColumns.some(excluded =>
      col.toLowerCase().includes(excluded.toLowerCase())
    )
  );
});

// Mapping icon untuk setiap kolom menggunakan component Lucid-Vue-Next
const getColumnIcon = (column: string) => {
  const col = column.toLowerCase();

  // Fasilitas
  if (col.includes('name') || col.includes('nama')) {
    // Jika nama fasilitas bisa spesifik seperti ruangan, bisa pakai DoorOpen, jika bangunan umum pakai Building
    // Untuk generalitas, Building lebih sering dipakai.
    return IconBuilding;
  }
  if (col.includes('type') || col.includes('tipe') || col.includes('jenis')) return IconTag;
  if (col.includes('status')) return IconInfo;
  if (col.includes('capacity') || col.includes('kapasitas')) return IconUsers;
  if (col.includes('location') || col.includes('lokasi')) return IconMapPin;
  if (col.includes('description') || col.includes('deskripsi')) return IconAlignLeft;
  if (col.includes('note') || col.includes('catatan')) return IconStickyNote;
  if (col.includes('availability') || col.includes('ketersediaan')) return IconCalendarCheck;
  if (col.includes('condition') || col.includes('kondisi')) return IconLightbulb; // Atau IconPackage jika maksudnya kondisi fisik barang
  if (col.includes('last_maintenance') || col.includes('terakhir_pemeliharaan')) return IconWrench;

  // Identifikasi & Kode
  if (col.includes('id') || col.includes('code') || col.includes('kode')) return IconHash;

  // Waktu
  if (col.includes('created') || col.includes('dibuat')) return IconPlus;
  if (col.includes('updated') || col.includes('diperbarui')) return IconEdit;

  // Default icon
  return IconColumns;
};

watch(() => props.modelValue, (newVal) => {
  localDialogVisible.value = newVal;
  if (newVal) {
    if (props.initialFilters) {
      localActiveFilters.value = { ...props.initialFilters };
      localSelectedColumns.value = Object.keys(props.initialFilters).filter(
        key => props.initialFilters && props.initialFilters[key] !== null && props.initialFilters[key] !== ''
      );
    } else {
      localActiveFilters.value = {};
      localSelectedColumns.value = [];
    }
  }
}, { immediate: true });

watch(localDialogVisible, (newVal) => {
  emit('update:modelValue', newVal);
});

watch(localSelectedColumns, (newSelected, oldSelected) => {
  newSelected.forEach(col => {
    if (!(col in localActiveFilters.value)) {
      localActiveFilters.value[col] = '';
    }
  });
  oldSelected.forEach(col => {
    if (!newSelected.includes(col)) {
      delete localActiveFilters.value[col];
    }
  });
});

const formatColumnName = (col: string): string => {
  return col.replace(/([A-Z])/g, ' $1')
    .replace(/^./, str => str.toUpperCase())
    .replace(/_/g, ' ');
};

const handleClose = () => {
  localDialogVisible.value = false;
};

const handleApplyFilters = async () => {
  isLoading.value = true;
  await new Promise(resolve => setTimeout(resolve, 800)); // Simulate async operation
  const filtersToEmit: { [key: string]: string | number | null } = {};
  for (const col of localSelectedColumns.value) {
    const value = localActiveFilters.value[col];
    if (value !== null && value !== '') {
      filtersToEmit[col] = value;
    }
  }
  emit('update:activeFilters', filtersToEmit);
  localDialogVisible.value = false;
  isLoading.value = false;
};

const handleClearFilters = () => {
  localSelectedColumns.value = [];
  localActiveFilters.value = {};
  emit('update:activeFilters', {});
  localDialogVisible.value = false;
};
</script>

<style scoped>
/* Transition animations yang lebih smooth */
.dialog-fade-enter-active,
.dialog-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.dialog-fade-enter-from,
.dialog-fade-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(-20px);
}

.dialog-fade-enter-to,
.dialog-fade-leave-from {
  opacity: 1;
  transform: scale(1) translateY(0);
}

/* Custom scrollbar untuk area scroll */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Animasi untuk indicator dot */
@keyframes pulse {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.5;
  }
}

.animate-pulse {
  animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Hover effects yang lebih halus */
.group:hover .group-hover\:border-pink-400 {
  border-color: #f472b6;
}

.group:hover .group-hover\:text-gray-900 {
  color: #111827;
}

/* Focus styles untuk accessibility */
input:focus,
button:focus {
  outline: none;
}

/* Custom gradient backgrounds */
.bg-gradient-to-r.from-pink-500.to-rose-500 {
  background-image: linear-gradient(to right, #ec4899, #f43f5e);
}

.bg-gradient-to-r.from-pink-600.to-rose-600:hover {
  background-image: linear-gradient(to right, #db2777, #e11d48);
}

/* Loading animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>