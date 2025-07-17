<script setup lang="ts">
// CATATAN: Semua impor dari 'element-plus' dan '@element-plus/icons-vue' 
// telah dihapus untuk mengurangi ukuran bundle.
// Komponen sekarang tidak memiliki dependensi script.
</script>

<template>
  <!-- Tentang Kami -->
  <section class="py-16 md:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- 
        CATATAN: ElRow dan ElCol diganti dengan div dan utility Flexbox dari Tailwind.
        '-mx-4' pada parent dan 'px-4' pada child digunakan untuk menciptakan efek gutter.
      -->
      <div class="flex flex-wrap items-center -mx-4">
        <!-- Kolom Teks Konten -->
        <div
          class="w-full md:w-1/2 px-4"
          data-aos="fade-right"
        >
          <div class="md:pr-8">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
              Tentang Kami
            </h2>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed text-justify">
              Dinas Pemberdayaan Perempuan dan Perlindungan Anak, Pengendalian Penduduk dan Keluarga Berencana (DP3AP2KB)
              berkomitmen untuk menciptakan masyarakat yang adil gender, melindungi hak-hak anak,
              dan mendukung program keluarga berencana yang berkelanjutan.
            </p>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed text-justify">
              Melalui berbagai program inovatif dan pelayanan terintegrasi, kami berupaya
              memberdayakan perempuan untuk berperan aktif dalam pembangunan, melindungi
              anak dari segala bentuk kekerasan, dan mendukung keluarga Indonesia yang sejahtera.
            </p>
            
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 gap-4 sm:gap-6 mt-8 sm:mt-12">
              <div class="text-center">
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-pink-500 mb-2">
                  5000+
                </h3>
                <p class="text-sm sm:text-base text-gray-600 font-medium">
                  Wanita Diberdayakan
                </p>
              </div>
              <div class="text-center">
                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-pink-500 mb-2">
                  15+
                </h3>
                <p class="text-sm sm:text-base text-gray-600 font-medium">
                  Kabupaten Kota
                </p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Kolom Foto Kepala Dinas -->
        <div
          class="w-full md:w-1/2 px-4 hidden sm:block"
          data-aos="fade-left"
        >
          <div class="flex items-center justify-center h-96 mt-12 md:mt-0">
            <div class="relative">
              <!-- Background Circle dengan Gradient -->
              <div class="w-[20rem] h-[20rem] bg-gradient-to-br from-pink-100 to-purple-100 rounded-full flex items-center justify-center shadow-lg">
                <!-- Foto Kepala Dinas -->
                <div class="w-[17.5rem] h-[17.5rem] rounded-full overflow-hidden border-4 border-white shadow-xl">
                  <img
                    src="/kadis.png"
                    alt="Kepala Dinas DP3AP2KB"
                    class="w-full h-full object-cover object-center"
                  >
                </div>
              </div>
              
              <!-- Decorative Elements -->
              <div class="absolute -top-2 -right-2 w-8 h-8 bg-pink-400 rounded-full opacity-70 animate-pulse" />
              <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-purple-400 rounded-full opacity-60 animate-pulse delay-300" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
/* TAG STYLE INI SEKARANG KOSONG.
  Semua styling, termasuk keyframes, class kustom, dan media query, 
  telah dimigrasikan ke dalam class utility Tailwind di dalam template.
*/
</style>