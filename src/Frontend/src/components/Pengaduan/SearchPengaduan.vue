<template>
  <div class="container mx-auto p-4">
    <el-card class="box-card shadow-lg rounded-lg bg-white">
      <template #header>
        <div class="flex items-center justify-between mb-4">
          <span class="text-2xl font-semibold text-gray-800">Cari Pengaduan</span>
        </div>
      </template>

      <el-form @submit.prevent="handleSearch">
        <el-form-item label="Kode Pengaduan (6 digit)">
          <el-input
            v-model="searchCode"
            placeholder="Masukkan kode pengaduan"
            maxlength="6"
            class="w-full rounded-md border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
            @keyup.enter="handleSearch"
          />
        </el-form-item>
        <el-button
          type="primary"
          :disabled="isSearching"
          class="bg-pink-500 text-white hover:bg-pink-600 border-none rounded-md transition-all duration-300 ease-in-out"
          @click="handleSearch"
        >
          {{ isSearching ? 'Mencari...' : 'Cari' }}
        </el-button>
      </el-form>

      <div
        v-if="isSearching"
        class="text-center text-blue-500 mt-8"
      >
        <p class="text-lg">
          Mencari pengaduan...
        </p>
      </div>

      <div
        v-else-if="error"
        class="text-center text-red-500 mt-8"
      >
        <p>{{ error }}</p>
      </div>

      <div
        v-else-if="pengaduanData"
        class="mt-8 p-6 border border-gray-200 rounded-lg shadow-sm bg-gray-50"
      >
        <h3 class="text-xl font-semibold text-gray-800 mb-4">
          Detail Pengaduan
        </h3>
        <p class="text-lg mb-2">
          <strong>Kode Pengaduan:</strong> {{ pengaduanData.kode_pengaduan }}
        </p>
        <p class="text-lg mb-2">
          <strong>Nama Pelapor:</strong> {{ pengaduanData.nama_pelapor }}
        </p>
        <p class="text-lg mb-2">
          <strong>Nama Korban:</strong> {{ pengaduanData.nama_korban || '-' }}
        </p>
        <p class="text-lg mb-2">
          <strong>Deskripsi:</strong> {{ pengaduanData.deskripsi }}
        </p>
        <p class="text-lg mb-2">
          <strong>Alamat:</strong> {{ pengaduanData.alamat }}
        </p>
        <p class="text-lg mb-2">
          <strong>Waktu Kejadian:</strong> {{ new Date(pengaduanData.waktu_kejadian).toLocaleString() }}
        </p>
        <p class="text-lg mb-2">
          <strong>Kasus:</strong> {{ pengaduanData.kasus }}
        </p>
        <p class="text-lg mb-2">
          <strong>No. HP:</strong> {{ pengaduanData.no_hp }}
        </p>
        <p class="text-lg mb-2">
          <strong>Saksi:</strong> {{ pengaduanData.saksi || '-' }}
        </p>
        <p class="text-lg mb-2">
          <strong>Status:</strong> <el-tag :type="pengaduanData.status === 'selesai' ? 'success' : 'info'">
            {{ pengaduanData.status }}
          </el-tag>
        </p>
        <div
          v-if="pengaduanData.lampiran_url"
          class="mt-4"
        >
          <strong>Lampiran:</strong>
          <img
            :src="pengaduanData.lampiran_url"
            alt="Lampiran Pengaduan"
            class="mt-2 max-w-full h-auto rounded-md shadow-md"
          >
        </div>
      </div>

      <div
        v-else-if="searchAttempted && !pengaduanData"
        class="text-center text-gray-500 mt-8"
      >
        <p class="text-lg">
          Pengaduan dengan kode tersebut tidak ditemukan.
        </p>
      </div>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { ElMessage } from 'element-plus';
import pengaduanService, { Pengaduan } from '@/services/pengaduanService';
import { AxiosError } from 'axios';

const searchCode = ref('');
const pengaduanData = ref<Pengaduan | null>(null);
const isSearching = ref(false);
const error = ref<string | null>(null);
const searchAttempted = ref(false);

const handleSearch = async () => {
  error.value = null;
  pengaduanData.value = null;
  searchAttempted.value = true;

  if (searchCode.value.length !== 6 || !/^[0-9]+$/.test(searchCode.value)) {
    error.value = 'Kode pengaduan harus 6 digit angka.';
    ElMessage.error(error.value);
    return;
  }

  isSearching.value = true;
  try {
    const response = await pengaduanService.searchByKodePengaduan(searchCode.value);
    pengaduanData.value = response;
  } catch (err: unknown) {
    if (err instanceof AxiosError && err.response) {
      if (err.response.status === 404) {
        error.value = 'Pengaduan tidak ditemukan.';
      } else if (err.response.data && err.response.data.message) {
        error.value = err.response.data.message;
      } else {
        error.value = 'Terjadi kesalahan saat mencari pengaduan.';
      }
    } else if (err instanceof Error) {
      error.value = err.message;
    } else {
      error.value = 'Terjadi kesalahan yang tidak diketahui.';
    }
    ElMessage.error(error.value);
  } finally {
    isSearching.value = false;
  }
};
</script>

<style scoped>
/* Tailwind handles most styling */
</style>
