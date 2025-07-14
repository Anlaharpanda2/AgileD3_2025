<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">{{ isEdit ? 'Edit Posttest' : 'Buat Posttest Baru' }}</span>
        </div>
      </template>

      <el-form
        :model="posttestForm"
        label-position="top"
        class="space-y-6"
      >
        <el-form-item
          label="Judul Posttest"
          class="mb-4"
        >
          <el-input
            v-model="posttestForm.title"
            placeholder="Masukkan judul posttest"
            class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
          />
        </el-form-item>
        <el-form-item
          label="Deskripsi"
          class="mb-4"
        >
          <el-input
            v-model="posttestForm.description"
            type="textarea"
            autosize
            placeholder="Masukkan deskripsi"
            class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
          />
        </el-form-item>

        <h3 class="text-xl font-semibold mt-8 mb-4 text-gray-800">
          Daftar Soal
        </h3>
        <div
          v-if="posttestForm.questions.length === 0"
          class="text-gray-500 mb-4 p-4 border border-dashed border-gray-300 rounded-md text-center"
        >
          Belum ada soal ditambahkan. Klik "Tambah Soal" untuk memulai.
        </div>
        <div
          v-for="(question, index) in posttestForm.questions"
          :key="question.order || index"
          class="mb-6"
        >
          <QuestionEditor
            :model-value="question"
            @update:model-value="updateQuestion(index, $event)"
            @remove="removeQuestion(index)"
          />
        </div>

        <el-button
          type="primary"
          :icon="Plus"
          class="mt-4 w-full md:w-auto bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="addQuestion"
        >
          Tambah Soal
        </el-button>

        <div class="mt-8 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
          <el-button
            type="success"
            class="w-full md:w-auto bg-green-500 text-white hover:bg-green-600 border-none rounded-md transition-all duration-300 ease-in-out"
            @click="savePosttest"
          >
            {{ isEdit ? 'Perbarui Posttest' : 'Buat Posttest' }}
          </el-button>
          <el-button
            class="w-full md:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out"
            @click="$router.back()"
          >
            Batal
          </el-button>
        </div>
      </el-form>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import { Plus } from '@element-plus/icons-vue';
import QuestionEditor from './QuestionEditor.vue';
import { usePosttestForm } from '@/composables/usePosttestForm';
import posttestService from '@/services/posttestService';

interface Question {
  id?: number;
  question_text: string;
  option_a: string;
  option_b: string;
  option_c: string;
  option_d: string;
  correct_answer: "A" | "B" | "C" | "D";
  order: number;
}

const route = useRoute();
const router = useRouter();
const isEdit = ref(false);
const posttestId = ref<number | null>(null);

const { posttestForm, addQuestion, removeQuestion, setPosttestForm } = usePosttestForm();

const updateQuestion = (index: number, updatedQuestion: Question) => {
  posttestForm.value.questions[index] = updatedQuestion;
};

onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true;
    posttestId.value = Number(route.params.id);
    try {
      const posttest = await posttestService.getPosttestById(posttestId.value);
      setPosttestForm(posttest);
    } catch (error) {
      ElMessage.error('Failed to load posttest data.');
      console.error(error);
    }
  }
});

const savePosttest = async () => {
  // Basic client-side validation
  if (!posttestForm.value.title) {
    ElMessage.error('Judul Posttest wajib diisi.');
    return;
  }
  if (posttestForm.value.questions.length === 0) {
    ElMessage.error('Setidaknya harus ada satu pertanyaan.');
    return;
  }
  for (const question of posttestForm.value.questions) {
    if (!question.question_text || !question.option_a || !question.option_b || !question.option_c || !question.option_d || !question.correct_answer) {
      ElMessage.error('Semua bidang pertanyaan (teks soal, opsi, dan jawaban benar) wajib diisi.');
      return;
    }
  }

  try {
    if (isEdit.value && posttestId.value) {
      await posttestService.updatePosttest(posttestId.value, posttestForm.value);
      ElMessage.success('Posttest updated successfully!');
    } else {
      await posttestService.createPosttest(posttestForm.value);
      ElMessage.success('Posttest created successfully!');
    }
    router.push({ name: 'TaskManagement' }); // Navigate back to list
  } catch (error) {
    ElMessage.error('Failed to save posttest.');
    console.error(error);
  }
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
