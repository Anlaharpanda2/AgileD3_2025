<template>
  <!-- Hero Section -->
  <section class="relative min-h-[600px] w-full overflow-hidden bg-gradient-to-br from-purple-50 via-fuchsia-50 to-pink-50 flex items-center pt-20">
    <!-- Decorative background shapes -->
    <div class="absolute -top-[280px] -right-[200px] w-[550px] h-[550px] bg-pink-400/20 rounded-full z-[1] md:bg-pink-400/30" />
    <div class="absolute top-[-50%] right-[-50%] w-[200%] h-[200%] bg-[radial-gradient(circle,rgba(236,72,153,0.08)_0%,transparent_60%)] animate-[float_6s_ease-in-out_infinite] z-0" />

    <!-- Hero Content -->
    <div
      ref="heroContentRef"
      :class="[
        'relative z-10 max-w-7xl mx-auto px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center transition-all ease-out duration-1000',
        isHeroContentVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'
      ]"
    >
      <!-- Text Content -->
      <div class="flex flex-col gap-6 text-center items-center lg:text-left lg:items-start">
        <h1 class="text-4xl lg:text-[3.5rem] font-extrabold text-slate-800 leading-tight lg:text-left lg:items-start">
          DP3AP2KB
          <span class="block bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent lg:text-left lg:items-start">
            Sumatera Barat
          </span>
        </h1>
        <h2 class="text-xl lg:text-2xl font-bold text-slate-800 leading-tight -mt-2 lg:text-left lg:items-start">
          Peningkatan Ekonomi Perempuan Rentan Berspektif Gender (PEPSIKUBURGER)
        </h2>
        <p class="text-base lg:text-lg text-slate-600 max-w-xl leading-relaxed lg:text-left lg:items-start">
          Pemberdayaan Perempuan Demi Meningkatkan Penghasilan Dan Kemandirian Ekonomi Melalui Pelatihan, Pendampingan Dan Pendekatan Berbasis Kesetaraan Gender.
        </p>
        
        <!-- Action Buttons -->
        <div class="flex gap-4 mt-4 flex-wrap justify-center lg:justify-start">
          <button
            class="flex items-center gap-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold text-sm lg:text-base px-6 py-3 rounded-lg shadow-lg shadow-pink-500/30 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-pink-500/40 transition-all duration-300"
            @click="$router.push('/daftar/masyarakat')"
          >
            Mulai Bergabung
            <!-- Inline SVG for ArrowRight Icon -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
              class="w-5 h-5"
            >
              <path
                fill-rule="evenodd"
                d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
          <button
            class="bg-white text-slate-600 font-semibold text-sm lg:text-base px-6 py-3 rounded-lg border-2 border-slate-200 hover:border-pink-400 hover:text-pink-500 hover:bg-pink-500/5 transition-all duration-300"
            @click="$router.push('/faq')"
          >
            Pelajari Program
          </button>
        </div>
      </div>

      <!-- Illustration -->
      <div
        ref="heroIllustrationRef"
        :class="[
          'hidden lg:flex relative h-[500px] items-center justify-center transition-all ease-out duration-1000 delay-200',
          isHeroIllustrationVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-90'
        ]"
      >
        <!-- Floating Cards -->
        <div class="absolute z-10 p-8 lg:p-12 text-center bg-white/70 backdrop-blur-lg rounded-2xl shadow-2xl shadow-slate-500/10 animate-[float_3s_ease-in-out_infinite]">
          <!-- Inline SVG for Female Icon -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-16 h-16 mx-auto text-pink-500"
          >
            <path
              fill="currentColor"
              d="M12 4.006A5 5 0 0 1 12.252 14h-.504A5 5 0 0 1 12 4.006m1 11.93a7.002 7.002 0 0 0-1-13.93a7 7 0 0 0-1 13.93V17H8v2h3v3h2v-3h3v-2h-3z"
            />
          </svg>
          <p class="mt-4 font-semibold text-slate-700">
            Pemberdayaan<br>Perempuan
          </p>
        </div>

        <div class="absolute top-[60%] left-[15%] p-6 text-center bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl shadow-slate-500/10 animate-[float_3s_ease-in-out_infinite] [animation-delay:-1s]">
          <!-- Inline SVG for User Icon -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-12 h-12 mx-auto text-purple-500"
          >
            <path
              fill-rule="evenodd"
              d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="mt-2 text-sm font-semibold text-slate-600">
            Pengendalian<br>Penduduk
          </p>
        </div>
        
        <div class="absolute top-[10%] right-[13%] p-6 text-center bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl shadow-slate-500/10 animate-[float_3s_ease-in-out_infinite] [animation-delay:-2s]">
          <!-- Inline SVG for Gender Icon -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="42"
            height="42"
            viewBox="0 0 14 14"
            class="w-12 h-12 mx-auto text-emerald-500"
          >
            <path
              fill="currentColor"
              fill-rule="evenodd"
              d="M9.5 0a.5.5 0 0 0-.354.854l.808.808l-1.013 1.013a4.125 4.125 0 1 0-3.066 7.403v1.172H5a.625.625 0 1 0 0 1.25h.875v.875a.625.625 0 1 0 1.25 0V12.5H8a.625.625 0 1 0 0-1.25h-.875v-1.172a4.126 4.126 0 0 0 2.7-6.52l1.013-1.013l.808.809A.5.5 0 0 0 12.5 3V.5A.5.5 0 0 0 12 0zm-.967 3.967l-.003-.003a2.875 2.875 0 1 0 .007.007zM4.875 5c0-.345.28-.625.625-.625h2a.625.625 0 1 1 0 1.25h-2A.625.625 0 0 1 4.875 5M5.5 6.375a.625.625 0 1 0 0 1.25h2a.625.625 0 1 0 0-1.25z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="mt-2 text-sm font-semibold text-slate-600">
            Kesetaraan<br>Gender
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// --- Pengganti AOS untuk animasi saat scroll ---
const heroContentRef = ref(null);
const heroIllustrationRef = ref(null);
const isHeroContentVisible = ref(false);
const isHeroIllustrationVisible = ref(false);

let observer;

onMounted(() => {
  // Opsi untuk Intersection Observer
  const options = {
    root: null, // relatif terhadap viewport
    threshold: 0.2, // elemen dianggap terlihat jika 20% areanya masuk viewport
  };

  // Callback function saat elemen teramati
  const callback = (entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Set ref yang sesuai menjadi true saat elemen terlihat
        if (entry.target === heroContentRef.value) {
          isHeroContentVisible.value = true;
        } else if (entry.target === heroIllustrationRef.value) {
          isHeroIllustrationVisible.value = true;
        }
        // Hentikan pengamatan setelah elemen terlihat untuk performa
        observer.unobserve(entry.target);
      }
    });
  };

  // Buat instance observer
  observer = new IntersectionObserver(callback, options);

  // Amati elemen-elemen yang diinginkan
  if (heroContentRef.value) {
    observer.observe(heroContentRef.value);
  }
  if (heroIllustrationRef.value) {
    observer.observe(heroIllustrationRef.value);
  }
});

// Hentikan observer saat komponen di-unmount untuk mencegah memory leak
onUnmounted(() => {
  if (observer) {
    observer.disconnect();
  }
});

// Tidak ada lagi import dari 'vue-router', 'aos', 'element-plus', atau '@element-plus/icons-vue'
// Jika Anda memerlukan fungsionalitas routing, Anda bisa menambahkannya kembali.
// import { useRouter } from 'vue-router'
// const router = useRouter()
</script>

<!-- 
  CATATAN PENTING:
  Tidak ada lagi blok <style scoped>. Semua styling sekarang ditangani oleh kelas utilitas Tailwind CSS.
  
  Untuk animasi 'float', Anda perlu menambahkan konfigurasi keyframes ke file tailwind.config.js Anda.
  Ini adalah satu-satunya cara untuk mendefinisikan keyframes kustom tanpa menggunakan tag <style>.

  Tambahkan ini di dalam file tailwind.config.js Anda:

  module.exports = {
    // ...konfigurasi lainnya
    theme: {
      extend: {
        keyframes: {
          float: {
            '0%, 100%': { transform: 'translateY(0px)' },
            '50%': { transform: 'translateY(-15px)' },
          }
        }
      },
    },
    // ...konfigurasi lainnya
  }
-->
