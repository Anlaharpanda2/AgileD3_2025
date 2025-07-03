<template>
  <Layout2>
    <div class="container mx-auto p-4">
      <el-card class="shadow-lg rounded-lg bg-white">
        <template #header>
          <div class="flex items-center justify-between mb-4">
            <span class="text-2xl font-semibold text-gray-800">Detail Pretest: {{ pretest.title }}</span>
          </div>
        </template>

        <div v-if="pretest.id">
          <h3 class="text-xl font-semibold mb-3 text-gray-800">Deskripsi:</h3>
          <p class="mb-6 text-gray-700">{{ pretest.description }}</p>

          <h3 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Soal:</h3>
          <div v-if="pretest.questions && pretest.questions.length > 0">
            <div v-for="(question, index) in pretest.questions" :key="question.id || index" class="border border-gray-200 p-6 mb-4 rounded-lg shadow-sm bg-gray-50 transition-all duration-300 ease-in-out hover:shadow-md">
              <h4 class="font-medium text-gray-800 mb-3">{{ question.order }}. {{ question.question_text }}</h4>
              <ul class="list-none space-y-2 text-gray-700">
                <li><span class="font-semibold">A.</span> {{ question.option_a }}</li>
                <li><span class="font-semibold">B.</span> {{ question.option_b }}</li>
                <li><span class="font-semibold">C.</span> {{ question.option_c }}</li>
                <li><span class="font-semibold">D.</span> {{ question.option_d }}</li>
              </ul>
              <p class="mt-4 text-sm font-bold text-green-600">Jawaban Benar: {{ question.correct_answer }}</p>
            </div>
          </div>
          <div v-else class="text-gray-500 p-4 border border-dashed border-gray-300 rounded-md text-center">
            Tidak ada soal untuk pretest ini.
          </div>

          <div class="mt-8 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
            <el-button type="primary" @click="startPretest" class="w-full md:w-auto bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
              Kerjakan Pretest
            </el-button>
            <el-button @click="$router.back()" class="w-full md:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out">
              Kembali
            </el-button>
          </div>
        </div>
        <div v-else class="text-center text-gray-500 mt-8">
          Memuat detail pretest...
        </div>
      </el-card>
    </div>
  </Layout2>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import pretestService, { Pretest } from '@/services/pretestService';
import Layout2 from '@/layouts/Layout2.vue';

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
