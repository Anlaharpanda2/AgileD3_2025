<template>
  <SimpleLayout>
    <div class="p-5 max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold text-center mb-8 text-black">
        FAQ
      </h1>

      <div
        v-for="(faq, index) in faqs"
        :key="index"
        class="mb-4 border border-gray-200 rounded-2xl shadow-md overflow-hidden transition"
      >
        <button
          class="w-full flex items-center justify-between px-5 py-4"
          :style="{
            backgroundColor: 'var(--color-pink-50)',
            color: openIndex === index ? 'var(--accent-pink)' : 'var(--text-dark)'
          }"
          @click="toggle(index)"
        >
          <span class="font-medium text-base text-left">
            {{ faq.question }}
          </span>
          <svg
            :class="[
              'w-5 h-5 transform transition-transform duration-300',
              openIndex === index ? 'rotate-180' : 'rotate-0'
            ]"
            :style="{ color: openIndex === index ? 'var(--accent-pink)' : '#888' }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 9l-7 7-7-7"
            />
          </svg>
        </button>

        <transition name="fade">
          <div
            v-if="openIndex === index"
            class="px-5 py-4 text-gray-700 bg-white text-justify leading-relaxed"
          >
            <!-- eslint-disable-next-line vue/no-v-html -->
            <p v-html="faq.answer" />
          </div>
        </transition>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import { ref } from 'vue';
import SimpleLayout from '../../layouts/SimpleLayout.vue';

const openIndex = ref(null);
const toggle = (index) => {
  openIndex.value = openIndex.value === index ? null : index;
};

const faqs = [
  {
    question: 'Bagaimana cara mendaftar pelatihan?',
    answer: `
      Berikut langkah-langkah mendaftar pelatihan:<br>
      1. Kunjungi halaman <b>'Beranda'</b> pada website DP3AP2KB.<br>
      2. Pilih <b>'Layanan Pelatihan'</b> <br>
      3. Klik tombol <b>'Ikut Pelatihan'</b> pada pelatihan yang Anda pilih.<br>
      4. Isi formulir pendaftaran dengan lengkap (NIK, nama, alamat, dsb).<br>
      5. Upload dokumen pendukung jika diminta.<br>
      6. Klik <b>'Kirim'</b> dan tunggu notifikasi via email atau SMS.<br>
      7. Anda akan menerima konfirmasi jika pendaftaran berhasil.
    `
  },
  {
    question: 'Apakah pelatihan ini gratis?',
    answer: `
      Ya, semua pelatihan yang diselenggarakan oleh DP3AP2KB bersifat <b>gratis</b>.<br>
      Anda tidak akan dikenakan biaya apapun selama mengikuti proses pelatihan.
    `
  },
  {
    question: 'Apa saja syarat mengikuti pelatihan?',
    answer: `
      Syarat umum untuk mengikuti pelatihan:<br>
      1. Usia minimal 17 tahun.<br>
      2. Memiliki KTP atau identitas resmi lainnya.<br>
      3. Berdomisili di Provinsi Sumatera Barat.<br>
      4. Bersedia mengikuti pelatihan sampai selesai.<br>
      5. Mengisi formulir pendaftaran dengan lengkap dan benar.
    `
  },
  {
    question: 'Apakah saya akan mendapatkan sertifikat?',
    answer: `
      Ya, peserta akan memperoleh <b>sertifikat digital</b> setelah:<br>
      1. Mengikuti pelatihan minimal 80% dari total waktu.<br>
      2. Mengikuti evaluasi akhir pelatihan.<br>
      3. Tidak melakukan pelanggaran tata tertib pelatihan.<br>
      Sertifikat dapat diunduh melalui dashboard peserta.
    `
  },
  {
    question: 'Berapa lama waktu pelatihan berlangsung?',
    answer: `
      Durasi pelatihan bervariasi tergantung jenis pelatihan:<br>
      - Pelatihan singkat: 1 - 2 hari.<br>
      - Pelatihan intensif: 3 - 7 hari.<br>
      Jadwal lengkap akan diumumkan sebelum pelatihan dimulai.
    `
  },
  {
    question: 'Bagaimana saya tahu jika pelatihan sudah selesai?',
    answer: `
      Anda akan mendapatkan notifikasi melalui:<br>
      1. Email atau No Handphone yang Anda daftarkan.<br>
      2. Dashboard website DP3AP2KB akan muncul status <b>'Selesai'</b>.<br>
      Anda juga dapat langsung mengunduh sertifikat dari sana.
    `
  },
  {
    question: 'Apakah bisa ikut lebih dari satu pelatihan?',
    answer: `
      Ya, peserta boleh mengikuti lebih dari satu pelatihan.<br>
      Namun pendaftaran dilakukan satu per satu untuk setiap program.<br>
      Disarankan menyelesaikan satu pelatihan terlebih dahulu sebelum mendaftar lagi.
    `
  },
  {
    question: 'Bagaimana jika saya tidak bisa hadir di pelatihan?',
    answer: `
      Jika tidak bisa hadir, lakukan hal berikut:<br>
      1. Hubungi panitia pelatihan melalui kontak yang tersedia.<br>
      2. Ajukan alasan ketidakhadiran secara sopan.<br>
      3. Panitia akan menawarkan opsi reschedule (jika tersedia).<br>
      Jika tidak ada pemberitahuan, Anda akan dianggap mengundurkan diri.
    `
  },
  {
    question: 'Apakah pelatihan bisa diikuti secara online?',
    answer: `
      Ya, sebagian besar pelatihan tersedia dalam format online.<br>
      Anda akan mendapatkan:<br>
      - Link Zoom atau platform lainnya.<br>
      - Materi PDF & video tutorial.<br>
      - Panduan teknis untuk login dan interaksi.
    `
  },
  {
    question: 'Bagaimana cara mengetahui status pendaftaran saya?',
    answer: `
      Ikuti langkah berikut:<br>
      1. Login ke akun Anda di website DP3AP2KB.<br>
      2. Masuk ke menu <b>'Profile'</b> lalu lihat bagian <b>'Status Pendaftaran'</b>.<br>
      3. Lihat status: <i>Menunggu, Diterima, atau Ditolak</i>.<br>
      4. Jika ditolak, Anda dapat mengajukan ulang atau memilih pelatihan lain.
    `
  },
  {
    question: 'Apa yang harus saya siapkan sebelum pelatihan dimulai?',
    answer: `
      Persiapan yang disarankan:<br>
      - Perangkat HP/laptop yang stabil.<br>
      - Koneksi internet yang baik.<br>
      - Buku dan alat tulis.<br>
      - Kesiapan mengikuti pelatihan dari awal hingga selesai.
    `
  },
  {
    question: 'Apakah ada batas usia maksimal untuk ikut pelatihan?',
    answer: `
      Tidak ada batas usia maksimal.<br>
      Asalkan Anda memenuhi syarat dasar dan mampu mengikuti pelatihan, Anda dipersilakan untuk mendaftar.
    `
  }
];
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
