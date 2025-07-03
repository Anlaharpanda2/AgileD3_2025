<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8 px-4 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 sm:text-3xl">Kelola Data</h1>
        <p class="text-gray-600 text-sm sm:text-base">Manajemen data dan pengaturan sistem</p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-4">
        <!-- Dynamic Cards -->
        <div 
          v-for="card in cards" 
          :key="card.id"
          class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-4 sm:p-5 lg:p-6 border border-gray-200"
          :class="{ 'bg-gradient-to-br from-pink-50 to-white border-2 border-pink-300': card.buttonColor === 'pink' }"
          @click="handleCardClick(card)"
        >
          <div class="flex items-center mb-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-3 sm:mr-4">
              <!-- Document Icon -->
              <svg v-if="card.icon === 'document'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <!-- Newspaper Icon -->
              <svg v-else-if="card.icon === 'newspaper'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
              </svg>
              <!-- Shield Icon -->
              <svg v-else-if="card.icon === 'shield'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12V9a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
              </svg>
              <!-- Chat Icon -->
              <svg v-else-if="card.icon === 'chat'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
              </svg>
              <!-- Users Icon -->
              <svg v-else-if="card.icon === 'users'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
              <!-- Lock Icon -->
              <svg v-else-if="card.icon === 'lock'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <!-- Building Icon -->
              <svg v-else-if="card.icon === 'building'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
              <!-- User Icon -->
              <svg v-else-if="card.icon === 'user'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <!-- Chart Icon -->
              <svg v-else-if="card.icon === 'chart'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
              <!-- Clipboard Icon -->
              <svg v-else-if="card.icon === 'clipboard'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
              </svg>
              <!-- Book Icon -->
              <svg v-else-if="card.icon === 'book'" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
            </div>
            <h3 class="text-base sm:text-lg lg:text-xl font-semibold text-gray-900">{{ card.title }}</h3>
          </div>
          <p class="text-sm sm:text-base text-gray-600 mb-3 sm:mb-4">{{ card.description }}</p>
          <button 
            class="w-full py-2 px-3 sm:px-4 rounded-lg transition-all duration-200 text-sm sm:text-base font-medium"
            :class="[
              card.buttonColor === 'pink' ? 'bg-pink-600 text-white hover:bg-pink-700 active:bg-pink-800' : 'bg-gray-500 text-white hover:bg-gray-600 active:bg-gray-700',
              { 'animate-pulse': isLoading }
            ]"
            @click.stop="handleButtonClick(card)"
            :disabled="isLoading"
          >
            {{ isLoading ? 'Loading...' : card.buttonText }}
          </button>
        </div>

        <!-- Card 2: Pengelola Berita dan Pengumuman -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Berita & Pengumuman</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola berita dan pengumuman untuk publikasi informasi</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 3: Pengelola Pengaduan -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12V9a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Pengaduan</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola pengaduan dan sistem pelaporan masalah</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 4: Pengelola Konsultasi -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Konsultasi</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola konsultasi dan layanan bantuan pengguna</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 5: Pengelola Data Panitia Kegiatan -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Panitia Kegiatan</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola data panitia kegiatan dan organisasi acara</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 6: Pengelola Akses Admin -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Akses Admin</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola akses admin dan pengaturan hak akses pengguna</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 7: Pengelola Fasilitas -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Fasilitas</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola fasilitas dan infrastruktur pendukung</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 8: Pengelola Struktur Pegawai -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Struktur Pegawai</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola struktur pegawai dan organisasi karyawan</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 9: Melihat Nilai Pretest dan Postest -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Nilai Pretest & Postest</h3>
          </div>
          <p class="text-gray-600 mb-4">Melihat nilai pretest dan postest peserta pelatihan</p>
          <button class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 transition-colors duration-200">
            Lihat Data
          </button>
        </div>

        <!-- Card 10: Pengelola Pretest dan Postest -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Pretest & Postest</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola pretest dan postest untuk evaluasi peserta</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>

        <!-- Card 11: Pengelola Peserta Pelatihan -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300 p-6 border border-gray-200">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Peserta Pelatihan</h3>
          </div>
          <p class="text-gray-600 mb-4">Pengelola peserta pelatihan dan manajemen kursus</p>
          <button class="w-full bg-pink-600 text-white py-2 px-4 rounded-lg hover:bg-pink-700 transition-colors duration-200">
            Kelola Data
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

// Define interfaces for type safety
interface CardData {
  id: number
  title: string
  description: string
  icon: string
  buttonText: string
  buttonColor: string
  route?: string
}

// Reactive data
const cards = ref<CardData[]>([
  {
    id: 1,
    title: 'Data Pendaftaran',
    description: 'Pengelola data pendaftaran peserta dan administrasi pendaftaran',
    icon: 'document',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/pendaftaran'
  },
  {
    id: 2,
    title: 'Berita & Pengumuman',
    description: 'Pengelola berita dan pengumuman untuk publikasi informasi',
    icon: 'newspaper',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/berita'
  },
  {
    id: 3,
    title: 'Pengaduan',
    description: 'Pengelola pengaduan dan sistem pelaporan masalah',
    icon: 'shield',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/pengaduan'
  },
  {
    id: 4,
    title: 'Konsultasi',
    description: 'Pengelola konsultasi dan layanan bantuan pengguna',
    icon: 'chat',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/konsultasi'
  },
  {
    id: 5,
    title: 'Panitia Kegiatan',
    description: 'Pengelola data panitia kegiatan dan organisasi acara',
    icon: 'users',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/panitia'
  },
  {
    id: 6,
    title: 'Akses Admin',
    description: 'Pengelola akses admin dan pengaturan hak akses pengguna',
    icon: 'lock',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/admin'
  },
  {
    id: 7,
    title: 'Fasilitas',
    description: 'Pengelola fasilitas dan infrastruktur pendukung',
    icon: 'building',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/fasilitas'
  },
  {
    id: 8,
    title: 'Struktur Pegawai',
    description: 'Pengelola struktur pegawai dan organisasi karyawan',
    icon: 'user',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/pegawai'
  },
  {
    id: 9,
    title: 'Nilai Pretest & Postest',
    description: 'Melihat nilai pretest dan postest peserta pelatihan',
    icon: 'chart',
    buttonText: 'Lihat Data',
    buttonColor: 'gray',
    route: '/nilai'
  },
  {
    id: 10,
    title: 'Pretest & Postest',
    description: 'Pengelola pretest dan postest untuk evaluasi peserta',
    icon: 'clipboard',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/test'
  },
  {
    id: 11,
    title: 'Peserta Pelatihan',
    description: 'Pengelola peserta pelatihan dan manajemen kursus',
    icon: 'book',
    buttonText: 'Kelola Data',
    buttonColor: 'pink',
    route: '/peserta'
  }
])

const isLoading = ref<boolean>(false)

// Methods
const handleCardClick = (card: CardData) => {
  console.log(`Navigating to ${card.route}`)
  // Router navigation will be implemented here
  // router.push(card.route)
}

const handleButtonClick = (card: CardData) => {
  isLoading.value = true
  
  // Simulate API call or navigation
  setTimeout(() => {
    handleCardClick(card)
    isLoading.value = false
  }, 500)
}

// Lifecycle hooks
onMounted(() => {
  console.log('KelolaData component mounted')
})
</script>

<style scoped>
/* Deep selector untuk override styling dari library */
:deep(.card-override) {
  background: linear-gradient(135deg, #fdf2f8 0%, #ffffff 100%);
  border: 2px solid #f9a8d4;
}

:deep(.pink-accent) {
  color: #ec4899;
  border-color: #ec4899;
}

:deep(.pink-accent:hover) {
  color: #be185d;
  border-color: #be185d;
  background-color: #fdf2f8;
}

/* Animation untuk loading state */
@keyframes pulse-pink {
  0%, 100% {
    background-color: #ec4899;
  }
  50% {
    background-color: #be185d;
  }
}

/* Custom scrollbar untuk mobile */
@media (max-width: 767px) {
  ::-webkit-scrollbar {
    width: 4px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f5f9;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #ec4899;
    border-radius: 2px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #be185d;
  }
}
</style>