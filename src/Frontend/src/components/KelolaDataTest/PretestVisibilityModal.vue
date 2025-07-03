<template>
  <el-dialog
    v-model="dialogVisible"
    title="Kelola Visibilitas Pretest"
    width="500px"
    @close="onClose"
  >
    <div v-if="localPretests.length > 0">
      <p class="text-sm text-gray-600 mb-4">
        Hanya satu pretest yang dapat aktif pada satu waktu. Mengaktifkan satu pretest akan secara otomatis menonaktifkan yang lain.
      </p>
      <el-table :data="localPretests" style="width: 100%">
        <el-table-column prop="title" label="Judul Pretest" />
        <el-table-column label="Aktif" width="100">
          <template #default="scope">
            <el-switch
              :model-value="scope.row.is_active"
              @change="(newValue) => handleSwitchChange(scope.row, newValue as boolean)"
            />
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div v-else class="text-center text-gray-500">
      Tidak ada pretest yang tersedia untuk dikelola.
    </div>

    <template #footer>
      <span class="dialog-footer">
        <el-button @click="closeDialog">Batal</el-button>
        <el-button type="primary" @click="saveVisibility" :disabled="isSaving">
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
