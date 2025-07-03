<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card">
      <template #header>
        <div class="card-header">
          <span class="text-xl font-bold">Kerjakan Pretest: {{ pretest.title }}</span>
        </div>
      </template>

      <div v-if="nikNotFound" class="text-center text-red-500 mt-8">
        <p class="text-lg">Anda tidak terdaftar sebagai peserta pelatihan atau NIK tidak ditemukan.</p>
        <el-button type="primary" class="mt-4" @click="$router.push({ name: 'LoginMasyarakat' })">Kembali ke Login</el-button>
      </div>

      <div v-else-if="noActivePretest" class="text-center text-blue-500 mt-8">
        <p class="text-lg">Saat ini tidak ada pretest yang aktif.</p>
        <el-button type="primary" class="mt-4" @click="$router.push('/')">Kembali ke Beranda</el-button>
      </div>

      <div v-else-if="pretest.id">
        <p class="mb-4">{{ pretest.description }}</p>

        <el-form v-if="!isSubmitted" @submit.prevent="submitPretest">
          <div v-for="(question) in pretest.questions" :key="question.id" class="border p-4 mb-4 rounded-lg shadow-sm bg-gray-50">
            <h4 class="font-medium text-gray-800">{{ question.order }}. {{ question.question_text }}</h4>
            <el-radio-group v-model="userAnswers[question.id!]">
              <el-radio label="A">A. {{ question.option_a }}</el-radio>
              <el-radio label="B">B. {{ question.option_b }}</el-radio>
              <el-radio label="C">C. {{ question.option_c }}</el-radio>
              <el-radio label="D">D. {{ question.option_d }}</el-radio>
            </el-radio-group>
          </div>

          <div class="mt-8">
            <el-button type="success" @click="submitPretest" :disabled="isSubmitting">
              {{ isSubmitting ? 'Menyimpan...' : 'Submit Pretest' }}
            </el-button>
            <el-button @click="$router.back()">Batal</el-button>
          </div>
        </el-form>

        <div v-else class="text-center mt-8">
          <h3 class="text-2xl font-bold text-green-600">Anda telah melaksanakan pretest!</h3>
          <p class="text-lg mt-2">Skor Anda: {{ score }} / {{ totalQuestions }}</p>
          <el-button type="primary" class="mt-4" @click="$router.push('/')">Kembali ke Beranda</el-button>
        </div>
      </div>
      <div v-else class="text-center text-gray-500">
        Memuat pretest...
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage } from 'element-plus';
import pretestService, { Pretest } from '@/services/pretestService';

const router = useRouter();

const pretest = ref<Pretest>({ id: undefined, title: '', description: '', questions: [] });
const userAnswers = reactive<{ [key: number]: 'A' | 'B' | 'C' | 'D' | null }>({});
const isSubmitted = ref(false);
const isSubmitting = ref(false);
const score = ref(0);
const totalQuestions = ref(0);

const userNik = ref<string | null>(null);
const userName = ref<string | null>(null);

const nikNotFound = ref(false);
const noActivePretest = ref(false);

onMounted(async () => {
  userNik.value = localStorage.getItem('savedNIK');
  if (!userNik.value) {
    nikNotFound.value = true;
    ElMessage.error('NIK tidak ditemukan di local storage. Silakan login kembali.');
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
      return;
    }

    // 2. Ambil semua pretest dan cari yang aktif
    const allPretests = await pretestService.getAllPretests();
    // @ts-ignore
    const activePretest = allPretests.find(p => p.is_active);

    if (!activePretest) {
      noActivePretest.value = true;
      ElMessage.warning('Saat ini tidak ada pretest yang aktif.');
      return;
    }

    pretest.value = activePretest;
    totalQuestions.value = activePretest.questions.length;
    activePretest.questions.forEach(q => {
      if (q.id) {
        userAnswers[q.id] = null; // Inisialisasi jawaban sebagai null
      }
    });

  } catch (error) {
    ElMessage.error('Gagal memuat data pretest atau pengguna.');
    console.error(error);
  }
});

const submitPretest = async () => {
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
      // @ts-ignore
      answersToSend,
      userNik.value,
      userName.value
    );
    score.value = result.score;
    isSubmitted.value = true;
    ElMessage.success(result.message || 'Pretest berhasil dikirim!');
  } catch (error: any) {
    if (error.response && error.response.status === 409) {
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
