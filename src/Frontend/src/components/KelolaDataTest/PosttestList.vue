<template>
  <div class=" bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-7xl mx-auto">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
          Manajemen Posttest
        </h1>
        <p class="text-gray-600">
          Kelola dan pantau semua posttest yang tersedia
        </p>
      </div>

      <!-- Action Bar -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
              <svg
                class="w-5 h-5 text-pink-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                />
              </svg>
            </div>
            <div>
              <h2 class="text-lg font-semibold text-gray-900">
                Daftar Posttest
              </h2>
              <p class="text-sm text-gray-500">
                {{ filteredPosttests.length }} posttest tersedia
              </p>
            </div>
          </div>
          
          <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <button 
              v-if="isOperator"
              class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200"
              @click="showVisibilityModal = true"
            >
              <svg
                class="w-4 h-4 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
              </svg>
              Kelola Visibilitas
            </button>
            <button 
              v-if="isOperator"
              class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200 shadow-sm"
              @click="$router.push({ name: 'CreatePosttest' })"
            >
              <svg
                class="w-4 h-4 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                />
              </svg>
              Buat Posttest Baru
            </button>
          </div>
        </div>
        <div class="mt-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Cari berdasarkan nama atau deskripsi..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
          >
        </div>
      </div>

      <!-- Table Container -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Posttest
                </th>
                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Deskripsi
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Jumlah Soal
                </th>
                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th 
                  v-if="isOperator"
                  class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Aksi
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="posttest in paginatedPosttests"
                :key="posttest.id"
                class="hover:bg-gray-50 transition-colors duration-200"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-lg bg-pink-100 flex items-center justify-center">
                        <svg
                          class="h-5 w-5 text-pink-600"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                          />
                        </svg>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ posttest.title }}
                      </div>
                      <div class="text-sm text-gray-500">
                        ID: {{ posttest.id }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 max-w-xs">
                    {{ posttest.description || 'Tidak ada deskripsi' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ posttest.questions ? posttest.questions.length : 0 }} soal
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <span
                    v-if="posttest.is_active"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                  >
                    <svg
                      class="w-1.5 h-1.5 mr-1.5"
                      fill="currentColor"
                      viewBox="0 0 8 8"
                    >
                      <circle
                        cx="4"
                        cy="4"
                        r="3"
                      />
                    </svg>
                    Aktif
                  </span>
                  <span
                    v-else
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                  >
                    <svg
                      class="w-1.5 h-1.5 mr-1.5"
                      fill="currentColor"
                      viewBox="0 0 8 8"
                    >
                      <circle
                        cx="4"
                        cy="4"
                        r="3"
                      />
                    </svg>
                    Tidak Aktif
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <div class="flex justify-center space-x-2">
                    <button 
                      class="inline-flex items-center p-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                      title="Lihat Detail"
                      @click="viewPosttest(posttest.id!)"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                      </svg>
                    </button>
                    <button 
                      class="inline-flex items-center p-1.5 border border-transparent text-xs font-medium rounded-md text-pink-700 bg-pink-100 hover:bg-pink-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200"
                      title="Edit Posttest"
                      @click="editPosttest(posttest.id!)"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                      </svg>
                    </button>
                    <button 
                      class="inline-flex items-center p-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                      title="Hapus Posttest"
                      @click="deletePosttest(posttest.id!)"
                    >
                      <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
              
              <!-- Empty State -->
              <tr v-if="paginatedPosttests.length === 0">
                <td
                  colspan="5"
                  class="px-6 py-12 text-center"
                >
                  <div class="flex flex-col items-center">
                    <svg
                      class="w-12 h-12 text-gray-400 mb-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                      />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                      Data tidak ditemukan
                    </h3>
                    <p class="text-gray-500 mb-4">
                      Tidak ada posttest yang cocok dengan pencarian Anda.
                    </p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 flex justify-between items-center">
          <div>
            <label
              for="itemsPerPagePost"
              class="text-sm text-gray-600"
            >Items per page:</label>
            <select
              id="itemsPerPagePost"
              v-model="itemsPerPage"
              class="ml-2 border-gray-300 rounded-md text-sm"
            >
              <option :value="10">
                10
              </option>
              <option :value="20">
                20
              </option>
              <option :value="50">
                50
              </option>
              <option :value="posttests.length">
                All
              </option>
            </select>
          </div>
          <div class="flex items-center">
            <button
              :disabled="currentPage === 1"
              class="bg-white border border-gray-300 px-3 py-1 rounded-md text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              @click="prevPage"
            >
              Sebelumnya
            </button>
            <span class="px-4 text-sm">Halaman {{ currentPage }} dari {{ totalPages }}</span>
            <button
              :disabled="currentPage === totalPages"
              class="bg-white border border-gray-300 px-3 py-1 rounded-md text-sm hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              @click="nextPage"
            >
              Berikutnya
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Component -->
    <PosttestVisibilityModal
      :visible="showVisibilityModal"
      :posttests-data="posttests"
      @update:visible="showVisibilityModal = $event"
      @saved="fetchPosttests"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage, ElMessageBox } from 'element-plus';
import posttestService, { Posttest } from '@/services/posttestService';
import PosttestVisibilityModal from './PosttestVisibilityModal.vue';

const userRole = ref(localStorage.getItem('role') || '');
const isOperator = computed(() => userRole.value === 'operator');

const router = useRouter();
const posttests = ref<Posttest[]>([]);
const showVisibilityModal = ref(false);
const searchQuery = ref('');
const currentPage = ref(1);
const itemsPerPage = ref(10);

const fetchPosttests = async () => {
  try {
    posttests.value = await posttestService.getAllPosttests();
  } catch (error) {
    ElMessage.error('Failed to fetch posttests.');
    console.error(error);
  }
};

const filteredPosttests = computed(() => {
  if (!searchQuery.value) {
    return posttests.value;
  }
  return posttests.value.filter(posttest =>
    (posttest.title && posttest.title.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
    (posttest.description && posttest.description.toLowerCase().includes(searchQuery.value.toLowerCase()))
  );
});

const totalPages = computed(() => {
  if (itemsPerPage.value === posttests.value.length) return 1;
  return Math.ceil(filteredPosttests.value.length / Number(itemsPerPage.value));
});

const paginatedPosttests = computed(() => {
  if (itemsPerPage.value === posttests.value.length) return filteredPosttests.value;
  const start = (currentPage.value - 1) * Number(itemsPerPage.value);
  const end = start + Number(itemsPerPage.value);
  return filteredPosttests.value.slice(start, end);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

onMounted(() => {
  fetchPosttests();
});

const viewPosttest = (id: number) => {
  router.push({ name: 'PosttestDetail', params: { id } });
};

const editPosttest = (id: number) => {
  router.push({ name: 'EditPosttest', params: { id } });
};

const deletePosttest = async (id: number) => {
  ElMessageBox.confirm(
    'Apakah Anda yakin ingin menghapus posttest ini? Tindakan ini tidak dapat dibatalkan.',
    'Konfirmasi Hapus',
    {
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal',
      type: 'warning',
    }
  )
    .then(async () => {
      try {
        await posttestService.deletePosttest(id);
        ElMessage.success('Posttest berhasil dihapus!');
        fetchPosttests(); // Refresh the list
      } catch (error) {
        ElMessage.error('Gagal menghapus posttest.');
        console.error(error);
      }
    })
    .catch(() => {
      ElMessage.info('Penghapusan dibatalkan');
    });
};
</script>

<style scoped>
/* Custom scrollbar untuk table */
.overflow-x-auto::-webkit-scrollbar {
  height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Smooth transitions */
* {
  transition: all 0.2s ease-in-out;
}

/* Focus states */
button:focus {
  outline: none;
}

/* Hover effects enhancement */
tr:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>

