<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
          <span class="text-2xl font-semibold text-gray-800">Daftar Pretest</span>
          <div class="mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-3">
            <el-button type="info" :icon="Setting" @click="showVisibilityModal = true" class="w-full md:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out">
              Kelola Visibilitas
            </el-button>
            <el-button type="primary" :icon="Plus" @click="$router.push({ name: 'CreatePretest' })" class="w-full md:w-auto bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
              Buat Pretest Baru
            </el-button>
          </div>
        </div>
      </template>

      <el-table :data="pretests" class="w-full text-gray-700 rounded-lg overflow-hidden" border stripe header-cell-class-name="bg-gray-100 text-gray-600 font-semibold" cell-class-name="py-3 px-4">
        <el-table-column prop="title" label="Judul" sortable class-name="font-medium" />
        <el-table-column prop="description" label="Deskripsi" class-name="text-sm text-gray-500" />
        <el-table-column label="Jumlah Soal" width="120" align="center">
          <template #default="scope">
            <span class="text-gray-600">{{ scope.row.questions ? scope.row.questions.length : 0 }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Visibilitas" width="120" align="center">
          <template #default="scope">
            <el-tag :type="scope.row.is_active ? 'success' : 'info'" :class="scope.row.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'" class="rounded-full px-3 py-1 text-xs font-semibold border-none">
              {{ scope.row.is_active ? 'Aktif' : 'Tidak Aktif' }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Aksi" width="250" align="center">
          <template #default="scope">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 justify-center">
              <el-button size="small" @click="viewPretest(scope.row.id)" class="bg-blue-100 text-blue-700 hover:bg-blue-200 border-none rounded-md transition-all duration-300 ease-in-out">
                Lihat
              </el-button>
              <el-button size="small" type="primary" @click="editPretest(scope.row.id)" class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
                Edit
              </el-button>
              <el-button size="small" type="danger" @click="deletePretest(scope.row.id)" class="bg-red-100 text-red-700 hover:bg-red-200 border-none rounded-md transition-all duration-300 ease-in-out">
                Hapus
              </el-button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </el-card>

    <PretestVisibilityModal
      :visible="showVisibilityModal"
      :pretests-data="pretests"
      @update:visible="showVisibilityModal = $event"
      @saved="fetchPretests"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage, ElMessageBox } from 'element-plus';
import { Plus, Setting } from '@element-plus/icons-vue';
import pretestService, { Pretest } from '@/services/pretestService';
import PretestVisibilityModal from './PretestVisibilityModal.vue';

const router = useRouter();
const pretests = ref<Pretest[]>([]);
const showVisibilityModal = ref(false);

const fetchPretests = async () => {
  try {
    pretests.value = await pretestService.getAllPretests();
  } catch (error) {
    ElMessage.error('Failed to fetch pretests.');
    console.error(error);
  }
};

onMounted(() => {
  fetchPretests();
});

const viewPretest = (id: number) => {
  router.push({ name: 'PretestDetail', params: { id } });
};

const editPretest = (id: number) => {
  router.push({ name: 'EditPretest', params: { id } });
};

const deletePretest = async (id: number) => {
  ElMessageBox.confirm(
    'This will permanently delete the pretest. Continue?',
    'Warning',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(async () => {
      try {
        await pretestService.deletePretest(id);
        ElMessage.success('Pretest deleted successfully!');
        fetchPretests(); // Refresh the list
      } catch (error) {
        ElMessage.error('Failed to delete pretest.');
        console.error(error);
      }
    })
    .catch(() => {
      ElMessage.info('Delete canceled');
    });
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
