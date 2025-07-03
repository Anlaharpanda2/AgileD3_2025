<template>
  <div class="border border-gray-200 p-6 rounded-lg shadow-sm bg-white transition-all duration-300 ease-in-out hover:shadow-md">
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-lg font-semibold text-gray-800">Soal {{ question.order }}</h3>
      <el-button type="danger" :icon="Delete" circle @click="$emit('remove')" class="bg-red-100 text-red-700 hover:bg-red-200 border-none transition-all duration-300 ease-in-out" />
    </div>

    <el-form-item label="Teks Soal" class="mb-4">
      <el-input v-model="question.question_text" type="textarea" autosize placeholder="Masukkan teks soal" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
    </el-form-item>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
      <el-form-item label="Opsi A">
        <el-input v-model="question.option_a" placeholder="Opsi A" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
      </el-form-item>
      <el-form-item label="Opsi B">
        <el-input v-model="question.option_b" placeholder="Opsi B" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
      </el-form-item>
      <el-form-item label="Opsi C">
        <el-input v-model="question.option_c" placeholder="Opsi C" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
      </el-form-item>
      <el-form-item label="Opsi D">
        <el-input v-model="question.option_d" placeholder="Opsi D" class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50" />
      </el-form-item>
    </div>

    <el-form-item label="Jawaban Benar" class="mt-4">
      <el-radio-group v-model="question.correct_answer" class="flex flex-wrap gap-4">
        <el-radio label="A" class="el-radio-custom">A</el-radio>
        <el-radio label="B" class="el-radio-custom">B</el-radio>
        <el-radio label="C" class="el-radio-custom">C</el-radio>
        <el-radio label="D" class="el-radio-custom">D</el-radio>
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
