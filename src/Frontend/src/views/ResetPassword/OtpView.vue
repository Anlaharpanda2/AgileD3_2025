<script>
import api from '../../api';
import { ElNotification } from 'element-plus'; // pastikan sudah install dan import

export default {
  data() {
    return {
      otpDigits: ['', '', '', '', '', ''],
      userEmail: 'memuat...',
      isLoading: false,
      isEmailLoaded: false,
    };
  },
  mounted() {
    this.fetchUserEmail();
  },
  methods: {
    // Ambil email dari query parameter
    fetchUserEmail() {
      const emailFromQuery = this.$route.query.email;

      if (emailFromQuery) {
        this.userEmail = emailFromQuery;
        this.isEmailLoaded = true;
      } else {
        ElNotification({
          title: 'Error',
          message: 'Email tidak ditemukan di URL.',
          type: 'error',
        });
        this.userEmail = 'Tidak dapat memuat email.';
        this.isEmailLoaded = false;
      }
    },

    handleInput(event, index) {
      const value = event.target.value;
      if (value.length > 1) {
        event.target.value = value.charAt(0);
        this.otpDigits[index] = value.charAt(0);
      } else if (!/^\d*$/.test(value)) {
        event.target.value = '';
        this.otpDigits[index] = '';
      } else {
        this.otpDigits[index] = value;
      }

      if (value && index < this.otpDigits.length - 1) {
        this.focusNextInput(index);
      }
    },

    handleKeyDown(event, index) {
      if (event.key === 'Backspace' && !this.otpDigits[index] && index > 0) {
        this.focusPrevInput(index);
      }
    },

    handlePaste(event) {
      event.preventDefault();
      const pasteData = event.clipboardData.getData('text').trim();
      if (/^\d{6}$/.test(pasteData)) {
        for (let i = 0; i < this.otpDigits.length; i++) {
          this.otpDigits[i] = pasteData.charAt(i);
        }
        this.$nextTick(() => {
          this.$refs.otpInput[this.otpDigits.length - 1].focus();
        });
      } else {
        ElNotification({
          title: 'Error',
          message: 'Format OTP yang ditempel tidak valid (harus 6 digit angka).',
          type: 'error',
        });
      }
    },

    focusNextInput(index) {
      this.$nextTick(() => {
        if (this.$refs.otpInput[index + 1]) {
          this.$refs.otpInput[index + 1].focus();
        }
      });
    },

    focusPrevInput(index) {
      this.$nextTick(() => {
        if (this.$refs.otpInput[index - 1]) {
          this.$refs.otpInput[index - 1].focus();
        }
      });
    },

    async verifyOTP(event) {
      event.preventDefault();

      const otpCode = this.otpDigits.join('');

      if (otpCode.length !== 6 || !/^\d{6}$/.test(otpCode)) {
        ElNotification({
          title: 'Error',
          message: 'Kode OTP harus 6 digit angka.',
          type: 'error',
        });
        return;
      }

      this.isLoading = true;
      try {
        const data = await api.post('/otp/confirm', { otp: otpCode });

        console.log('[OTPConfirmation] data =', data);

        if (data && data.message === 'Kode OTP valid') {
          ElNotification({
            title: 'Sukses',
            message: 'Verifikasi OTP berhasil!',
            type: 'success',
          });
            this.$router.push({
                path: '/reset/password',
                query: { email: this.userEmail }
            });
        } else {
          ElNotification({
            title: 'Error',
            message: data.message || 'Verifikasi OTP gagal. Silakan coba lagi.',
            type: 'error',
          });
        }
      } catch (error) {
        ElNotification({
          title: 'Error',
          message:
            error.response?.data?.message ||
            error.message ||
            'Verifikasi OTP gagal. Silakan coba lagi.',
          type: 'error',
        });
        console.error('Error verifying OTP:', error);
      } finally {
        this.isLoading = false;
      }
    },
  },
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
            <div class="masuk">
              Verifikasi OTP
            </div>
            <p class="p">
              Silakan masukkan kode OTP 6 digit yang telah dikirim ke email
              <br>
              <span class="email-display">{{ userEmail }}</span>
            </p>

            <form @submit="verifyOTP">
              <div class="otp-input-container">
                <input
                  v-for="(digit, index) in otpDigits"
                  :key="index"
                  :ref="`otpInput`"
                  type="text"
                  maxlength="1"
                  :value="digit"
                  class="otp-digit-input"
                  inputmode="numeric"
                  pattern="[0-9]"
                  @input="event => handleInput(event, index)"
                  @keydown.backspace="event => handleKeyDown(event, index)"
                  @paste="handlePaste"
                >
              </div>

              <div class="group-7">
                <button
                  type="submit"
                  class="btn overlap-5 btn-gradient"
                  :disabled="isLoading"
                >
                  <div class="text-wrapper-4">
                    {{ isLoading ? 'Memverifikasi...' : 'Verifikasi OTP' }}
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
          <!-- Bagian "Lupa Kata Sandi" dan "Masuk Sebagai" dihapus karena tidak relevan -->
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
  margin-top: 20px; /* Adjusted margin-top for OTP form */
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

.btn-gradient:disabled {
  opacity: 0.6;
  cursor: not-allowed;
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

.masuk {
  left: 0; /* Adjusted */
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
  top: 21px; /* Adjusted */
  left: 0; /* Adjusted */
  font-family: "Poppins", Helvetica;
  font-weight: 400;
  color: #525252;
  font-size: 10.7px;
  letter-spacing: 0;
  line-height: normal;
  width: 100%; /* Ensure text wraps if needed */
}

.email-display {
  font-weight: 700;
  color: #fe3275; /* Highlight the email */
}

/* New styles for OTP inputs */
.otp-input-container {
  display: flex;
  justify-content: space-between;
  width: 245px; /* Same width as username/password input groups */
  margin-top: 110px; /* Positioning similar to old input fields */
  margin-left: 0; /* Aligned with other form elements */
}

.otp-digit-input {
  width: 35px; /* Size for each digit input */
  height: 35px;
  text-align: center;
  font-size: 18px;
  font-family: "Poppins", Helvetica;
  border: 1px solid #d4d4d4;
  border-radius: 10.67px;
  background-color: #efedffcc;
  box-shadow: inset 0px 1px 3px rgba(0,0,0,0.1);
  transition: all 0.2s ease-in-out;
}

.otp-digit-input:focus {
  outline: none;
  border-color: #fe3275;
  box-shadow: 0px 0px 0px 3px rgba(254, 50, 117, 0.2);
}

.group-7 {
  position: absolute;
  width: 120px; /* Increased width for button */
  height: 35px;
  top: 200px; /* Adjusted position below OTP inputs */
  left: 65px; /* Centered in the 250px wide area */
}

.overlap-5 {
  top: 0; /* Reset top to align with group-7 */
  position: relative;
  width: 100%; /* Fill group-7 width */
  height: 35px;
  border-radius: 10.67px;
  box-shadow: 0px 5.33px 14px #00000029;
}

.text-wrapper-4 {
  position: absolute;
  top: 11px;
  left: 50%;
  transform: translateX(-50%); /* Center text horizontally */
  font-family: "Poppins", Helvetica;
  font-weight: 700;
  color: #ffffff;
  font-size: 8px;
  letter-spacing: 0;
  line-height: normal;
  white-space: nowrap; /* Prevent text wrapping */
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
    margin-top: 20px; /* Adjusted for mobile */
  }
  .otp-input-container {
    margin-top: 100px; /* Adjusted for mobile */
    justify-content: center; /* Center OTP inputs on smaller screens */
    gap: 5px; /* Add a small gap between inputs */
  }
  .otp-digit-input {
    width: 30px; /* Slightly smaller for mobile */
    height: 30px;
    font-size: 16px;
  }
  .group-7 {
    top: 180px; /* Adjusted button position for mobile */
    left: 65px;
  }
}
</style>