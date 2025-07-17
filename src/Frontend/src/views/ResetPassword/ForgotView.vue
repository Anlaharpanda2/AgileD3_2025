<script>
import api from '../../api';
import { ElNotification } from 'element-plus';

export default {
  data() {
    return {
      email: '',
      isLoading: false,
      isPageLoaded: false,
    };
  },
  mounted() {
    setTimeout(() => {
      this.isPageLoaded = true;
    }, 100);
  },
  methods: {
    async handleSubmit(event) {
      event.preventDefault();

      if (!this.email) {
        ElNotification.error({
          title: 'Error',
          message: 'Silakan masukkan alamat email Anda.',
          position: 'top-right',
        });
        return;
      }

      if (!/^[\w-.@]+([\w-]+\.)+[\w-]{2,4}$/.test(this.email)) {
        ElNotification.error({
          title: 'Error',
          message: 'Format email tidak valid.',
          position: 'top-right',
        });
        return;
      }

      this.isLoading = true;

      try {
        await api.post('/email/check', { email: this.email });
        const forgotResponse = await api.post('/password/forgot', { email: this.email });
        
        ElNotification.success({
          title: 'Sukses',
          message: forgotResponse.data?.message || 'OTP berhasil dikirim ke email Anda.',
          position: 'top-right',
        });

        this.$router.push({ 
          path: '/reset/otp', 
          query: { email: this.email }
        });
      } catch (error) {
        const errorMessage = 
          error.response?.data?.message ||
          error.message ||
          'Terjadi kesalahan. Silakan coba lagi.';
        
        ElNotification.error({
          title: 'Error',
          message: errorMessage,
          position: 'top-right',
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
          <div class="w-full max-w-[280px] lg:max-w-[250px]">
            <h2 class="text-center text-black text-2xl lg:text-xl font-bold font-['Poppins'] mb-2">
              LUPA KATA SANDI
            </h2>
            <p class="text-center text-gray-600 text-sm lg:text-[10.7px] mb-6 lg:mb-4 font-['Poppins']">
              Masukkan email Anda untuk menerima OTP
            </p>

            <form
              class="space-y-4 lg:space-y-3"
              @submit.prevent="handleSubmit"
            >
              <div class="relative w-full h-[45px] lg:h-[35px]">
                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img
                    class="w-5 h-5 lg:w-4 lg:h-4"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg"
                    alt="Email icon"
                  >
                </div>
                <input
                  v-model="email"
                  type="email"
                  placeholder="Alamat Email"
                  autocomplete="email"
                  class="w-full h-full bg-[#efedffcc] rounded-[10.67px] pl-11 lg:pl-9 pr-3 text-sm lg:text-[11px] font-['Poppins'] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                >
              </div>

              <div class="pt-3 lg:pt-2 flex justify-center">
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="w-[120px] h-[45px] lg:w-[100px] lg:h-[35px] rounded-[10.67px] text-white text-sm lg:text-[8px] font-bold font-['Poppins'] shadow-lg bg-gradient-to-br from-pink-500/80 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isLoading ? '...' : 'Kirim OTP' }}
                </button>
              </div>
            </form>

            <p class="text-center text-sm lg:text-[9px] mt-6 lg:mt-4 font-['Roboto']">
              <span class="font-light text-black">Ingat kata sandi? </span>
              <a
                href="/login/operator"
                class="font-bold text-[#fe3275] hover:underline"
              >Login</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>