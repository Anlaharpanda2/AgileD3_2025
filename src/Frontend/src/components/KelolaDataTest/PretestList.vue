<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card">
      <template #header>
        <div class="card-header flex justify-between items-center">
          <span class="text-xl font-bold">Pretest List</span>
          <div>
            <el-button type="info" :icon="Setting" @click="showVisibilityModal = true">Manage Visibility</el-button>
            <el-button type="primary" :icon="Plus" @click="$router.push({ name: 'CreatePretest' })">Create New Pretest</el-button>
          </div>
        </div>
      </template>

      <el-table :data="pretests" style="width: 100%" border stripe>
        <el-table-column prop="title" label="Title" sortable />
        <el-table-column prop="description" label="Description" />
        <el-table-column label="Questions Count">
          <template #default="scope">
            {{ scope.row.questions ? scope.row.questions.length : 0 }}
          </template>
        </el-table-column>
        <el-table-column label="Visibility" width="100">
          <template #default="scope">
            <el-tag :type="scope.row.is_active ? 'success' : 'info'">
              {{ scope.row.is_active ? 'Active' : 'Inactive' }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Actions" width="220">
          <template #default="scope">
            <el-button size="small" @click="viewPretest(scope.row.id)">View</el-button>
            <el-button size="small" type="primary" @click="editPretest(scope.row.id)">Edit</el-button>
            <el-button size="small" type="danger" @click="deletePretest(scope.row.id)">Delete</el-button>
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
