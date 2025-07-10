<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">Kerjakan Pretest: {{ pretest.title }}</span>
        </div>
      </template>

      <div
        v-if="isLoading"
        class="text-center text-blue-500 mt-8"
      >
        <p class="text-lg">
          Memuat data pretest...
        </p>
      </div>

      <div
        v-else-if="!hasAccess"
        class="text-center text-red-500 mt-8"
      >
        <p class="text-lg">
          Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.
        </p>
        <el-button
          type="primary"
          class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="$router.push({ name: 'LoginMasyarakat' })"
        >
          Kembali ke Login
        </el-button>
      </div>

      <div
        v-else-if="isMasyarakat && nikNotFound"
        class="text-center text-red-500 mt-8"
      >
        <p class="text-lg">
          Anda tidak terdaftar sebagai peserta pelatihan atau NIK tidak ditemukan.
        </p>
        <el-button
          type="primary"
          class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="$router.push({ name: 'LoginMasyarakat' })"
        >
          Kembali ke Login
        </el-button>
      </div>

      <div
        v-else-if="noActivePretest"
        class="text-center text-blue-500 mt-8"
      >
        <p class="text-lg">
          Saat ini tidak ada pretest yang aktif.
        </p>
        <el-button
          type="primary"
          class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="$router.push('/')"
        >
          Kembali ke Beranda
        </el-button>
      </div>

      <div v-else-if="pretest.id">
        <p class="mb-4 text-gray-700">
          {{ pretest.description }}
        </p>

        <el-form
          v-if="!isSubmitted && isMasyarakat"
          @submit.prevent="submitPretest"
        >
          <div
            v-for="(question) in pretest.questions"
            :key="question.id"
            class="border border-gray-200 p-4 mb-4 rounded-lg shadow-sm bg-gray-50 transition-all duration-300 ease-in-out hover:shadow-md"
          >
            <h4 class="font-medium text-gray-800 mb-3">
              {{ question.order }}. {{ question.question_text }}
            </h4>
            <el-radio-group
              v-model="userAnswers[question.id!]"
              class="flex flex-col space-y-2"
            >
              <el-radio
                value="A"
                class="el-radio-custom"
              >
                A. {{ question.option_a }}
              </el-radio>
              <el-radio
                value="B"
                class="el-radio-custom"
              >
                B. {{ question.option_b }}
              </el-radio>
              <el-radio
                value="C"
                class="el-radio-custom"
              >
                C. {{ question.option_c }}
              </el-radio>
              <el-radio
                value="D"
                class="el-radio-custom"
              >
                D. {{ question.option_d }}
              </el-radio>
            </el-radio-group>
          </div>

          <div class="mt-8 flex space-x-4">
            <el-button
              type="success"
              :disabled="isSubmitting"
              class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
              @click="submitPretest"
            >
              {{ isSubmitting ? 'Menyimpan...' : 'Submit Pretest' }}
            </el-button>
            <el-button
              class="bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out"
              @click="$router.back()"
            >
              Batal
            </el-button>
          </div>
        </el-form>

        <div
          v-else-if="isSubmitted && isMasyarakat"
          class="text-center mt-8 p-6 bg-green-50 rounded-lg shadow-md"
        >
          <h3 class="text-2xl font-bold text-green-600 mb-2">
            Anda telah melaksanakan pretest!
          </h3>
          <p class="text-lg mt-2 text-gray-700">
            Skor Anda: <span class="font-bold">{{ score }}%</span>
          </p>
          <el-button
            type="primary"
            class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
            @click="$router.push('/')"
          >
            Kembali ke Beranda
          </el-button>
        </div>

        <PretestPreview
          v-else-if="isOperatorOrPegawai"
          :pretest="pretest"
        />
      </div>
      <div
        v-else
        class="text-center text-gray-500 mt-8"
      >
        Memuat pretest...
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue';
import PretestPreview from './PretestPreview.vue';
import { ElMessage } from 'element-plus';
import pretestService, { Pretest } from '@/services/pretestService';
import { AxiosError } from 'axios';



const pretest = ref<Pretest>({ id: undefined, title: '', description: '', questions: [] });
const userAnswers = reactive<{ [key: number]: 'A' | 'B' | 'C' | 'D' | null }>({});
const isSubmitted = ref(false);
const isSubmitting = ref(false);
const score = ref(0);
const totalQuestions = ref(0);

const userNik = ref<string | null>(null);
const userName = ref<string | null>(null);

const nikNotFound = ref(false); // Used for masyarakat role
const noActivePretest = ref(false); // Used for masyarakat role

const userRole = ref<string | null>(null);
const isOperatorOrPegawai = ref(false);
const isMasyarakat = ref(false);
const hasAccess = ref(false); // General access to the page content
const isLoading = ref(true);

onMounted(async () => {
  userRole.value = localStorage.getItem('role');
  isOperatorOrPegawai.value = userRole.value === 'operator' || userRole.value === 'pegawai';
  isMasyarakat.value = userRole.value === 'masyarakat';

  if (isOperatorOrPegawai.value) {
    hasAccess.value = true;
    try {
      // For operators/pegawai, just fetch all pretests and display the first one
      // or the one specified by route param if applicable (though current route is /pretests)
      const allPretests = await pretestService.getAllPretests();
      if (allPretests.length > 0) {
        // If there's an active pretest, show that. Otherwise, show the first one.
        const activePretest = allPretests.find(p => p.is_active);
        pretest.value = activePretest || allPretests[0];
        totalQuestions.value = pretest.value.questions.length;
        pretest.value.questions.forEach(q => {
          if (q.id) {
            userAnswers[q.id] = null; // Initialize answers for display
          }
        });
      } else {
        noActivePretest.value = true; // No pretests available at all
        ElMessage.info('Tidak ada pretest yang tersedia untuk ditampilkan.');
      }
    } catch (error) {
      ElMessage.error('Gagal memuat data pretest.');
      console.error(error);
      hasAccess.value = false; // Revoke access if fetching fails
    } finally {
      isLoading.value = false;
    }
  } else if (isMasyarakat.value) {
    userNik.value = localStorage.getItem('savedNIK');
    if (!userNik.value) {
      nikNotFound.value = true;
      ElMessage.error('NIK tidak ditemukan di local storage. Silakan login kembali.');
      hasAccess.value = false;
      return;
    }

    try {
      // 1. Validasi NIK pengguna
      const userInfo = await pretestService.getUserInfoByNik(userNik.value);
      if (userInfo && userInfo.length > 0 && userInfo[0].status_pendaftaran === "Diterima") {
        userName.value = userInfo[0].nama;
      } else {
        nikNotFound.value = true;
        ElMessage.warning('Anda tidak terdaftar sebagai peserta pelatihan atau status pendaftaran Anda belum diterima.');
        hasAccess.value = false;
        return;
      }

      // 2. Ambil semua pretest dan cari yang aktif
      const allPretests = await pretestService.getAllPretests();
      const activePretest = allPretests.find(p => p.is_active);

      if (!activePretest) {
        noActivePretest.value = true;
        ElMessage.warning('Saat ini tidak ada pretest yang aktif.');
        hasAccess.value = false;
        return;
      }

      pretest.value = activePretest;
      totalQuestions.value = activePretest.questions.length;
      activePretest.questions.forEach(q => {
        if (q.id) {
          userAnswers[q.id] = null; // Inisialisasi jawaban sebagai null
        }
      });
      hasAccess.value = true; // Access granted for masyarakat
    } catch (error) {
      ElMessage.error('Gagal memuat data pretest atau pengguna.');
      console.error(error);
      hasAccess.value = false; // Revoke access if fetching fails
    } finally {
      isLoading.value = false;
    }
  } else {
    // No valid role found
    hasAccess.value = false;
    ElMessage.error('Akses ditolak. Peran pengguna tidak dikenali.');
    isLoading.value = false;
  }
});

const submitPretest = async () => {
  if (isOperatorOrPegawai.value) {
    ElMessage.info('Operator/Pegawai tidak dapat mengirim pretest.');
    return;
  }
  // Existing submit logic for masyarakat
  if (!userNik.value || !userName.value) {
    ElMessage.error('NIK atau Nama pengguna tidak ada. Tidak dapat mengirim pretest.');
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
    const result = await pretestService.submitPretestAnswers(
      pretest.value.id!,
      answersToSend,
      userNik.value,
      userName.value
    );
    score.value = result.score;
    isSubmitted.value = true;
    ElMessage.success(result.message || 'Pretest berhasil dikirim!');
  } catch (error: unknown) {
    if (error instanceof AxiosError && error.response && error.response.status === 409) {
      ElMessage.warning(error.response.data.message);
    } else {
      ElMessage.error('Gagal mengirim pretest.');
    }
    console.error(error);
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>