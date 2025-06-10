<template>
  <Transition name="dialog-fade">
    <div v-if="localDialogVisible" class="filter-dialog-overlay">
      <div class="filter-dialog">
        <div class="my-header">
          <h4>
            <i class="fa-solid fa-filter dialog-icon"></i>
            Filter Data Pelatihan
          </h4>
          <!-- The close button now uses the primary color for consistency -->
          <el-button class="el-button--primary-custom" circle :icon="Close" @click="handleClose" />
        </div>
        <div class="scrollable-form-container">
          <div class="filter-section filter-selection">
            <h3 class="section-title">Pilih Kolom untuk Filter:</h3>
            <el-checkbox-group v-model="localSelectedColumns" class="column-checkboxes">
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
              </el-checkbox>
            </el-checkbox-group>
          </div>
          <div class="filter-section filter-inputs" v-if="localSelectedColumns.length > 0">
            <h3 class="section-title">Masukkan Nilai Filter:</h3>
            <div
              v-for="col in localSelectedColumns"
              :key="col"
              class="filter-input-item"
            >
              <el-input
                v-model="localActiveFilters[col]"
                :placeholder="`Filter berdasarkan ${formatColumnName(col)}`"
                clearable
                size="large"
                class="styled-input"
              >
                <template #prepend>
                  <span class="input-prepend">{{ formatColumnName(col) }}</span>
                </template>
              </el-input>
            </div>
          </div>
        </div>
        <div class="dialog-footer">
          <el-button @click="handleClearFilters" class="footer-button reset-button" :disabled="isLoading">
            <i class="fa-solid fa-eraser mr-2"></i>Bersihkan Filter
          </el-button>
          <el-button type="primary" @click="handleApplyFilters" class="footer-button apply-button" :loading="isLoading">
            <i class="fa-solid fa-check-circle mr-2"></i>Terapkan Filter
          </el-button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script lang="ts" setup>
import { ref, watch } from 'vue';
import { Close } from '@element-plus/icons-vue';

const props = defineProps<{
  modelValue: boolean; // Controls dialog visibility
  columns: string[]; // List of available columns for filtering
  initialFilters?: { [key: string]: string | number | null }; // Initial filters when dialog opens
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void; // To update dialog visibility in parent
  (e: 'update:activeFilters', filters: { [key: string]: string | number | null }): void; // To send active filters to parent
}>();

const localDialogVisible = ref(props.modelValue);
const localSelectedColumns = ref<string[]>([]);
const localActiveFilters = ref<{ [key: string]: string | number | null }>({});
const isLoading = ref(false);

watch(() => props.modelValue, (newVal) => {
  localDialogVisible.value = newVal;
  if (newVal) { // Only reset/initialize when dialog opens
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
}, { immediate: true }); // immediate: true so the watcher runs when the component is first mounted

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
  return col.replace(/([A-Z])/g, ' $1') // Add space before capital letters
    .replace(/^./, str => str.toUpperCase()) // Capitalize first letter
    .replace(/_/g, ' '); // Replace underscores with spaces
};

const handleClose = () => {
  localDialogVisible.value = false;
};

const handleApplyFilters = async () => {
  isLoading.value = true; // Activate loading status
  await new Promise(resolve => setTimeout(resolve, 800)); // 0.8 second delay
  const filtersToEmit: { [key: string]: string | number | null } = {};
  for (const col of localSelectedColumns.value) {
    const value = localActiveFilters.value[col];
    if (value !== null && value !== '') {
      filtersToEmit[col] = value;
    }
  }
  emit('update:activeFilters', filtersToEmit); // Emit cleaned filters to parent
  localDialogVisible.value = false; // Close dialog
  isLoading.value = false; // Deactivate loading status
};

const handleClearFilters = () => {
  localSelectedColumns.value = []; // Clear selected columns
  localActiveFilters.value = {}; // Clear active filters
  emit('update:activeFilters', {}); // Emit empty filters to parent
  localDialogVisible.value = false; // Close dialog
};
</script>

<style scoped>
/* Dialog transition styles */
.dialog-fade-enter-active,
.dialog-fade-leave-active {
  transition: opacity 0.7s ease-in-out;
}
.dialog-fade-enter-from,
.dialog-fade-leave-to {
  opacity: 0;
}
.dialog-fade-enter-active .filter-dialog,
.dialog-fade-leave-active .filter-dialog {
  transition: transform 0.7s, opacity 0.7s ease-in-out;
}
.dialog-fade-enter-from .filter-dialog,
.dialog-fade-leave-to .filter-dialog {
  transform: translateY(50px);
  opacity: 0;
}

/* Overlay and dialog container */
.filter-dialog-overlay {
  display: flex;
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.filter-dialog {
  width: 90%;
  max-width: 650px;
  border-radius: 12px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
  background-color: #f8f9fa; /* Light background for the dialog content */
  display: flex;
  flex-direction: column;
  max-height: 90vh;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .filter-dialog {
    width: 95vw !important;
    margin: 10px;
  }
  .column-checkboxes {
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
  }
}

/* Header styles (using #69C5C2 as primary color) */
.my-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 25px;
  /* Updated gradient with shades of #69C5C2 */
  background: linear-gradient(to right, #88D3D1, #69C5C2);
  color: white;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px 12px 0 0;
  flex-shrink: 0;
}

.my-header h4 {
  margin: 0;
  font-size: 1.5em;
  font-weight: bold;
  display: flex;
  align-items: center;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.dialog-icon {
  margin-right: 10px;
  font-size: 1.2em;
}

/* Scrollable form container */
.scrollable-form-container {
  flex-grow: 1;
  overflow-y: auto;
  padding: 20px;
  background-color: #ffffff; /* White background for form content */
}

/* Filter section styles */
.filter-section {
  margin-bottom: 20px;
  background-color: #fefefe; /* Slightly off-white background */
  padding: 20px;
  border-radius: 10px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* Section title (using #69C5C2 as primary color) */
.section-title {
  margin-top: 0;
  margin-bottom: 15px;
  color: #69C5C2; /* Primary color for title */
  font-size: 1.2em;
  font-weight: 600;
  border-bottom: 2px solid #B0E0DF; /* Lighter shade of primary for border */
  padding-bottom: 5px;
}

/* Checkbox group layout */
.column-checkboxes {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 12px;
}

/* Individual checkbox styling (using #69C5C2 for themed elements) */
.column-checkbox {
  background-color: #F0FBFA; /* Very light teal background */
  border-color: #B0E0DF; /* Light teal border */
  border-radius: 8px;
  padding: 10px 12px;
  transition: all 0.3s ease;
  font-weight: 500;
  color: #333;
  cursor: pointer;
}

.column-checkbox:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(105, 197, 194, 0.1); /* Primary color for hover shadow */
}

.column-checkbox-label-text {
  white-space: normal;
  word-break: break-word;
  line-height: 1.3;
}

.column-checkbox.is-checked {
  background-color: #E0F5F4; /* Slightly darker light teal when checked */
  border-color: #69C5C2; /* Primary color for border when checked */
  box-shadow: 0 0 0 2px #69C5C2; /* Primary color for box shadow when checked */
  color: #69C5C2; /* Primary color for text when checked */
}

/* Input field styling */
.filter-input-item {
  margin-bottom: 12px;
}

.styled-input .el-input-group__prepend {
  min-width: 120px;
  text-align: right;
  font-weight: bold;
  color: #555;
  background-color: #f1f7f9; /* Light grey background */
  border-right: 1px solid #dcdfe6;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding-right: 10px;
}

.styled-input .el-input__wrapper {
  border-radius: 6px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Input focus style (using #69C5C2 for focus) */
.styled-input .el-input__wrapper.is-focus {
  border-color: #69C5C2; /* Primary color for border on focus */
  box-shadow: 0 0 0 2px rgba(105, 197, 194, 0.2); /* Primary color for shadow on focus */
}

/* Dialog footer styles */
.dialog-footer {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-end;
  gap: 12px;
  padding: 15px 20px;
  background-color: #f8f9fa; /* Light background for footer */
  border-top: 1px solid #e0e0e0;
  border-radius: 0 0 12px 12px;
  flex-shrink: 0;
}

.footer-button {
  min-width: 140px;
  padding: 10px 16px;
  font-size: 1em;
  font-weight: bold;
  border-radius: 8px;
  transition: all 0.3s ease;
}

/* Reset button styling */
.reset-button {
  background-color: #fef0f0; /* Light red background */
  color: #f56c6c; /* Red text */
  border: 1px solid #fbc4c4; /* Light red border */
}

.reset-button:hover {
  background-color: #fef7f7;
  border-color: #f7a7a7;
  color: #f56c6c;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(245, 108, 108, 0.2);
}

/* Apply button styling (using #69C5C2 as primary color) */
.apply-button {
  /* Updated gradient with shades of #69C5C2 */
  background: linear-gradient(to right, #88D3D1, #69C5C2);
  border: none;
  color: white;
}

.apply-button:hover {
  /* Darker gradient for hover state */
  background: linear-gradient(to right, #72C3C0, #5AAEA8);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(105, 197, 194, 0.3); /* Primary color for hover shadow */
}

/* Custom styling for the close button to match the primary color */
.el-button--primary-custom {
  background-color: #69C5C2 !important;
  border-color: #69C5C2 !important;
  color: white !important;
}

.el-button--primary-custom:hover,
.el-button--primary-custom:focus {
  background-color: #88D3D1 !important; /* Lighter shade for hover */
  border-color: #88D3D1 !important;
}
</style>
