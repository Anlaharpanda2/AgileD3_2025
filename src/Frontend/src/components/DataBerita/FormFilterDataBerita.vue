<template>
  <Transition name="dialog-fade">
    <div
      v-if="localDialogVisible"
      class="filter-dialog-overlay"
      @click.self="handleClose"
    >
      <div class="filter-dialog">
        <div class="my-header">
          <h4>
            <IconFilter class="dialog-icon" />
            Filter Data Berita
          </h4>
          <el-button
            class="el-button--close-custom"
            circle
            :icon="IconX"
            @click="handleClose"
          />
        </div>
        <div class="scrollable-form-container">
          <div class="filter-section filter-selection">
            <h3 class="section-title">
              Pilih Kolom untuk Filter:
            </h3>
            <el-checkbox-group
              v-model="localSelectedColumns"
              class="column-checkboxes"
            >
              <el-checkbox
                v-for="col in columns"
                :key="col"
                :label="col"
                :value="col"
                size="large"
                border
                class="column-checkbox"
              >
                <span class="column-checkbox-label-text">{{ formatColumnName(col) }}</span>
                <component
                  :is="getColumnIcon(col)"
                  class="column-icon"
                />
              </el-checkbox>
            </el-checkbox-group>
          </div>

          <div
            v-if="localSelectedColumns.length > 0"
            class="filter-section filter-inputs"
          >
            <h3 class="section-title">
              Masukkan Nilai Filter:
            </h3>
            <div
              v-for="col in localSelectedColumns"
              :key="col"
              class="filter-input-group"
            >
              <label :for="`filter-${col}`" class="input-label">{{ formatColumnName(col) }}:</label>
              <div class="input-wrapper">
                <input
                  :id="`filter-${col}`"
                  v-model="localActiveFilters[col]"
                  type="text"
                  :placeholder="`Masukkan filter untuk ${formatColumnName(col).toLowerCase()}`"
                  class="filter-input"
                >
                <button
                  v-if="localActiveFilters[col]"
                  class="clear-button"
                  @click="localActiveFilters[col] = ''"
                >
                  <IconX class="w-3 h-3" />
                </button>
              </div>
            </div>
          </div>
          <div
            v-else
            class="empty-state"
          >
            <IconFilter class="empty-state-icon" />
            <p class="empty-state-text">
              Belum ada kolom yang dipilih. Silakan pilih kolom untuk mulai memfilter.
            </p>
          </div>
        </div>

        <div class="my-footer">
          <el-button
            type="info"
            class="reset-button"
            :disabled="isLoading"
            @click="handleClearFilters"
          >
            <IconTrash class="w-4 h-4 mr-2" />
            Bersihkan Filter
          </el-button>
          <el-button
            type="primary"
            class="apply-button"
            :disabled="isLoading || localSelectedColumns.length === 0"
            @click="handleApplyFilters"
          >
            <div v-if="isLoading" class="loading-spinner" />
            <span :class="{ 'opacity-0': isLoading }">
              <IconCheck class="w-4 h-4 mr-2" />
              Terapkan Filter
            </span>
          </el-button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script lang="ts" setup>
import { ref, watch, computed } from 'vue';

// Hapus import Close dari Element Plus karena akan diganti dengan IconX dari Lucide
import { ElButton, ElCheckboxGroup, ElCheckbox } from 'element-plus';
import 'element-plus/es/components/button/style/css';
import 'element-plus/es/components/checkbox-group/style/css';
import 'element-plus/es/components/checkbox/style/css';

// Import icon components dari lucide-vue-next
import {
  Filter as IconFilter,
  X as IconX,
  Check as IconCheck,
  Trash as IconTrash,
  Type as IconType,
  UserPen as IconUserPen,
  Folder as IconFolder,
  Info as IconInfo,
  Calendar as IconCalendar,
  Eye as IconEye,
  MessageCircle as IconMessageCircle,
  Tags as IconTags,
  Link as IconLink,
  Hash as IconHash,
  Plus as IconPlus,
  Edit as IconEdit,
  Columns as IconColumns
} from 'lucide-vue-next';


const props = defineProps<{
  modelValue: boolean;
  columns: string[];
  initialFilters?: { [key: string]: string | number | null };
}>();

const emit = defineEmits(['update:modelValue', 'update:activeFilters']);

const localDialogVisible = ref(props.modelValue);
const localSelectedColumns = ref<string[]>([]);
const localActiveFilters = ref<{ [key: string]: string | number | null }>({});
const isLoading = ref(false);

// Mapping icon untuk setiap kolom menggunakan component Lucid-Vue-Next
const getColumnIcon = (column: string) => {
  const col = column.toLowerCase();

  // Berita
  if (col.includes('title') || col.includes('judul')) return IconType;
  if (col.includes('author') || col.includes('penulis')) return IconUserPen;
  if (col.includes('category') || col.includes('kategori')) return IconFolder;
  if (col.includes('status')) return IconInfo;
  if (col.includes('date') || col.includes('tanggal')) return IconCalendar;
  if (col.includes('published_at') || col.includes('diterbitkan')) return IconCalendar; // Bisa juga CalendarCheck jika ada konotasi sudah publish
  if (col.includes('views') || col.includes('dibaca')) return IconEye;
  if (col.includes('comments') || col.includes('komentar')) return IconMessageCircle;
  if (col.includes('tags')) return IconTags;
  if (col.includes('source')) return IconLink;

  // Identifikasi & Waktu umum
  if (col.includes('id') || col.includes('code') || col.includes('kode')) return IconHash;
  if (col.includes('created_at') || col.includes('dibuat')) return IconPlus;
  if (col.includes('updated_at') || col.includes('diperbarui')) return IconEdit;

  // Default icon
  return IconColumns;
};


watch(() => props.modelValue, (newVal) => {
  localDialogVisible.value = newVal;
  if (newVal) {
    if (props.initialFilters) {
      localActiveFilters.value = { ...props.initialFilters };
      localSelectedColumns.value = Object.keys(props.initialFilters).filter(
        key => props.initialFilters[key] !== null && props.initialFilters[key] !== ''
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
/* Transisi untuk dialog */
.dialog-fade-enter-active,
.dialog-fade-leave-active {
  transition: all 0.3s ease-in-out;
}
.dialog-fade-enter-from,
.dialog-fade-leave-to {
  opacity: 0;
  transform: translateY(-20px) scale(0.95);
}
.dialog-fade-enter-to,
.dialog-fade-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}

/* Overlay */
.filter-dialog-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  padding: 20px;
  box-sizing: border-box;
}

/* Dialog container */
.filter-dialog {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 800px;
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transform: scale(1);
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.filter-dialog:hover {
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Header */
.my-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 18px 24px;
  border-bottom: 1px solid #eee;
  background: linear-gradient(to right, #e0f2f7, #e0f7f2); /* Light blue-green gradient */
  color: #333;
}

.my-header h4 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  color: #2c3e50;
}

.dialog-icon {
  margin-right: 10px;
  color: #007bff; /* Primary blue color for icon */
  font-size: 1.1em;
}

/* Close button Element Plus custom style */
.el-button--close-custom {
  border: none;
  background-color: transparent;
  color: #909399;
  font-size: 20px;
  transition: all 0.2s ease-in-out;
}
.el-button--close-custom:hover {
  background-color: #f0f2f5;
  color: #606266;
  transform: rotate(90deg);
}

/* Scrollable form container */
.scrollable-form-container {
  flex-grow: 1;
  overflow-y: auto;
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 25px;
}

/* Custom scrollbar */
.scrollable-form-container::-webkit-scrollbar {
  width: 6px;
}
.scrollable-form-container::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}
.scrollable-form-container::-webkit-scrollbar-thumb {
  background: #c0c4cc;
  border-radius: 3px;
}
.scrollable-form-container::-webkit-scrollbar-thumb:hover {
  background: #a8abb2;
}

/* Section styling */
.filter-section {
  background-color: #f9f9f9;
  border: 1px solid #eee;
  border-radius: 10px;
  padding: 20px;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
}

.section-title {
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 15px;
  border-bottom: 2px solid #e0e0e0;
  padding-bottom: 10px;
}

/* Checkbox styling */
.column-checkboxes {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 12px;
}

.column-checkbox {
  margin: 0 !important; /* Override Element Plus default margin */
  border: 1px solid #dcdfe6;
  border-radius: 8px;
  transition: all 0.2s ease-in-out;
  padding: 12px 15px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #fff;
  cursor: pointer;
}

.column-checkbox.is-checked {
  border-color: #409eff;
  background-color: #ecf5ff;
  box-shadow: 0 2px 8px rgba(64, 158, 255, 0.1);
}

.column-checkbox:hover {
  border-color: #a0cfff;
  box-shadow: 0 4px 12px rgba(64, 158, 255, 0.08);
  transform: translateY(-2px);
}

.column-checkbox .el-checkbox__input {
  margin-right: 10px; /* Space between checkbox and label */
}

.column-checkbox-label-text {
  flex-grow: 1;
  font-weight: 500;
  color: #333;
  font-size: 0.95em;
}

.column-icon {
  margin-left: 10px;
  color: #909399;
  font-size: 1.1em;
  transition: color 0.2s ease-in-out;
}

.column-checkbox.is-checked .column-icon {
  color: #409eff; /* Change icon color when checked */
}

/* Filter input group */
.filter-input-group {
  margin-bottom: 15px;
}

.input-label {
  display: block;
  font-size: 0.9em;
  color: #606266;
  margin-bottom: 8px;
  font-weight: 500;
}

.input-wrapper {
  position: relative;
}

.filter-input {
  width: 100%;
  padding: 10px 40px 10px 15px;
  border: 1px solid #dcdfe6;
  border-radius: 8px;
  font-size: 1em;
  color: #333;
  transition: all 0.2s ease-in-out;
  box-sizing: border-box; /* Ensures padding doesn't add to total width */
}

.filter-input:focus {
  border-color: #409eff;
  box-shadow: 0 0 0 3px rgba(64, 158, 255, 0.2);
  outline: none;
}

.clear-button {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: #909399;
  cursor: pointer;
  padding: 5px;
  border-radius: 50%;
  transition: all 0.2s ease-in-out;
}
.clear-button:hover {
  color: #606266;
  background-color: #f0f2f5;
}

/* Empty state styling */
.empty-state {
  text-align: center;
  padding: 50px 20px;
  color: #909399;
  font-size: 1.1em;
}

.empty-state-icon {
  font-size: 3em;
  margin-bottom: 20px;
  color: #c0c4cc;
}

.empty-state-text {
  margin: 0;
  line-height: 1.5;
}

/* Footer buttons */
.my-footer {
  display: flex;
  justify-content: flex-end;
  padding: 18px 24px;
  border-top: 1px solid #eee;
  background-color: #fcfcfc;
  gap: 15px; /* Spasi antar tombol */
}

.reset-button, .apply-button {
  padding: 10px 20px;
  border-radius: 8px;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 150px;
}

.reset-button {
  background-color: #FEEEEE; /* Lighter red background */
  color: #EB5757; /* Deeper red text */
  border: 1px solid #FBCACD; /* Lighter red border */
  box-shadow: 0 2px 8px rgba(235, 87, 87, 0.1); /* Subtle red shadow */
}
.reset-button:hover {
  background-color: #FAEAEA;
  border-color: #E88F92;
  color: #D63030;
  transform: translateY(-3px);
  box-shadow: 0 6px 15px rgba(245, 108, 108, 0.2);
}

/* Apply button styling */
.apply-button {
  background: linear-gradient(to right, #88D3D1, #69C5C2);
  border: none;
  color: white;
  box-shadow: 0 4px 10px rgba(105, 197, 194, 0.25); /* Initial shadow for apply button */
}
.apply-button:hover {
  background: linear-gradient(to right, #69C5C2, #5AAEA8); /* Darker gradient for hover */
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(105, 197, 194, 0.35); /* More prominent shadow on hover */
}

.apply-button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Loading spinner */
.loading-spinner {
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-top: 3px solid #fff;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 1s linear infinite;
  position: absolute;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.apply-button span {
  transition: opacity 0.3s;
}
</style>