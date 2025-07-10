<template>
  <SimpleLayout>
    <div>
      <h1 class="p-5 text-2xl font-bold">
        Layanan Pendampingan
      </h1>

      <p class="pt-1 p-5 leading-relaxed text-justify">
        DP3AP2KB Provinsi Sumatera Barat menyediakan <b>layanan pendampingan langsung</b> bagi masyarakat yang mengalami permasalahan serius, seperti:
      </p>
      <ul class="list-disc list-inside px-5 mt-1 mb-3">
        <li>Kekerasan Dalam Rumah Tangga (KDRT)</li>
        <li>Kekerasan terhadap Anak</li>
        <li>Diskriminasi atau permasalahan sosial lainnya</li>
      </ul>

      <p class="px-5 leading-relaxed text-justify">
        Layanan ini bertujuan untuk memastikan korban mendapatkan <b>bantuan tepat waktu, empatik, dan berkelanjutan</b>, mulai dari proses pelaporan hingga pemulihan.
      </p>

      <p class="px-5 leading-relaxed text-justify mt-4">
        <b>Jenis Pendampingan yang Disediakan:</b>
      </p>
      <ol class="list-decimal list-inside px-5 mt-2 mb-2">
        <li>
          <b>Pendampingan Psikologis</b><br>
          Korban akan didampingi oleh psikolog untuk mengatasi trauma dan tekanan mental akibat kekerasan atau masalah sosial yang dialami.
        </li>
        <li class="mt-2">
          <b>Pendampingan Hukum</b><br>
          DP3AP2KB menyediakan bantuan dari tenaga hukum atau advokat untuk memberikan pemahaman hak-hak hukum korban dan mendampingi selama proses hukum berjalan.
        </li>
        <li class="mt-2">
          <b>Proses Laporan hingga Selesai</b><br>
          Pendampingan dilakukan sejak korban membuat laporan di DP3AP2KB hingga kasus tuntas dan korban mendapatkan perlindungan atau pemulihan.
        </li>
        <li class="mt-2">
          <b>Koneksi dengan Lembaga Terkait</b><br>
          Jika dibutuhkan, DP3AP2KB akan menghubungkan korban dengan lembaga:
          <ul class="list-[circle] list-inside ml-5 mt-1">
            <li>P2TP2A (Pusat Pelayanan Terpadu Perlindungan Perempuan dan Anak)</li>
            <li>RSUD dan unit kesehatan mental</li>
            <li>Lembaga hukum dan bantuan sosial</li>
          </ul>
        </li>
      </ol>

      <p class="px-5 leading-relaxed text-justify mt-4">
        <b>Cara Mengakses Layanan:</b>
      </p>
      <ul class="list-disc list-inside px-5 mt-2 mb-2">
        <li>Datang langsung ke kantor DP3AP2KB atau isi form permohonan online</li>
        <li>Tim kami akan segera menghubungi untuk verifikasi dan jadwal pendampingan</li>
        <li>Pendampingan dilakukan secara pribadi dan rahasia</li>
      </ul>

      <p class="px-5 leading-relaxed text-justify mt-4">
        🛡️ Semua layanan bersifat <b>gratis, aman, dan rahasia</b>.<br>
        🚨 Jika Anda atau seseorang yang Anda kenal sedang berada dalam situasi darurat, segera hubungi pihak berwajib atau layanan darurat terdekat.
      </p>
    </div>
  </SimpleLayout>
</template>

<script setup>
import SimpleLayout from '../../layouts/SimpleLayout.vue';

defineOptions({
  name: 'PendampinganPage'
});
</script>
