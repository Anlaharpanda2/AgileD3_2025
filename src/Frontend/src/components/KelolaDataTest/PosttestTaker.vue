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
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                Kerjakan Posttest: {{ posttest.title }}
              </h3>
              <div class="flex items-center space-x-2 mb-3">
                <div
                  v-if="isMasyarakat"
                  class="px-3 py-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-sm font-medium shadow-sm"
                >
                  Peserta Pelatihan
                </div>
                <div
                  v-else-if="isOperatorOrPegawai"
                  class="px-3 py-1 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-full text-sm font-medium shadow-sm"
                >
                  Operator/Pegawai
                </div>
                <div class="w-2 h-2 bg-gray-300 rounded-full" />
                <span class="text-sm text-gray-500">Mode Pengerjaan</span>
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
                      Pastikan Anda menjawab semua pertanyaan sebelum mengirimkan posttest. Jawaban tidak dapat diubah setelah dikirim.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading State -->
      <div
        v-if="isLoading"
        class="text-center text-blue-500 mt-8"
      >
        <p class="text-lg">
          Memuat data posttest...
        </p>
      </div>

      <!-- Access Denied -->
      <div
        v-else-if="!hasAccess"
        class="text-center text-red-500 mt-8"
      >
        <p class="text-lg">
          Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.
        </p>
        <el-button
          type="primary"
          class="mt-4 back-button"
          @click="$router.push({ name: 'LoginMasyarakat' })"
        >
          Kembali ke Login
        </el-button>
      </div>

      <!-- NIK Not Found -->
      <div
        v-else-if="isMasyarakat && nikNotFound"
        class="text-center text-red-500 mt-8"
      >
        <p class="text-lg">
          Anda tidak terdaftar sebagai peserta pelatihan atau NIK tidak ditemukan.
        </p>
        <el-button
          type="primary"
          class="mt-4 back-button"
          @click="$router.push({ name: 'LoginMasyarakat' })"
        >
          Kembali ke Login
        </el-button>
      </div>

      <!-- No Active Posttest -->
      <div
        v-else-if="noActivePosttest"
        class="text-center text-blue-500 mt-8"
      >
        <p class="text-lg">
          Saat ini tidak ada posttest yang aktif.
        </p>
        <el-button
          type="primary"
          class="mt-4 back-button"
          @click="$router.push('/')"
        >
          Kembali ke Beranda
        </el-button>
      </div>

      <!-- Main Test Area -->
      <div v-else-if="posttest.id">
        <!-- Test Form for Masyarakat -->
        <el-form
          v-if="!isSubmitted && isMasyarakat"
          @submit.prevent="submitPosttest"
        >
          <div class="space-y-6">
            <div
              v-for="(question, index) in posttest.questions"
              :key="question.id"
              class="question-card group"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 overflow-hidden hover:shadow-xl transition-all duration-300">
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
                <div class="p-6">
                  <div class="grid gap-3">
                    <label
                      v-for="(option, optionKey) in getQuestionOptions(question)"
                      :key="optionKey"
                      class="option-item block cursor-pointer"
                    >
                      <input
                        v-model="userAnswers[question.id!]"
                        type="radio"
                        :name="`question-${question.id}`"
                        :value="optionKey.toUpperCase()"
                        class="hidden"
                      >
                      <div
                        class="flex items-start space-x-4 p-4 rounded-xl border transition-all duration-200"
                        :class="{
                          'border-blue-400 bg-blue-50': userAnswers[question.id!] === optionKey.toUpperCase(),
                          'border-gray-200 bg-gray-50 hover:border-gray-300 hover:bg-white': userAnswers[question.id!] !== optionKey.toUpperCase()
                        }"
                      >
                        <div
                          class="option-letter"
                          :class="{
                            'bg-blue-500 text-white': userAnswers[question.id!] === optionKey.toUpperCase(),
                            'bg-gray-100 text-gray-700': userAnswers[question.id!] !== optionKey.toUpperCase()
                          }"
                        >
                          <span class="font-bold text-sm">{{ optionKey.toUpperCase() }}.</span>
                        </div>
                        <div class="flex-1">
                          <p class="text-gray-700 leading-relaxed">
                            {{ option }}
                          </p>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="mt-8 text-center">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-gray-200/50 p-6 flex justify-center space-x-4">
              <el-button
                :disabled="isSubmitting"
                class="submit-button"
                @click="submitPosttest"
              >
                {{ isSubmitting ? 'Menyimpan...' : 'Submit Posttest' }}
              </el-button>
              <el-button
                class="cancel-button"
                @click="$router.back()"
              >
                Batal
              </el-button>
            </div>
          </div>
        </el-form>

        <!-- Submission Success Message -->
        <div
          v-else-if="isSubmitted && isMasyarakat"
          class="text-center mt-8 p-6 bg-green-50 rounded-lg shadow-md"
        >
          <h3 class="text-2xl font-bold text-green-600 mb-2">
            Anda telah melaksanakan posttest!
          </h3>
          <p class="text-lg mt-2 text-gray-700">
            Skor Anda: <span class="font-bold">{{ score }}%</span>
          </p>
          <el-button
            type="primary"
            class="mt-4 back-button"
            @click="$router.push('/')"
          >
            Kembali ke Beranda
          </el-button>
        </div>

        <!-- Preview for Operator/Pegawai -->
        <PosttestPreview
          v-else-if="isOperatorOrPegawai"
          :posttest="posttest"
        />
      </div>

      <!-- Fallback for no posttest data -->
      <div
        v-else
        class="text-center text-gray-500 mt-8"
      >
        Memuat posttest...
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue';
import PosttestPreview from './PosttestPreview.vue';
import { ElMessage } from 'element-plus';
import posttestService, { Posttest } from '@/services/posttestService';
import { AxiosError } from 'axios';

const posttest = ref<Posttest>({ id: undefined, title: '', description: '', questions: [] });
const userAnswers = reactive<{ [key: number]: 'A' | 'B' | 'C' | 'D' | null }>({});
const isSubmitted = ref(false);
const isSubmitting = ref(false);
const score = ref(0);
const totalQuestions = ref(0);

const userNik = ref<string | null>(null);
const userName = ref<string | null>(null);

const nikNotFound = ref(false);
const noActivePosttest = ref(false);

const userRole = ref<string | null>(null);
const isOperatorOrPegawai = ref(false);
const isMasyarakat = ref(false);
const hasAccess = ref(false);
const isLoading = ref(true);

onMounted(async () => {
  userRole.value = localStorage.getItem('role');
  isOperatorOrPegawai.value = userRole.value === 'operator' || userRole.value === 'pegawai';
  isMasyarakat.value = userRole.value === 'masyarakat';
  isLoading.value = true;

  if (isOperatorOrPegawai.value) {
    hasAccess.value = true;
    try {
      const allPosttests = await posttestService.getAllPosttests();
      if (allPosttests.length > 0) {
        const activePosttest = allPosttests.find(p => p.is_active);
        posttest.value = activePosttest || allPosttests[0];
        totalQuestions.value = posttest.value.questions.length;
      } else {
        noActivePosttest.value = true;
        ElMessage.info('Tidak ada posttest yang tersedia untuk ditampilkan.');
      }
    } catch (error) {
      ElMessage.error('Gagal memuat data posttest.');
      console.error(error);
    } finally {
      isLoading.value = false;
    }
  } else if (isMasyarakat.value) {
    userNik.value = localStorage.getItem('savedNIK');
    if (!userNik.value) {
      nikNotFound.value = true;
      hasAccess.value = false;
      isLoading.value = false;
      ElMessage.error('NIK tidak ditemukan di local storage. Silakan login kembali.');
      return;
    }

    try {
      const userInfo = await posttestService.getUserInfoByNik(userNik.value);
      if (!userInfo || userInfo.length === 0 || userInfo[0].status_pendaftaran !== "Diterima") {
        nikNotFound.value = true;
        hasAccess.value = false;
        isLoading.value = false;
        ElMessage.warning('Anda tidak terdaftar sebagai peserta pelatihan atau status pendaftaran Anda belum diterima.');
        return;
      }
      userName.value = userInfo[0].nama;

      const allPosttests = await posttestService.getAllPosttests();
      const activePosttest = allPosttests.find(p => p.is_active);

      if (!activePosttest) {
        noActivePosttest.value = true;
        hasAccess.value = false;
        isLoading.value = false;
        ElMessage.warning('Saat ini tidak ada posttest yang aktif.');
        return;
      }

      posttest.value = activePosttest;
      totalQuestions.value = activePosttest.questions.length;
      activePosttest.questions.forEach(q => {
        if (q.id) {
          userAnswers[q.id] = null;
        }
      });
      hasAccess.value = true;
    } catch (error) {
      ElMessage.error('Gagal memuat data posttest atau pengguna.');
      console.error(error);
      hasAccess.value = false;
    } finally {
      isLoading.value = false;
    }
  } else {
    hasAccess.value = false;
    isLoading.value = false;
    ElMessage.error('Akses ditolak. Peran pengguna tidak dikenali.');
  }
});

const submitPosttest = async () => {
  if (!userNik.value || !userName.value) {
    ElMessage.error('NIK atau Nama pengguna tidak ada. Tidak dapat mengirim posttest.');
    return;
  }

  const unansweredQuestions = Object.values(userAnswers).some(answer => answer === null);
  if (unansweredQuestions) {
    ElMessage.warning('Silakan jawab semua pertanyaan sebelum mengirim.');
    return;
  }

  isSubmitting.value = true;

  const answersToSend = Object.entries(userAnswers).map(([questionId, selectedOption]) => ({
    question_id: Number(questionId),
    selected_option: selectedOption,
  }));

  try {
    const result = await posttestService.submitPosttestAnswers(
      posttest.value.id!,
      answersToSend,
      userNik.value,
      userName.value
    );
    score.value = result.score;
    isSubmitted.value = true;
    ElMessage.success(result.message || 'Posttest berhasil dikirim!');
  } catch (error: unknown) {
    if (error instanceof AxiosError && error.response && error.response.status === 409) {
      ElMessage.warning(error.response.data.message);
    } else {
      ElMessage.error('Gagal mengirim posttest.');
    }
    console.error(error);
  } finally {
    isSubmitting.value = false;
  }
};

const getQuestionOptions = (question: Posttest['questions'][number]) => {
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

.option-item:hover .flex {
  border-color: #f3f4f6;
  background: #ffffff;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
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

/* Responsive */
@media (max-width: 768px) {
  .question-card {
    margin: 0 -1rem;
  }
  
  .option-item .flex {
    padding: 12px;
  }
  
  .submit-button,
  .cancel-button,
  .back-button {
    width: 100%;
    padding: 16px 24px;
  }
}
</style>

<style>
/* Global styles to override element-plus defaults */
</style>