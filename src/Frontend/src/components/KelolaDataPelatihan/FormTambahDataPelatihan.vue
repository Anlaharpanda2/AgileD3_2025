<template>
  <div
    class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click.self="$emit('close')"
  >
    <transition
      name="modal"
      appear
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full max-h-[95vh] flex flex-col overflow-hidden relative">
        <button @click="fillWithDemoData" class="demo-button">Demo Tambah Data</button>
        <!-- Header -->
        <div
          class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700
 px-6 py-4 sm:px-8 sm:py-6 rounded-t-xl"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <!-- Icon for header (using Heroicons/Lucide-like SVG) -->
                <svg
                  class="w-6 h-6 text-white"
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
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                  Tambah Data Pelatihan
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Isi form untuk menambahkan data pelatihan baru
                </p>
              </div>
            </div>
            <button
              class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
              aria-label="Tutup"
              @click="$emit('close')"
            >
              <!-- Close icon -->
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>

        <!-- Form Body -->
        <div class="flex-grow overflow-y-auto p-6 sm:p-8">
          <el-form
            ref="formRef"
            :model="form"
            :rules="rules"
            label-position="top"
            class="space-y-6"
          >
            <!-- Personal Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Personal info icon -->
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
                <el-form-item
                  label="Nama Lengkap"
                  prop="nama"
                >
                  <el-input
                    v-model="form.nama"
                    placeholder="Masukkan nama lengkap"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
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
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="NIK"
                  prop="nik"
                >
                  <el-input
                    v-model="form.nik"
                    placeholder="Masukkan NIK"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Tempat Tanggal Lahir"
                  prop="tempat_tanggal_lahir"
                >
                  <el-input
                    v-model="form.tempat_tanggal_lahir"
                    placeholder="Contoh: Jakarta, 15 Januari 1990"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Status"
                  prop="status"
                >
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
                </el-form-item>
                <el-form-item
                  label="Pendidikan"
                  prop="pendidikan"
                >
                  <el-input
                    v-model="form.pendidikan"
                    placeholder="Contoh: S1 Teknik Informatika"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Nomor Telepon"
                  prop="nomor_telefon"
                >
                  <el-input
                    v-model="form.nomor_telefon"
                    placeholder="Contoh: 081234567890"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
              </div>
              <el-form-item
                label="Alamat"
                prop="alamat"
                class="mt-4"
              >
                <el-input
                  v-model="form.alamat"
                  type="textarea"
                  placeholder="Masukkan alamat lengkap"
                  :rows="3"
                  class="modern-textarea"
                />
              </el-form-item>
            </div>

            <!-- Training Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Training info icon -->
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
                <el-form-item
                  label="Jenis Bimtek"
                  prop="jenis_bimtek"
                >
                  <el-input
                    v-model="form.jenis_bimtek"
                    placeholder="Masukkan jenis bimbingan teknis"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
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
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Angkatan"
                  prop="angkatan"
                >
                  <el-input
                    v-model="form.angkatan"
                    type="number"
                    placeholder="Masukkan angkatan"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Kegiatan Dimulai"
                  prop="kegiatan_dimulai"
                >
                  <el-date-picker
                    v-model="form.kegiatan_dimulai"
                    type="date"
                    placeholder="Pilih tanggal mulai"
                    size="large"
                    class="w-full modern-date"
                    format="DD/MM/YYYY"
                    value-format="YYYY-MM-DD"
                  />
                </el-form-item>
                <el-form-item
                  label="Kegiatan Berakhir"
                  prop="kegiatan_berakhir"
                >
                  <el-date-picker
                    v-model="form.kegiatan_berakhir"
                    type="date"
                    placeholder="Pilih tanggal berakhir"
                    size="large"
                    class="w-full modern-date"
                    format="DD/MM/YYYY"
                    value-format="YYYY-MM-DD"
                  />
                </el-form-item>
                <el-form-item
                  label="Tempat Kegiatan"
                  prop="tempat_kegiatan"
                  class="md:col-span-2"
                >
                  <el-input
                    v-model="form.tempat_kegiatan"
                    placeholder="Masukkan tempat kegiatan"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
              </div>
            </div>

            <!-- Business Information Section -->
            <div class="bg-gray-50 rounded-xl p-5 sm:p-6 border border-gray-100 shadow-sm">
              <div class="flex items-center space-x-3 mb-5">
                <div class="p-2 bg-pink-100 rounded-lg">
                  <!-- Business info icon -->
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
                <el-form-item
                  label="Jenis Usaha"
                  prop="jenis_usaha"
                >
                  <el-input
                    v-model="form.jenis_usaha"
                    placeholder="Contoh: Kuliner, Fashion, Digital Marketing"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
                <el-form-item
                  label="Penghasilan Per Bulan"
                  prop="penghasilan_perbulan"
                >
                  <el-input
                    v-model="form.penghasilan_perbulan"
                    placeholder="Contoh: Rp 5.000.000"
                    size="large"
                    class="modern-input"
                  >
                    <template #prefix>
                      <svg
                        class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                        />
                      </svg>
                    </template>
                  </el-input>
                </el-form-item>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end pt-6 border-t border-gray-200">
              <button
                type="button"
                class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl font-medium hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-sm"
                @click="$emit('close')"
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
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                  <span>Batal</span>
                </div>
              </button>
              <button
                type="button"
                class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl font-medium focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
                @click="submitForm"
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
                  <span>Simpan Data</span>
                </div>
              </button>
            </div>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'; // Removed 'watch' and 'onMounted' as they are not used in FormTambahDataPelatihan
import { ElNotification } from 'element-plus';
import api from '../../api.js'; // Pastikan path ini benar

// Removed props as FormTambahDataPelatihan does not use initialData
const emit = defineEmits(['close']);

const formRef = ref(null);
const statusOptions = ['kawin', 'lajang', 'janda'];

// Form fields definition (copied from FormTambahDataPelatihan.vue)


// Reactive form state (copied from FormTambahDataPelatihan.vue)
const form = reactive({
  nik: '',
  nama: '',
  jenis_bimtek: '',
  kegiatan_dimulai: null,
  kegiatan_berakhir: null,
  tempat_kegiatan: '',
  angkatan: null,
  tempat_tanggal_lahir: '',
  pendidikan: '',
  status: '',
  alamat: '',
  jenis_usaha: '',
  penghasilan_perbulan: '',
  nomor_telefon: '',
});

const fillWithDemoData = () => {
  form.nama = 'Peserta Demo';
  form.nik = '1234567890987659';
  form.tempat_tanggal_lahir = 'Bandung, 20 Mei 1995';
  form.status = 'kawin';
  form.pendidikan = 'S1 Manajemen';
  form.nomor_telefon = '081122334455';
  form.alamat = 'Jl. Presentasi No. 404, Kota Demo';
  form.jenis_bimtek = 'Pelatihan Pemasaran Online';
  form.angkatan = 2025;
  form.kegiatan_dimulai = '2025-08-01';
  form.kegiatan_berakhir = '2025-08-10';
  form.tempat_kegiatan = 'Gedung Serbaguna, Kota Demo';
  form.jenis_usaha = 'Toko Online Pakaian';
  form.penghasilan_perbulan = '7500000';
};

// Removed applyInitialData and watch as they are not relevant for a "tambah" form

// Form validation rules (copied from FormTambahDataPelatihan.vue)
const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  jenis_bimtek: [{ required: true, message: 'Jenis bimtek wajib diisi', trigger: 'blur' }],
  kegiatan_dimulai: [{ type: 'date', required: true, message: 'Tanggal Mulai Kegiatan wajib diisi', trigger: 'change' }],
  kegiatan_berakhir: [{ type: 'date', required: true, message: 'Tanggal Berakhir Kegiatan wajib diisi', trigger: 'change' }],
  tempat_kegiatan: [{ required: true, message: 'Tempat wajib diisi', trigger: 'blur' }],
  angkatan: [
    { required: true, message: 'Angkatan wajib diisi', trigger: 'change' },
    {
       
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
      validator: (rule: any, value: any, callback: (error?: Error) => void) => {
        const number = Number(value);
        if (value === '' || value === null || value === undefined) {
          callback(new Error('Angkatan wajib diisi'));
        } else if (isNaN(number)) {
          callback(new Error('Angkatan harus berupa angka'));
        } else if (number <= 0) {
          callback(new Error('Angkatan harus lebih besar dari 0'));
        } else {
          callback();
        }
      },
      trigger: 'blur',
    },
  ],
  tempat_tanggal_lahir: [{ required: true, message: 'Tempat tanggal lahir wajib diisi', trigger: 'blur' }],
  pendidikan: [{ required: true, message: 'Pendidikan wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  jenis_usaha: [{ required: true, message: 'Jenis usaha wajib diisi', trigger: 'blur' }],
  penghasilan_perbulan: [{ required: true, message: 'Penghasilan wajib diisi', trigger: 'blur' }],
  nomor_telefon: [{ required: true, message: 'Nomor telepon wajib diisi', trigger: 'blur' }],
};

// Helper function to capitalize strings (copied from FormTambahDataPelatihan.vue)
const capitalize = (s: string) => s.charAt(0).toUpperCase() + s.slice(1);

// Form submission logic (copied from FormTambahDataPelatihan.vue)
const submitForm = () => {
  formRef.value.validate(async (valid: boolean) => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }
    const payload = {
      ...form,
      kegiatan_dimulai: form.kegiatan_dimulai instanceof Date
        ? `${form.kegiatan_dimulai.getFullYear()}-${String(form.kegiatan_dimulai.getMonth() + 1).padStart(2, '0')}-${String(form.kegiatan_dimulai.getDate()).padStart(2, '0')}`
        : form.kegiatan_dimulai,
      kegiatan_berakhir: form.kegiatan_berakhir instanceof Date
        ? `${form.kegiatan_berakhir.getFullYear()}-${String(form.kegiatan_berakhir.getMonth() + 1).padStart(2, '0')}-${String(form.kegiatan_berakhir.getDate()).padStart(2, '0')}`
        : form.kegiatan_berakhir,
      angkatan: Number(form.angkatan),
    };
    try {
      console.log('Kirim JSON:', JSON.stringify(payload));
      const response = await api.post('/kelola/pelatihan', payload); // This is the POST request for adding data
        ElNotification({
          title: 'Berhasil',
          message: response.data.message || 'Data berhasil disimpan!',
          type: 'success',
          duration: 3000,
        });
        emit('close');
        window.location.reload();
     
    } catch (error) {
      console.error('Error submitting form:', error);
      let errorMessage = 'Gagal menyimpan data. Terjadi kesalahan jaringan atau server.';
      if (error instanceof Error) {
        if ('response' in error && error.response && typeof error.response === 'object' && 'data' in error.response && error.response.data && typeof error.response.data === 'object' && 'message' in error.response.data) {
          errorMessage = error.response.data.message;
        } else {
          errorMessage = error.message;
        }
      }
      ElNotification({
        title: 'Gagal',
        message: errorMessage,
        type: 'error',
        duration: 0,
      });
    }
  });
};
</script>

<style scoped>
.demo-button {
  position: absolute;
  top: 24px;
  right: 80px; /* Adjusted to avoid close button */
  background-color: #8B4513; /* Brown color */
  color: white;
  padding: 8px 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-family: sans-serif;
  font-weight: 600;
  font-size: 12px;
  z-index: 60; /* Above content, below close button if needed */
  transition: background-color 0.3s ease;
}

.demo-button:hover {
  background-color: #A0522D; /* Lighter brown */
}

/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

/* Modern Input Styles */
/* Apply styles to Element Plus input wrapper */
:deep(.modern-input .el-input__wrapper),
:deep(.modern-select .el-input__wrapper),
:deep(.modern-date .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner) {
  border-radius: 12px; /* Rounded corners for all inputs */
  border: 1px solid #e5e7eb; /* Light gray border */
  transition: all 0.2s ease; /* Smooth transition for hover/focus */
  box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Subtle shadow */
  padding: 8px 12px; /* Adjust padding for a better look */
}

/* Hover state for inputs */
:deep(.modern-input .el-input__wrapper:hover),
:deep(.modern-select .el-input__wrapper:hover),
:deep(.modern-date .el-input__wrapper:hover),
:deep(.modern-textarea .el-textarea__inner:hover) {
  border-color: #f472b6; /* Softer pink on hover */
}

/* Focus state for inputs */
:deep(.modern-input.is-focus .el-input__wrapper),
:deep(.modern-select.is-focus .el-input__wrapper),
:deep(.modern-date.is-focus .el-input__wrapper),
:deep(.modern-textarea .el-textarea__inner:focus) {
  border-color: #f472b6; /* Softer pink on focus */
  box-shadow: 0 0 0 3px rgba(244, 114, 182, 0.15); /* Softer pink ring shadow */
}

/* Remove Element Plus default form item margin to control spacing with Tailwind gap */
:deep(.el-form-item) {
  margin-bottom: 0;
}

/* Adjust label style for better spacing and appearance */
:deep(.el-form-item__label) {
  font-size: 0.875rem; /* text-sm */
  font-weight: 500; /* font-medium */
  color: #374151; /* gray-700 */
  margin-bottom: 0.5rem; /* space-y-2 equivalent */
}

/* Ensure full width for Element Plus components within the grid */
:deep(.el-input),
:deep(.el-select),
:deep(.el-date-picker),
:deep(.el-textarea) {
  width: 100%;
}
</style>
