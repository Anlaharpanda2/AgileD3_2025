<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card">
      <template #header>
        <div class="card-header">
          <span class="text-xl font-bold">{{ isEdit ? 'Edit Pretest' : 'Create New Pretest' }}</span>
        </div>
      </template>

      <el-form :model="pretestForm" label-position="top">
        <el-form-item label="Pretest Title">
          <el-input v-model="pretestForm.title" placeholder="Enter pretest title" />
        </el-form-item>
        <el-form-item label="Description">
          <el-input v-model="pretestForm.description" type="textarea" autosize placeholder="Enter description" />
        </el-form-item>

        <h3 class="text-lg font-semibold mt-6 mb-4">Questions</h3>
        <div v-if="pretestForm.questions.length === 0" class="text-gray-500 mb-4">
          No questions added yet. Click "Add Question" to start.
        </div>
        <div v-for="(question, index) in pretestForm.questions" :key="question.order || index">
          <QuestionEditor :question="question" @remove="removeQuestion(index)" />
        </div>

        <el-button type="primary" :icon="Plus" @click="addQuestion" class="mt-4">Add Question</el-button>

        <div class="mt-8">
          <el-button type="success" @click="savePretest">{{ isEdit ? 'Update Pretest' : 'Create Pretest' }}</el-button>
          <el-button @click="$router.back()">Cancel</el-button>
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
