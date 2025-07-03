<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">Tabel Nilai Peserta</span>
        </div>
      </template>

      <el-table :data="combinedScoreList" class="w-full text-gray-700 rounded-lg overflow-hidden" border stripe v-loading="loading" @row-click="handleRowClick" header-cell-class-name="bg-gray-100 text-gray-600 font-semibold" cell-class-name="py-3 px-4">
        <el-table-column prop="user_nik" label="NIK" sortable class-name="font-medium" />
        <el-table-column prop="user_name" label="Nama Peserta" sortable class-name="font-medium" />
        <el-table-column label="Nilai Pretest" sortable align="center">
          <template #default="scope">
            <span :class="{'text-green-600 font-semibold': scope.row.pretest_score !== null, 'text-gray-500 italic': scope.row.pretest_score === null}">
              {{ scope.row.pretest_score !== null ? scope.row.pretest_score + '%' : 'Belum melaksanakan pretest' }}
            </span>
          </template>
        </el-table-column>
        <el-table-column label="Nilai Posttest" sortable align="center">
          <template #default="scope">
            <span :class="{'text-green-600 font-semibold': scope.row.posttest_score !== null, 'text-gray-500 italic': scope.row.posttest_score === null}">
              {{ scope.row.posttest_score !== null ? scope.row.posttest_score + '%' : 'Belum melaksanakan posttest' }}
            </span>
          </template>
        </el-table-column>
      </el-table>

       <div v-if="error" class="text-center text-red-500 mt-4">
        <p>{{ error }}</p>
      </div>

    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import combinedScoreService, { CombinedScore } from '@/services/combinedScoreService';

const router = useRouter();

const combinedScoreList = ref<CombinedScore[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const fetchCombinedScores = async () => {
  loading.value = true;
  error.value = null;
  try {
    combinedScoreList.value = await combinedScoreService.getAllCombinedScores();
  } catch (err) {
    const message = err instanceof Error ? err.message : 'An unknown error occurred';
    error.value = `Gagal memuat data nilai: ${message}`;
    ElMessage.error(error.value);
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const handleRowClick = (row: CombinedScore) => {
  router.push({ name: 'DetailMasyarakat', params: { id: row.user_nik } });
};

onMounted(() => {
  fetchCombinedScores();
});
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
