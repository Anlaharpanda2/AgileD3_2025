<template>
  <div
    v-if="visible"
    class="fixed inset-0 z-50 flex items-center justify-center"
  >
    <!-- Overlay with immediate dark background -->
    <div 
      class="absolute inset-0 bg-black/50 backdrop-blur-sm" 
      @click.self="closeForm"
    />
    
    <!-- Modal Container with separate transition -->
    <transition
      name="modal"
      appear
    >
      <div class="relative z-10 w-full max-w-md mx-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
          <!-- Header -->
          <div class="relative bg-gradient-to-r from-pink-50 to-white p-6 border-b border-gray-100">
            <button 
              class="absolute top-4 right-4 p-2 text-gray-400 hover:text-pink-500 hover:bg-pink-50 rounded-full transition-all duration-200 group" 
              @click="closeForm"
            >
              <X class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" />
            </button>
            
            <div class="flex items-center space-x-3">
              <div class="p-3 bg-pink-100 rounded-xl">
                <Settings class="w-6 h-6 text-pink-600" />
              </div>
              <div>
                <h2 class="text-xl font-bold text-gray-800">
                  Pengaturan Kuota
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                  Kelola kuota pendaftaran
                </p>
              </div>
            </div>
          </div>

          <!-- Content -->
          <div class="p-6 space-y-6">
            <!-- Status Toggle -->
            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-700">
                Status Pendaftaran
              </label>
              <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
                <div class="flex items-center space-x-3">
                  <div
                    :class="[
                      'w-3 h-3 rounded-full transition-colors duration-200',
                      form.status ? 'bg-green-400' : 'bg-gray-300'
                    ]"
                  />
                  <span class="text-sm font-medium text-gray-700">
                    {{ form.status ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' }}
                  </span>
                </div>
                <button
                  :class="[
                    'relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2',
                    form.status ? 'bg-pink-500' : 'bg-gray-300'
                  ]"
                  @click="toggleStatus"
                >
                  <span
                    :class="[
                      'inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200',
                      form.status ? 'translate-x-6' : 'translate-x-1'
                    ]"
                  />
                </button>
              </div>
            </div>

            <!-- Quota Input -->
            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-700">
                Jumlah Kuota Pendaftaran
              </label>
              <div class="relative">
                <input
                  v-model="form.quota"
                  type="number"
                  min="1"
                  max="9999"
                  class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-200 bg-white text-gray-800"
                  placeholder="Masukkan jumlah kuota"
                >
                <div class="absolute right-3 top-1/2 -translate-y-1/2 flex flex-col">
                  <button
                    class="text-gray-400 hover:text-pink-500 transition-colors duration-200"
                    @click="incrementQuota"
                  >
                    <ChevronUp class="w-4 h-4" />
                  </button>
                  <button
                    class="text-gray-400 hover:text-pink-500 transition-colors duration-200"
                    @click="decrementQuota"
                  >
                    <ChevronDown class="w-4 h-4" />
                  </button>
                </div>
              </div>
              
              <!-- Info Card -->
              <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="grid grid-cols-2 gap-4 text-sm">
                  <div class="flex items-center space-x-2">
                    <Users class="w-4 h-4 text-gray-400" />
                    <span class="text-gray-600">Kuota Saat Ini:</span>
                  </div>
                  <span class="font-semibold text-gray-800">{{ currentQuotaData.quota }}</span>
                  
                  <div class="flex items-center space-x-2">
                    <UserCheck class="w-4 h-4 text-gray-400" />
                    <span class="text-gray-600">Terdaftar:</span>
                  </div>
                  <span class="font-semibold text-gray-800">{{ currentQuotaData.count_pendaftar }}</span>
                </div>
              </div>
            </div>

            <!-- Message -->
            <div
              v-if="message"
              :class="[
                'p-4 rounded-xl border text-sm font-medium',
                messageType === 'success' 
                  ? 'bg-green-50 border-green-200 text-green-700' 
                  : 'bg-red-50 border-red-200 text-red-700'
              ]"
            >
              <div class="flex items-center space-x-2">
                <CheckCircle
                  v-if="messageType === 'success'"
                  class="w-4 h-4"
                />
                <AlertCircle
                  v-else
                  class="w-4 h-4"
                />
                <span>{{ message }}</span>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            <div class="flex space-x-3">
              <button
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
                @click="cancelChanges"
              >
                Batal
              </button>
              <button
                :disabled="isLoading"
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-pink-500 to-pink-600 rounded-xl hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl"
                @click="applyChanges"
              >
                <div class="flex items-center justify-center space-x-2">
                  <Loader2
                    v-if="isLoading"
                    class="w-4 h-4 animate-spin"
                  />
                  <Save
                    v-else
                    class="w-4 h-4"
                  />
                  <span>{{ isLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
                </div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, watch } from 'vue';
import { 
  X, Settings, Users, UserCheck, ChevronUp, ChevronDown,
  CheckCircle, AlertCircle, Loader2, Save
} from 'lucide-vue-next';
import api from '../../api.js';

const props = defineProps<{
  visible: boolean;
}>();

const emits = defineEmits<{
  (e: 'update:visible', value: boolean): void;
  (e: 'quota-updated'): void;
}>();

// State untuk form
const form = reactive({
  status: false,
  quota: 1,
});

// State untuk data kuota saat ini dari API
const currentQuotaData = reactive({
  status: false,
  quota: 0,
  count_pendaftar: 0,
  status_quota: false,
});

const isLoading = ref(false);
const message = ref('');
const messageType = ref('');

// Fungsi untuk menutup form
function closeForm(): void {
  emits('update:visible', false);
  message.value = '';
  messageType.value = '';
}

// Fungsi toggle status
function toggleStatus(): void {
  form.status = !form.status;
}

// Fungsi increment/decrement quota
function incrementQuota(): void {
  if (form.quota < 9999) {
    form.quota++;
  }
}

function decrementQuota(): void {
  if (form.quota > 1) {
    form.quota--;
  }
}

// Fungsi untuk mengambil data kuota dari API
async function fetchQuotaData(): Promise<void> {
  isLoading.value = true;
  message.value = '';
  try {
    const response = await api.get('/quota/pendaftaran');
    if (response.data && typeof response.data === 'object' && response.data.status !== undefined && response.data.quota !== undefined) {
      const data = response.data;
      currentQuotaData.status = data.status;
      currentQuotaData.quota = data.quota;
      currentQuotaData.count_pendaftar = data.count_pendaftar;
      currentQuotaData.status_quota = data.status_quota;

      // Sinkronkan form dengan data yang diambil
      form.status = data.status;
      form.quota = data.quota;
    } else {
      console.error('Format data API tidak sesuai:', response.data);
      message.value = 'Gagal mengambil data kuota: Format tidak valid.';
      messageType.value = 'error';
    }
  } catch (error) {
    console.error('Error mengambil data kuota:', error);
    message.value = 'Gagal mengambil data kuota. Silakan coba lagi.';
    messageType.value = 'error';
  } finally {
    isLoading.value = false;
  }
}

// Fungsi untuk mengirim perubahan ke API
async function applyChanges(): Promise<void> {
  isLoading.value = true;
  message.value = '';
  try {
    const payload = {
      status: form.status,
      quota: form.quota,
    };
    const response = await api.post('/update/quota', payload);
    if (response.data) {
      message.value = 'Perubahan berhasil disimpan!';
      messageType.value = 'success';
      await fetchQuotaData();
      emits('quota-updated');
      setTimeout(() => {
        closeForm();
      }, 2000);
    } else {
      console.error('Respon API tidak sesuai:', response.data);
      message.value = 'Gagal menyimpan perubahan: Respon tidak valid.';
      messageType.value = 'error';
    }
  } catch (error) {
    console.error('Error menyimpan perubahan kuota:', error);
    message.value = 'Gagal menyimpan perubahan. Silakan coba lagi.';
    messageType.value = 'error';
  } finally {
    isLoading.value = false;
  }
}

// Fungsi untuk membatalkan perubahan
function cancelChanges(): void {
  form.status = currentQuotaData.status;
  form.quota = currentQuotaData.quota;
  closeForm();
}

// Watcher untuk mengambil data saat modal dibuka
watch(() => props.visible, (newVal) => {
  if (newVal) {
    fetchQuotaData();
  }
}, { immediate: true });
</script>

<style scoped>
/* Modal transition - hanya untuk konten modal */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.95) translateY(20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(-10px);
}

/* Custom scrollbar untuk area yang bisa di-scroll */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #ec4899;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #db2777;
}

/* Animasi untuk input number buttons */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}
</style>