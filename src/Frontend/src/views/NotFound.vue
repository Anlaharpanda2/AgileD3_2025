<template>
  <div class="element-error-page">
    <div class="div">
      <!-- Wrapper baru untuk konten kiri (judul 404ERRORS, teks 404, paragraf, dan tombol) -->
      <div class="left-panel">
        <div class="element">404ERRORS</div>
        <div class="group">
          <!-- Teks '404' besar akan tetap position: absolute untuk menjaga layering -->
          <div class="text-wrapper">404</div>
          <div class="group-2">
            <p class="p">Maaf halaman yang anda cari tidak tersedia di sistem DP3AP2KB Provinsi Sumatera Barat</p>
            <div class="overlap-group-wrapper" @click="goToBeranda">
              <div class="overlap-group">
                <div class="text-wrapper-2">Kembali Ke Beranda</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Gambar tetap di sisi kanan -->
      <img class="img" src="/group-15-1.png" />
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function goToBeranda() {
  router.push('/')
}
</script>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
/* Impor font yang digunakan */
@import url("https://fonts.googleapis.com/css2?family=Clash+Grotesk:wght@500&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Concert+One&display=swap");
@import url("https://fonts.googleapis.com/css2?family=ABeeZee&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Aclonica&display=swap");


* {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}
button:focus-visible {
  outline: 2px solid #4a90e2 !important;
  outline: -webkit-focus-ring-color auto 5px !important;
}
a {
  text-decoration: none;
}

/* Animasi Goyang Atas Bawah untuk gambar */
@keyframes goyangAtasBawah {
  0% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(0);
  }
}

/* Kontainer utama halaman error */
.element-error-page {
  background-color: rgba(255, 255, 255, 1.0);
  display: flex;
  flex-direction: row;
  justify-content: center;
  width: 100%;
  min-height: 100vh; /* Gunakan min-height untuk memastikan tinggi penuh */
}

/* Div utama dengan background gradient dan layout flexbox */
.div {
  background: linear-gradient(
    72deg,
    rgb(250, 160, 183) 0%,
    rgb(255, 98, 147) 100%
  );
  width: 100%;
  min-height: 100vh; /* Pastikan tinggi penuh */
  display: flex; /* Menggunakan Flexbox */
  flex-direction: row; /* Default: item berdampingan (konten kiri - gambar) */
  flex-wrap: wrap; /* Izinkan wrapping untuk tampilan responsif */
  justify-content: center; /* Pusatkan item secara horizontal */
  align-items: center; /* Pusatkan item secara vertikal */
  gap: 40px; /* Jarak antara konten kiri dan gambar */
  padding: 20px; /* Padding keseluruhan untuk ruang */
}

/* Wrapper baru untuk konten panel kiri (404ERRORS title, 404 number, paragraph, button) */
.left-panel {
  display: flex;
  flex-direction: column; /* Susun item secara vertikal */
  align-items: center; /* Pusatkan item horizontal di dalam panel kiri */
  justify-content: center;
  flex-basis: 500px; /* Lebar dasar item, memungkinkan penyusutan/pembesaran */
  max-width: 90%; /* Batasi lebar maksimum untuk layar kecil */
  text-align: center; /* Pusatkan teks di dalam panel kiri */
  /* Tambahkan min-width agar panel tidak terlalu kecil pada layar sangat sempit */
  min-width: 280px;
}

/* Judul "404ERRORS" */
.element-error-page .element {
  font-family: "Clash Grotesk-Medium", Helvetica;
  font-weight: 500;
  color: #ffffff;
  font-size: 22px; /* Tetap fixed pixel seperti aslinya */
  letter-spacing: 0;
  line-height: normal;
  margin-bottom: 20px; /* Jarak di bawah judul */
  text-align: center; /* Pastikan teks di tengah */
}

/* Grup utama yang berisi teks "404", paragraf, dan tombol */
.element-error-page .group {
  width: 100%; /* Ambil lebar penuh dari left-panel */
  max-width: 463px; /* Lebar maksimum seperti aslinya */
  height: auto; /* Tinggi menyesuaikan konten */
  display: flex;
  flex-direction: column; /* Susun children secara vertikal */
  align-items: center; /* Pusatkan children secara horizontal */
  position: relative; /* Penting: Jadikan induk relatif agar .text-wrapper bisa absolute di dalamnya */
  /* Sesuaikan padding-top untuk mencegah tumpang tindih dengan teks '404' besar */
  /* Perhitungan: jika 404 di top -60px dan tinggi sekitar 302px (font-size),
     maka bagian bawahnya 302-60 = 242px dari top group.
     Padding-top harus lebih besar dari ini. */
  padding-top: 250px; /* Cukupkan padding atas untuk menghindari tumpang tindih */
  padding-bottom: 20px; /* Padding di bawah tombol */
}

/* Teks besar "404" */
.element-error-page .text-wrapper {
  /* TETAP menggunakan position: absolute untuk menjaga tampilan layering */
  position: absolute;
  top: -60px; /* Offset ke atas relatif terhadap parent .group */
  left: 50%; /* Pusatkan secara horizontal */
  transform: translateX(-50%); /* Penyesuaian untuk centering absolut */
  background: linear-gradient(
    180deg,
    rgba(27, 48, 68, 1) 0%,
    rgba(18, 38, 56, 1) 100%
  );
  -webkit-background-clip: text !important;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family: "Concert One-Regular", Helvetica;
  font-weight: 400;
  color: transparent;
  font-size: 302px; /* Tetap fixed pixel seperti aslinya */
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
  z-index: 0; /* Letakkan di belakang konten lain */
  pointer-events: none; /* Pastikan tidak menghalangi klik */
}

/* Kontainer paragraf dan tombol */
.element-error-page .group-2 {
  width: 100%;
  max-width: 382px; /* Lebar maksimum seperti aslinya */
  height: auto; /* Tinggi menyesuaikan konten */
  display: flex;
  flex-direction: column; /* Susun children secara vertikal */
  align-items: center; /* Pusatkan children horizontal */
  margin-top: 20px; /* Jarak dari elemen di atasnya (setelah padding group) */
  z-index: 1; /* Bawa ke depan dari teks '404' besar */
}

/* Paragraf pesan error */
.element-error-page .p {
  width: 100%;
  max-width: 380px; /* Lebar maksimum seperti aslinya */
  -webkit-text-stroke: 0.5px #ffffff;
  font-family: "ABeeZee-Regular", Helvetica;
  font-weight: 400;
  color: #ffffff;
  font-size: 21px; /* Tetap fixed pixel seperti aslinya */
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  margin-bottom: 30px; /* Jarak di bawah paragraf */
}

/* Wrapper tombol "Kembali Ke Beranda" */
.element-error-page .overlap-group-wrapper {
  width: 204px;
  height: 48px;
  cursor: pointer;
  margin-top: 10px; /* Jarak di atas tombol */
}

.element-error-page .overlap-group {
  position: relative; /* Bisa tetap relative jika ada elemen di dalamnya yang butuh absolute */
  width: 202px;
  height: 48px;
  background-color: #1a3f55;
  border-radius: 16px;
  display: flex; /* Menggunakan Flexbox untuk memusatkan teks */
  justify-content: center;
  align-items: center;
}

/* Teks tombol "Kembali Ke Beranda" */
.element-error-page .text-wrapper-2 {
  font-family: "Aclonica-Regular", Helvetica;
  font-weight: 400;
  color: #ffffff;
  font-size: 14px; /* Tetap fixed pixel seperti aslinya */
  text-align: center;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}

/* Gambar */
.element-error-page .img {
  animation: goyangAtasBawah 2s ease-in-out infinite;
  width: auto; /* Biarkan flexbox dan max-width menentukan */
  height: auto; /* Jaga rasio aspek */
  max-width: 474px; /* Lebar maksimum gambar, seperti aslinya */
  flex-shrink: 0; /* Cegah gambar menyusut terlalu banyak */
  object-fit: cover;
  /* Tambahkan min-width agar gambar tidak terlalu kecil */
  min-width: 250px;
}
@media(max-width:750px){
  /* Container utama: susun item secara vertikal */
  .div {
    flex-direction: column; /* Konten dan gambar bertumpuk */
    gap: 20px; /* Kurangi jarak antar item */
  }

  /* Urutan item untuk mobile: gambar di atas, teks di bawah */
  .left-panel {
    order: 2; /* Panel kiri (teks) akan berada di bawah */
    flex-basis: auto; /* Reset flex-basis */
    max-width: 95%; /* Lebih lebar untuk mobile */
  }
  .element-error-page .img {
    order: 1; /* Gambar akan berada di atas */
    width: 50%; /* Lebar 50% dari layar */
    max-width: 250px; /* Batasi ukuran gambar agar tidak terlalu besar di mobile */
    min-width: 150px; /* Batasi ukuran gambar agar tidak terlalu kecil */
  }

  /* Sembunyikan judul "404ERRORS" di mobile */
  .element {
    display: none;
  }

  /* Sesuaikan grup utama untuk mobile */
  .element-error-page .group {
    width: 100%;
    max-width: 400px; /* Batasi lebar untuk mobile */
    padding-top: 150px; /* Sesuaikan padding untuk teks '404' */
  }

  /* Ukuran teks '404' besar untuk mobile */
  .element-error-page .text-wrapper {
    font-size: 200px; /* Ukuran lebih kecil */
    top: -40px; /* Sesuaikan offset */
  }

  /* Ukuran paragraf untuk mobile */
  .element-error-page .p {
    font-size: 18px;
  }

  /* Sesuaikan kontainer paragraf dan tombol untuk mobile */
  .element-error-page .group-2 {
    max-width: 300px;
  }
}
</style>
