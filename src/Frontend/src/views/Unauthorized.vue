<template>
  <div class="error-container">
    <div class="content-wrapper">
      <div class="text-section">
        <div class="ooops-text">Ooops....</div>
        <div class="access-denied-title">Akses Ditolak</div>
        <div class="permission-message">Anda tidak memiliki izin untuk mengakses halaman ini.</div>
        <div class="back-home-button" @click="goToBeranda">
          <div class="button-text">Kembali Ke Beranda</div>
        </div>
      </div>
      <img class="error-image" alt="Akses Ditolak" src="/Forbiden/image.png" />
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

// Fungsi untuk mengarahkan pengguna kembali ke halaman beranda
function goToBeranda() {
  router.push('/')
}
</script>

<style scoped>
/* Import font Poppins dan Clash Grotesk */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Clash+Grotesk:wght@500&display=swap');

/* Reset margin default untuk body */
body {
  margin: 0;
  line-height: normal;
}

/* Variabel CSS untuk warna dan font */
:root {
  --color-black: #000;
  --color-gray: #767676;
  --color-darkslategray: #ff0606;
  --color-white: #fff;
  --font-poppins: 'Poppins', sans-serif;
  --font-clash-grotesk: 'Clash Grotesk', sans-serif;
}

/* Gaya untuk kontainer utama halaman error */
.error-container {
  width: 100%;
  height: 100vh; /* Mengisi seluruh tinggi viewport */
  display: flex;
  justify-content: center; /* Memusatkan secara horizontal */
  align-items: center; /* Memusatkan secara vertikal */
  background: linear-gradient(253.9deg, var(--color-white), #ffe2e2);
  text-align: left;
  font-family: var(--font-poppins);
  font-size: 56.89px; /* Ukuran font default untuk teks besar */
  color: var(--color-black);
  overflow: hidden; /* Mencegah overflow */
}

/* Wrapper untuk konten (teks dan gambar) */
.content-wrapper {
  display: flex;
  flex-wrap: wrap; /* Memungkinkan wrap pada layar kecil */
  justify-content: center; /* Memusatkan item di dalam wrapper */
  align-items: center;
  max-width: 1200px; /* Batasan lebar maksimum untuk desktop */
  padding: 20px; /* Padding di sekitar konten */
  gap: 40px; /* Jarak antara teks dan gambar */
}

/* Bagian teks */
.text-section {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  gap: 10px;
  max-width: 500px; /* Batasan lebar untuk bagian teks */
}

.ooops-text {
  font-weight: 600;
  font-size: 56.89px;
}

.access-denied-title {
  font-size: 35.56px;
  font-weight: 300;
}

.permission-message {
  font-size: 21.33px;
  font-weight: 300;
  color: var(--color-gray);
  margin-bottom: 20px; /* Jarak sebelum tombol */
}

/* Tombol "Kembali Ke Beranda" */
.back-home-button {
  position: relative;
  width: 202px;
  height: 48px;
  background-color: #1a3f55;
  border-radius: 16px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer; /* Menambahkan indikator klik */
  transition: background-color 0.3s ease; /* Efek hover */
}

.back-home-button:hover {
  background-color: #77215c; /* Warna lebih gelap saat hover */
}

.button-text {
  font-family: 'Aclonica-Regular', Helvetica; /* Menggunakan font asli yang Anda berikan */
  font-weight: 400;
  color: var(--color-white);
  font-size: 14px;
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}

/* Gambar error */
.error-image {
  width: 581px; /* Lebar default untuk desktop */
  max-width: 100%; /* Memastikan gambar tidak melebihi lebar kontainernya */
  height: auto; /* Mempertahankan rasio aspek */
  object-fit: contain; /* Memastikan gambar pas di dalam elemennya */
}

/* Media query untuk layar lebih kecil dari 750px (mobile) */
@media screen and (max-width: 750px) {
  .content-wrapper {
    flex-direction: column-reverse; /* Gambar di atas teks */
    text-align: center; /* Teks di tengah */
    gap: 30px; /* Sesuaikan jarak untuk mobile */
    padding: 15px; /* Padding lebih kecil untuk mobile */
  }

  .text-section {
    align-items: center; /* Memusatkan item teks di mobile */
    max-width: 100%; /* Gunakan lebar penuh yang tersedia */
  }

  .ooops-text {
    font-size: 40px; /* Ukuran font lebih kecil untuk mobile */
  }

  .access-denied-title {
    font-size: 28px; /* Ukuran font lebih kecil untuk mobile */
  }

  .permission-message {
    font-size: 16px; /* Ukuran font lebih kecil untuk mobile */
  }

  .error-image {
    width: 50vw; /* Gambar 1/2 dari lebar viewport mobile */
    margin-bottom: 20px; /* Jarak antara gambar dan teks */
  }

  .back-home-button {
    width: 100%; /* Tombol bisa lebih lebar di mobile */
    max-width: 250px; /* Atau batasi lebar maksimumnya */
  }
}
</style>
