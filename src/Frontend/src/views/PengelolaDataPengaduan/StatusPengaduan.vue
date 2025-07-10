<template>
  <SimpleLayout>
    <!-- Loading State -->
    <div
      v-if="loading"
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-4 border-gray-200 border-t-pink-500 mx-auto mb-4" />
        <p class="text-gray-600 font-medium">
          Memuat detail pengaduan...
        </p>
      </div>
    </div>

    <!-- Error State -->
    <div
      v-else-if="error"
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-2xl shadow-lg border border-red-100 p-8 text-center">
          <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg
              class="w-8 h-8 text-red-500"
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
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">
            Oops! Terjadi Kesalahan
          </h3>
          <p class="text-gray-600 mb-6">
            {{ error }}
          </p>
          <button
            class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105"
            @click="fetchDetail"
          >
            <svg
              class="w-5 h-5 inline mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              />
            </svg>
            Coba Lagi
          </button>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div
      v-else-if="pengaduan"
      class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-8">
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
              <div class="flex items-center justify-between">
                <button
                  class="flex items-center text-white hover:text-pink-100 transition-colors group"
                  @click="goBack"
                >
                  <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center mr-3 group-hover:bg-white/30 transition-colors">
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
                  </div>
                  <span class="font-medium">Kembali ke Daftar</span>
                </button>
                
                <div class="flex items-center space-x-3">
                  <div
                    :class="statusBadgeClass"
                    class="px-4 py-2 rounded-full text-sm font-semibold shadow-sm"
                  >
                    <div class="flex items-center space-x-2">
                      <div
                        :class="statusDotClass"
                        class="w-2 h-2 rounded-full"
                      />
                      <span>{{ pengaduan.status.charAt(0).toUpperCase() + pengaduan.status.slice(1) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Header Info -->
            <div class="px-6 py-6">
              <div class="flex items-start justify-between">
                <div>
                  <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Pengaduan
                  </h1>

                  <!-- Kode Pengaduan Section -->
                  <div
                    v-if="pengaduan.kode_pengaduan"
                    class="flex items-center mt-2 mb-4"
                  >
                    <div class="bg-gray-100 rounded-lg px-4 py-2 flex items-center space-x-3">
                      <span class="text-xl font-mono text-gray-800 tracking-wider">{{ pengaduan.kode_pengaduan }}</span>
                      <button
                        class="p-2 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 transition-colors relative" 
                        title="Salin Kode Pengaduan"
                        @click="copyToClipboard(pengaduan.kode_pengaduan)"
                      >
                        <svg
                          class="w-5 h-5"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-2M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1"
                          />
                        </svg>
                        <span
                          v-if="showCopySuccess"
                          class="absolute -top-8 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs px-2 py-1 rounded-md whitespace-nowrap animate-fade-out"
                        >Disalin!</span>
                      </button>
                    </div>
                    <p class="text-sm text-gray-600 ml-4">
                      Kode pengaduan Anda yang digunakan untuk mencari pengaduan.
                    </p>
                  </div>
                  <!-- End Kode Pengaduan Section -->

                  <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center">
                      <div class="w-5 h-5 bg-pink-100 rounded-full flex items-center justify-center mr-2">
                        <svg
                          class="w-3 h-3 text-pink-600"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                      </div>
                      <span>Dibuat: {{ formatDate(pengaduan.created_at) }}</span>
                    </div>
                    <div class="flex items-center">
                      <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                        <svg
                          class="w-3 h-3 text-blue-600"
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
                      </div>
                      <span>Kasus: {{ pengaduan.kasus }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
          <!-- Main Content -->
          <div class="xl:col-span-3 space-y-6">
            <!-- Informasi Pelapor -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gradient-to-r from-pink-50 to-pink-100 px-6 py-4 border-b border-pink-200">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-pink-500 rounded-xl flex items-center justify-center mr-4">
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
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h2 class="text-xl font-bold text-gray-900">
                      Informasi Pelapor
                    </h2>
                    <p class="text-sm text-gray-600">
                      Data orang yang melaporkan kejadian
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelapor</label>
                    <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                      <p class="text-gray-900 font-medium text-lg">
                        {{ pengaduan.nama_pelapor }}
                      </p>
                    </div>
                  </div>
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                    <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                      <p class="text-gray-900 font-medium text-lg">
                        {{ pengaduan.no_hp }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Informasi Korban -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4">
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
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h2 class="text-xl font-bold text-gray-900">
                      Informasi Korban
                    </h2>
                    <p class="text-sm text-gray-600">
                      Data orang yang menjadi korban
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Korban</label>
                    <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                      <p class="text-gray-900 font-medium text-lg">
                        {{ pengaduan.nama_korban }}
                      </p>
                    </div>
                  </div>
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Saksi</label>
                    <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                      <p class="text-gray-900 font-medium text-lg">
                        {{ pengaduan.saksi || 'Tidak ada saksi' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Detail Kejadian -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-blue-200">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4">
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                      />
                    </svg>
                  </div>
                  <div>
                    <h2 class="text-xl font-bold text-gray-900">
                      Detail Kejadian
                    </h2>
                    <p class="text-sm text-gray-600">
                      Informasi lengkap tentang kejadian
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="p-6 space-y-6">
                <div class="group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Kejadian</label>
                  <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                    <p class="text-gray-900 font-medium text-lg">
                      {{ formatDateTime(pengaduan.waktu_kejadian) }}
                    </p>
                  </div>
                </div>
                
                <div class="group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Kejadian</label>
                  <div class="bg-gray-50 rounded-xl p-4 group-hover:bg-gray-100 transition-colors">
                    <p class="text-gray-900 font-medium text-lg whitespace-pre-line">
                      {{ pengaduan.alamat }}
                    </p>
                  </div>
                </div>
                
                <div class="group">
                  <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Kejadian</label>
                  <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 group-hover:from-gray-100 group-hover:to-gray-200 transition-colors">
                    <p class="text-gray-900 leading-relaxed text-lg">
                      {{ pengaduan.deskripsi }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="xl:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">
                  Status Pengaduan
                </h3>
              </div>
              
              <div class="p-6 text-center">
                <div
                  :class="statusIconBgClass"
                  class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center mb-4"
                >
                  <svg
                    :class="statusIconTextClass"
                    class="w-10 h-10"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      v-if="pengaduan.status === 'selesai'"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <path
                      v-else-if="pengaduan.status === 'diproses'"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <path
                      v-else
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                    />
                  </svg>
                </div>
                
                <div
                  :class="statusBadgeClass"
                  class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold mb-3"
                >
                  <div
                    :class="statusDotClass"
                    class="w-2 h-2 rounded-full mr-2"
                  />
                  {{ pengaduan.status.charAt(0).toUpperCase() + pengaduan.status.slice(1) }}
                </div>
                
                <p class="text-sm text-gray-600 leading-relaxed">
                  {{ getStatusDescription(pengaduan.status) }}
                </p>
              </div>
            </div>

            <!-- Lampiran -->
            <div
              v-if="pengaduan.lampiran"
              class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden"
            >
              <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b border-purple-200">
                <h3 class="text-lg font-bold text-gray-900">
                  Lampiran
                </h3>
              </div>
              
              <div class="p-6">
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 hover:border-pink-300 hover:bg-pink-50 transition-all duration-200 group">
                  <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-200 transition-colors">
                      <svg
                        class="w-8 h-8 text-pink-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                        />
                      </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">
                      {{ getFileName(pengaduan.lampiran) }}
                    </h4>
                    <p class="text-sm text-gray-600 mb-4">
                      Dokumen lampiran pengaduan
                    </p>
                  </div>
                  
                  <div class="grid grid-cols-2 gap-3">
                    <button
                      class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 transform hover:scale-105"
                      @click="viewAttachment"
                    >
                      <svg
                        class="w-4 h-4 inline mr-1"
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
                      Lihat
                    </button>
                    <button
                      class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-xl transition-all duration-200"
                      @click="downloadAttachment"
                    >
                      <svg
                        class="w-4 h-4 inline mr-1"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                      Unduh
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
              <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">
                  Aksi Pengaduan
                </h3>
              </div>
              
              <div class="p-6 space-y-4">
                <button
                  class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center"
                  @click="editPengaduan"
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
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                    />
                  </svg>
                  Edit Pengaduan
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Fallback untuk data kosong -->
    <div
      v-else
      class="min-h-screen bg-gray-50 flex items-center justify-center"
    >
      <div class="text-center">
        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg
            class="w-8 h-8 text-gray-400"
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
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          Data Tidak Ditemukan
        </h3>
        <p class="text-gray-600 mb-4">
          Pengaduan yang Anda cari tidak dapat ditemukan.
        </p>
        <button
          class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-6 rounded-xl transition-colors"
          @click="goBack"
        >
          Kembali
        </button>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import SimpleLayout from '../../layouts/SimpleLayout.vue'
import api from '../../api.js'

const route = useRoute()
const router = useRouter()

// Reactive data
const pengaduan = ref(null)
const loading = ref(true)
const error = ref(null)
const showCopySuccess = ref(false) // New reactive state for copy success message

// Computed properties untuk status badge
const statusBadgeClass = computed(() => {
  const status = pengaduan.value?.status
  switch (status) {
    case 'selesai':
      return 'bg-green-100 text-green-800 border border-green-200'
    case 'diproses':
      return 'bg-yellow-100 text-yellow-800 border border-yellow-200'
    case 'pending':
      return 'bg-gray-100 text-gray-800 border border-gray-200'
    default:
      return 'bg-red-100 text-red-800 border border-red-200'
  }
})

const statusDotClass = computed(() => {
  const status = pengaduan.value?.status
  switch (status) {
    case 'selesai':
      return 'bg-green-500'
    case 'diproses':
      return 'bg-yellow-500'
    case 'pending':
      return 'bg-gray-500'
    default:
      return 'bg-red-500'
  }
})

const statusIconBgClass = computed(() => {
  const status = pengaduan.value?.status
  switch (status) {
    case 'selesai':
      return 'bg-green-100'
    case 'diproses':
      return 'bg-yellow-100'
    case 'pending':
      return 'bg-gray-100'
    default:
      return 'bg-red-100'
  }
})

const statusIconTextClass = computed(() => {
  const status = pengaduan.value?.status
  switch (status) {
    case 'selesai':
      return 'text-green-600'
    case 'diproses':
      return 'text-yellow-600'
    case 'pending':
      return 'text-gray-600'
    default:
      return 'text-red-600'
  }
})

// Methods
const fetchDetail = async () => {
  try {
    loading.value = true
    error.value = null
    
    const response = await api.get(`/kelola/pengaduan/${route.params.id}`)
    
    // Debug: log response untuk memastikan struktur data
    console.log('API Response:', response)
    console.log('Response Data:', response.data)
    
    // Pastikan pengaduan.value diset dengan benar
    if (response.data && response.data.data) {
      pengaduan.value = response.data.data
    } else if (response.data) {
      pengaduan.value = response.data
    } else {
      throw new Error('Data tidak ditemukan')
    }
    
  } catch (err) {
    console.error('Error fetching pengaduan detail:', err)
    error.value = err.response?.data?.message || err.message || 'Gagal memuat detail pengaduan'
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'Tanggal tidak tersedia'
  try {
    return new Date(dateString).toLocaleDateString('id-ID', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  } catch (// eslint-disable-next-line @typescript-eslint/no-unused-vars
  _e) {
    return 'Format tanggal tidak valid'
  }
}

const formatDateTime = (dateString) => {
  if (!dateString) return 'Waktu tidak tersedia'
  try {
    return new Date(dateString).toLocaleDateString('id-ID', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    })
  } catch (// eslint-disable-next-line @typescript-eslint/no-unused-vars
  _e) {
    return 'Format waktu tidak valid'
  }
}

const getStatusDescription = (status) => {
  switch (status) {
    case 'selesai':
      return 'Pengaduan telah selesai ditangani dan diselesaikan'
    case 'diproses':
      return 'Pengaduan sedang dalam proses penanganan oleh tim terkait'
    case 'pending':
      return 'Pengaduan menunggu untuk diproses lebih lanjut'
    default:
      return 'Status pengaduan tidak dikenal'
  }
}

const getFileName = (path) => {
  if (!path) return 'File tidak tersedia'
  return path.split('/').pop() || 'File tidak dikenal'
}

const goBack = () => {
  router.go(-1)
}

const viewAttachment = () => {
  if (pengaduan.value?.lampiran_url) {
    window.open(pengaduan.value.lampiran_url, '_blank')
  }
}

const downloadAttachment = () => {
  if (pengaduan.value?.lampiran) {
    const link = document.createElement('a')
    const fullUrl = pengaduan.value.lampiran.startsWith('http') 
      ? pengaduan.value.lampiran 
      : `/storage/${pengaduan.value.lampiran}`
    link.href = fullUrl
    link.download = getFileName(pengaduan.value.lampiran)
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
  }
}

const editPengaduan = () => {
  router.push(`/pengaduan/${pengaduan.value.id}/edit`)
}
const copyToClipboard = (text) => {
  if (text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    try {
      document.execCommand('copy');
      showCopySuccess.value = true;
      setTimeout(() => {
        showCopySuccess.value = false;
      }, 2000); // Pesan "Disalin!" akan hilang setelah 2 detik
    } catch (err) {
      console.error('Gagal menyalin teks:', err);
      // Fallback: Anda bisa menambahkan pesan error di UI jika gagal menyalin
    } finally {
      document.body.removeChild(textarea);
    }
  }
};

// Lifecycle
onMounted(() => {
  // Debug: pastikan route params ada
  console.log('Route params:', route.params)
  console.log('Pengaduan ID:', route.params.id)
  
  if (route.params.id) {
    fetchDetail()
  } else {
    error.value = 'ID pengaduan tidak ditemukan'
    loading.value = false
  }
})
</script>

<style scoped>
/* Custom animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeOut {
  0% { opacity: 1; transform: translateY(0); }
  80% { opacity: 1; transform: translateY(0); }
  100% { opacity: 0; transform: translateY(-10px); }
}

.fade-in {
  animation: fadeIn 0.5s ease-out;
}

.animate-fade-out {
  animation: fadeOut 2s forwards;
}

/* Smooth transitions */
* {
  transition: all 0.3s ease;
}

/* Hover effects */
.group:hover .group-hover\:scale-105 {
  transform: scale(1.05);
}

.group:hover .group-hover\:bg-pink-200 {
  background-color: rgb(251 207 232);
}

.group:hover .group-hover\:bg-gray-100 {
  background-color: rgb(243 244 246);
}

.group:hover .group-hover\:bg-gray-200 {
  background-color: rgb(229 231 235);
}

.group:hover .group-hover\:from-gray-100 {
  background-image: linear-gradient(to right, rgb(243 244 246), var(--tw-gradient-to));
}

.group:hover .group-hover\:to-gray-200 {
  --tw-gradient-to: rgb(229 231 235);
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #ec4899;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #db2777;
}
</style>
