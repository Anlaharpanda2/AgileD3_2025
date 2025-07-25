<script>
import api from '../../api';
import { ElNotification } from 'element-plus';

export default {
  data() {
    return {
      otpDigits: ['', '', '', '', '', ''],
      userEmail: 'memuat...',
      isLoading: false,
      isPageLoaded: false,
    };
  },
  mounted() {
    this.fetchUserEmail();
    setTimeout(() => {
      this.isPageLoaded = true;
    }, 100);
  },
  methods: {
    fetchUserEmail() {
      const emailFromQuery = this.$route.query.email;
      if (emailFromQuery) {
        this.userEmail = emailFromQuery;
      } else {
        ElNotification.error({
          title: 'Error',
          message: 'Email tidak ditemukan di URL.',
        });
        this.userEmail = 'Tidak dapat memuat email.';
      }
    },
    handleInput(event, index) {
      const input = event.target;
      let value = input.value;
      
      if (!/^[0-9]*$/.test(value)) {
        input.value = this.otpDigits[index];
        return;
      }

      if (value.length > 1) {
        value = value.charAt(0);
        input.value = value;
      }

      this.otpDigits[index] = value;

      if (value && index < this.otpDigits.length - 1) {
        this.$refs.otpInput[index + 1].focus();
      }
    },
    handleKeyDown(event, index) {
      if (event.key === 'Backspace' && !this.otpDigits[index] && index > 0) {
        this.$refs.otpInput[index - 1].focus();
      }
    },
    handlePaste(event) {
      event.preventDefault();
      const pasteData = event.clipboardData.getData('text').trim();
      if (/^\d{6}$/.test(pasteData)) {
        pasteData.split('').forEach((char, index) => {
          this.otpDigits[index] = char;
        });
        this.$refs.otpInput[5].focus();
      } else {
        ElNotification.error({
          title: 'Error',
          message: 'Format OTP yang ditempel tidak valid.',
        });
      }
    },
    async verifyOTP() {
      const otpCode = this.otpDigits.join('');
      if (otpCode.length !== 6) {
        ElNotification.error({
          title: 'Error',
          message: 'Kode OTP harus 6 digit.',
        });
        return;
      }

      this.isLoading = true;
      try {
        // Logika diperbaiki: periksa isi respons secara eksplisit
        const data = await api.post('/otp/confirm', { otp: otpCode });

        if (data && data.message === 'Kode OTP valid') {
          ElNotification.success({
            title: 'Sukses',
            message: 'Verifikasi OTP berhasil!',
          });
          this.$router.push({
            path: '/reset/password',
            query: { email: this.userEmail },
          });
        } else {
          // Menangani kasus di mana API mengembalikan 200 OK tetapi OTP salah
          ElNotification.error({
            title: 'Gagal',
            message: data.message || 'Kode OTP salah. Silakan coba lagi.',
          });
        }
      } catch (error) {
        // Menangani error jaringan atau status non-2xx
        ElNotification.error({
          title: 'Gagal',
          message: error.response?.data?.message || 'Verifikasi OTP gagal.',
        });
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script>

<template>
  <div 
    class="font-sans min-h-screen w-full flex items-center justify-center bg-[#ffe4ed] p-4 transition-all duration-1000 ease-out"
    :class="isPageLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
  >
    <div class="relative w-full max-w-[950px] h-auto min-h-[400px] lg:h-[550px] flex items-center justify-center">
      <div class="absolute top-2 left-2 lg:top-[-20px] lg:left-0 w-[40px] h-[40px] lg:w-[63px] lg:h-[63px] rounded-full bg-gradient-to-br from-pink-500/70 to-pink-600" />
      <div class="absolute bottom-2 right-2 lg:bottom-[-20px] lg:right-0 w-[50px] h-[50px] lg:w-[75px] lg:h-[75px] rounded-full bg-white" />

      <div 
        class="w-full max-w-[900px] min-h-[400px] lg:h-[512px] bg-white rounded-2xl shadow-2xl flex flex-col lg:flex-row overflow-hidden transition-all duration-1000 ease-out delay-300"
        :class="isPageLoaded ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
      >
        <div
          class="hidden lg:flex w-full lg:w-1/2 h-[200px] lg:h-full relative bg-cover bg-center"
          style="background-image: url('/login/Rectangle 4.png');"
        >
          <div class="absolute inset-0 flex justify-center items-center">
            <div class="transform scale-90 lg:scale-110">
              <div class="relative w-[250px] lg:w-[300px] h-[280px] lg:h-[330px]">
                <div class="absolute inset-0 bg-white/20 border border-white/50 rounded-[30px] backdrop-blur-sm" />
                <div class="absolute top-[30px] lg:top-[36px] left-[16px] lg:left-[20px] text-white font-bold text-[18px] lg:text-[21.3px] leading-[26px] lg:leading-[30.7px] font-['Poppins'] z-10">
                  sumbar madani <br> yang unggul <br> dan berkelanjutan
                </div>
                <img
                  class="absolute top-[120px] lg:top-[144px] w-[230px] lg:w-[275px] inset-0 object-cover"
                  src="/login/login.png"
                  alt="Decorative background"
                >
                <div class="absolute bottom-[-15px] lg:bottom-[-20px] left-[-18px] lg:left-[-21px] w-[45px] lg:w-[53px] h-[45px] lg:h-[53px] bg-white rounded-full flex items-center justify-center">
                  <img
                    class="w-[24px] lg:w-[28px] h-[24px] lg:h-[28px]"
                    src="/login/petir.png"
                    alt="Thunderbolt icon"
                  >
                </div>
              </div>
            </div>
          </div>
        </div>

        <div 
          class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center p-6 lg:p-8 transition-all duration-1000 ease-out delay-500"
          :class="isPageLoaded ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
        >
          <div class="w-full max-w-md text-center">
            <h2 class="text-black text-2xl lg:text-xl font-bold font-['Poppins'] mb-2">
              VERIFIKASI OTP
            </h2>
            <p class="text-gray-600 text-sm lg:text-[10.7px] mb-6 lg:mb-4 font-['Poppins']">
              Masukkan 6 digit kode yang dikirim ke <br> <span class="font-bold text-pink-600">{{ userEmail }}</span>
            </p>

            <form
              class="space-y-6"
              @submit.prevent="verifyOTP"
            >
              <div
                class="flex justify-center gap-2 lg:gap-3"
                @paste="handlePaste"
              >
                <input
                  v-for="(digit, index) in otpDigits"
                  :key="index"
                  ref="otpInput"
                  v-model="otpDigits[index]"
                  type="text"
                  maxlength="1"
                  class="w-12 h-12 lg:w-10 lg:h-10 text-center text-lg lg:text-base font-bold bg-[#efedffcc] rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 transition"
                  @input="handleInput($event, index)"
                  @keydown="handleKeyDown($event, index)"
                >
              </div>

              <div class="flex justify-center">
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="w-[150px] h-[45px] lg:w-[120px] lg:h-[35px] rounded-[10.67px] text-white text-sm lg:text-[8px] font-bold font-['Poppins'] shadow-lg bg-gradient-to-br from-pink-500/80 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isLoading ? '...' : 'Verifikasi' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>