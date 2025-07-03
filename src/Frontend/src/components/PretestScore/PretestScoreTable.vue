<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card">
      <template #header>
        <div class="card-header">
          <span class="text-xl font-bold">Tabel Nilai Peserta</span>
        </div>
      </template>

      <el-table :data="pretestScoreList" style="width: 100%" border stripe v-loading="loading">
        <el-table-column prop="nik" label="NIK" sortable />
        <el-table-column label="Nama Peserta" sortable>
            <template #default="scope">
                {{ scope.row.user ? scope.row.user.name : 'N/A' }}
            </template>
        </el-table-column>
        <el-table-column prop="pretest_score" label="Nilai Pretest" sortable />
        <el-table-column prop="posttest_score" label="Nilai Post-test" sortable>
            <template #default="scope">
                {{ scope.row.posttest_score !== null ? scope.row.posttest_score : 'Belum ada' }}
            </template>
        </el-table-column>
        <el-table-column prop="kategori" label="Kategori" sortable />
        <el-table-column prop="tanggal" label="Tanggal" sortable />
      </el-table>

       <div v-if="error" class="text-center text-red-500 mt-4">
        <p>{{ error }}</p>
      </div>

    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { ElMessage } from 'element-plus';
import pretestScoreService, { PretestScore } from '@/services/pretestScoreService';

const pretestScoreList = ref<PretestScore[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);

const fetchPretestScores = async () => {
  loading.value = true;
  error.value = null;
  try {
    pretestScoreList.value = await pretestScoreService.getAllPretestScores();
  } catch (err) {
    const message = err instanceof Error ? err.message : 'An unknown error occurred';
    error.value = `Gagal memuat data nilai: ${message}`;
    ElMessage.error(error.value);
    console.error(err);
  } finally {
    loading.value = false;
  }
};

onMounted(() => {
  fetchPretestScores();
});
</script>

<style scoped>
/* Tailwind handles most styling */
</style>