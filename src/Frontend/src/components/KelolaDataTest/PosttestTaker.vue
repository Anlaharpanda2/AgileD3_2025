<template>
  <div class="p-4">
    <el-card class="shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">Kerjakan Posttest: {{ posttest.title }}</span>
        </div>
      </template>

      <div v-if="isLoading" class="text-center text-blue-500 mt-8">
        <p class="text-lg">Memuat data posttest...</p>
      </div>

      <div v-else-if="!hasAccess" class="text-center text-red-500 mt-8">
        <p class="text-lg">Akses ditolak. Anda tidak memiliki izin untuk melihat halaman ini.</p>
        <el-button type="primary" class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out" @click="$router.push({ name: 'LoginMasyarakat' })">Kembali ke Login</el-button>
      </div>

      <div v-else-if="isMasyarakat && nikNotFound" class="text-center text-red-500 mt-8">
        <p class="text-lg">Anda tidak terdaftar sebagai peserta pelatihan atau NIK tidak ditemukan.</p>
        <el-button type="primary" class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out" @click="$router.push({ name: 'LoginMasyarakat' })">Kembali ke Login</el-button>
      </div>

      <div v-else-if="noActivePosttest" class="text-center text-blue-500 mt-8">
        <p class="text-lg">Saat ini tidak ada posttest yang aktif.</p>
        <el-button type="primary" class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out" @click="$router.push('/')">Kembali ke Beranda</el-button>
      </div>

      <div v-else-if="posttest.id">
        <p class="mb-4 text-gray-700">{{ posttest.description }}</p>

        <el-form v-if="!isSubmitted && isMasyarakat" @submit.prevent="submitPosttest">
          <div v-for="(question) in posttest.questions" :key="question.id" class="border border-gray-200 p-4 mb-4 rounded-lg shadow-sm bg-gray-50 transition-all duration-300 ease-in-out hover:shadow-md">
            <h4 class="font-medium text-gray-800 mb-3">{{ question.order }}. {{ question.question_text }}</h4>
            <el-radio-group v-model="userAnswers[question.id!]">
              <el-radio value="A" class="el-radio-custom">A. {{ question.option_a }}</el-radio>
              <el-radio value="B" class="el-radio-custom">B. {{ question.option_b }}</el-radio>
              <el-radio value="C" class="el-radio-custom">C. {{ question.option_c }}</el-radio>
              <el-radio value="D" class="el-radio-custom">D. {{ question.option_d }}</el-radio>
            </el-radio-group>
          </div>

          <div class="mt-8 flex space-x-4">
            <el-button type="success" @click="submitPosttest" :disabled="isSubmitting" class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out">
              {{ isSubmitting ? 'Menyimpan...' : 'Submit Posttest' }}
            </el-button>
            <el-button @click="$router.back()" class="bg-gray-200 text-gray-700 hover:bg-gray-300 border-none rounded-md transition-all duration-300 ease-in-out">
              Batal
            </el-button>
          </div>
        </el-form>

        <div v-else-if="isSubmitted && isMasyarakat" class="text-center mt-8 p-6 bg-green-50 rounded-lg shadow-md">
          <h3 class="text-2xl font-bold text-green-600 mb-2">Anda telah melaksanakan posttest!</h3>
          <p class="text-lg mt-2 text-gray-700">Skor Anda: <span class="font-bold">{{ score }}%</span></p>
          <el-button type="primary" class="mt-4 bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out" @click="$router.push('/')">Kembali ke Beranda</el-button>
        </div>

        <PosttestPreview v-else-if="isOperatorOrPegawai" :posttest="posttest" />

      </div>
      <div v-else class="text-center text-gray-500 mt-8">
        Memuat posttest...
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue';
import PosttestPreview from './PosttestPreview.vue';
import { useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import posttestService, { Posttest } from '@/services/posttestService';

const router = useRouter();

const posttest = ref<Posttest>({ id: undefined, title: '', description: '', questions: [] });
const userAnswers = reactive<{ [key: number]: 'A' | 'B' | 'C' | 'D' | null }>({});
const isSubmitted = ref(false);
const isSubmitting = ref(false);
const score = ref(0);
const totalQuestions = ref(0);

const userNik = ref<string | null>(null);
const userName = ref<string | null>(null);

const nikNotFound = ref(false); // Used for masyarakat role
const noActivePosttest = ref(false); // Used for masyarakat role

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
      const allPosttests = await posttestService.getAllPosttests();
      if (allPosttests.length > 0) {
        const activePosttest = allPosttests.find(p => p.is_active);
        posttest.value = activePosttest || allPosttests[0];
        totalQuestions.value = posttest.value.questions.length;
        posttest.value.questions.forEach(q => {
          if (q.id) {
            userAnswers[q.id] = null; // Initialize answers for display
          }
        });
      } else {
        noActivePosttest.value = true; // No posttests available at all
        ElMessage.info('Tidak ada posttest yang tersedia untuk ditampilkan.');
      }
    } catch (error) {
      ElMessage.error('Gagal memuat data posttest.');
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
      const userInfo = await posttestService.getUserInfoByNik(userNik.value);
      if (userInfo && userInfo.length > 0 && userInfo[0].status_pendaftaran === "Diterima") {
        userName.value = userInfo[0].nama;
      } else {
        nikNotFound.value = true;
        ElMessage.warning('Anda tidak terdaftar sebagai peserta pelatihan atau status pendaftaran Anda belum diterima.');
        hasAccess.value = false;
        return;
      }

      const allPosttests = await posttestService.getAllPosttests();
      const activePosttest = allPosttests.find(p => p.is_active);

      if (!activePosttest) {
        noActivePosttest.value = true;
        ElMessage.warning('Saat ini tidak ada posttest yang aktif.');
        hasAccess.value = false;
        return;
      }

      posttest.value = activePosttest;
      totalQuestions.value = activePosttest.questions.length;
      activePosttest.questions.forEach(q => {
        if (q.id) {
          userAnswers[q.id] = null; // Inisialisasi jawaban sebagai null
        }
      });
      hasAccess.value = true; // Access granted for masyarakat
    } catch (error) {
      ElMessage.error('Gagal memuat data posttest atau pengguna.');
      console.error(error);
      hasAccess.value = false; // Revoke access if fetching fails
    } finally {
      isLoading.value = false;
    }
  } else {
    hasAccess.value = false;
    ElMessage.error('Akses ditolak. Peran pengguna tidak dikenali.');
    isLoading.value = false;
  }
});

const submitPosttest = async () => {
  if (isOperatorOrPegawai.value) {
    ElMessage.info('Operator/Pegawai tidak dapat mengirim posttest.');
    return;
  }
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
  } catch (error: any) {
    if (error.response && error.response.status === 409) {
      ElMessage.warning(error.response.data.message);
    } else {
      ElMessage.error('Gagal mengirim posttest.');
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
