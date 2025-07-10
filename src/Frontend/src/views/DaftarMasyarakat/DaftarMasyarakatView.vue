<script>
import api from '../../api'; // Pastikan path ini benar untuk axios instance Anda
import { ElNotification } from 'element-plus'; // Impor ElNotification

export default {
  data() {
    return {
      namaLengkap: '',
      nik: '',
      tempatLahir: '',
      tanggalLahir: '',
      // errorMessage: '', // Dihapus karena notifikasi akan menggunakan ElNotification
    };
  },
  methods: {
    /**
     * Memvalidasi form pendaftaran dan mengirim data ke API.
     * @param {Event} event - Event submit form.
     */
    async submitRegistration(event) {
      event.preventDefault(); // Mencegah reload halaman default form

      // --- Validasi Input ---
      if (!this.namaLengkap.trim()) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'Nama Lengkap tidak boleh kosong',
          duration: 3000 // Notifikasi ditampilkan selama 3 detik
        });
        return;
      }
      if (/\d/.test(this.namaLengkap)) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'Nama Lengkap tidak boleh mengandung angka',
          duration: 3000
        });
        return;
      }

      if (!/^\d{16}$/.test(this.nik)) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'NIK harus 16 angka',
          duration: 3000
        });
        return;
      }

      if (!this.tempatLahir.trim()) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'Tempat Lahir tidak boleh kosong',
          duration: 3000
        });
        return;
      }
      if (/\d/.test(this.tempatLahir)) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'Tempat Lahir tidak boleh mengandung angka',
          duration: 3000
        });
        return;
      }

      if (!this.tanggalLahir) {
        ElNotification.error({
          title: 'Error Validasi',
          message: 'Tanggal Lahir tidak boleh kosong',
          duration: 3000
        });
        return;
      }

      // --- Pengiriman Data ke API ---
      try {
        // Membangun payload JSON sesuai format yang diminta
        const payload = {
          nama: this.namaLengkap,
          nik: this.nik,
          // Menggabungkan tempat_lahir dan tanggal_lahir menjadi satu string
          tempat_tanggal_lahir: `${this.tempatLahir}, ${this.tanggalLahir}`
        };

        // Mengirim data pendaftaran ke endpoint API menggunakan Axios
        const response = await api.post('/daftar/masyarakat', payload);

        // Jika pendaftaran berhasil:
        ElNotification.success({
          title: 'Berhasil',
          message: response.data.message || 'Pendaftaran berhasil!',
          duration: 3000
        });

        // Redirect setelah sedikit delay agar pengguna dapat melihat pesan sukses
        setTimeout(() => {
          this.$router.push('/login/masyarakat');
        }, 2000); // Redirect setelah 2 detik

      } catch (error) {
        // Jika pendaftaran gagal:
        ElNotification.error({
          title: 'Gagal',
          message: error.response?.data?.message || 'Pendaftaran gagal. Mohon coba lagi.',
          duration: 3000
        });
        console.error('Error pendaftaran:', error);
      }
    }
  }
};
</script>

<template>
  <div class="coverpage">
    <div class="overlap">
      <div class="ellipse" />
      <div class="div" />
      <div class="login">
        <div class="overlap-group">
          <div class="rectangle" />
          <img
            class="mask-group"
            src="https://c.animaapp.com/IJi6pJQY/img/mask-group@2x.png"
          >
          <div class="group">
            <img
              class="thunderbolt"
              src="https://c.animaapp.com/IJi6pJQY/img/thunderbolt-1@2x.png"
            >
          </div>
          <div class="keluarga-sejahtera">
            Keluarga<br>Sejahtera<br>Setara<br>Terlindung
          </div>
        </div>
        <div class="overlap-2">
          <div class="group-2">
            <!-- Bagian pesan error/success yang sebelumnya menggunakan errorMessage sekarang dihapus -->
            <div class="masuk">
              DAFTAR
            </div> <!-- Diubah dari 'MASUK' ke 'DAFTAR' -->
            <p class="p">
              Silahkan Lengkapi Data Diri Anda
            </p> <!-- Pesan diubah -->

            <form
              class="form-register"
              @submit="submitRegistration"
            >
              <!-- Input: Nama Lengkap -->
              <div class="form-group">
                <div class="overlap-4">
                  <input
                    v-model="namaLengkap"
                    type="text"
                    class="text-wrapper-3"
                    placeholder="Nama Lengkap"
                    name="full-name"
                    autocomplete="name"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg"
                  > <!-- Icon untuk nama -->
                </div>
              </div>

              <!-- Input: NIK -->
              <div class="form-group">
                <div class="overlap-4">
                  <input
                    v-model="nik"
                    type="text"
                    class="text-wrapper-3"
                    placeholder="NIK"
                    name="id-number"
                    autocomplete="one-time-code"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame.svg"
                  > <!-- Icon untuk NIK -->
                </div>
              </div>

              <!-- Input: Tempat Lahir -->
              <div class="form-group">
                <div class="overlap-4">
                  <input
                    v-model="tempatLahir"
                    type="text"
                    class="text-wrapper-3"
                    placeholder="Tempat Lahir"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg"
                  > <!-- Icon placeholder -->
                </div>
              </div>

              <!-- Input: Tanggal Lahir -->
              <div class="form-group">
                <div class="overlap-4">
                  <input
                    v-model="tanggalLahir"
                    type="date"
                    class="text-wrapper-3"
                    placeholder="Tanggal Lahir"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame.svg"
                  > <!-- Icon placeholder, bisa diganti icon kalender -->
                </div>
              </div>

              <!-- Tombol Daftar -->
              <div class="group-7-register">
                <button
                  type="submit"
                  class="btn overlap-5 btn-gradient"
                >
                  <div class="text-wrapper-4">
                    Daftar
                  </div> <!-- Teks tombol diubah -->
                </button>
              </div>
            </form>
          </div>
          <!-- Link ke halaman login -->
          <p class="sudah-memiliki-akun">
            <span class="text-wrapper-5">Sudah memiliki akun?</span>
            <span class="text-wrapper-6">&nbsp;&nbsp;</span>
            <a href="/login/masyarakat">
              <span class="text-wrapper-7">Login</span> <!-- Teks link diubah -->
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
@import url("https://fonts.googleapis.com/css?family=Poppins:700,400|Roboto:400");

* {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}

html,
body {
  margin: 0px;
  height: 100%;
}

button:focus-visible {
  outline: 2px solid #4a90e2 !important;
  outline: -webkit-focus-ring-color auto 5px !important;
}

a {
  text-decoration: none;
}

.coverpage {
  background-color: #ffe4ed;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
}

@keyframes popIn {
  0% {
    transform: translate(-50%, -50%) scale(0.5);
    opacity: 0;
  }

  50% {
    transform: translate(-50%, -50%) scale(1.1);
    opacity: 1;
  }

  100% {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
  }
}

.checkbox {
  display: flex;
  align-items: center;
  margin-top: 135px;
  margin-left: 5px;
  font-size: 8px;
}

.checkbox input[type="checkbox"] {
  width: 12px;
  height: 18px;
  margin-right: 5px;
}

.overlap {
  position: relative;
  align-items: center;
  justify-content: center;
  width: 950px;
  height: 550px;
}

/* .error-message-wrapper { Dihapus } */
/* .error-message { Dihapus } */

.btn-gradient {
  background: linear-gradient(218deg,
      rgba(255, 51, 118, 0.49) 0%,
      rgba(255, 51, 118, 1) 100%);
  color: white;
  border: none;
}

.btn-gradient:hover {
  background: linear-gradient(218deg,
      rgba(255, 51, 118, 1) 100%,
      rgba(255, 51, 118, 0.49) 0%);
  color: white;
  border: none;
}

.ellipse {
  position: absolute;
  width: 63px;
  height: 63px;
  top: 0;
  left: 0;
  border-radius: 31.5px;
  background: linear-gradient(218deg,
      rgba(255, 51, 118, 0.49) 0%,
      rgba(255, 51, 118, 1) 100%);
  opacity: 0;
  transform: scale(0.5);
  animation: popUp 0.8s ease-out forwards;
}

@keyframes popUp {
  0% {
    opacity: 0;
    transform: scale(0.5);
  }

  60% {
    opacity: 0.7;
    transform: scale(1.1);
  }

  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.div {
  position: absolute;
  width: 75px;
  height: 75px;
  top: 480px;
  left: 901px;
  background-color: #ffffff;
  border-radius: 37.5px;
  opacity: 0;
  transform: scale(0.5);
  animation: popUp 0.8s ease-out forwards;
}

.login {
  position: absolute;
  width: 900px;
  height: 512px;
  top: 32px;
  left: 32px;
  background-color: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 21px 22px 124px 3px #0000003b;
  opacity: 0;
  transform: translateY(30px);
  animation: fadeUp 0.8s ease-out forwards;
}

@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.overlap-group {
  position: absolute;
  width: 455px;
  height: 512px;
  top: 0;
  left: 455px;
  background-image: url(https://c.animaapp.com/IJi6pJQY/img/rectangle-4.svg);
  background-size: 100% 100%;
}

.rectangle {
  position: absolute;
  width: 275px;
  height: 349px;
  top: 81px;
  left: 91px;
  background-color: #ffffff36;
  border-radius: 30.67px;
  border: 0.67px solid;
  border-color: #ffffff85;
  backdrop-filter: blur(4.53px) brightness(100%);
  -webkit-backdrop-filter: blur(4.53px) brightness(100%);
}

.mask-group {
  position: absolute;
  width: 275px;
  height: 349px;
  top: 81px;
  left: 91px;
}

.group {
  position: absolute;
  width: 53px;
  height: 53px;
  top: 313px;
  left: 70px;
  background-color: #ffffff;
  border-radius: 26.33px;
}

.thunderbolt {
  position: absolute;
  width: 28px;
  height: 28px;
  top: 12px;
  left: 13px;
  object-fit: cover;
}

.keluarga-sejahtera {
  position: absolute;
  top: 117px;
  left: 111px;
  font-family: "Poppins", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 21.3px;
  letter-spacing: 0;
  line-height: 30.7px;
}

.overlap-2 {
  position: absolute;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 250px;
  height: 313px; /* Akan disesuaikan oleh konten di dalamnya */
  top: 100px;
  left: 106px;
}

.group-2 {
  /* Mengubah menjadi Flexbox untuk tata letak yang lebih baik */
  display: flex;
  flex-direction: column;
  align-items: center; /* Memusatkan elemen secara horizontal */
  position: relative; /* Atur relatif agar child absolut lainnya tidak keluar */
  width: 250px;
  height: auto; /* Biarkan tinggi menyesuaikan konten */
  top: 0;
  left: 0;
  padding-top: 10px; /* Tambahkan padding agar judul tidak terlalu mepet atas */
}

.masuk {
  /* Hapus posisi absolut agar mengikuti alur flexbox */
  position: static;
  margin-bottom: 5px; /* Jarak antara judul "DAFTAR" dan deskripsi */
  /* Pertahankan styling font */
  font-weight: 700;
  color: #000000;
  font-size: 20px;
  white-space: nowrap;
  font-family: "Poppins", Helvetica;
  letter-spacing: 0;
  line-height: normal;
}

.p {
  /* Hapus posisi absolut agar mengikuti alur flexbox */
  position: static;
  margin-bottom: 20px; /* Jarak antara deskripsi dan form */
  /* Pertahankan styling font */
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #525252;
  font-size: 10.7px;
  letter-spacing: 0;
  line-height: normal;
}

/* Container untuk form */
.form-register {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%; /* Agar form bisa mengambil lebar penuh group-2 */
}

/* Styling umum untuk setiap grup input (Nama Lengkap, NIK, Tempat Lahir, Tanggal Lahir) */
.form-group {
  width: 245px;
  height: 35px;
  margin-bottom: 15px; /* Jarak antar input */
}

.overlap-4 {
  position: relative;
  width: 243px;
  height: 35px;
  background-color: #efedffcc;
  border-radius: 10.67px;
}

.text-wrapper-3 {
  border: none;
  background: transparent;
  padding: 0;
  outline: none;
  line-height: 1.5;
  width: 80%;
  position: absolute;
  top: 11px;
  left: 32px;
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #1c1c1c;
  font-size: 11px;
  letter-spacing: 0;
  line-height: normal;
}

.frame {
  position: absolute;
  width: 16px;
  height: 16px;
  top: 9px;
  left: 12px;
}

/* Tombol Daftar */
.group-7-register {
  position: static; /* Hapus posisi absolut */
  width: 85px;
  height: 35px;
  margin-top: 10px; /* Jarak dari input terakhir */
  margin-bottom: 20px; /* Jarak ke link di bawahnya */
}

.overlap-5 {
  top: 0; /* Ubah dari 15px ke 0 */
  position: relative;
  width: 83px;
  height: 35px;
  border-radius: 10.67px;
  box-shadow: 0px 5.33px 14px #00000029;
}

.text-wrapper-4 {
  position: absolute;
  top: 11px;
  left: 27px;
  font-family: "Poppins", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 8px;
  letter-spacing: 0;
  line-height: normal;
}

/* Link "Sudah memiliki akun?" */
.sudah-memiliki-akun {
  width: 166px;
  height: 23px;
  font-family: "Roboto", Helvetica;
  font-weight: 400;
  color: transparent;
  font-size: 9px;
  letter-spacing: 0;
  line-height: 16.1px;
  text-align: center;
}

.text-wrapper-5 {
  font-weight: 300;
  color: #000000;
}

.text-wrapper-6 {
  font-weight: 700;
  color: #000000;
}

.text-wrapper-7 {
  font-weight: 700;
  color: #fe3275;
}

.img {
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-300%, -50%);
  pointer-events: none;
  z-index: 1;
}

/* Media query untuk responsivitas */
@media(max-width:750px) {
  .overlap-group {
    display: none;
  }

  .login {
    width: 340px;
    align-items: center;
    justify-content: center;
  }

  .overlap {
    position: absolute;
    top: 80px;
    width: 100%;
  }

  .div {
    position: absolute;
    top: 500px;
    left: 330px;
  }

  .overlap-2 {
    position: absolute;
    width: 250px;
    height: auto;
    top: 10%;
    left: 15%;
  }

  /* Elemen-elemen ini sekarang relatif dan dikelola oleh flexbox, tidak perlu posisi absolut */
  .masuk,
  .p,
  .form-group,
  .group-7-register,
  .sudah-memiliki-akun {
    position: static; /* Penting untuk responsivitas */
    top: auto;
    left: auto;
    margin-bottom: 15px; /* Memberikan jarak vertikal yang konsisten */
  }

  /* Khusus untuk .masuk dan .p, bisa sedikit lebih dekat */
  .masuk {
    margin-bottom: 5px;
  }

  .p {
    margin-bottom: 20px;
  }

  form {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 10px; /* Padding di sisi form */
  }
}
@media(max-width:370px) {
  .overlap-group {
    display: none;
  }

  .login {
    width: 300px;
    align-items: center;
    justify-content: center;
  }
   .overlap-2 {
    position: absolute;
    width: 250px;
    height: auto;
    top: 10%;
    left: 9%;
  }
  .div {
    position: absolute;
    top: 500px;
    left: 280px;
  }
}
</style>
