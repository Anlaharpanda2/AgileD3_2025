<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-pink-50 p-6">
    <div class="max-w-4xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200/50 p-6">
          <div class="flex items-start space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
              <svg
                class="w-8 h-8 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Mode Pratinjau Pretest
              </h3>
              <div class="flex items-center space-x-2 mb-3">
                <div class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-sm font-medium shadow-sm">
                  Operator/Pegawai
                </div>
                <div class="w-2 h-2 bg-gray-300 rounded-full" />
                <span class="text-sm text-gray-500">Mode Pratinjau</span>
              </div>
              <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                  <svg
                    class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                    />
                  </svg>
                  <div>
                    <p class="text-yellow-800 font-medium text-sm">
                      Perhatian
                    </p>
                    <p class="text-yellow-700 text-sm mt-1">
                      Anda sedang melihat soal pretest dalam mode pratinjau. Fitur pengiriman jawaban tidak tersedia dalam mode ini.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Questions Section -->
      <div class="space-y-6">
        <div
          v-for="(question, index) in pretest.questions"
          :key="question.id"
          class="question-card group"
          :style="{ animationDelay: `${index * 0.1}s` }"
        >
          <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden hover:shadow-xl transition-all duration-300">
            <!-- Question Header -->
            <div class="bg-gradient-to-r from-gray-50 to-pink-50 p-6 border-b border-gray-200/50">
              <div class="flex items-start space-x-4">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                  <span class="text-white font-bold text-lg">{{ question.order }}</span>
                </div>
                <div class="flex-1">
                  <h4 class="text-lg font-semibold text-gray-800 leading-relaxed">
                    {{ question.question_text }}
                  </h4>
                </div>
              </div>
            </div>

            <!-- Options -->
            <div class="p-6">
              <div class="grid gap-3">
                <div
                  v-for="(option, optionKey) in getQuestionOptions(question)"
                  :key="optionKey"
                  class="option-item"
                  :class="{ 'correct-answer': optionKey.toUpperCase() === question.correct_answer }"
                >
                  <div class="flex items-start space-x-4 p-4 rounded-xl border transition-all duration-200">
                    <div class="option-letter">
                      <span class="font-bold text-sm">{{ optionKey.toUpperCase() }}.</span>
                    </div>
                    <div class="flex-1">
                      <p class="text-gray-700 leading-relaxed">
                        {{ option }}
                      </p>
                    </div>
                    <div
                      v-if="optionKey.toUpperCase() === question.correct_answer"
                      class="correct-indicator"
                    >
                      <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                        <svg
                          class="w-3 h-3 text-white"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="3"
                            d="M5 13l4 4L19 7"
                          />
                        </svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Correct Answer Badge -->
              <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl">
                <div class="flex items-center space-x-3">
                  <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                    <svg
                      class="w-4 h-4 text-white"
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
                  </div>
                  <div>
                    <p class="text-green-800 font-semibold text-sm">
                      Jawaban Benar
                    </p>
                    <p class="text-green-700 text-sm">
                      Opsi {{ question.correct_answer.toUpperCase() }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Button -->
      <div class="mt-8 text-center">
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 p-6">
          <el-button
            type="primary"
            size="large"
            class="back-button"
            @click="$router.back()"
          >
            <svg
              class="w-5 h-5 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              />
            </svg>
            Kembali ke Halaman Sebelumnya
          </el-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { Pretest, Question } from '@/services/pretestService';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const props = defineProps<{
  pretest: Pretest;
}>();

const getQuestionOptions = (question: Question) => {
  return {
    a: question.option_a,
    b: question.option_b,
    c: question.option_c,
    d: question.option_d,
  };
};
</script>

<style scoped>
.question-card {
  animation: slideInUp 0.6s ease-out forwards;
  opacity: 0;
  transform: translateY(20px);
}

@keyframes slideInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.option-item {
  transition: all 0.3s ease;
}

.option-item:hover {
  transform: translateX(4px);
}

.option-item .flex {
  border: 2px solid #e5e7eb;
  background: #fafafa;
}

.option-item:hover .flex {
  border-color: #f3f4f6;
  background: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.option-item.correct-answer .flex {
  background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
  border-color: #86efac;
}

.option-item.correct-answer:hover .flex {
  background: linear-gradient(135deg, #bbf7d0 0%, #a7f3d0 100%);
  border-color: #6ee7b7;
}

.option-letter {
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e2e8f0;
  flex-shrink: 0;
}

.option-item.correct-answer .option-letter {
  background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
  border-color: #16a34a;
  color: white;
}

.correct-indicator {
  animation: bounceIn 0.5s ease-out;
}

@keyframes bounceIn {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  50% {
    transform: scale(1.1);
    opacity: 1;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.back-button {
  background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
  border: none;
  color: white;
  padding: 12px 32px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 16px;
  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
  transition: all 0.3s ease;
}

.back-button:hover {
  background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
}

.back-button:active {
  transform: translateY(0);
  box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
  .question-card {
    margin: 0 -1rem;
  }
  
  .option-item .flex {
    padding: 12px;
  }
  
  .back-button {
    width: 100%;
    padding: 16px 24px;
  }
}
</style>