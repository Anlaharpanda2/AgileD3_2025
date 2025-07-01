<template>
  <div class="coverpage">
    <div class="overlap">
      <div class="ellipse"></div>
      <div class="div"></div>
      <div class="login">
        <div class="overlap-group">
          <div class="rectangle"></div>
          <img class="mask-group" src="https://c.animaapp.com/IJi6pJQY/img/mask-group@2x.png" alt="Mask Group" />
          <div class="group">
            <img class="thunderbolt" src="https://c.animaapp.com/IJi6pJQY/img/thunderbolt-1@2x.png" alt="Thunderbolt" />
          </div>
          <div class="keluarga-sejahtera">Keluarga<br />Sejahtera<br />Setara<br />Terlindung</div>
        </div>
        <div class="overlap-2">
          <div class="group-2">
            <!-- Judul halaman diubah menjadi "Atur Kata Sandi Baru" -->
            <div class="masuk">Atur Kata Sandi Baru</div>
            <p class="p">
              Silakan masukkan kata sandi baru Anda.
              <br />
              <span class="email-display">{{ email }}</span>
            </p>

            <form @submit.prevent="resetPassword">
              <!-- Kolom input untuk password baru -->
              <div class="form-group" style="margin-top: 50px;">
                <label for="newPassword" class="input-label">Password Baru</label>
                <div class="password-input-container">
                    <input
                        id="newPassword"
                        v-model="newPassword"
                        :type="showNewPassword ? 'text' : 'password'"
                        class="input-field"
                        placeholder="Masukkan password baru"
                    />
                    <span class="password-toggle" @click="toggleNewPasswordVisibility">
                        <img
                            v-if="showNewPassword"
                            src="/reset/asset1.svg"
                            alt="Tampilkan password"
                            class="w-6 h-6"
                        />
                        <img
                            v-else
                            src="/reset/asset2.svg"
                            alt="Sembunyikan password"
                            class="w-6 h-6"
                        />
                    </span>
                </div>
              </div>

              <!-- Kolom input untuk konfirmasi password baru -->
              <div class="form-group" style="margin-top: 20px;">
                <label for="confirmPassword" class="input-label">Konfirmasi Password Baru</label>
                <div class="password-input-container">
                  <input
                    id="confirmPassword"
                    v-model="confirmPassword"
                    :type="showConfirmPassword ? 'text' : 'password'"
                    class="input-field"
                    placeholder="Konfirmasi password baru"
                  />
                  <span class="password-toggle" @click="toggleConfirmPasswordVisibility">
                    <img
                        v-if="showConfirmPassword"
                        src="/reset/asset1.svg"
                        alt="Tampilkan password"
                        class="w-6 h-6"
                    />
                    <img
                        v-else
                        src="/reset/asset2.svg"
                        alt="Sembunyikan password"
                        class="w-6 h-6"
                    />
                  </span>
                </div>
              </div>

              <!-- Tombol submit -->
              <div class="group-7" style="top: 180px; left: 65px;">
                <button type="submit" class="btn overlap-5 btn-gradient" :disabled="isLoading">
                  <div class="text-wrapper-4">{{ isLoading ? 'Memproses...' : 'Reset Password' }}</div>
                </button>
              </div>

              <!-- Pesan error jika ada -->
              <div v-if="errorMessage" class="error-message">
                {{ errorMessage }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../../api'; // Pastikan path ke file API Anda benar
import { ElNotification } from 'element-plus'; // Pastikan sudah install dan import Element Plus Notification

export default {
  name: 'ResetPassword', // Nama komponen
  data() {
    return {
      newPassword: '', // Data untuk password baru
      confirmPassword: '', // Data untuk konfirmasi password baru
      email: '',
      isLoading: false, // Status loading untuk tombol
      errorMessage: '', // Pesan error untuk validasi atau API
      showNewPassword: false, // State untuk mengontrol visibilitas password baru
      showConfirmPassword: false, // State untuk mengontrol visibilitas konfirmasi password baru
    };
  },
  mounted() {
    this.fetchUserEmail(); // Ambil email saat komponen dimuat
  },
  methods: {
    /**
     * Mengambil email dari query parameter URL.
     * Email ini akan digunakan untuk API reset password.
     */
    fetchUserEmail() {
      const emailFromQuery = this.$route.query.email;

      if (emailFromQuery) {
        this.email = emailFromQuery;
      } else {
        ElNotification({
          title: 'Error',
          message: 'Email tidak ditemukan di URL. Tidak dapat mereset password.',
          type: 'error',
        });
      }
    },

    /**
     * Mengubah visibilitas input password baru.
     * Mengganti tipe input antara 'password' dan 'text'.
     */
    toggleNewPasswordVisibility() {
      this.showNewPassword = !this.showNewPassword;
    },

    /**
     * Mengubah visibilitas input konfirmasi password baru.
     * Mengganti tipe input antara 'password' dan 'text'.
     */
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },

    /**
     * Mengirim permintaan reset password ke API.
     * Melakukan validasi input dan menangani respons API.
     */
    async resetPassword() {
      this.errorMessage = ''; // Hapus pesan error sebelumnya

      // Validasi input tidak boleh kosong
      if (!this.newPassword || !this.confirmPassword) {
        this.errorMessage = 'Password baru dan konfirmasi password tidak boleh kosong.';
        ElNotification({
          title: 'Error',
          message: this.errorMessage,
          type: 'error',
        });
        return;
      }

      // Validasi kesesuaian password
      if (this.newPassword !== this.confirmPassword) {
        this.errorMessage = 'Password baru dan konfirmasi password tidak cocok.';
        ElNotification({
          title: 'Error',
          message: this.errorMessage,
          type: 'error',
        });
        return;
      }

      this.isLoading = true; // Set loading state
      try {
        const response = await api.patch('/password/reset', {
          email: this.email,
          password: this.newPassword,
          password_confirmation: this.confirmPassword,
        });

        // Contoh penanganan respons API yang sukses
        if (response && response.message === 'Password berhasil direset') {
          ElNotification({
            title: 'Sukses',
            message: 'Password berhasil direset. Anda akan diarahkan ke halaman login.',
            type: 'success',
          });

          // Redirect ke halaman login setelah 3 detik
          setTimeout(() => {
            this.$router.push('/login/operator');
          }, 3000);
        } else {
          // Tangani kasus ketika API mengembalikan status sukses tetapi pesan error
          ElNotification({
            title: 'Error',
            message: response.message || 'Gagal mereset password. Silakan coba lagi.',
            type: 'error',
          });
        }
      } catch (error) {
        // Tangani error dari permintaan API
        this.errorMessage = error.response?.data?.message || error.message || 'Terjadi kesalahan saat mereset password.';
        ElNotification({
          title: 'Error',
          message: this.errorMessage,
          type: 'error',
        });
        console.error('Error resetting password:', error);
      } finally {
        this.isLoading = false; // Nonaktifkan loading state
      }
    },
  },
};
</script>

<style scoped>
/* Impor reset CSS dan font */
@import url("https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css");
@import url("https://fonts.googleapis.com/css?family=Poppins:700,400|Roboto:400");

/* Gaya umum */
* {
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
}
html, body {
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

/* Gaya layout utama */
.coverpage {
  background-color: #ffe4ed;
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
}

.overlap {
  position: relative;
  align-items: center;
  justify-content: center;
  width: 950px;
  height: 550px;
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

/* Animasi */
@keyframes popIn {
  0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
  50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
  100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
}

.ellipse {
  position: absolute;
  width: 63px;
  height: 63px;
  top: 0;
  left: 0;
  border-radius: 31.5px;
  background: linear-gradient(218deg, rgba(255, 51, 118, 0.49) 0%, rgba(255, 51, 118, 1) 100%);
  opacity: 0;
  transform: scale(0.5);
  animation: popUp 0.8s ease-out forwards;
}

@keyframes popUp {
  0% { opacity: 0; transform: scale(0.5); }
  60% { opacity: 0.7; transform: scale(1.1); }
  100% { opacity: 1; transform: scale(1); }
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

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Bagian Kiri (Latar Belakang dan Logo) */
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
  object-fit: cover;
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

/* Bagian Kanan (Formulir) */
.overlap-2 {
  position: absolute;
  width: 250px; /* Lebar area formulir */
  height: 313px; /* Tinggi area formulir */
  top: 99px;
  left: 106px;
}

.group-2 {
  position: absolute;
  width: 250px;
  height: 313px;
  top: 0;
  left: 0;
}

.masuk {
  left: 0;
  font-weight: 700;
  color: #000000;
  font-size: 20px;
  white-space: nowrap;
  position: absolute;
  top: -20px;
  font-family: "Poppins", Helvetica;
  letter-spacing: 0;
  line-height: normal;
}

.p {
  position: absolute;
  top: 2px;
  left: 0;
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #525252;
  font-size: 10.7px;
  letter-spacing: 0;
  line-height: normal;
  width: 100%;
}

.email-display {
  font-weight: 700;
  color: #fe3275; /* Warna highlight untuk email */
}

/* Gaya untuk input field */
.form-group {
  position: relative;
  width: 245px; /* Sesuaikan dengan desain asli */
  margin-left: 0;
}

.input-label {
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #7d7d7d;
  font-size: 9.3px;
  letter-spacing: 0;
  line-height: normal;
  position: absolute;
  top: -15px; /* Posisikan label di atas input */
  left: 0;
}

/* Container untuk input password dan ikon */
.password-input-container {
  position: relative;
  width: 100%;
}

.input-field {
  width: 100%; /* Lebar input mengikuti lebar form-group */
  height: 35px;
  padding: 0 15px;
  font-size: 14px;
  font-family: "Poppins", Helvetica;
  border: 1px solid #d4d4d4;
  border-radius: 10.67px;
  background-color: #efedffcc;
  box-shadow: inset 0px 1px 3px rgba(0,0,0,0.1);
  transition: all 0.2s ease-in-out;
  padding-right: 40px; /* Tambahkan padding agar tidak tumpang tindih dengan ikon */
}

.input-field:focus {
  outline: none;
  border-color: #fe3275;
  box-shadow: 0px 0px 0px 3px rgba(254, 50, 117, 0.2);
}

/* Gaya untuk ikon toggle password */
.password-toggle {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #7d7d7d; /* Warna ikon */
  height: 20px; /* Sesuaikan ukuran SVG */
  width: 20px; /* Sesuaikan ukuran SVG */
}

.password-toggle svg {
  width: 100%;
  height: 100%;
}

/* Gaya tombol submit */
.group-7 {
  position: absolute;
  width: 120px; /* Lebar tombol */
  height: 35px;
}

.overlap-5 {
  top: 0;
  position: relative;
  width: 100%;
  height: 35px;
  border-radius: 10.67px;
  box-shadow: 0px 5.33px 14px #00000029;
}

.text-wrapper-4 {
  position: absolute;
  top: 11px;
  left: 50%;
  transform: translateX(-50%);
  font-family: "Poppins", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 8px;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap;
}

.btn-gradient {
  background: linear-gradient(218deg, rgba(255, 51, 118, 0.49) 0%, rgba(255, 51, 118, 1) 100%);
  color: white;
  border: none;
  cursor: pointer;
}

.btn-gradient:hover {
  background: linear-gradient(218deg, rgba(255, 51, 118, 1) 100%, rgba(255, 51, 118, 0.49) 0%);
}

.btn-gradient:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Gaya pesan error */
.error-message {
  background-color: #ff4d4d;
  color: white;
  padding: 10px;
  border-radius: 5px;
  margin-top: 20px;
  font-size: 14px;
  text-align: center;
  opacity: 0;
  transform: scale(0.5);
  animation: popUp 0.8s ease-out forwards;
  position: absolute; /* Atur posisi agar tidak mengganggu layout lain */
  width: 100%;
  left: 0;
  bottom: -60px; /* Posisikan di bawah form */
}

/* Responsive adjustments */
@media(max-width:750px){
  .overlap-group{
    display: none;
  }
  .login{
    width: 340px;
    align-items: center;
    justify-content: center;
  }
  .group-2 {
    align-items: center;
    justify-content: center;
  }
  .overlap {
    position: absolute;
    top: 80px;
    width: 100%;
  }
  .div{
    position: absolute;
    top: 500px;
    left: 330px;
  }
  .group-2 {
    width: 250px;
    height: 313px;
  }
  .overlap-2 {
    position: absolute;
    width: 250px;
    height: 313px;
    top: 20%;
    left: 15%;
  }
  .error-message {
    margin-top: 20px;
    position: relative; /* Kembali ke posisi relatif untuk mobile */
    bottom: auto;
    left: auto;
  }
  /* Sesuaikan posisi form group dan tombol untuk mobile */
  .form-group {
    margin-top: 40px !important;
  }
  .group-7 {
    top: 220px !important;
    left: 65px !important;
  }
}
</style>