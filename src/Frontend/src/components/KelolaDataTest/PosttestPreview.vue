<template>
  <div class="p-4">
    <h3 class="text-2xl font-bold text-gray-800 mb-2">
      Mode Pratinjau Posttest (Operator/Pegawai)
    </h3>
    <p class="text-lg text-gray-600 mb-6">
      Anda sedang melihat soal posttest. Fitur pengiriman jawaban tidak tersedia dalam mode ini.
    </p>
    <div
      v-for="(question) in posttest.questions"
      :key="question.id"
      class="border border-gray-200 p-6 mb-4 rounded-lg shadow-sm bg-white transition-all duration-300 ease-in-out hover:shadow-md"
    >
      <h4 class="font-medium text-gray-800 mb-3">
        {{ question.order }}. {{ question.question_text }}
      </h4>
      <ul class="list-none space-y-2 text-gray-700">
        <li><span class="font-semibold">A.</span> {{ question.option_a }}</li>
        <li><span class="font-semibold">B.</span> {{ question.option_b }}</li>
        <li><span class="font-semibold">C.</span> {{ question.option_c }}</li>
        <li><span class="font-semibold">D.</span> {{ question.option_d }}</li>
      </ul>
      <p class="font-bold text-green-600 mt-4">
        Jawaban Benar: {{ question.correct_answer }}
      </p>
    </div>
    <el-button
      type="primary"
      class="mt-6 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
      @click="$router.back()"
    >
      Kembali
    </el-button>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Posttest } from '@/services/posttestService';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<{
  posttest: Posttest;
}>();
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
