<template>
  <el-dialog
    v-model="dialogVisible"
    title="Kelola Visibilitas Posttest"
    width="500px"
    @close="onClose"
    class="rounded-lg shadow-xl transition-all duration-300 ease-in-out"
  >
    <div v-if="localPosttests.length > 0" class="p-4">
      <p class="text-sm text-gray-600 mb-4">
        Hanya satu posttest yang dapat aktif pada satu waktu. Mengaktifkan satu posttest akan secara otomatis menonaktifkan yang lain.
      </p>
      <el-table :data="localPosttests" class="w-full text-gray-700 rounded-lg overflow-hidden" border stripe header-cell-class-name="bg-gray-100 text-gray-600 font-semibold" cell-class-name="py-2 px-3">
        <el-table-column prop="title" label="Judul Posttest" />
        <el-table-column label="Aktif" width="100" align="center">
          <template #default="scope">
            <el-switch
              :model-value="scope.row.is_active"
              @change="(newValue) => handleSwitchChange(scope.row, newValue as boolean)"
              class="transition-all duration-300 ease-in-out"
              active-color="#EC4899" 
              inactive-color="#D1D5DB"
            />
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div v-else class="text-center text-gray-500 p-4">
      Tidak ada posttest yang tersedia untuk dikelola.
    </div>

    <template #footer>
      <span class="dialog-footer flex justify-end space-x-3 p-4">
        <el-button @click="closeDialog" class="bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out">
          Batal
        </el-button>
        <el-button type="primary" @click="saveVisibility" :disabled="isSaving" class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
          {{ isSaving ? 'Menyimpan...' : 'Simpan' }}
        </el-button>
      </span>
    </template>
  </el-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { ElMessage } from 'element-plus';
import posttestService, { Posttest } from '@/services/posttestService';

const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },
  posttestsData: {
    type: Array as () => Posttest[],
    required: true,
  },
});

const emit = defineEmits(['update:visible', 'saved']);

const dialogVisible = ref(props.visible);
const localPosttests = ref<Posttest[]>([]);
const isSaving = ref(false);

watch(() => props.visible, (newVal) => {
  dialogVisible.value = newVal;
  if (newVal) {
    localPosttests.value = JSON.parse(JSON.stringify(props.posttestsData));
  }
});

const handleSwitchChange = (changedPosttest: Posttest, newValue: boolean) => {
  localPosttests.value.forEach(posttest => {
    if (posttest.id === changedPosttest.id) {
      posttest.is_active = newValue;
    } else if (newValue) {
      posttest.is_active = false;
    }
  });
};

const saveVisibility = async () => {
  isSaving.value = true;
  try {
    const visibilityUpdates = localPosttests.value.map(p => ({
      id: p.id!,
      is_active: p.is_active || false,
    }));
    await posttestService.updatePosttestVisibility(visibilityUpdates);
    ElMessage.success('Visibilitas posttest berhasil diperbarui!');
    emit('saved');
    closeDialog();
  } catch (error) {
    ElMessage.error('Gagal memperbarui visibilitas posttest.');
    console.error(error);
  } finally {
    isSaving.value = false;
  }
};

const closeDialog = () => {
  emit('update:visible', false);
};

const onClose = () => {
    localPosttests.value = JSON.parse(JSON.stringify(props.posttestsData));
}

</script>
