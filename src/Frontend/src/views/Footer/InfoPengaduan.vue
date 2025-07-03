<template>
  <layout2>
    <div>
      <h1 class="p-5 text-2xl font-bold">
        Layanan Pengaduan Masyarakat
      </h1>
      <div class="pt-1 p-5 leading-relaxed text-justify">
        <p>
          Layanan Pengaduan DP3AP2KB adalah sarana resmi untuk masyarakat dalam melaporkan kasus
          <b>kekerasan terhadap perempuan dan anak</b>, penelantaran, atau permasalahan sosial lainnya.
        </p>

        <br>

        <p>
          Setiap laporan akan ditangani secara <b>rahasia, aman, dan profesional</b> oleh tim khusus kami
          yang terdiri dari petugas lapangan, psikolog, dan tim hukum.
        </p>

        <br>

        <div>
          <b>Tata Cara Pengaduan:</b>
          <ol class="list-decimal list-inside mt-2 mb-2">
            <li>
              <b>Isi Formulir Pengaduan Online</b><br>
              Klik link berikut untuk mengisi formulir:  
              🔗 <router-link to="/pengaduan/buat" class="text-blue-600 underline">Formulir Pengaduan</router-link>
            </li>
            <li class="mt-2">
              <b>Verifikasi Awal</b><br>
              Tim DP3AP2KB akan memverifikasi isi laporan dan menghubungi pelapor untuk konfirmasi data.
            </li>
            <li class="mt-2">
              <b>Penanganan dan Tindak Lanjut</b><br>
              Tim akan melakukan langkah-langkah awal penanganan di lapangan jika diperlukan.
            </li>
            <li class="mt-2">
              <b>Pendampingan Psikologis dan Hukum</b><br>
              Korban akan mendapatkan pendampingan dari psikolog atau bantuan hukum bila dibutuhkan.
            </li>
            <li class="mt-2">
              <b>Koordinasi Lanjutan</b><br>
              Bila perlu, kami akan menghubungkan korban dengan lembaga mitra seperti P2TP2A, pihak kepolisian, atau rumah aman.
            </li>
          </ol>
        </div>

        <br>

        <div>
          <b>Jenis Laporan yang Bisa Diajukan:</b>
          <ul class="list-disc list-inside mt-2 mb-2">
            <li>KDRT (Kekerasan Dalam Rumah Tangga)</li>
            <li>Kekerasan atau eksploitasi terhadap anak</li>
            <li>Pelecehan seksual atau verbal</li>
            <li>Penelantaran keluarga atau anak</li>
            <li>Kasus sosial atau diskriminasi berbasis gender</li>
          </ul>
        </div>

        <br>

        <p>
          🛡️ Kami menjamin <b>kerahasiaan laporan</b> Anda dan memastikan pendampingan sesuai prosedur.
          🚨 Jika Anda dalam keadaan darurat, segera hubungi layanan darurat atau kepolisian terdekat.
        </p>

        <br>

        <router-link to="/pengaduan/buat">
          <button class="mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
            Laporkan Sekarang
          </button>
        </router-link>
      </div>
    </div>
  </layout2>
</template>

<script setup>
import layout2 from '../../layouts/Layout2.vue';
</script>
