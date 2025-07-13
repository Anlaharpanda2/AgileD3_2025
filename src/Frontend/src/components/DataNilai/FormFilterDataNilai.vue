<template>
  <el-dialog
    v-model="dialogVisible"
    title="Filter Data Nilai"
    width="30%"
    @close="handleClose"
  >
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Kolom</label>
        <el-select v-model="filterColumn" placeholder="Pilih Kolom" class="w-full">
          <el-option
            v-for="col in filterableColumns"
            :key="col.value"
            :label="col.label"
            :value="col.value"
          />
        </el-select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Nilai</label>
        <el-input
          v-model="filterValue"
          placeholder="Masukkan nilai filter"
          clearable
          @keyup.enter="submitFilter"
        />
      </div>
    </div>
    <template #footer>
      <span class="dialog-footer">
        <el-button @click="handleClose">Batal</el-button>
        <el-button type="primary" @click="submitFilter">Terapkan Filter</el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
  visible: boolean;
  filterableColumns: Array<{ label: string; value: string }>;
}>();

const emit = defineEmits(['update:visible', 'apply-filter']);

const dialogVisible = ref(props.visible);
const filterColumn = ref('user_name');
const filterValue = ref('');

watch(() => props.visible, (newValue) => {
  dialogVisible.value = newValue;
});

const handleClose = () => {
  emit('update:visible', false);
};

const submitFilter = () => {
  emit('apply-filter', { column: filterColumn.value, value: filterValue.value });
  handleClose();
};
</script>
