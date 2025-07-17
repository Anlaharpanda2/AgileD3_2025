<template>
  <SimpleLayout>
    <div class="container mx-auto p-4">
      <el-card class="box-card">
        <template #header>
          <div class="card-header">
            <span class="text-xl font-bold">Nilai Saya</span>
          </div>
        </template>

        <div
          v-if="isLoading"
          class="text-center text-blue-500 mt-8"
        >
          <p class="text-lg">
            Memuat nilai...
          </p>
        </div>

        <div
          v-else-if="error"
          class="text-center text-red-500 mt-8"
        >
          <p>{{ error }}</p>
        </div>

        <div v-else-if="scoreData">
          <p class="text-lg mb-2">
            Nama: <span class="font-semibold">{{ scoreData.user_name }}</span>
          </p>
          <p class="text-lg mb-2">
            NIK: <span class="font-semibold">{{ scoreData.user_nik }}</span>
          </p>
          <p class="text-lg mb-2">
            Nilai Pretest: <span class="font-semibold">{{ scoreData.pretest_score !== null ? scoreData.pretest_score : 'Belum melaksanakan pretest' }}</span>
          </p>
          <p class="text-lg mb-2">
            Nilai Posttest: <span class="font-semibold">{{ scoreData.posttest_score !== null ? scoreData.posttest_score : 'Belum melaksanakan posttest' }}</span>
          </p>
          <div class="mt-4 flex gap-2">
            <el-button
              v-if="scoreData.pretest_score === null"
              type="primary"
              @click="$router.push({ name: 'TakePretest' })"
            >
              Ikuti Pretest
            </el-button>
            <el-button
              v-if="scoreData.posttest_score === null"
              type="success"
              @click="$router.push({ name: 'TakePosttest' })"
            >
              Ikuti Posttest
            </el-button>
          </div>
        </div>

        <div
          v-else
          class="text-center text-gray-500 mt-8"
        >
          <p class="text-lg">
            Anda belum mengerjakan pretest atau posttest.
          </p>
          <div class="mt-4 flex gap-2">
            <el-button
              type="primary"
              @click="$router.push({ name: 'TakePretest' })"
            >
              Ikuti Pretest
            </el-button>
            <el-button
              type="success"
              @click="$router.push({ name: 'TakePosttest' })"
            >
              Ikuti Posttest
            </el-button>
          </div>
        </div>

        <el-alert
          title="Peringatan: Pretest dan Posttest hanya dapat dilakukan sekali untuk setiap angkatan pada tahun yang sama."
          type="warning"
          show-icon
          :closable="false"
          class="mt-4"
        />

        <div class="mt-8">
          <el-button
            type="primary"
            @click="$router.back()"
          >
            Kembali
          </el-button>
        </div>
      </el-card>
    </div>
  </SimpleLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { ElMessage } from 'element-plus';
import combinedScoreService, { CombinedScore } from '@/services/combinedScoreService';
import SimpleLayout from '@/layouts/SimpleLayout.vue';
import { AxiosError } from 'axios';

const scoreData = ref<CombinedScore | null>(null);
const isLoading = ref(true);
const error = ref<string | null>(null);

onMounted(async () => {
  const userNik = localStorage.getItem('savedNIK');

  if (!userNik) {
    error.value = 'NIK tidak ditemukan di local storage. Silakan login kembali.';
    isLoading.value = false;
    ElMessage.error(error.value);
    return;
  }

  try {
    scoreData.value = await combinedScoreService.getCombinedScoreByNik(userNik);
  } catch (err: unknown) {
    if (err instanceof AxiosError && err.response && err.response.status === 404) {
      scoreData.value = null; // Set scoreData to null to trigger the v-else block
      error.value = null; // Clear error to show the custom message and links
    } else if (err instanceof Error) {
      error.value = `Gagal memuat nilai: ${err.message}`;
    } else {
      error.value = 'Gagal memuat nilai: Terjadi kesalahan tidak dikenal.';
    }
    if (error.value) {
      ElMessage.error(error.value);
    }
    console.error(err);
  } finally {
    isLoading.value = false;
  }
});
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
