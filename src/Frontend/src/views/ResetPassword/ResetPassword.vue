<script>
import api from '../../api';
import { ElNotification } from 'element-plus';

export default {
  data() {
    return {
      email: '',
      newPassword: '',
      confirmPassword: '',
      showNewPassword: false,
      showConfirmPassword: false,
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
        this.email = emailFromQuery;
      } else {
        ElNotification.error({
          title: 'Error',
          message: 'Email tidak ditemukan. Tidak dapat mereset password.',
        });
      }
    },
    toggleNewPasswordVisibility() {
      this.showNewPassword = !this.showNewPassword;
    },
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    async resetPassword() {
      // Validasi dasar
      if (!this.newPassword || !this.confirmPassword) {
        ElNotification.error({ title: 'Error', message: 'Semua field harus diisi.' });
        return;
      }
      if (this.newPassword !== this.confirmPassword) {
        ElNotification.error({ title: 'Error', message: 'Password tidak cocok.' });
        return;
      }

      // --- Validasi Password Ketat (diambil dari LoginOperator.vue) ---
      if (this.newPassword.length < 8 || this.newPassword.length > 30) {
        ElNotification.error({ title: 'Error', message: 'Password harus 8 hingga 30 karakter.' });
        return;
      }
      if (!/[A-Z]/.test(this.newPassword)) {
        ElNotification.error({ title: 'Error', message: 'Password harus mengandung setidaknya satu huruf besar (A-Z).' });
        return;
      }
      if (!/[a-z]/.test(this.newPassword)) {
        ElNotification.error({ title: 'Error', message: 'Password harus mengandung setidaknya satu huruf kecil (a-z).' });
        return;
      }
      if (!/\d/.test(this.newPassword)) {
        ElNotification.error({ title: 'Error', message: 'Password harus mengandung setidaknya satu angka (0-9).' });
        return;
      }
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(this.newPassword)) {
        ElNotification.error({ title: 'Error', message: 'Password harus mengandung setidaknya satu simbol (contoh: !@#$%^&*).' });
        return;
      }
      // --- Akhir Validasi Password Ketat ---

      this.isLoading = true;
      try {
        const data = await api.patch('/password/reset', {
          email: this.email,
          password: this.newPassword,
          password_confirmation: this.confirmPassword,
        });

        if (data && data.message === 'Password berhasil direset') {
            ElNotification.success({
                title: 'Sukses',
                message: 'Password berhasil direset. Anda akan diarahkan ke halaman login.',
            });

            setTimeout(() => {
                this.$router.push('/login/operator');
            }, 2000);
        } else {
            ElNotification.error({
                title: 'Gagal',
                message: data.message || 'Gagal mereset password. Silakan coba lagi.',
            });
        }

      } catch (error) {
        ElNotification.error({
          title: 'Gagal',
          message: error.response?.data?.message || 'Gagal mereset password.',
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
      
      <div class="absolute top-2 left-2 lg:top-[-20px] lg:left-0 w-[40px] h-[40px] lg:w-[63px] lg:h-[63px] rounded-full bg-gradient-to-br from-pink-500/70 to-pink-600"></div>
      <div class="absolute bottom-2 right-2 lg:bottom-[-20px] lg:right-0 w-[50px] h-[50px] lg:w-[75px] lg:h-[75px] rounded-full bg-white"></div>

      <div 
        class="w-full max-w-[900px] min-h-[400px] lg:h-[512px] bg-white rounded-2xl shadow-2xl flex flex-col lg:flex-row overflow-hidden transition-all duration-1000 ease-out delay-300"
        :class="isPageLoaded ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
      >
        
        <div class="hidden lg:flex w-full lg:w-1/2 h-[200px] lg:h-full relative bg-cover bg-center" style="background-image: url('/login/Rectangle 4.png');">
          <div class="absolute inset-0 flex justify-center items-center">
            <div class="transform scale-90 lg:scale-110">
              <div class="relative w-[250px] lg:w-[300px] h-[280px] lg:h-[330px]">
                <div class="absolute inset-0 bg-white/20 border border-white/50 rounded-[30px] backdrop-blur-sm"></div>
                <div class="absolute top-[30px] lg:top-[36px] left-[16px] lg:left-[20px] text-white font-bold text-[18px] lg:text-[21.3px] leading-[26px] lg:leading-[30.7px] font-['Poppins'] z-10">
                  sumbar madani <br> yang unggul <br> dan berkelanjutan
                </div>
                <img class="absolute top-[120px] lg:top-[144px] w-[230px] lg:w-[275px] inset-0 object-cover" src="/login/login.png" alt="Decorative background">
                <div class="absolute bottom-[-15px] lg:bottom-[-20px] left-[-18px] lg:left-[-21px] w-[45px] lg:w-[53px] h-[45px] lg:h-[53px] bg-white rounded-full flex items-center justify-center">
                  <img class="w-[24px] lg:w-[28px] h-[24px] lg:h-[28px]" src="/login/petir.png" alt="Thunderbolt icon">
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
            <h2 class="text-black text-2xl lg:text-xl font-bold font-['Poppins'] mb-2">ATUR KATA SANDI BARU</h2>
            <p class="text-gray-600 text-sm lg:text-[10.7px] mb-6 lg:mb-4 font-['Poppins']">
              Masukkan kata sandi baru untuk akun <br> <span class="font-bold text-pink-600">{{ email }}</span>
            </p>

            <form @submit.prevent="resetPassword" class="space-y-4">
              <!-- New Password -->
              <div class="relative w-full">
                <input
                  v-model="newPassword"
                  :type="showNewPassword ? 'text' : 'password'"
                  placeholder="Kata Sandi Baru"
                  class="w-full h-[45px] lg:h-[35px] bg-[#efedffcc] rounded-[10.67px] pl-11 pr-10 text-sm lg:text-[11px] font-['Poppins'] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                >
                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img class="w-5 h-5 lg:w-4 lg:h-4" src="https://c.animaapp.com/IJi6pJQY/img/frame.svg" alt="Password icon">
                </div>
                <button type="button" @click="toggleNewPasswordVisibility" class="absolute right-3 top-1/2 -translate-y-1/2">
                  <img :src="showNewPassword ? '/reset/asset1.svg' : '/reset/asset2.svg'" class="w-5 h-5">
                </button>
              </div>

              <!-- Confirm Password -->
              <div class="relative w-full">
                <input
                  v-model="confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  placeholder="Konfirmasi Kata Sandi"
                  class="w-full h-[45px] lg:h-[35px] bg-[#efedffcc] rounded-[10.67px] pl-11 pr-10 text-sm lg:text-[11px] font-['Poppins'] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                >
                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img class="w-5 h-5 lg:w-4 lg:h-4" src="https://c.animaapp.com/IJi6pJQY/img/frame.svg" alt="Password icon">
                </div>
                <button type="button" @click="toggleConfirmPasswordVisibility" class="absolute right-3 top-1/2 -translate-y-1/2">
                  <img :src="showConfirmPassword ? '/reset/asset1.svg' : '/reset/asset2.svg'" class="w-5 h-5">
                </button>
              </div>

              <div class="pt-3 flex justify-center">
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="w-[180px] h-[45px] lg:w-[150px] lg:h-[35px] rounded-[10.67px] text-white text-sm lg:text-[8px] font-bold font-['Poppins'] shadow-lg bg-gradient-to-br from-pink-500/80 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isLoading ? '...' : 'Reset Password' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
