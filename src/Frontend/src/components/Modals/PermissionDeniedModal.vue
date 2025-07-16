<template>
  <div
    v-if="isVisible"
    class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 p-4 sm:p-6"
    @click.self="closeModal"
  >
    <transition name="modal-fade">
      <div
        v-if="isVisible"
        class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6 sm:p-8 text-center transform transition-all duration-300 ease-out scale-95 opacity-0"
        :class="{ 'scale-100 opacity-100': isVisible }"
      >
        <div class="flex justify-center mb-4">
          <svg
            class="w-16 h-16 text-red-500"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            ></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">Akses Ditolak!</h3>
        <p class="text-gray-600 mb-6">
          Anda bukan operator utama. Operator utama adalah pengguna dengan label hijau di tampilan data.
          Jika Anda merasa perlu mengubah data, mintalah mereka untuk melakukannya.
          Namun, jika Anda ingin mengubah kata sandi akun Anda, maka Anda bisa melakukannya pada halaman
          <router-link to="/reset/forgot" class="text-blue-600 hover:underline font-medium">ubah password</router-link> berikut.
        </p>
        <button
          @click="closeModal"
          class="px-6 py-3 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
        >
          Mengerti
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps<{
  isVisible: boolean;
}>();

const emit = defineEmits(['update:isVisible']);

const closeModal = () => {
  emit('update:isVisible', false);
};
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.3s ease-in-out;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.9);
}
</style>
