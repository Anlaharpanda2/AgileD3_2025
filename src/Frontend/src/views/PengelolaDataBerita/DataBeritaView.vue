<template>
  <Layout>
    <!-- Form Popups -->
    <FormTambahBerita 
      v-if="showTambah && TambahData" 
      :initialData="TambahData" 
      @close="showTambah = false" 
    />
    <FormEditBerita 
      v-if="showEdit && editData" 
      :initialData="editData" 
      @close="showEdit = false" 
    />
    <FormExport 
      v-if="showExport" 
      :data="pagedData" 
      @close="showExport = false" 
    />
    <FormImport v-if="showImport" @close="showImport = false" />

    <!-- Main Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
      <!-- Page Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Berita</h1>
        <p class="text-gray-600">Kelola dan pantau semua data berita dalam satu tempat</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Berita</p>
              <p class="text-2xl font-bold text-gray-900">{{ tableData.length }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
              </svg>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Dipilih</p>
              <p class="text-2xl font-bold text-gray-900">{{ selected.length }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Hasil Filter</p>
              <p class="text-2xl font-bold text-gray-900">{{ filteredData.length }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
              </svg>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Halaman</p>
              <p class="text-2xl font-bold text-gray-900">{{ currentPage }}/{{ totalPages }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Controls Section -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6">
          <!-- Top Controls -->
          <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <!-- Left Controls -->
            <div class="flex flex-col sm:flex-row gap-4">
              <!-- Items Per Page -->
              <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan</label>
                <div class="relative">
                  <button
                    @click.stop="toggleDropdown"
                    class="bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors min-w-[80px]"
                  >
                    {{ itemsPerPage === Infinity ? 'All' : itemsPerPage }}
                  </button>
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>
                  
                  <!-- Dropdown -->
                  <div v-show="dropdownOpen" class="absolute z-10 mt-1 w-full bg-white shadow-lg border border-gray-200 rounded-lg">
                    <ul style="padding: 0;">
                      <li
                        v-for="option in perPageOptions"
                        :key="option"
                        @click="changeItemsPerPage(option)"
                        class="px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-colors"
                      >
                        {{ option === 'all' ? 'All' : option }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Search Box -->
              <div class="flex-1 max-w-md">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <div class="relative">
                  <input
                    type="text"
                    placeholder="Cari Judul"
                    v-model="search"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors"
                  />
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Filter & Sort -->
              <div class="flex gap-2">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                  <button
                    @click="onFilterClick"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filter
                  </button>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                  <button
                    @click="onSortClick"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                    </svg>
                    Sort
                  </button>
                </div>
              </div>
            </div>

            <!-- Right Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <div class="flex gap-3">
                  <button
                    @click="onTrashClick"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Sampah
                  </button>
                  
                  <button
                    @click="onMassDeleteClick"
                    :disabled="selected.length === 0"
                    class="inline-flex items-center px-4 py-2.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Massal
                  </button>
                  
                  <button
                    @click="openTambah"
                    class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg text-sm font-medium hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-md"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Berita
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
          <el-table
              ref="elTable"
              :data="pagedData"
              v-loading="loading"
              style="width: 100%"
              @selection-change="onSelectionChange"
              @row-click="goToDetail"
              :header-cell-style="{
                backgroundColor: '#3c4758',
                color: '#ffffff',
                fontWeight: '700',
                textAlign: 'left',
                borderBottom: '2px solid #e5e7eb',
                padding: '16px 12px'
              }"
              :row-style="{
                backgroundColor: '#ffffff'
              }"
              :cell-style="{
                padding: '16px 12px',
                borderBottom: '1px solid #f3f4f6'
              }"
              class="modern-table full-width-cells"
            >
            <el-table-column type="selection" width="55" />
            
            <el-table-column prop="judul" label="Judul" min-width="200">
              <template #default="{ row }">
                <div class="font-medium text-gray-900 hover:text-pink-600 transition-colors full-width-content line-clamp-2">
                  {{ row.judul }}
                </div>
              </template>
            </el-table-column>
            
            <el-table-column prop="jenis_konten" label="Jenis Konten" width="150">
              <template #default="{ row }">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 full-width-content">
                  {{ row.jenis_konten }}
                </span>
              </template>
            </el-table-column>
            
            <el-table-column prop="isi" label="Isi Berita" min-width="300">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm line-clamp-2 full-width-content">
                  {{ row.isi }}
                </div>
              </template>
            </el-table-column>
            
            <el-table-column prop="updated_at" label="Diperbarui" width="140">
              <template #default="{ row }">
                <div class="text-sm text-gray-500 full-width-content">
                  {{ new Date(row.updated_at).toLocaleDateString('id-ID') }}
                </div>
              </template>
            </el-table-column>
            
            <el-table-column prop="created_at" label="Dibuat" width="140">
              <template #default="{ row }">
                <div class="text-sm text-gray-500 full-width-content">
                  {{ new Date(row.created_at).toLocaleDateString('id-ID') }}
                </div>
              </template>
            </el-table-column>
            
            <el-table-column label="Gambar" width="100">
              <template #default="{ row }">
                <div class="w-16 h-12 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center full-width-content">
                  <img
                    :src="row.foto || '/Berita/Placeholder.jpg'"
                    alt="Gambar Berita"
                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-200"
                  />
                </div>
              </template>
            </el-table-column>
            
            <el-table-column label="Aksi" width="120" fixed="right">
              <template #default="{ row }">
                <div class="flex items-center gap-2 full-width-content">
                  <button
                    @click="openEdit(row)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors"
                    title="Edit"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                
                  <button
                    @click="onDelete(row)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors"
                    title="Hapus"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-700">
          Menampilkan <span class="font-medium">{{ Math.min((currentPage - 1) * (typeof itemsPerPage === 'number' ? itemsPerPage : filteredData.length) + 1, filteredData.length) }}</span>
          hingga <span class="font-medium">{{ Math.min(currentPage * (typeof itemsPerPage === 'number' ? itemsPerPage : filteredData.length), filteredData.length) }}</span>
          dari <span class="font-medium">{{ filteredData.length }}</span> hasil
        </div>
        
        <div class="flex items-center gap-2">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Sebelum
          </button>
          
          <div class="flex items-center gap-1">
            <template v-for="item in visiblePages" :key="String(item)">
              <button
                v-if="item === '...'"
                class="px-3 py-2 text-sm text-gray-500 cursor-default"
                disabled
              >
                …
              </button>
              <button
                v-else
                @click="goToPage(item)"
                :class="[
                  'px-3 py-2 text-sm font-medium rounded-lg transition-colors',
                  item === currentPage
                    ? 'bg-pink-500 text-white shadow-sm'
                    : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                {{ item }}
              </button>
            </template>
          </div>
          
          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            Selanjutnya
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import Layout from "../../layouts/Layout.vue";
import FormEditBerita from '../../components/DataBerita/FormEditDataBerita.vue'; 
import FormTambahBerita from '../../components/DataBerita/FormTambahBerita.vue';
import { ElNotification } from 'element-plus';

interface Berita {
  id: number;
  judul: string;
  jenis_konten: string;
  isi: string;
  foto: string | File;
  created_at?: string;
  updated_at?: string;
}

const tableData = ref<Berita[]>([]);
const selected = ref<Berita[]>([]);
const search = ref("");
const loading = ref(false);
const itemsPerPage = ref<number | string>(10);
const currentPage = ref(1);
const dropdownOpen = ref(false);
const showExport = ref(false);
const showImport = ref(false);
const showEdit = ref(false);
const showTambah = ref(false);
const editData = ref(false);
const TambahData = ref(false);
const perPageOptions = [10, 20, 50, 100, "all"];
const router = useRouter()

const openEdit = (row: Berita) => {
  editData.value = { ...row };
  showEdit.value = true;
  loading.value = false;
};

const openTambah = () => {
  TambahData.value = true;
  showTambah.value = true;
  loading.value = false;
};

const goToDetail = (row: any, column: any, event: MouseEvent) => {
  if (column.type === 'selection' || column.label === 'Aksi') {
    return
  }
  router.push({ name: 'DetailBerita', params: { id: row.id } })
}

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value;
}

function changeItemsPerPage(option: number | string) {
  itemsPerPage.value = option === "all" ? filteredData.value.length : option;
  currentPage.value = 1;
  dropdownOpen.value = false;
}

const filteredData = computed(() => {
  const data = tableData.value.filter(
    (item) =>
      item.judul.toLowerCase().includes(search.value.toLowerCase())
  );
  return data.sort((a, b) => {
    const dateA = new Date(a.updated_at || 0).getTime();
    const dateB = new Date(b.updated_at || 0).getTime();
    return dateB - dateA;
  });
});

const totalPages = computed(() =>
  Math.ceil(
    filteredData.value.length /
      (typeof itemsPerPage.value === "number" ? itemsPerPage.value : 1)
  )
);

const pagedData = computed(() => {
  const perPage = typeof itemsPerPage.value === "number" ? itemsPerPage.value : 1;
  const start = (currentPage.value - 1) * perPage;
  return filteredData.value.slice(start, start + perPage);
});

function prevPage() {
  if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++;
}

function goToPage(page: number) {
  currentPage.value = page;
}

const visiblePages = computed<(number | '...')[]>(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  const delta = 2;
  const pages: (number | '...')[] = [];

  if (total < 1) return pages;
  pages.push(1);

  let left = current - delta;
  let right = current + delta;

  if (left < 2) {
    right += (2 - left);
    left = 2;
  }
  if (right > total - 1) {
    left -= (right - (total - 1));
    right = total - 1;
  }
  left = Math.max(left, 2);
  right = Math.min(right, total - 1);

  if (left > 2) pages.push('...');
  for (let i = left; i <= right; i++) pages.push(i);
  if (right < total - 1) pages.push('...');
  if (total > 1) pages.push(total);

  return pages;
});

function onSelectionChange(rows: Berita[]) {
  selected.value = rows;
}

async function onMassDeleteClick() {
  if (!selected.value.length) return;
  loading.value = true;
  try {
    const ids = selected.value.map(b => b.id);
    await api.delete('/kelola/berita', { data: { ids } });
    await fetchData();
    ElNotification({ title: 'Berhasil', message: 'Hapus Data Massal Berita', type: 'success', duration: 3000 });
  } catch (err) {
    console.error('Gagal menghapus data:', err);
  } finally {
    loading.value = false;
  }
}

async function onTrashClick() {
  window.location.href = '/data/berita/sampah';
}

async function onDelete(row: Berita) {
  try {
    loading.value = true;
    await api.delete(`/kelola/berita/${row.id}`);
    await fetchData();
    ElNotification({ 
      title: 'Berhasil', 
      message: 'Data berita berhasil dihapus', 
      type: 'success', 
      duration: 3000 
    });
  } catch (error) {
    console.error('Error deleting berita:', error);
    ElNotification({ 
      title: 'Error', 
      message: 'Gagal menghapus data berita', 
      type: 'error', 
      duration: 3000 
    });
  } finally {
    loading.value = false;
  }
}

function onFilterClick() {}
function onSortClick() {}

async function fetchData() {
  try {
    const res = await api.get('/kelola/berita');
    tableData.value = Array.isArray(res) ? res : res.data || [];
  } catch (error) {
    console.error('Error fetching berita data:', error);
    ElNotification({ 
      title: 'Error', 
      message: 'Gagal memuat data berita', 
      type: 'error', 
      duration: 3000 
    });
  }
}

let clickOutsideHandler: ((e: Event) => void) | null = null;

onMounted(async () => {
  // Buat handler yang bisa direferensikan untuk cleanup
  clickOutsideHandler = (e: Event) => {
    const path = (e as MouseEvent).composedPath() as HTMLElement[];
    if (!path.some((el) => el.classList?.contains('select-box'))) {
      dropdownOpen.value = false;
    }
  };
  
  document.addEventListener('click', clickOutsideHandler);
  
  // Load data hanya sekali saat component mount
  loading.value = true;
  try {
    await fetchData();
  } catch (error) {
    console.error('Error fetching data:', error);
  } finally {
    loading.value = false;
  }
});

onBeforeUnmount(() => {
  // Cleanup event listener dengan reference yang tepat
  if (clickOutsideHandler) {
    document.removeEventListener('click', clickOutsideHandler);
    clickOutsideHandler = null;
  }
});
</script>

<style scoped>
/* Custom styles for modern table */
/* Tambahkan CSS ini jika solusi di atas belum optimal */
.modern-table {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Mengatasi masalah Element Plus internal .cell class */
.full-width-cells :deep(.el-table__cell) {
  padding: 0 !important;
}

.full-width-cells :deep(.cell) {
  width: 100% !important;
  padding: 16px 12px !important;
  box-sizing: border-box !important;
  display: flex !important;
  align-items: center !important;
  min-height: 100% !important;
}


/* Memastikan konten dalam cell mengisi penuh */
.full-width-content {
  width: 100% !important;
  flex: 1 !important;
}

/* Untuk kolom selection agar tetap center */
.full-width-cells :deep(.el-table-column--selection .cell) {
  justify-content: center !important;
}

/* Untuk kolom dengan fixed right */
.full-width-cells :deep(.el-table-fixed-column--right .cell) {
  justify-content: center !important;
}

/* Mengatasi overflow untuk text panjang */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  width: 100%;
}

/* Responsif */
@media (max-width: 768px) {
  .full-width-cells :deep(.cell) {
    padding: 8px 6px !important;
    font-size: 12px;
  }
}

/* Alternatif jika masih ada masalah, paksa width 100% pada semua cell */
.full-width-cells :deep(.el-table__body-wrapper .el-table__body .el-table__row .el-table__cell .cell) {
  width: 100% !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
}

.full-width-cells :deep(.el-table__header-wrapper .el-table__header .el-table__header-row .el-table__cell .cell) {
  width: 100% !important;
  max-width: 100% !important;
  box-sizing: border-box !important;
}
.modern-table :deep(.el-table__body-wrapper) {
  border-radius: 0;
}

.modern-table :deep(.el-table__row:hover) {
  background-color: #f8fafc !important;
}

.modern-table :deep(.el-table__row:hover td) {
  background-color: #f8fafc !important;
}

.modern-table :deep(.el-checkbox__input.is-checked .el-checkbox__inner) {
  background-color: #ec4899;
  border-color: #ec4899;
}

.modern-table :deep(.el-checkbox__input.is-indeterminate .el-checkbox__inner) {
  background-color: #ec4899;
  border-color: #ec4899;
}

.modern-table :deep(.el-checkbox__input.is-checked + .el-checkbox__label) {
  color: #ec4899;
}

/* Loading overlay styling */
.modern-table :deep(.el-loading-mask) {
  background-color: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(4px);
}

.modern-table :deep(.el-loading-spinner) {
  color: #ec4899;
}

/* Text truncation for long content */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Smooth transitions */
* {
  transition: all 0.2s ease-in-out;
}

/* Hover effects for interactive elements */
button:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Custom scrollbar for dropdown */
.overflow-y-auto::-webkit-scrollbar {
  width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 2px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Focus styles */
input:focus,
button:focus,
select:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

/* Card hover effects */
.hover\:shadow-md:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Gradient text for stats */
.bg-gradient-to-r {
  background: linear-gradient(to right, #ec4899, #be185d);
}

/* Table cell padding consistency */
.modern-table :deep(.el-table td),
.modern-table :deep(.el-table th) {
  padding: 16px 12px !important;
}

/* Responsive table scroll */
@media (max-width: 768px) {
  .overflow-x-auto {
    -webkit-overflow-scrolling: touch;
  }
}

/* Animation keyframes */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

/* Status badge styles */
.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  color: #626974;
  font-size: 0.75rem;
  font-weight: 500;
  text-transform: capitalize;
}

/* Pink theme variations */
.bg-pink-gradient {
  background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
}

.text-pink-gradient {
  background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

/* Card shadows */
.card-shadow {
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.card-shadow-hover:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Custom dropdown styling */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>