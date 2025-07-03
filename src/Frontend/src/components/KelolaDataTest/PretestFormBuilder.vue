<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">{{ isEdit ? 'Edit Pretest' : 'Buat Pretest Baru' }}</span>
        </div>
      </template>

      <el-form :model="pretestForm" label-position="top" class="space-y-6">
        <el-form-item label="Judul Pretest" class="mb-4">
          <el-input v-model="pretestForm.title" placeholder="Masukkan judul pretest" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
        </el-form-item>
        <el-form-item label="Deskripsi" class="mb-4">
          <el-input v-model="pretestForm.description" type="textarea" autosize placeholder="Masukkan deskripsi" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
        </el-form-item>

        <h3 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Daftar Soal</h3>
        <div v-if="pretestForm.questions.length === 0" class="text-gray-500 mb-4 p-4 border border-dashed border-gray-300 rounded-md text-center">
          Belum ada soal ditambahkan. Klik "Tambah Soal" untuk memulai.
        </div>
        <div v-for="(question, index) in pretestForm.questions" :key="question.order || index" class="mb-6">
          <QuestionEditor :question="question" @remove="removeQuestion(index)" />
        </div>

        <el-button type="primary" :icon="Plus" @click="addQuestion" class="mt-4 w-full md:w-auto bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
          Tambah Soal
        </el-button>

        <div class="mt-8 flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
          <el-button type="success" @click="savePretest" class="w-full md:w-auto bg-green-500 text-white hover:bg-green-600 border-none rounded-md transition-all duration-300 ease-in-out">
            {{ isEdit ? 'Perbarui Pretest' : 'Buat Pretest' }}
          </el-button>
          <el-button @click="$router.back()" class="w-full md:w-auto bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out">
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
import { usePretestForm } from '@/composables/usePretestForm';
import pretestService from '@/services/pretestService';

const route = useRoute();
const router = useRouter();
const isEdit = ref(false);
const pretestId = ref<number | null>(null);

const { pretestForm, addQuestion, removeQuestion, setPretestForm } = usePretestForm();

onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true;
    pretestId.value = Number(route.params.id);
    try {
      const pretest = await pretestService.getPretestById(pretestId.value);
      setPretestForm(pretest);
    } catch (error) {
      ElMessage.error('Failed to load pretest data.');
      console.error(error);
    }
  }
});

const savePretest = async () => {
  try {
    if (isEdit.value && pretestId.value) {
      await pretestService.updatePretest(pretestId.value, pretestForm.value);
      ElMessage.success('Pretest updated successfully!');
    } else {
      await pretestService.createPretest(pretestForm.value);
      ElMessage.success('Pretest created successfully!');
    }
    router.push({ name: 'PretestManagement' }); // Navigate back to list
  } catch (error) {
    ElMessage.error('Failed to save pretest.');
    console.error(error);
  }
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
