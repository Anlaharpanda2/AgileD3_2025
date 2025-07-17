<script>
import api from '../../api';

export default {
  data() {
    return {
      username: '',
      password: '',
      showPassword: false,
      errorMessage: '',
      isPageLoaded: false,
      isLoading: false,
    };
  },
  computed: {
    passwordInputType() {
      return this.showPassword ? 'text' : 'password';
    }
  },
  mounted() {
    setTimeout(() => {
      this.isPageLoaded = true;
    }, 100);

    if (localStorage.getItem('isLoggedIn') === 'true' &&
        localStorage.getItem('role') === 'pegawai') {
      this.$router.push('/data/pelatihan');
    }
  },
  methods: {
    async handleLogin() {
      this.errorMessage = '';
      this.isLoading = true;

      // Validasi input
      if (!this.username || !this.password) {
        this.errorMessage = 'Silakan isi username dan password.';
        this.isLoading = false;
        return;
      }
      if (!/^[a-zA-Z0-9_.]{1,30}$/.test(this.username)) {
        this.errorMessage = 'Username maksimal 30 karakter dan hanya boleh huruf, angka, titik, atau underscore.';
        this.isLoading = false;
        return;
      }
      if (this.password.length < 8 || this.password.length > 30) {
        this.errorMessage = 'Password harus 8 hingga 30 karakter.';
        this.isLoading = false;
        return;
      }
      if (!/[A-Z]/.test(this.password)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu huruf besar (A-Z).';
        this.isLoading = false;
        return;
      }
      if (!/[a-z]/.test(this.password)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu huruf kecil (a-z).';
        this.isLoading = false;
        return;
      }
      if (!/\d/.test(this.password)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu angka (0-9).';
        this.isLoading = false;
        return;
      }
      if (!/[!@#$%^&*(),.?":{}|<>]/.test(this.password)) {
        this.errorMessage = 'Password harus mengandung setidaknya satu simbol (contoh: !@#$%^&*).';
        this.isLoading = false;
        return;
      }

      try {
        const data = await api.post('/login/pegawai', {
          username: this.username,
          password: this.password
        });

        if (!data || !data.user || !data.token) {
          throw new Error('Data login tidak lengkap dari server.');
        }

        const { user, token } = data;
        if (user.role !== 'pegawai') {
          this.errorMessage = 'Anda bukan pegawai.';
          return;
        }

        localStorage.setItem('isLoggedIn', 'true');
        localStorage.setItem('savedusername', user.username);
        localStorage.setItem('savedName', user.name);
        localStorage.setItem('role', user.role);
        localStorage.setItem('email', user.email);
        localStorage.setItem('token', token);
        localStorage.setItem('userId', user.id);
        localStorage.setItem('main', user.main);

        this.$router.push('/data/pelatihan');
      } catch (error) {
        this.errorMessage =
          error.response?.data?.message ||
          error.message ||
          'Login gagal. Silakan coba lagi.';
      } finally {
        this.isLoading = false;
      }
    }
  }
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
              MASUK PEGAWAI
            </h2>
            <p class="text-center text-gray-600 text-sm lg:text-[10.7px] mb-6 lg:mb-4 font-['Poppins']">
              Silahkan Masukan Username dan Password
            </p>

            <form
              class="space-y-4 lg:space-y-3"
              @submit.prevent="handleLogin"
            >
              <div class="relative w-full h-[45px] lg:h-[35px]">
                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img
                    class="w-5 h-5 lg:w-4 lg:h-4"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame-1.svg"
                    alt="User icon"
                  >
                </div>
                <input
                  v-model="username"
                  type="text"
                  placeholder="Username"
                  autocomplete="username"
                  class="w-full h-full bg-[#efedffcc] rounded-[10.67px] pl-11 lg:pl-9 pr-3 text-sm lg:text-[11px] font-['Poppins'] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                >
              </div>

              <div class="relative w-full h-[45px] lg:h-[35px]">
                <div class="absolute left-3 top-1/2 -translate-y-1/2">
                  <img
                    class="w-5 h-5 lg:w-4 lg:h-4"
                    src="https://c.animaapp.com/IJi6pJQY/img/frame.svg"
                    alt="Password icon"
                  >
                </div>
                <input
                  v-model="password"
                  :type="passwordInputType"
                  placeholder="Password"
                  autocomplete="current-password"
                  class="w-full h-full bg-[#efedffcc] rounded-[10.67px] pl-11 lg:pl-9 pr-3 text-sm lg:text-[11px] font-['Poppins'] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                >
              </div>
              
              <div class="flex items-center pt-2 lg:pt-1">
                <input
                  id="show-password"
                  v-model="showPassword"
                  type="checkbox"
                  class="h-4 w-4 lg:h-3 lg:w-3 rounded border-gray-300 text-pink-600 focus:ring-pink-500"
                >
                <label
                  for="show-password"
                  class="ml-2 text-sm lg:text-[8px] font-['Poppins'] text-gray-700"
                >Tampilkan Password</label>
              </div>

              <div class="pt-3 lg:pt-2 flex justify-center">
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="w-[100px] h-[45px] lg:w-[83px] lg:h-[35px] rounded-[10.67px] text-white text-sm lg:text-[8px] font-bold font-['Poppins'] shadow-lg bg-gradient-to-br from-pink-500/80 to-pink-600 hover:from-pink-600 hover:to-pink-700 transition-all transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isLoading ? '...' : 'Login Now' }}
                </button>
              </div>
              
              <div
                v-if="errorMessage"
                class="!mt-4 bg-red-500 text-white text-sm lg:text-xs text-center p-3 lg:p-2 rounded-md"
              >
                {{ errorMessage }}
              </div>
            </form>

            <p class="text-center text-sm lg:text-[9px] mt-6 lg:mt-4 font-['Roboto']">
              <span class="font-light text-black">Lupa Kata Sandi ? </span>
              <a
                href="/reset/forgot"
                class="font-bold text-[#fe3275] hover:underline"
              >Reset</a>
            </p>

            <div class="flex items-center my-4 lg:my-3">
              <hr class="flex-grow border-t border-gray-300">
              <span class="px-2 text-gray-500 text-sm lg:text-[10.7px] font-['Poppins']">Atau</span>
              <hr class="flex-grow border-t border-gray-300">
            </div>

            <div class="space-y-3 lg:space-y-2">
              <a
                href="/login/masyarakat"
                class="flex items-center justify-center w-full h-[45px] lg:h-[35px] border border-gray-300 rounded-[10.67px] hover:bg-gray-100 hover:border-pink-400 transition group"
              >
                <img
                  src="https://c.animaapp.com/IJi6pJQY/img/manage-accounts-24dp-e8eaed-fill0-wght400-grad0-opsz24-1.svg"
                  class="w-6 h-6 lg:w-5 lg:h-5 mr-4"
                  alt="Masyarakat icon"
                >
                <p class="text-sm lg:text-[8px] text-gray-800 font-['Poppins'] group-hover:text-pink-600">Masuk Sebagai <span class="font-bold">Masyarakat</span></p>
              </a>
              <a
                href="/login/operator"
                class="flex items-center justify-center w-full h-[45px] lg:h-[35px] border border-gray-300 rounded-[10.67px] hover:bg-gray-100 hover:border-pink-400 transition group"
              >
                <img
                  src="https://c.animaapp.com/IJi6pJQY/img/mask-group-1@2x.png"
                  class="w-6 h-6 lg:w-5 lg:h-5 mr-4"
                  alt="Operator icon"
                >
                <p class="text-sm lg:text-[8px] text-gray-800 font-['Poppins'] group-hover:text-pink-600">Masuk Sebagai <span class="font-bold">Operator</span></p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
