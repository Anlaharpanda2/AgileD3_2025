<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-pink-50 p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 p-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg
                  class="w-6 h-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                  />
                </svg>
              </div>
              <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                  Tabel Nilai Peserta
                </h1>
                <p class="text-gray-500 mt-1">
                  Monitoring hasil pretest dan posttest peserta
                </p>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <div class="px-4 py-2 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg font-medium shadow-md">
                {{ combinedScoreList.length }} Peserta
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 overflow-hidden">
        <div class="p-6 border-b border-gray-200/50">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
              <div class="w-2 h-2 bg-pink-500 rounded-full animate-pulse" />
              <span class="text-lg font-semibold text-gray-700">Data Nilai Peserta</span>
            </div>
            <div
              v-if="loading"
              class="flex items-center space-x-2 text-gray-500"
            >
              <svg
                class="animate-spin w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                />
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                />
              </svg>
              <span class="text-sm">Memuat data...</span>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <el-table
            v-loading="loading"
            :data="combinedScoreList"
            class="w-full modern-table"
            stripe
            :row-class-name="getRowClassName"
            element-loading-text="Memuat data nilai..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(255, 255, 255, 0.8)"
            @row-click="handleRowClick"
          >
            <el-table-column
              prop="user_nik"
              label="NIK"
              sortable
              min-width="140"
              class-name="nik-column"
            >
              <template #default="scope">
                <div class="flex items-center space-x-3">
                  <div class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                    <svg
                      class="w-4 h-4 text-gray-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0v1m4-1v1"
                      />
                    </svg>
                  </div>
                  <span class="font-mono text-sm font-medium text-gray-700">{{ scope.row.user_nik }}</span>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              prop="user_name"
              label="Nama Peserta"
              sortable
              min-width="200"
              class-name="name-column"
            >
              <template #default="scope">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-500 rounded-full flex items-center justify-center shadow-md">
                    <span class="text-white font-semibold text-sm">
                      {{ scope.row.user_name.charAt(0).toUpperCase() }}
                    </span>
                  </div>
                  <div>
                    <p class="font-semibold text-gray-800">
                      {{ scope.row.user_name }}
                    </p>
                    <p class="text-xs text-gray-500">
                      Peserta
                    </p>
                  </div>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              label="Nilai Pretest"
              sortable
              align="center"
              min-width="180"
              class-name="score-column"
            >
              <template #default="scope">
                <div class="flex flex-col items-center space-y-1">
                  <div
                    v-if="scope.row.pretest_score !== null"
                    class="score-badge success"
                  >
                    <div class="flex items-center space-x-2">
                      <svg
                        class="w-4 h-4 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      <span class="font-bold text-green-700">{{ scope.row.pretest_score }}%</span>
                    </div>
                  </div>
                  <div
                    v-else
                    class="score-badge pending"
                  >
                    <div class="flex items-center space-x-2">
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                  </div>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              label="Nilai Posttest"
              sortable
              align="center"
              min-width="180"
              class-name="score-column"
            >
              <template #default="scope">
                <div class="flex flex-col items-center space-y-1">
                  <div
                    v-if="scope.row.posttest_score !== null"
                    class="score-badge success"
                  >
                    <div class="flex items-center space-x-2">
                      <svg
                        class="w-4 h-4 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      <span class="font-bold text-green-700">{{ scope.row.posttest_score }}%</span>
                    </div>
                  </div>
                  <div
                    v-else
                    class="score-badge pending"
                  >
                    <div class="flex items-center space-x-2">
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                      </svg>
                      <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                  </div>
                </div>
              </template>
            </el-table-column>

            <el-table-column
              label="Status"
              align="center"
              min-width="120"
            >
              <template #default="scope">
                <div class="flex justify-center">
                  <div
                    v-if="scope.row.pretest_score !== null && scope.row.posttest_score !== null"
                    class="px-3 py-1 bg-gradient-to-r from-green-400 to-green-500 text-white rounded-full text-xs font-medium shadow-sm"
                  >
                    Selesai
                  </div>
                  <div
                    v-else-if="scope.row.pretest_score !== null || scope.row.posttest_score !== null"
                    class="px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-full text-xs font-medium shadow-sm"
                  >
                    Proses
                  </div>
                  <div
                    v-else
                    class="px-3 py-1 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-full text-xs font-medium shadow-sm"
                  >
                    Belum Mulai
                  </div>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>

        <!-- Empty State -->
        <div
          v-if="!loading && combinedScoreList.length === 0"
          class="text-center py-12"
        >
          <svg
            class="w-16 h-16 text-gray-300 mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
          <p class="text-gray-500 text-lg font-medium">
            Belum ada data nilai
          </p>
          <p class="text-gray-400 text-sm mt-1">
            Data akan muncul setelah peserta mengikuti tes
          </p>
        </div>

        <!-- Error State -->
        <div
          v-if="error"
          class="p-6 bg-red-50 border-l-4 border-red-500 mx-6 mb-6 rounded-r-lg"
        >
          <div class="flex items-center space-x-3">
            <svg
              class="w-5 h-5 text-red-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            <div>
              <p class="font-semibold text-red-800">
                Terjadi Kesalahan
              </p>
              <p class="text-red-600 text-sm">
                {{ error }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
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

const getRowClassName = () => {
  return 'table-row-hover';
};

onMounted(() => {
  fetchCombinedScores();
});
</script>

<style scoped>
.modern-table {
  border-radius: 0;
  border: none;
}

.modern-table :deep(.el-table__header) {
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.modern-table :deep(.el-table__header th) {
  background: transparent;
  border-bottom: 2px solid #e2e8f0;
  color: #475569;
  font-weight: 600;
  padding: 16px 12px;
  font-size: 14px;
}

.modern-table :deep(.el-table__body tr) {
  transition: all 0.2s ease;
  cursor: pointer;
}

.modern-table :deep(.el-table__body tr.table-row-hover:hover) {
  background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.1);
}

.modern-table :deep(.el-table__body td) {
  border-bottom: 1px solid #f1f5f9;
  padding: 16px 12px;
  vertical-align: middle;
}

.modern-table :deep(.el-table__body tr:last-child td) {
  border-bottom: none;
}

.modern-table :deep(.el-table--striped .el-table__body tr.el-table__row--striped) {
  background: #fbfcfd;
}

.score-badge {
  padding: 8px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  min-width: 80px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.score-badge.success {
  background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
  border: 1px solid #86efac;
}

.score-badge.pending {
  background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
  border: 1px solid #d1d5db;
}

.score-badge:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Loading animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.modern-table :deep(.el-table__body tr) {
  animation: fadeIn 0.3s ease forwards;
}

/* Responsive */
@media (max-width: 768px) {
  .modern-table :deep(.el-table__header th),
  .modern-table :deep(.el-table__body td) {
    padding: 12px 8px;
    font-size: 12px;
  }
  
  .score-badge {
    min-width: 60px;
    padding: 6px 8px;
    font-size: 11px;
  }
}
</style>