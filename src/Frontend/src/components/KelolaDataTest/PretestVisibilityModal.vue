<template>
  <el-dialog
    v-model="dialogVisible"
    title="Kelola Visibilitas Pretest"
    width="500px"
    class="rounded-lg shadow-xl transition-all duration-300 ease-in-out"
    @close="onClose"
  >
    <div
      v-if="localPretests.length > 0"
      class="p-4"
    >
      <p class="text-sm text-gray-600 mb-4">
        Hanya satu pretest yang dapat aktif pada satu waktu. Mengaktifkan satu pretest akan secara otomatis menonaktifkan yang lain.
      </p>
      <el-table
        :data="localPretests"
        class="w-full text-gray-700 rounded-lg overflow-hidden"
        border
        stripe
        header-cell-class-name="bg-gray-100 text-gray-600 font-semibold"
        cell-class-name="py-2 px-3"
      >
        <el-table-column
          prop="title"
          label="Judul Pretest"
        />
        <el-table-column
          label="Aktif"
          width="100"
          align="center"
        >
          <template #default="scope">
            <el-switch
              :model-value="scope.row.is_active"
              class="transition-all duration-300 ease-in-out"
              active-color="#EC4899"
              inactive-color="#D1D5DB" 
              @change="(newValue) => handleSwitchChange(scope.row, newValue as boolean)"
            />
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div
      v-else
      class="text-center text-gray-500 p-4"
    >
      Tidak ada pretest yang tersedia untuk dikelola.
    </div>

    <template #footer>
      <span class="dialog-footer flex justify-end space-x-3 p-4">
        <el-button
          class="bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="closeDialog"
        >
          Batal
        </el-button>
        <el-button
          type="primary"
          :disabled="isSaving"
          class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="saveVisibility"
        >
          {{ isSaving ? 'Menyimpan...' : 'Simpan' }}
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { ElMessage } from 'element-plus';
import pretestService, { Pretest } from '@/services/pretestService';

const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },
  pretestsData: {
    type: Array as () => Pretest[],
    required: true,
  },
});

const emit = defineEmits(['update:visible', 'saved']);

const dialogVisible = ref(props.visible);
const localPretests = ref<Pretest[]>([]);
const isSaving = ref(false);

watch(() => props.visible, (newVal) => {
  dialogVisible.value = newVal;
  if (newVal) {
    // Buat salinan lokal untuk diedit agar tidak mengubah data asli secara langsung
    localPretests.value = JSON.parse(JSON.stringify(props.pretestsData));
  }
});

const handleSwitchChange = (changedPretest: Pretest, newValue: boolean) => {
  localPretests.value.forEach(pretest => {
    if (pretest.id === changedPretest.id) {
      pretest.is_active = newValue;
    } else if (newValue) {
      // Jika pretest lain diaktifkan, matikan yang ini
      pretest.is_active = false;
    }
  });
};

const saveVisibility = async () => {
  isSaving.value = true;
  try {
    const visibilityUpdates = localPretests.value.map(p => ({
      id: p.id!,
      is_active: p.is_active || false,
    }));
    await pretestService.updatePretestVisibility(visibilityUpdates);
    ElMessage.success('Visibilitas pretest berhasil diperbarui!');
    emit('saved');
    closeDialog();
  } catch (error) {
    ElMessage.error('Gagal memperbarui visibilitas pretest.');
    console.error(error);
  } finally {
    isSaving.value = false;
  }
};

const closeDialog = () => {
  emit('update:visible', false);
};

const onClose = () => {
    // Reset state when dialog is closed without saving
    localPretests.value = JSON.parse(JSON.stringify(props.pretestsData));
}

</script>
