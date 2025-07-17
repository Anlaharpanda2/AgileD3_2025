<template>
  <SimpleLayout>
    <div class="min-h-screen bg-gray-100 font-sans">
      <!-- Header -->
      <div class="bg-white px-6 py-4 sm:px-8 sm:py-6 shadow-sm border-b border-gray-200">
        <div class="flex items-center justify-between">
          <!-- Back Arrow -->
          <button
            class="p-2 -ml-2 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500"
            @click="goBack"
          >
            <svg
              class="w-6 h-6 text-gray-600"
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
          </button>
          
          <div class="flex items-center space-x-3 flex-grow ml-4">
            <div class="p-2 bg-pink-100 rounded-lg">
              <svg
                class="w-6 h-6 text-pink-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
            <div>
              <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                Daftar Pelatihan
              </h2>
              <p class="text-gray-600 text-xs sm:text-sm">
                Lengkapi informasi untuk mendaftar pelatihan baru
              </p>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Roadmap -->
      <div
        v-if="isAuthenticated && !isLoadingQuota && isQuotaAvailable && !isSubmitted"
        class="p-6 sm:p-8 bg-white shadow-sm border-b border-gray-200"
      >
        <div class="flex items-center justify-between space-x-2">
          <div
            v-for="(step, index) in steps"
            :key="index"
            class="flex-1 flex items-center"
          >
            <div class="flex items-center w-full">
              <!-- Step Circle -->
              <div
                :class="[
                  'flex items-center justify-center w-8 h-8 rounded-full text-sm font-semibold transition-all duration-300 ease-in-out',
                  currentStep >= index ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-600',
                  isStepClickable(index) ? 'cursor-pointer' : 'cursor-not-allowed'
                ]"
                @click="goToStep(index)"
              >
                {{ index < 4 ? index + 1 : '' }}
                <svg
                  v-if="index === 4 && isSubmitted"
                  class="w-5 h-5 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                  />
                </svg>
              </div>
              <!-- Step Label -->
              <span class="ml-2 text-sm font-medium text-gray-700 hidden sm:block">{{ step.label }}</span>
              <!-- Connector Line -->
              <div
                v-if="index < steps.length - 1"
                class="flex-1 h-1 bg-gray-200 mx-2 rounded-full overflow-hidden"
              >
                <div
                  :class="['h-full transition-all duration-300 ease-in-out', currentStep > index ? 'bg-pink-500' : 'bg-gray-200']"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Main Content -->
      <div class="p-6 sm:p-8">
        <!-- Pesan jika belum login -->
        <div
          v-if="!isAuthenticated"
          class="bg-white rounded-xl p-8 text-center shadow-md border border-gray-100"
        >
          <svg
            class="w-16 h-16 text-pink-500 mx-auto mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">
            Akses Ditolak
          </h3>
          <p class="text-gray-600 mb-6">
            Anda belum masuk atau daftar akun. Silakan masuk terlebih dahulu.
          </p>
          <button
            class="px-8 py-3 bg-pink-500 text-white rounded-xl font-medium hover:bg-pink-600 transition-all duration-200 ease-in-out transform hover:scale-105 shadow-lg"
            @click="router.push('/daftar/masyarakat')"
          >
            Daftar atau Masuk
          </button>
        </div>

        <div v-else>
          <!-- Tampilan Loading -->
          <div
            v-if="isLoadingQuota"
            class="text-center py-10"
          >
            <p class="text-gray-600">
              Memuat status pendaftaran...
            </p>
          </div>
    
          <!-- Tampilan Setelah Loading Selesai -->
          <div v-else>
            <!-- Tampilan Jika Pendaftaran Tidak Tersedia -->
            <div
              v-if="!isQuotaAvailable"
              class="bg-white rounded-xl p-8 text-center shadow-md border border-gray-100"
            >
              <svg
                class="w-16 h-16 text-pink-500 mx-auto mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Pendaftaran Tidak Tersedia
              </h3>
              <p class="text-gray-600 mb-6">
                {{ quotaMessage }}
              </p>
            </div>
    
            <!-- Tampilan Form Pendaftaran -->
            <div
              v-else-if="!isSubmitted"
              class="space-y-6"
            >
              <!-- Step 1: Informasi Personal -->
              <div
                v-if="currentStep === 0"
                class="bg-white rounded-xl p-5 sm:p-6 border border-gray-100 shadow-md"
              >
                <div class="flex items-center space-x-3 mb-5">
                  <div class="p-2 bg-pink-100 rounded-lg">
                    <svg
                      class="w-5 h-5 text-pink-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                  </div>
                  <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    Informasi Personal
                  </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.nama"
                      placeholder="Masukkan nama lengkap"
                      size="large"
                      class="modern-input"
                      :disabled="isNamaDisabled"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.nik"
                      placeholder="Masukkan NIK"
                      size="large"
                      class="modern-input"
                      :disabled="isNikDisabled"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Tanggal Lahir <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.tempat_tanggal_lahir"
                      placeholder="Contoh: Jakarta, 15 Januari 1990"
                      size="large"
                      class="modern-input"
                      :disabled="isTtlDisabled"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                    <el-select
                      v-model="form.status"
                      placeholder="Pilih status"
                      size="large"
                      class="w-full modern-select"
                      clearable
                    >
                      <el-option
                        v-for="option in statusOptions"
                        :key="option"
                        :label="capitalize(option)"
                        :value="option"
                      />
                    </el-select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.pendidikan"
                      placeholder="Contoh: S1 Teknik Informatika"
                      size="large"
                      class="modern-input"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.nomor_telefon"
                      placeholder="Contoh: 081234567890"
                      size="large"
                      class="modern-input"
                    />
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.alamat"
                      type="textarea"
                      placeholder="Masukkan alamat lengkap"
                      :rows="3"
                      class="modern-textarea"
                    />
                  </div>
                </div>
              </div>
    
              <!-- Step 2: Informasi Pelatihan -->
              <div
                v-if="currentStep === 1"
                class="bg-white rounded-xl p-5 sm:p-6 border border-gray-100 shadow-md"
              >
                <div class="flex items-center space-x-3 mb-5">
                  <div class="p-2 bg-pink-100 rounded-lg">
                    <svg
                      class="w-5 h-5 text-pink-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                      />
                    </svg>
                  </div>
                  <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    Informasi Pelatihan
                  </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Bimtek <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.jenis_bimtek"
                      placeholder="Masukkan jenis bimbingan teknis"
                      size="large"
                      class="modern-input"
                    />
                  </div>
                </div>
              </div>
    
              <!-- Step 3: Informasi Usaha -->
              <div
                v-if="currentStep === 2"
                class="bg-white rounded-xl p-5 sm:p-6 border border-gray-100 shadow-md"
              >
                <div class="flex items-center space-x-3 mb-5">
                  <div class="p-2 bg-pink-100 rounded-lg">
                    <svg
                      class="w-5 h-5 text-pink-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6m8 0H8"
                      />
                    </svg>
                  </div>
                  <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    Informasi Usaha
                  </h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Usaha <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.jenis_usaha"
                      placeholder="Contoh: Kuliner, Fashion"
                      size="large"
                      class="modern-input"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penghasilan Per Bulan <span class="text-red-500">*</span></label>
                    <el-input
                      v-model="form.penghasilan_perbulan"
                      placeholder="Contoh: Rp 5.000.000"
                      size="large"
                      class="modern-input"
                    />
                  </div>
                </div>
              </div>
    
              <!-- Step 4: Rangkuman Data -->
              <div
                v-if="currentStep === 3"
                class="bg-white rounded-xl p-5 sm:p-6 border border-gray-100 shadow-md"
              >
                <div class="flex items-center space-x-3 mb-5">
                  <div class="p-2 bg-pink-100 rounded-lg">
                    <svg
                      class="w-5 h-5 text-pink-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                      />
                    </svg>
                  </div>
                  <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    Rangkuman Data
                  </h3>
                </div>
                <div class="space-y-4">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">
                    <div
                      v-for="(value, key) in form"
                      :key="key"
                      class="flex flex-col"
                    >
                      <span class="text-sm font-medium text-gray-500">{{ formatLabel(String(key)) }}</span>
                      <span class="text-base text-gray-800 font-semibold">{{ value || '-' }}</span>
                    </div>
                  </div>
                </div>
              </div>
    
              <!-- Navigation Buttons -->
              <div class="flex flex-col sm:flex-row gap-3 justify-between pt-6 border-t border-gray-200">
                <button
                  v-if="currentStep > 0"
                  type="button"
                  class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl font-medium hover:bg-gray-50 transition-all duration-200 ease-in-out transform hover:scale-105 shadow-sm"
                  @click="currentStep--"
                >
                  <div class="flex items-center justify-center space-x-2">
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                      />
                    </svg>
                    <span>Kembali</span>
                  </div>
                </button>
                <div class="flex flex-col sm:flex-row gap-3 justify-end sm:ml-auto">
                  <button
                    v-if="currentStep < 3"
                    type="button"
                    class="px-6 py-3 bg-pink-500 text-white rounded-xl font-medium hover:bg-pink-600 transition-all duration-200 ease-in-out transform hover:scale-105 shadow-lg"
                    @click="nextStep"
                  >
                    <div class="flex items-center justify-center space-x-2">
                      <span>Lanjut</span>
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"
                        />
                      </svg>
                    </div>
                  </button>
                  <button
                    v-if="currentStep === 3"
                    type="button"
                    class="px-6 py-3 bg-pink-500 text-white rounded-xl font-medium hover:bg-pink-600 transition-all duration-200 ease-in-out transform hover:scale-105 shadow-lg"
                    @click="confirmSubmitData"
                  >
                    <div class="flex items-center justify-center space-x-2">
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"
                        />
                      </svg>
                      <span>Kirim Data</span>
                    </div>
                  </button>
                </div>
              </div>
            </div>
    
            <!-- Tampilan Konfirmasi Pengiriman -->
            <div
              v-else-if="isSubmitted"
              class="bg-white rounded-xl p-8 text-center shadow-md border border-gray-100"
            >
              <svg
                class="w-16 h-16 text-pink-500 mx-auto mb-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"
                />
              </svg>
              <h3 class="text-xl font-semibold text-gray-800 mb-2">
                Data Pendaftaran Diterima!
              </h3>
              <p class="text-gray-600 mb-6">
                Terima kasih atas pendaftaran Anda. Data Anda sedang diproses. Anda akan menerima notifikasi lebih lanjut.
              </p>
              <button
                type="button"
                class="px-8 py-3 bg-pink-500 text-white rounded-xl font-medium hover:bg-pink-600 transition-all duration-200 ease-in-out transform hover:scale-105 shadow-lg"
                @click="resetPage"
              >
                Lihat Status Pendaftaran
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, computed } from 'vue';
import { ElNotification, ElMessageBox } from 'element-plus';
import api from '../../api.js';
import { useRouter } from 'vue-router';
import SimpleLayout from '@/layouts/SimpleLayout.vue';

const router = useRouter();
const isAuthenticated = ref(false);
const statusOptions = ['kawin', 'lajang', 'janda'];
const currentStep = ref(0);
const isSubmitted = ref(false);

// New refs for disabling inputs
const isNikDisabled = ref(false);
const isNamaDisabled = ref(false);
const isTtlDisabled = ref(false);

// New states for quota validation
const isLoadingQuota = ref(true);
const isQuotaAvailable = ref(false);
const quotaMessage = ref('');

const steps = [
  { label: 'Informasi Personal' },
  { label: 'Informasi Pelatihan' },
  { label: 'Informasi Usaha' },
  { label: 'Rangkuman Data' },
  { label: 'Selesai' },
];

interface FormData {
  nama: string;
  nik: string;
  tempat_tanggal_lahir: string;
  status: string;
  pendidikan: string;
  nomor_telefon: string;
  alamat: string;
  jenis_bimtek: string;
  jenis_usaha: string;
  penghasilan_perbulan: string;
  [key: string]: string | number | null; // Add index signature
}

const form = reactive<FormData>({
  nama: '',
  nik: '',
  tempat_tanggal_lahir: '',
  status: '',
  pendidikan: '',
  nomor_telefon: '',
  alamat: '',
  jenis_bimtek: '',
  jenis_usaha: '',
  penghasilan_perbulan: '',
});

// Function to navigate back to the home route
const goBack = () => {
  window.location.href = '/';
};

// On component mount, check local storage for pre-filled data and API for quota
onMounted(async () => {
  const userId = localStorage.getItem('userId');
  if (!userId) {
    isAuthenticated.value = false;
    isLoadingQuota.value = false; // Stop loading
    return; // Stop execution
  }
  isAuthenticated.value = true;

  // Load data from local storage
  const savedNik = localStorage.getItem('savedNIK');
  const savedNama = localStorage.getItem('savedName');
  const savedTtl = localStorage.getItem('Ttl');

  if (savedNik) {
    form.nik = savedNik;
    isNikDisabled.value = true;
  }
  if (savedNama) {
    form.nama = savedNama;
    isNamaDisabled.value = true;
  }
  if (savedTtl) {
    form.tempat_tanggal_lahir = savedTtl;
    isTtlDisabled.value = true;
  }

  try {
    // --- Validasi NIK Sudah Terdaftar ---
    if (savedNik) {
      const cekNikResponse = await api.post('/cek/nik', { nik: savedNik });
      console.log('Cek NIK Raw Response Object:', cekNikResponse); // Log the entire response object

      let existsInResponse = false;

      // Prioritize checking cekNikResponse.data.exists (standard Axios behavior)
      if (cekNikResponse.data && typeof cekNikResponse.data.exists === 'boolean') {
        existsInResponse = cekNikResponse.data.exists;
      }

      console.log('Determined existsInResponse:', existsInResponse);

      if (existsInResponse === true) {
        isQuotaAvailable.value = false; // Setel ke false untuk menyembunyikan form
        quotaMessage.value = 'Tidak bisa mendaftar, anda sudah melakukan pendaftaran pada angkatan ini.';
        isLoadingQuota.value = false; // Pastikan loading dihentikan
        return; // *** KELUAR DARI FUNGSI onMounted SECEPATNYA ***
      }
    }

    // --- Validasi Kuota Pendaftaran (hanya jika NIK belum terdaftar) ---
    const quotaResponse = await api.get('/quota/pendaftaran');
    console.log('Full quotaResponse:', quotaResponse);

    let quotaData = null;
    const rawQuotaData = quotaResponse?.data?.data ?? quotaResponse?.data;

    if (typeof rawQuotaData === 'object' && rawQuotaData !== null) {
      quotaData = rawQuotaData;
    }
    console.log('Parsed quotaData:', quotaData);

    // Validasi struktur dan properti quotaData
    if (!quotaData || typeof quotaData.status !== 'boolean' || typeof quotaData.status_quota !== 'boolean') {
        console.error('Invalid quotaData structure or missing properties:', quotaData);
        throw new Error('Format data kuota dari API tidak valid atau tidak lengkap. (Missing status/status_quota or wrong type)');
    }

    // Logika berdasarkan properti 'status' dan 'status_quota'
    if (quotaData.status === false) { // Jika pendaftaran belum dibuka
      isQuotaAvailable.value = false;
      quotaMessage.value = 'Pendaftaran belum dibuka, silahkan menunggu sesuai jadwal.';
    } else { // Jika pendaftaran sudah dibuka, periksa status kuota
      if (quotaData.status_quota === true) { // Jika kuota tersedia
        isQuotaAvailable.value = true;
      } else { // Jika kuota penuh
        isQuotaAvailable.value = false;
        quotaMessage.value = 'Kuota pendaftaran sudah penuh.';
      }
    }
  } 
  
  catch (error) {
    console.error('Error fetching data:', error);
    isQuotaAvailable.value = false;
    // Berikan pesan yang lebih spesifik jika error disebabkan oleh struktur data
    quotaMessage.value = (error as Error).message.includes('Format data kuota dari API tidak valid')
      ? 'Terjadi kesalahan dalam format data kuota dari server. Silakan hubungi administrator.'
      : 'Terjadi kesalahan saat memuat status pendaftaran. Silakan coba lagi nanti.';
    ElNotification({
      title: 'Error',
      message: 'Gagal memuat status pendaftaran.',
      type: 'error',
      duration: 0,
    });
  } finally {
    isLoadingQuota.value = false; // Pastikan loading dihentikan di semua skenario
  }
});

const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

// Function to format keys into readable labels
const formatLabel = (key: string) => {
  const labels: { [key: string]: string } = {
    nama: 'Nama Lengkap',
    nik: 'NIK',
    tempat_tanggal_lahir: 'Tempat Tanggal Lahir',
    status: 'Status',
    pendidikan: 'Pendidikan',
    nomor_telefon: 'Nomor Telepon',
    alamat: 'Alamat',
    jenis_bimtek: 'Jenis Bimtek',
    jenis_usaha: 'Jenis Usaha',
    penghasilan_perbulan: 'Penghasilan Per Bulan',
  };
  return labels[key] || capitalize(key.replace(/_/g, ' '));
};

// Computed property to determine if a step is clickable
const isStepClickable = computed(() => (index: number) => {
  if (isSubmitted.value) {
    // If already submitted, only the 'Selesai' step is conceptually clickable
    return index === 4;
  } else {
    // If not submitted, allow clicking up to 'Rangkuman Data' (index 3)
    return index <= 3;
  }
});

const nextStep = () => {
  const requiredFields: string[][] = [
    ['nama', 'nik', 'tempat_tanggal_lahir', 'status', 'pendidikan', 'nomor_telefon', 'alamat'],
    ['jenis_bimtek'],
    ['jenis_usaha', 'penghasilan_perbulan'],
    [], // No specific required fields for summary step, as it's just a review
  ];

  const fields = requiredFields[currentStep.value];
  const isValid = fields.every((field: string) => form[field]);

  if (isValid) {
    currentStep.value++;
  } else {
    ElNotification({
      title: 'Validasi Gagal',
      message: 'Lengkapi semua field yang bertanda (*) pada tahap ini.',
      type: 'warning',
      duration: 3000,
    });
  }
};

const submitData = async () => {
  const requiredFields = [
    'nama', 'nik', 'tempat_tanggal_lahir', 'status', 'pendidikan', 'nomor_telefon', 'alamat',
    'jenis_bimtek',
    'jenis_usaha', 'penghasilan_perbulan',
  ];

  const isValid = requiredFields.every(field => form[field as keyof FormData]);

  if (!isValid) {
    ElNotification({
      title: 'Validasi Gagal',
      message: 'Lengkapi semua field yang bertanda (*) sebelum mengirim.',
      type: 'warning',
      duration: 3000,
    });
    return;
  }

  const payload = {
    ...form,
  };

  try {
    console.log('Kirim JSON:', JSON.stringify(payload));
    const response = await api.post('/daftar/pelatihan', payload);
    
    ElNotification({
      title: 'Berhasil',
      message: response.data.message || 'Data berhasil disimpan!',
      type: 'success',
      duration: 3000,
    });
    currentStep.value = 4; // Move to the 'Selesai' step (index 4)
    isSubmitted.value = true;
  } catch (error) {
    console.error('Error submitting data:', error);
    ElNotification({
      title: 'Gagal',
      message: error instanceof Error ? error.message : 'Terjadi kesalahan saat menyimpan data.',
      type: 'error',
      duration: 0,
    });
  }
};

const confirmSubmitData = () => {
  ElMessageBox.confirm(
    'Setelah data dikirim, data tidak dapat diubah. Apakah Anda yakin ingin mengirim data ini?',
    'Konfirmasi Pengiriman Data',
    {
      confirmButtonText: 'Kirim',
      cancelButtonText: 'Batal',
      type: 'warning',
      customClass: 'custom-message-box', // Apply custom class here
    }
  )
    .then(() => {
      submitData();
    })
    .catch(() => {
      ElNotification({
        title: 'Dibatalkan',
        message: 'Pengiriman data dibatalkan.',
        type: 'info',
        duration: 2000,
      });
    });
};

const resetPage = () => {
  const savedNIK = localStorage.getItem('savedNIK');
  if (savedNIK) {
    router.push({ path: `/masyarakat/${savedNIK}` });
  } else {
    router.push({ path: '/' });
  }
};

const goToStep = (stepIndex: number) => {
  // Only allow navigation if the step is clickable based on the computed property
  if (isStepClickable.value(stepIndex)) {
    currentStep.value = stepIndex;
  } else if (!isSubmitted.value && stepIndex === 4) {
    // Provide a notification if they try to click 'Selesai' prematurely
    ElNotification({
      title: 'Navigasi Terbatas',
      message: 'Langkah "Selesai" hanya dapat diakses setelah data dikirim.',
      type: 'info',
      duration: 3000,
    });
  }
};
</script>

<style>
/* Custom styles for ElMessageBox - Moved out of scoped to apply globally */
.custom-message-box {
  border-radius: 1rem !important; /* rounded-xl */
  background-color: #ffffff !important; /* bg-white */
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important; /* shadow-lg */
  border: 1px solid #e5e7eb !important; /* border-gray-200 */
}

.custom-message-box .el-message-box__header {
  background-color: #ffffff !important; /* bg-white */
  border-bottom: 1px solid #fbcfe8 !important; /* pink-200 */
  padding: 1rem 1.5rem !important; /* px-6 py-4 */
  border-top-left-radius: 1rem !important;
  border-top-right-radius: 1rem !important;
}

.custom-message-box .el-message-box__title {
  color: #374151 !important; /* gray-800 */
  font-weight: 700 !important; /* font-bold */
  font-size: 1.125rem !important; /* text-lg */
}

.custom-message-box .el-message-box__content {
  padding: 1.5rem !important; /* p-6 */
  color: #4b5563 !important; /* gray-600 */
  font-size: 0.875rem !important; /* text-sm */
}

.custom-message-box .el-message-box__btns {
  padding: 1rem 1.5rem !important; /* px-6 py-4 */
  background-color: #f9fafb !important; /* gray-50 */
  border-top: 1px solid #e5e7eb !important; /* gray-200 */
  border-bottom-left-radius: 1rem !important;
  border-bottom-right-radius: 1rem !important;
}

.custom-message-box .el-button {
  border-radius: 0.75rem !important; /* rounded-xl */
  font-weight: 500 !important; /* font-medium */
  transition: all 0.2s ease-in-out !important;
  transform: scale(1) !important;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
  padding: 0.75rem 1.5rem !important; /* px-6 py-3 */
}

.custom-message-box .el-button--default { /* Cancel button */
  background-color: #ffffff !important; /* bg-white */
  border-color: #d1d5db !important; /* gray-300 */
  color: #4b5563 !important; /* gray-700 */
}

.custom-message-box .el-button--default:hover {
  background-color: #f9fafb !important; /* hover:bg-gray-50 */
  transform: scale(1.05) !important;
}

.custom-message-box .el-button--primary { /* Confirm button */
  background-color: #ec4899 !important; /* pink-500 */
  border-color: #ec4899 !important; /* pink-500 */
  color: #ffffff !important; /* text-white */
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important; /* shadow-lg */
}

.custom-message-box .el-button--primary:hover {
  background-color: #db2777 !important; /* hover:bg-pink-600 */
  border-color: #db2777 !important; /* hover:bg-pink-600 */
  transform: scale(1.05) !important;
}

/* Modern Input Styles - Keep these scoped as they apply to elements within the component */
:deep(.modern-input .el-input__wrapper),
:deep(.modern-select .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner) {
  border-radius: 12px;
  border: 1px solid #e5e7eb; /* gray-200 */
  transition: all 0.2s ease;
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
  padding: 8px 12px;
  background-color: #ffffff; /* Ensure white background for inputs */
}

:deep(.modern-input .el-input__wrapper:hover),
:deep(.modern-select .el-input__wrapper:hover),
:deep(.modern-textarea .el-textarea__inner:hover) {
  border-color: #f472b6; /* pink-400 */
}

:deep(.modern-input.is-focus .el-input__wrapper),
:deep(.modern-select.is-focus .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner:focus) {
  border-color: #ec4899; /* pink-500 */
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1); /* pink-500 with 0.1 opacity */
}

:deep(.el-input),
:deep(.el-select),
:deep(.el-textarea) {
  width: 100%;
}
</style>
