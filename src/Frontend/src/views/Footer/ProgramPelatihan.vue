<template>
  <SimpleLayout>
    <div>
      <h1 class="p-5 text-2xl font-bold">
        Program Pelatihan Masyarakat DP3AP2KB
      </h1>
      <div class="pt-1 p-5 leading-relaxed text-justify">
        <p>
          Dinas Pemberdayaan Perempuan, Perlindungan Anak, dan Keluarga Berencana (DP3AP2KB) Provinsi Sumatera Barat menyelenggarakan
          <b> Program Pelatihan Masyarakat </b> sebagai bagian dari upaya meningkatkan <b> kapasitas, keterampilan, dan kesadaran </b> masyarakat dalam bidang <b>Pemberdayaan Perempuan</b>
        </p>

        <p>
          Program ini bersifat <b>gratis</b> dan terbuka bagi masyarakat umum yang memenuhi syarat pendaftaran.
        </p>

        <p class="mt-4">
          <b>Manfaat Mengikuti Program:</b>
        </p>

        <ul class="list-disc list-inside mt-2 mb-2">
          <li>Memperoleh wawasan dan keterampilan baru</li>
          <li>Meningkatkan kesiapan dalam menghadapi tantangan ekonomi</li>
          <li>Memperoleh <b>sertifikat resmi</b> dari DP3AP2KB</li>
        </ul>

        <p class="mt-4">
          <b>Fitur dalam Program Pelatihan:</b>
        </p>

        <ol class="list-decimal list-inside mt-2 mb-2">
          <li>
            <b>Pendaftaran Online</b>  
            <br>
            Calon peserta dapat mendaftar langsung melalui sistem pendaftaran yang tersedia di website. Formulir meliputi data diri, NIK (verifikasi via API Dukcapil), serta jenis pelatihan yang diikuti.
          </li>
          <li class="mt-2">
            <b>Pretest dan Posttest</b>  
            <br>
            Digunakan sebagai evaluasi pemahaman peserta sebelum dan sesudah pelatihan. Nilai hasil evaluasi akan mempengaruhi kelulusan dan sertifikasi.
          </li>
          <li class="mt-2">
            <b>Sertifikat Digital</b>  
            <br>
            Peserta yang memenuhi syarat kelulusan (mengikuti pelatihan penuh dan lulus posttest) akan mendapatkan sertifikat dalam bentuk PDF yang dapat diunduh langsung.
          </li>
          <li class="mt-2">
            <b>Manajemen Data Peserta dan Pelatihan (Untuk Admin)</b>  
            <br>
            Admin dan panitia pelatihan dapat mengelola:
            <ul class="list-disc list-inside mt-1">
              <li>Data peserta (verifikasi, kelulusan, dan sertifikasi)</li>
              <li>Jadwal dan lokasi pelatihan</li>
              <li>Materi pelatihan yang diunggah</li>
              <li>Monitoring hasil pretest dan posttest</li>
            </ul>
          </li>
        </ol>

        <p class="mt-4">
          <b>Jenis Pelatihan yang Disediakan:</b>
        </p>

        <ul class="list-disc list-inside mt-2 mb-2">
          <li>Pelatihan Keterampilan Ekonomi Perempuan</li>
        </ul>

        <p class="mt-4">
          📌 Semua pelatihan akan dilaksanakan secara luring, tergantung jadwal dan ketersediaan tempat.
        </p>

        <p class="mt-4">
          🎓 Ayo daftarkan diri Anda sekarang dan jadilah bagian dari masyarakat yang lebih cakap, sadar, dan siap menghadapi tantangan keluarga dan sosial masa kini.
        </p>
      </div>
    </div>
  </SimpleLayout>
</template>

<script setup>
import SimpleLayout from '../../layouts/SimpleLayout.vue';
</script>
