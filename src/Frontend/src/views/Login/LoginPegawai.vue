<script>
import api from '../../api'; // axios instance

export default {
  data() {
    return {
      password: '',
      username: '',
      showPassword: false,
      errorMessage: '',
    };
  },
  mounted() {
    if (localStorage.getItem('isLoggedIn') === 'true') {
      this.$router.push('/data/pendaftar');
    }
  },
  watch: {
    showPassword(newValue) {
      this.$nextTick(() => {
        if (this.$refs.passwordInput) {
          this.$refs.passwordInput.type = newValue ? 'text' : 'password';
        }
      });
    }
  },
  methods: {
    async validateForm(event) {
      event.preventDefault();

      // Validasi username
      if (!/^[a-zA-Z0-9_.]{1,30}$/.test(this.username)) {
        this.errorMessage = 'Username maksimal 30 karakter dan hanya boleh huruf, angka, titik, atau underscore.';
        return;
      }

      // Validasi password
      const pwd = this.password;

      if (pwd.length < 8 || pwd.length > 30) {
        this.errorMessage = 'Password harus 8 hingga 30 karakter.';
        return;
      }
      if (!/[A-Z]/.test(pwd)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu huruf besar (A-Z).';
        return;
      }
      if (!/[a-z]/.test(pwd)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu huruf kecil (a-z).';
        return;
      }
      if (!/\d/.test(pwd)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu angka (0-9).';
        return;
      }
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(pwd)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu simbol (contoh: !@#$%^&*).';
        return;
      }

      try {
        const response = await api.post('/login/operator', {
          password: this.password,
          username: this.username,
        });

        // Simpan status login
        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('savedpassword', this.password);
        localStorage.setItem('savedusername', this.username);

        // Redirect
        setTimeout(() => {
          this.$router.push('/data/pendaftar');
        }, 100);
      } catch (error) {
        const message = error.response?.data?.message;

        // Tampilkan pesan dari backend secara manusiawi
        if (message === 'Password salah') {
          this.errorMessage = 'Password salah';
        } else if (message === 'Username salah') {
          this.errorMessage = 'Username salah';
        } else if (message === 'Username dan Password salah') {
          this.errorMessage = 'Username dan Password salah';
        } else {
          this.errorMessage = 'Login gagal. Silakan coba lagi.';
        }
      }
    }
  }
};
</script>


<template>
    <div class="coverpage">
      <div class="overlap-wrapper">
        <div class="overlap">
          <div class="ellipse"></div>
          <div class="div"></div>
          <div class="login">
            <div class="overlap-group">
              <div class="rectangle"></div>
              <img class="mask-group" src="https://c.animaapp.com/IJi6pJQY/img/mask-group@2x.png" />
              <div class="group">
                <img class="thunderbolt" src="https://c.animaapp.com/IJi6pJQY/img/thunderbolt-1@2x.png" />
              </div>
              <div class="keluarga-sejahtera">Keluarga<br />Sejahtera<br />Setara<br />Terlindung</div>
            </div>
            <div class="overlap-2">
              <div class="group-2">
                <div class="overlap-3">
                  <div class="overlap-group-wrapper">
                    <div class="overlap-group-2">
                      <div class="text-wrapper">Atau</div>
                      <img class="subtract" src="https://c.animaapp.com/IJi6pJQY/img/subtract.svg" />
                    </div>
                  </div>
                  <div class="group-3">
                    <a href="/login/operator">
                      <div class="group-wrapper ">
                        <img class="manage-accounts"src="https://c.animaapp.com/IJi6pJQY/img/manage-accounts-24dp-e8eaed-fill0-wght400-grad0-opsz24-1.svg"/>
                        <div class="masuk-sebagai-wrapper">
                          <p class="masuk-sebagai">
                            <span class="span">Masuk Sebagai <span class="text-wrapper-2">Operator</span></span> 
                          </p>
                        </div>
                      </div>
                    </a>
                    <a href="/login/masyarakat">
                      <div class="div-wrapper">
                        <img class="img" src="/external/image.png" />
                        <div class="group-4">
                          <p class="masuk-sebagai">
                            <span class="span">Masuk Sebagai <span class="text-wrapper-2">Masyarakat</span>  </span> 
                          </p>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="masuk">MASUK</div>
                <p class="p">Silahkan Masukan Username dan Password</p>
                <form @submit="validateForm">
                  <div class="group-5">
                    <div class="overlap-4">
                      <input
                        :type="showPassword ? 'text' : 'password'"
                        v-model="password"
                        class="text-wrapper-3"
                        placeholder="Password"
                        name="current-password"
                        autocomplete="current-password"
                      />
                      <img class="frame" src="https://c.animaapp.com/IJi6pJQY/img/frame.svg" />
                    </div>
                  </div>
                  <div class="group-6">
                    <div class="overlap-4">
                      <input
                        type="text"
                        v-model="username"
                        class="text-wrapper-3"
                        placeholder="Username"
                        name="username"
                        autocomplete="username"
                      />
                      <img class="frame" src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg" />
                    </div>
                  </div>

                  <div class="group-8">
                    <label class = "checkbox">
                      <input type="checkbox" v-model="showPassword" />
                      Tampilkan Password
                    </label>
                  </div>
                  <div class="group-7">
                    <button type="submit" class="btn overlap-5 btn-gradient">
                      <div class="text-wrapper-4">Login Now</div>
                    </button>
                  </div>
                  <div v-if="errorMessage" class="error-message">
                    {{ errorMessage }}
                  </div>
                </form>
              </div>
            </div>
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
  width: 100%;
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

.coverpage .overlap-wrapper {
  background-color: #ffe4ed;
  width: 1280px;
  height: 720px;
}

.coverpage .overlap {
  position: relative;
  width: 976px;
  height: 555px;
  top: 37px;
  left: 157px;
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

.coverpage .ellipse {
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


.coverpage .div {
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


.coverpage .login {
  position: absolute;
  width: 911px;
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


.coverpage .overlap-group {
  position: absolute;
  width: 455px;
  height: 512px;
  top: 0;
  left: 455px;
  background-image: url(https://c.animaapp.com/IJi6pJQY/img/rectangle-4.svg);
  background-size: 100% 100%;
}

.coverpage .rectangle {
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

.coverpage .mask-group {
  position: absolute;
  width: 275px;
  height: 349px;
  top: 81px;
  left: 91px;
}

.coverpage .group {
  position: absolute;
  width: 53px;
  height: 53px;
  top: 313px;
  left: 70px;
  background-color: #ffffff;
  border-radius: 26.33px;
}

.coverpage .thunderbolt {
  position: absolute;
  width: 28px;
  height: 28px;
  top: 12px;
  left: 13px;
  object-fit: cover;
}

.coverpage .keluarga-sejahtera {
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

.coverpage .overlap-2 {
  position: absolute;
  width: 250px;
  height: 313px;
  top: 99px;
  left: 106px;
}

.coverpage .group-2 {
  position: absolute;
  width: 250px;
  height: 313px;
  top: 0;
  left: 0;
}

.coverpage .overlap-3 {
  position: absolute;
  width: 248px;
  height: 95px;
  top: 218px;
  left: 0;
}

.coverpage .overlap-group-wrapper {
  position: absolute;
  width: 248px;
  height: 16px;
  top: 0;
  left: 0;
}

.coverpage .overlap-group-2 {
  position: relative;
  width: 246px;
  height: 16px;
}

.coverpage .text-wrapper {
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

.coverpage .subtract {
  position: absolute;
  width: 246px;
  height: 1px;
  top: 7px;
  left: 0;
}

.coverpage .group-3 {
  position: absolute;
  width: 243px;
  height: 80px;
  top: 15px;
  left: 0;
}

.coverpage .group-wrapper {
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
.coverpage .manage-accounts {
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

.coverpage .masuk-sebagai-wrapper {
  position: relative;
  width: 103px;
  height: 12px;
  top: 10px;
  left: 90px;
  overflow: visible;
  white-space: nowrap;
}

.coverpage .masuk-sebagai {
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

.coverpage .span {
  font-family: "Poppins", Helvetica;
  font-weight: 400;
}

.coverpage .text-wrapper-2 {
  font-weight: 700;
}

.coverpage .div-wrapper {
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

.coverpage .group-4 {
  position: relative;
  width: 103px;
  height: 12px;
  top: 10px;
  left: 90px;
  overflow: visible;
  white-space: nowrap;
}

.coverpage .masuk {
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

.coverpage .p {
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

.coverpage .group-5 {
  position: absolute;
  width: 245px;
  height: 35px;
  top: 99px;
  left: 0;
}

.coverpage .overlap-4 {
  position: relative;
  width: 243px;
  height: 35px;
  background-color: #efedffcc;
  border-radius: 10.67px;
}

.coverpage .text-wrapper-3 {
  border: none;
  background: transparent;
  padding: 0;
  outline: none;
  line-height: 1.5;
  width: 100%;
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

.coverpage .frame {
  position: absolute;
  width: 16px;
  height: 16px;
  top: 9px;
  left: 12px;
}

.coverpage .group-6 {
  position: absolute;
  width: 245px;
  height: 35px;
  top: 53px;
  left: 0;
}

.coverpage .group-7 {
  position: absolute;
  width: 85px;
  height: 35px;
  top: 150px;
  left: 80px;
}

.coverpage .overlap-5 {
  top: 15px;
  position: relative;
  width: 83px;
  height: 35px;
  border-radius: 10.67px;
  box-shadow: 0px 5.33px 14px #00000029;
}

.coverpage .text-wrapper-4 {
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

.coverpage .belum-memiliki-akun {
  position: absolute;
  width: 166px;
  height: 23px;
  top: 186px;
  left: 49px;
  font-family: "Roboto", Helvetica;
  font-weight: 400;
  color: transparent;
  font-size: 11.3px;
  letter-spacing: 0;
  line-height: 16.1px;
}

.coverpage .text-wrapper-5 {
  font-weight: 300;
  color: #000000;
}

.coverpage .text-wrapper-6 {
  font-weight: 700;
  color: #000000;
}

.coverpage .text-wrapper-7 {
  font-weight: 700;
  color: #fe3275;
}

.coverpage .img {
  position: absolute;
  width: 20px;
  height: 20px;
  top: 50%;
  left: 50%;
  transform: translate(-300%, -50%);
  pointer-events: none;
  z-index: 1;
}

</style>