<template>
  <div class="border p-4 mb-4 rounded-lg shadow-sm bg-white">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Question {{ question.order }}</h3>
      <el-button type="danger" :icon="Delete" circle @click="$emit('remove')" />
    </div>

    <el-form-item label="Question Text">
      <el-input v-model="question.question_text" type="textarea" autosize placeholder="Enter question text" />
    </el-form-item>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
      <el-form-item label="Option A">
        <el-input v-model="question.option_a" placeholder="Option A" />
      </el-form-item>
      <el-form-item label="Option B">
        <el-input v-model="question.option_b" placeholder="Option B" />
      </el-form-item>
      <el-form-item label="Option C">
        <el-input v-model="question.option_c" placeholder="Option C" />
      </el-form-item>
      <el-form-item label="Option D">
        <el-input v-model="question.option_d" placeholder="Option D" />
      </el-form-item>
    </div>

    <el-form-item label="Correct Answer" class="mt-4">
      <el-radio-group v-model="question.correct_answer">
        <el-radio label="A">A</el-radio>
        <el-radio label="B">B</el-radio>
        <el-radio label="C">C</el-radio>
        <el-radio label="D">D</el-radio>
      </el-radio-group>
    </el-form-item>
  </div>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { Question } from '@/services/pretestService';
import { ElInput, ElButton, ElFormItem, ElRadioGroup, ElRadio } from 'element-plus';
import { Delete } from '@element-plus/icons-vue';

const props = defineProps({
  question: {
    type: Object as PropType<Question>,
    required: true,
  },
});

const emit = defineEmits(['remove']);
</script>

<style scoped>
/* Tailwind handles most styling, but you can add custom styles here if needed */
</style>
