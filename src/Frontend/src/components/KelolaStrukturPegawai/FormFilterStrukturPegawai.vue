<template>
  <Transition name="dialog-fade">
    <div v-if="localDialogVisible" class="filter-dialog-overlay" @click.self="handleClose">
      <div class="filter-dialog">
        <div class="my-header">
          <h4>
            <i class="fa-solid fa-filter dialog-icon"></i>
            Filter Data Struktur Pegawai
          </h4>
          <el-button class="el-button--close-custom" circle :icon="Close" @click="handleClose" />
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
  await new Promise(resolve => setTimeout(resolve, 800));
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
/* Dialog transition styles */
.dialog-fade-enter-active,
.dialog-fade-leave-active {
  transition: opacity 0.4s ease-in-out;
}
.dialog-fade-enter-from,
.dialog-fade-leave-to {
  opacity: 0;
}
.dialog-fade-enter-active .filter-dialog,
.dialog-fade-leave-active .filter-dialog {
  transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55), opacity 0.4s ease-in-out;
}
.dialog-fade-enter-from .filter-dialog,
.dialog-fade-leave-to .filter-dialog {
  transform: translateY(50px) scale(0.95);
  opacity: 0;
}

/* Overlay and dialog container */
.filter-dialog-overlay {
  display: flex;
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.65); /* Slightly darker overlay */
  justify-content: center;
  align-items: center;
  z-index: 1000;
  padding: 20px; /* Add padding for smaller screens */
}
.filter-dialog {
  width: 90%;
  max-width: 700px; /* Slightly wider max-width */
  border-radius: 16px; /* More rounded corners */
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15); /* Stronger shadow */
  background-color: #ffffff; /* White background for the dialog content */
  display: flex;
  flex-direction: column;
  max-height: 95vh; /* Allow it to take more vertical space */
  overflow: hidden; /* Ensure content doesn't overflow rounded corners */
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .filter-dialog {
    width: 95vw;
    margin: 10px;
    border-radius: 12px; /* Slightly less rounded on small screens */
  }
  .column-checkboxes {
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); /* Adjust for smaller checkboxes on mobile */
  }
  .my-header h4 {
    font-size: 1.3em;
  }
  .section-title {
    font-size: 1.1em;
  }
}

/* Header styles */
.my-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 30px; /* More padding */
  background: linear-gradient(to right, #88D3D1, #69C5C2);
  color: white;
  border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 16px 16px 0 0; /* Match dialog border-radius */
  flex-shrink: 0;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for header */
}
.my-header h4 {
  margin: 0;
  font-size: 1.6em; /* Slightly larger title */
  font-weight: 700; /* Bolder font weight */
  display: flex;
  align-items: center;
  text-shadow: 1px 2px 4px rgba(0, 0, 0, 0.2); /* More pronounced text shadow */
  letter-spacing: 0.5px;
}
.dialog-icon {
  margin-right: 12px; /* More space for icon */
  font-size: 1.3em; /* Slightly larger icon */
  opacity: 0.9;
}

/* Scrollable form container */
.scrollable-form-container {
  flex-grow: 1;
  overflow-y: auto;
  padding: 25px 30px; /* More padding */
  background-color: #f8f9fa; /* Light background for form content */
}

/* Filter section styles */
.filter-section {
  margin-bottom: 25px; /* More space between sections */
  background-color: #ffffff;
  padding: 25px;
  border-radius: 12px; /* Consistent rounded corners */
  border: 1px solid #e0e0e0;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Nicer shadow */
}

/* Section title */
.section-title {
  margin-top: 0;
  margin-bottom: 20px; /* More space below title */
  color: #69C5C2;
  font-size: 1.35em; /* Larger title */
  font-weight: 700; /* Bolder font weight */
  border-bottom: 3px solid #88D3D1; /* Thicker border */
  padding-bottom: 8px; /* More padding below border */
  position: relative;
  letter-spacing: 0.3px;
}
.section-title::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px; /* Align with border-bottom */
  width: 50px; /* Short accent line */
  height: 3px;
  background-color: #69C5C2;
  border-radius: 2px;
}

/* Checkbox group layout */
.column-checkboxes {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); /* Adjusted min-width for better spacing */
  gap: 15px; /* More gap */
}

/* Individual checkbox styling */
.column-checkbox {
  background-color: #F8FCFB; /* Very light, almost white background */
  border: 1px solid #CFE9E8; /* Lighter primary border */
  border-radius: 10px; /* More rounded */
  padding: 12px 15px; /* More padding */
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); /* Softer transition */
  font-weight: 500;
  color: #333;
  cursor: pointer;
  display: flex; /* Use flex for better alignment of text */
  align-items: center;
}
.column-checkbox:hover {
  transform: translateY(-3px); /* More pronounced lift */
  box-shadow: 0 6px 15px rgba(105, 197, 194, 0.25); /* Stronger primary shadow on hover */
  border-color: #69C5C2;
}
.column-checkbox-label-text {
  white-space: normal;
  word-break: break-word;
  line-height: 1.4; /* Better line height for readability */
}
.column-checkbox.is-checked {
  background-color: #88D3D1; /* Light primary background when checked */
  border-color: #69C5C2; /* Primary border when checked */
  box-shadow: 0 0 0 3px #69C5C2; /* More prominent ring */
  color: white; /* White text when checked for contrast */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

/* Input field styling */
.filter-input-item {
  margin-bottom: 15px; /* More space between inputs */
}
.styled-input .el-input-group__prepend {
  min-width: 140px; /* Wider prepend */
  text-align: right;
  font-weight: 600; /* Bolder font */
  color: #555;
  background-color: #F5F9FB; /* Slightly off-white background */
  border-right: 1px solid #DCE6E9;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding-right: 15px;
  border-radius: 8px 0 0 8px; /* Match input border-radius */
}
.styled-input .el-input__wrapper {
  border-radius: 8px; /* More rounded */
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  padding: 8px 12px; /* Adjust padding for visual balance */
}
/* Input focus style */
.styled-input .el-input__wrapper.is-focus {
  border-color: #69C5C2;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25);
}

/* Dialog footer styles */
.dialog-footer {
  display: flex;
  flex-wrap: wrap;
  justify-content: flex-end;
  gap: 15px; /* More gap between buttons */
  padding: 20px 30px; /* More padding */
  background-color: #f8f9fa;
  border-top: 1px solid #e0e0e0;
  border-radius: 0 0 16px 16px; /* Match dialog border-radius */
  flex-shrink: 0;
  box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05); /* Subtle shadow for footer */
}
.footer-button {
  min-width: 150px; /* Wider buttons */
  padding: 12px 20px; /* More padding */
  font-size: 1.05em; /* Slightly larger font */
  font-weight: bold;
  border-radius: 10px; /* More rounded */
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  text-transform: uppercase; /* Uppercase text */
  letter-spacing: 0.5px;
}

/* Reset button styling */
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
  box-shadow: 0 8px 20px rgba(105, 197, 194, 0.25); /* Stronger shadow on hover */
}

/* Custom styling for the close button to match the primary color */
.el-button--close-custom {
  background-color: rgba(255, 255, 255, 0.2) !important; /* Semi-transparent white */
  border-color: rgba(255, 255, 255, 0.3) !important;
  color: white !important;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.el-button--close-custom:hover,
.el-button--close-custom:focus {
  background-color: rgba(255, 255, 255, 0.35) !important; /* More opaque white on hover */
  border-color: rgba(255, 255, 255, 0.5) !important;
  transform: scale(1.05); /* Slight scale up */
}
</style>
