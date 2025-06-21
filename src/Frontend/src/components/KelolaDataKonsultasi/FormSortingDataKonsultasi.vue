<template>
  <transition name="fade">
    <div v-if="visible" class="form-overlay-wrapper">
      <div class="overlay" @click.self="closeForm"></div>
      <div class="sorting-form-container">
        <button @click="closeForm" class="close-button">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
        <h2 class="form-title">Pengurutan Data Konsultasi</h2>
        <el-form
          :model="form"
          label-position="top"
          class="space-y-6 text-base"
        >
          <el-form-item label="Kolom Data">
            <el-select
              v-model="form.column"
              placeholder="Pilih kolom yang akan diurutkan"
              class="w-full custom-select"
              filterable
              clearable
              size="large"
            >
              <el-option
                v-for="col in columns"
                :key="col"
                :label="formatLabel(col)"
                :value="col"
              />
            </el-select>
          </el-form-item>
          <el-form-item label="Arah Pengurutan">
            <el-radio-group
              v-model="form.order"
              class="flex flex-col gap-3 mt-1 text-gray-700 custom-radio-group"
              size="large"
            >
              <el-radio value="asc">
                <span class="font-medium">Naik</span> (A-Z / 0-9 / Terlama)
              </el-radio>
              <el-radio value="desc">
                <span class="font-medium">Turun</span> (Z-A / 9-0 / Terbaru)
              </el-radio>
            </el-radio-group>
          </el-form-item>
        </el-form>
        <div class="form-actions">
          <el-button
            @click="cancelSort"
            class="custom-cancel-button"
          >
            Batal
          </el-button>
          <el-button
            type="primary"
            @click="applySort"
            class="custom-apply-button"
          >
            Terapkan
          </el-button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup lang="ts">
import { reactive } from 'vue';

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

function formatLabel(key: string): string {
  return key
    .split('_')
    .map(w => w.charAt(0).toUpperCase() + w.slice(1))
    .join(' ');
}

function closeForm(): void {
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
  closeForm();
}

function cancelSort(): void {
  emits('cancel-sort');
  form.column = '';
  form.order = 'asc';
  closeForm();
}
</script>

<style scoped>
/* Transisi fade untuk overlay dan form */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Wrapper untuk overlay dan form, memastikan posisi tetap */
.form-overlay-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

/* Overlay gelap */
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  z-index: 998;
}

/* Kontainer utama formulir */
.sorting-form-container {
  position: relative;
  z-index: 1000;
  background-color: #ffffff;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
  border-radius: 20px;
  padding: 30px;
  max-width: 480px;
  width: 90%;
  font-family: 'Inter', sans-serif;

  /* Animasi masuk */
  animation: slideInFromBottom 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55) forwards;
}

/* Keyframes untuk Animasi "slideInFromBottom" */
@keyframes slideInFromBottom {
  0% {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* Tombol tutup form */
.close-button {
  position: absolute;
  top: 20px;
  right: 20px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  line-height: 1;
  color: #69C5C2;
  transition: transform 0.2s ease-in-out, color 0.2s ease-in-out;
}
.close-button:hover {
  transform: rotate(90deg);
  color: #5AAEA8;
}

/* Judul formulir */
.form-title {
  font-size: 1.8em;
  font-weight: 700;
  color: #333333;
  margin-bottom: 25px;
  padding-bottom: 15px;
  border-bottom: 2px solid #88D3D1;
  position: relative;
  letter-spacing: 0.5px;
}
.form-title::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -2px;
  width: 60px;
  height: 2px;
  background-color: #69C5C2;
  border-radius: 1px;
}

/* Item form */
.el-form-item {
  margin-bottom: 20px;
}
.el-form-item__label {
  font-weight: 600;
  color: #555555;
  margin-bottom: 8px !important;
  font-size: 0.95em;
}

/* Radio button yang terpilih */
.el-radio__input.is-checked + .el-radio__label {
  color: #333333 !important;
  font-weight: 600;
}
.el-radio__input.is-checked .el-radio__inner {
  background-color: #69C5C2 !important;
  border-color: #69C5C2 !important;
}
.el-radio__inner:hover,
.el-radio:hover .el-radio__inner {
  border-color: #88D3D1 !important;
}
.custom-radio-group .el-radio__label {
  font-size: 1.05em;
  line-height: 1.5;
}

/* Input select */
.el-select .el-input__wrapper {
  border-radius: 12px !important;
  padding: 12px 16px !important;
  transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
}
.el-select .el-input__wrapper.is-focused {
  border-color: #69C5C2 !important;
  box-shadow: 0 0 0 4px rgba(105, 197, 194, 0.25) !important;
}
.el-select .el-input__inner {
  font-size: 1.05rem !important;
  color: #333;
}
.el-select .el-select__caret {
  color: #999;
  transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
}
.el-select .el-select__caret.is-reverse {
  color: #69C5C2;
  transform: rotate(180deg);
}

/* Div actions footer */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  padding-top: 25px;
  border-top: 1px solid #f0f0f0;
  margin-top: 30px;
}

/* Tombol Terapkan (Apply) */
.custom-apply-button {
  background: linear-gradient(to right, #88D3D1, #69C5C2);
  border: none;
  color: white;
  padding: 12px 25px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 1.05em;
  box-shadow: 0 4px 12px rgba(105, 197, 194, 0.35);
  transition: all 0.3s ease-in-out;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.custom-apply-button:hover {
  background: linear-gradient(to right, #69C5C2, #5AAEA8);
  box-shadow: 0 6px 18px rgba(105, 197, 194, 0.5);
  transform: translateY(-2px);
}
.custom-apply-button:active {
  background: #69C5C2;
  box-shadow: 0 2px 8px rgba(105, 197, 194, 0.2);
}

/* Tombol Batal (Cancel) */
.custom-cancel-button {
  color: #69C5C2;
  background-color: transparent;
  border: 1px solid #B0E0DF;
  padding: 12px 25px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 1.05em;
  transition: all 0.3s ease-in-out;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.custom-cancel-button:hover {
  background-color: rgba(105, 197, 194, 0.08);
  border-color: #69C5C2;
  color: #69C5C2;
}
.custom-cancel-button:active {
  background-color: rgba(105, 197, 194, 0.15);
  border-color: #5AAEA8;
}

/* Dropdown untuk select (opsi pilihan) */
.el-select-dropdown {
  border-radius: 12px !important;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
  padding: 10px 0 !important;
}
.el-select-dropdown__item {
  font-size: 1rem !important;
  padding: 12px 20px !important;
  transition: background-color 0.2s ease-in-out;
}
.el-select-dropdown__item.hover {
  background-color: rgba(105, 197, 194, 0.1) !important;
  color: #333;
}
.el-select-dropdown__item.selected {
  color: #69C5C2 !important;
  font-weight: 600;
  background-color: rgba(105, 197, 194, 0.15) !important;
}

/* Media queries untuk responsif */
@media (max-width: 600px) {
  .sorting-form-container {
    padding: 20px;
    border-radius: 15px;
  }
  .form-title {
    font-size: 1.5em;
    margin-bottom: 20px;
  }
  .form-actions {
    flex-direction: column;
    gap: 10px;
  }
  .custom-apply-button,
  .custom-cancel-button {
    width: 100%;
    padding: 10px 15px;
    font-size: 1em;
  }
  .close-button {
    top: 15px;
    right: 15px;
  }
}
</style>