<script>
import api from '../../api'; // axios instance

export default {
  data() {
    return {
      nik: '',
      nama: '',
      showPassword: false,
      errorMessage: '',
    };
  },
  watch: {
    showPassword(newValue) {
      this.$nextTick(() => {
        if (this.$refs.nikInput) {
          this.$refs.nikInput.type = newValue ? 'text' : 'password';
        }
      });
    }
  },
  mounted() {
    // Jika sudah login, langsung arahkan ke halaman data pendaftar
    if (localStorage.getItem('isLoggedIn') === 'true') {
      this.$router.push('/data/pelatihan');
    }
  },
  methods: {
    async validateForm(event) {
      event.preventDefault();

      // Validasi NIK
      if (!/^\d{16}$/.test(this.nik)) {
        this.errorMessage = 'NIK harus 16 angka';
        return;
      }

      // Validasi Nama
      if (/\d/.test(this.nama)) {
        this.errorMessage = 'Nama tidak boleh mengandung angka';
        return;
      }

      try {
        const response = await api.post('/login/masyarakat', {
          nik: this.nik,
          nama: this.nama,
        });
        const userId = response.id;
        const ttl = response.tempat_tanggal_lahir;
        // Simpan status login dan inputan untuk autocomplete
        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('role', 'masyarakat');
        localStorage.setItem('savedNIK', this.nik);
        localStorage.setItem('savedName', this.nama);
        localStorage.setItem('userId', userId);
        localStorage.setItem('Ttl', ttl);

        // Redirect setelah sedikit delay
        setTimeout(() => {
          this.$router.push('/');
        }, 100);
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 'Login gagal';
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
            Sumbar<br>Madani<br>yang unggul<br>dan berkelanjutan
          </div>
        </div>
        <div class="overlap-2">
          <div class="group-2">
            <div class="overlap-3">
              <div class="overlap-group-wrapper">
                <div class="overlap-group-2">
                  <div class="text-wrapper">
                    Atau
                  </div>
                  <img
                    class="subtract"
                    src="https://c.animaapp.com/IJi6pJQY/img/subtract.svg"
                  >
                </div>
              </div>
              <div class="group-3">
                <a href="/login/operator">
                  <div class="group-wrapper ">
                    <img
                      class="manage-accounts"
                      src="https://c.animaapp.com/IJi6pJQY/img/manage-accounts-24dp-e8eaed-fill0-wght400-grad0-opsz24-1.svg"
                    >
                    <div class="masuk-sebagai-wrapper">
                      <p class="masuk-sebagai">
                        <span class="span">Masuk Sebagai <span class="text-wrapper-2">Operator</span></span> 
                      </p>
                    </div>
                  </div>
                </a>
                <a href="/login/pegawai">
                  <div class="div-wrapper">
                    <img
                      class="img"
                      src="https://c.animaapp.com/IJi6pJQY/img/mask-group-1@2x.png"
                    >
                    <div class="group-4">
                      <p class="masuk-sebagai">
                        <span class="span">Masuk Sebagai <span class="text-wrapper-2">Pegawai</span>  </span> 
                      </p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <div class="masuk">
              MASUK
            </div>
            <p class="p">
              Silahkan Masukan Nama dan NIK sesuai KK
            </p>
            <form @submit="validateForm">
              <div class="group-5">
                <div class="overlap-4">
                  <input
                    v-model="nik"
                    :type="showPassword ? 'text' : 'password'"
                    class="text-wrapper-3"
                    placeholder="NIK"
                    name="current-password"
                    autocomplete="current-password"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame.svg"
                  >
                </div>
              </div>
              <div class="group-6">
                <div class="overlap-4">
                  <input
                    v-model="nama"
                    type="text"
                    class="text-wrapper-3"
                    placeholder="Nama"
                    name="username"
                    autocomplete="username"
                  >
                  <img
                    class="frame"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg"
                  >
                </div>
              </div>

              <div class="group-8">
                <label class="checkbox">
                  <input
                    v-model="showPassword"
                    type="checkbox"
                  >
                  Tampilkan NIK
                </label>
              </div>
              <div class="group-7">
                <button
                  type="submit"
                  class="btn overlap-5 btn-gradient"
                >
                  <div class="text-wrapper-4">
                    Login Now
                  </div>
                </button>
              </div>
              <div
                v-if="errorMessage"
                class="error-message"
              >
                {{ errorMessage }}
              </div>
            </form>
          </div>
          <p class="belum-memiliki-akun">
            <span class="text-wrapper-5">Belum memiliki akun?</span>
            <span class="text-wrapper-6">&nbsp;&nbsp;</span>
            <a href="/daftar/masyarakat">
              <span class="text-wrapper-7">Daftar</span>
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
/* a blue color as a generic focus style */
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

/* Animasi keyframes untuk pop-up */
@keyframes popIn {
  0% {
    transform: translate(-50%, -50%) scale(0.5); /* Mulai dari kecil */
    opacity: 0;
  }
  50% {
    transform: translate(-50%, -50%) scale(1.1); /* Sedikit lebih besar untuk efek */
    opacity: 1;
  }
  100% {
    transform: translate(-50%, -50%) scale(1); /* Akhirnya normal */
    opacity: 1;
  }
}

.checkbox {
  display: flex;         /* Supaya checkbox dan teks sejajar */
  align-items: center;   /* Vertikal rata tengah */
  margin-top: 135px;      /* Jarak dari elemen atasnya */
  margin-left: 5px;      /* Jarak dari elemen atasnya */
  font-size: 8px;       /* Besar huruf */
}

.checkbox input[type="checkbox"] {
  width: 12px;           /* Ukuran kotak checkbox */
  height: 18px;
  margin-right: 5px;     /* Jarak antara kotak dan teks */
}

.overlap {
  position: relative;
  align-items: center;
  justify-content: center;
  width: 950px;
  height: 550px;
}

.error-message {
  background-color: #ff4d4d;
  color: white;
  padding: 10px;
  border-radius: 5px;
  margin-top: -200px;
  font-size: 14px;
  text-align: center;
  opacity: 0;
  transform: scale(0.5);
  animation: popUp 0.8s ease-out forwards;
}

.error-message p {
  margin: 0;
}

.btn-gradient {
  background: linear-gradient(
    218deg,
    rgba(255, 51, 118, 0.49) 0%,
    rgba(255, 51, 118, 1) 100%
  );
  color: white;
  border: none;
}

.btn-gradient:hover {
  background: linear-gradient(
    218deg,
    rgba(255, 51, 118, 1) 100%,
    rgba(255, 51, 118, 0.49) 0%
  );
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
  background: linear-gradient(
    218deg,
    rgba(255, 51, 118, 0.49) 0%,
    rgba(255, 51, 118, 1) 100%
  );

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
  width: 250px;
  height: 313px;
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

 .overlap-3 {
  position: absolute;
  width: 248px;
  height: 95px;
  top: 218px;
  left: 0;
}

 .overlap-group-wrapper {
  position: absolute;
  width: 248px;
  height: 16px;
  top: 0;
  left: 0;
}

 .overlap-group-2 {
  position: relative;
  width: 246px;
  height: 16px;
}

 .text-wrapper {
  position: absolute;
  top: 0;
  left: 112px;
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #525252;
  font-size: 10.7px;
  letter-spacing: 0;
  line-height: normal;
}

 .subtract {
  position: absolute;
  width: 246px;
  height: 1px;
  top: 7px;
  left: 0;
}

 .group-3 {
  position: absolute;
  width: 243px;
  height: 80px;
  top: 15px;
  left: 0;
}

 .group-wrapper {
  position: relative;
  width: 243px;
  height: 35px;
  top: 0;
  left: 0;
  border-radius: 10.67px;
  border: 0.67px solid;
  border-color: #d4d4d4;
  transition: transform 0.3s ease;
  overflow: visible;
}
 .manage-accounts {
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-300%, -50%);
  pointer-events: none;
  z-index: 1;
}

.group-wrapper:hover {
  background: linear-gradient(
    218deg,
    rgba(255, 51, 118, 0.49) 0%,
    rgba(255, 51, 118, 1) 100%
  );
  transform: scale(1.05);
}
.group-wrapper:hover *{
  color: white;
}

 .masuk-sebagai-wrapper {
  position: relative;
  width: 103px;
  height: 12px;
  top: 10px;
  left: 90px;
  overflow: visible;
  white-space: nowrap;
}

 .masuk-sebagai {
  left: 0;
  font-weight: 400;
  color: #1c1c1c;
  font-size: 8px;
  position: absolute;
  top: 0;
  font-family: "Poppins", Helvetica;
  letter-spacing: 0;
  line-height: normal;
}

 .span {
  font-family: "Poppins", Helvetica;
  font-weight: 400;
}

 .text-wrapper-2 {
  font-weight: 700;
}

 .div-wrapper {
  position: absolute;
  width: 243px;
  height: 35px;
  top: 45px;
  left: 0;
  border-radius: 10.67px;
  border: 0.67px solid;
  border-color: #d4d4d4;
  transition: transform 0.3s ease;
}

.div-wrapper:hover {
  background: linear-gradient(
    218deg,
    rgba(255, 51, 118, 0.49) 0%,
    rgba(255, 51, 118, 1) 100%
  );
  transform: scale(1.05);
}

.div-wrapper:hover *{
  color:white;
}

 .group-4 {
  position: relative;
  width: 101px;
  height: 12px;
  top: 10px;
  left: 90px;
}

 .masuk {
  left: 90px;
  font-weight: 700;
  color: #000000;
  font-size: 20px;
  white-space: nowrap;
  position: absolute;
  top: 0;
  font-family: "Poppins", Helvetica;
  letter-spacing: 0;
  line-height: normal;
}

 .p {
  position: absolute;
  top: 21px;
  left: 9px;
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #525252;
  font-size: 10.7px;
  letter-spacing: 0;
  line-height: normal;
}

 .group-5 {
  position: absolute;
  width: 245px;
  height: 35px;
  top: 99px;
  left: 0;
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

 .group-6 {
  position: absolute;
  width: 245px;
  height: 35px;
  top: 53px;
  left: 0;
}

 .group-7 {
  position: absolute;
  width: 85px;
  height: 35px;
  top: 150px;
  left: 80px;
}

 .overlap-5 {
  top: 15px;
  position: relative;
  width: 83px;
  height: 35px;
  border-radius: 10.67px;
  box-shadow: 0px 5.33px 14px #00000029;
}

 .text-wrapper-4 {
  position: absolute;
  top: 11px;
  left: 20px;
  font-family: "Poppins", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 8px;
  letter-spacing: 0;
  line-height: normal;
}

 .belum-memiliki-akun {
  position: absolute;
  width: 166px;
  height: 23px;
  top: 135px;
  left: 140px;
  font-family: "Roboto", Helvetica;
  font-weight: 400;
  color: transparent;
  font-size: 9px;
  letter-spacing: 0;
  line-height: 16.1px;
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
    margin-top: -230px;
  }
}
</style>