<template>
  <div
    v-if="visible"
    class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
    @click.self="close"
  >
    <transition
      name="modal"
      appear
    >
      <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full max-h-[95vh] flex flex-col overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4 sm:px-8 sm:py-6 rounded-t-xl">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
              <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <svg
                  class="w-6 h-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                ><path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                /></svg>
              </div>
              <div>
                <h2 class="text-xl sm:text-2xl font-bold text-white">
                  Tindak Lanjut Pengaduan
                </h2>
                <p class="text-pink-100 text-xs sm:text-sm">
                  Pilih tindakan yang akan diambil untuk pengaduan ini.
                </p>
              </div>
            </div>
            <button
              class="p-2 hover:bg-white/20 rounded-lg transition-colors duration-200"
              aria-label="Tutup"
              @click="close"
            >
              <svg
                class="w-6 h-6 text-white"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              ><path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              /></svg>
            </button>
          </div>
        </div>

        <!-- Form Body -->
        <div class="flex-grow overflow-y-auto p-6 sm:p-8">
          <div class="space-y-4">
            <label
              class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200"
              :class="tindakan === 'konsultasi' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-200 hover:bg-pink-50/50'"
            >
              <input
                v-model="tindakan"
                type="radio"
                class="sr-only"
                value="konsultasi"
              >
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full flex items-center justify-center">
                      <svg
                        class="w-4 h-4 text-pink-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      ><path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V4a2 2 0 012-2h6l4 4z"
                      /></svg>
                    </div>
                  </div>
                  <div>
                    <div class="font-semibold text-gray-800">
                      Lanjutkan sebagai Konsultasi
                    </div>
                    <div class="text-xs text-gray-500">
                      Data akan dipindahkan ke menu konsultasi.
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="tindakan === 'konsultasi'"
                class="w-5 h-5 bg-pink-500 rounded-full flex items-center justify-center ml-4"
              >
                <svg
                  class="w-3 h-3 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                ><path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M5 13l4 4L19 7"
                /></svg>
              </div>
            </label>

            <label
              class="flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all duration-200"
              :class="tindakan === 'lainnya' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-200 hover:bg-pink-50/50'"
            >
              <input
                v-model="tindakan"
                type="radio"
                class="sr-only"
                value="lainnya"
              >
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                      <svg
                        class="w-4 h-4 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                      ><path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                      /></svg>
                    </div>
                  </div>
                  <div>
                    <div class="font-semibold text-gray-800">
                      Lainnya
                    </div>
                    <div class="text-xs text-gray-500">
                      Masukkan keterangan atau tindakan lain.
                    </div>
                  </div>
                </div>
                <div
                  v-if="tindakan === 'lainnya'"
                  class="mt-3"
                >
                  <textarea
                    v-model="keteranganLainnya"
                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                    placeholder="Masukkan keterangan..."
                    rows="3"
                  />
                </div>
              </div>
              <div
                v-if="tindakan === 'lainnya'"
                class="w-5 h-5 bg-pink-500 rounded-full flex items-center justify-center ml-4 flex-shrink-0 mt-1"
              >
                <svg
                  class="w-3 h-3 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                ><path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="3"
                  d="M5 13l4 4L19 7"
                /></svg>
              </div>
            </label>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-end p-6 bg-gray-50 border-t border-gray-200">
          <button
            type="button"
            class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl font-medium hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-sm"
            @click="close"
          >
            <div class="flex items-center justify-center space-x-2">
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              ><path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              /></svg>
              <span>Batal</span>
            </div>
          </button>
          <button
            type="button"
            class="px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white rounded-xl font-medium focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl"
            @click="submit"
          >
            <div class="flex items-center justify-center space-x-2">
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              ><path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              /></svg>
              <span>Submit Tindakan</span>
            </div>
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script lang="ts" setup>
import { ref, defineProps, defineEmits } from 'vue';

const props = defineProps({
  visible: {
    type: Boolean,
    default: false,
  },
  pengaduanId: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(['close', 'submit']);

const tindakan = ref('konsultasi');
const keteranganLainnya = ref('');

const close = () => {
  emit('close');
};

const submit = () => {
  emit('submit', {
    id: props.pengaduanId,
    tindakan: tindakan.value,
    keterangan: keteranganLainnya.value,
  });
  close();
};
</script>

<style scoped>
/* Modal Transition */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}
</style>
