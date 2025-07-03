<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card">
      <template #header>
        <div class="card-header">
          <span class="text-xl font-bold">Detail Pretest: {{ pretest.title }}</span>
        </div>
      </template>

      <div v-if="pretest.id">
        <h3 class="text-lg font-semibold mb-2">Deskripsi:</h3>
        <p class="mb-4">{{ pretest.description }}</p>

        <h3 class="text-lg font-semibold mt-6 mb-4">Soal:</h3>
        <div v-if="pretest.questions && pretest.questions.length > 0">
          <div v-for="(question, index) in pretest.questions" :key="question.id || index" class="border p-4 mb-4 rounded-lg shadow-sm bg-gray-50">
            <h4 class="font-medium text-gray-800">{{ question.order }}. {{ question.question_text }}</h4>
            <ul class="list-disc list-inside ml-4 mt-2">
              <li>A. {{ question.option_a }}</li>
              <li>B. {{ question.option_b }}</li>
              <li>C. {{ question.option_c }}</li>
              <li>D. {{ question.option_d }}</li>
            </ul>
            <p class="mt-2 text-sm text-green-600">Jawaban Benar: {{ question.correct_answer }}</p>
          </div>
        </div>
        <div v-else class="text-gray-500">
          Tidak ada soal untuk pretest ini.
        </div>

        <div class="mt-8">
          <el-button type="primary" @click="startPretest">Kerjakan Pretest</el-button>
          <el-button @click="$router.back()">Kembali</el-button>
        </div>
      </div>
      <div v-else class="text-center text-gray-500">
        Memuat detail pretest...
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import pretestService, { Pretest } from '@/services/pretestService';

const route = useRoute();
const router = useRouter();
const pretest = ref<Pretest>({ title: '', description: '', questions: [] });

const pretestId = Number(route.params.id);

onMounted(async () => {
  if (pretestId) {
    try {
      pretest.value = await pretestService.getPretestById(pretestId);
    } catch (error) {
      ElMessage.error('Gagal memuat detail pretest.');
      console.error(error);
    }
  }
});

const startPretest = () => {
  router.push({ name: 'TakePretest', params: { id: pretestId } });
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
