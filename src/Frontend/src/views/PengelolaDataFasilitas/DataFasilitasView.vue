<template>
  <!-- Form pop up -->
  <DefaultLayout>
    <FormSortingDataFasilitas
      v-if="showSort"
      :visible="showSort"
      :columns="filterableColumns"
      :data="tableData"
      @update:visible="showSort = $event"
    />
    <FormFilterDataFasilitas
      v-model="showFilter"  :columns="filterableColumns"
      v-model:active-filters="activeFilters"
    />
    <FormTambahDataFasilitas 
      v-if="showTambah"
      @close="showTambah = false" 
    />
    <FormEditDataFasilitas
      v-if="showEdit && editData" 
      :initialData="editData" 
      @close="showEdit = false" 
    />
    <FormExportDataFasilitas
      v-if="showExport" 
      :data="pagedData" 
      @close="showExport = false" 
    />
    <FormImportDataFasilitas
      v-if="showImport" 
      @close="showImport = false" 
    />

    <!-- Kontrol atas -->
    <h1 class="h3 fw-bold text-secondary border-bottom pb-2 mb-4">
      Data Fasilitas
    </h1>
    <div class="table-header">
      <div class="left-controls">
        <div class="show-wrapper">
          <div class="select-box" @click.stop="toggleDropdown">
            <span>{{ itemsPerPage === Infinity ? 'All' : itemsPerPage }}</span>
            <img src="/table/panah.svg" alt="Dropdown" style="width:22px;height:22px" />
            <ul class="dropdown-list" v-show="dropdownOpen">
              <li
                v-for="option in perPageOptions"
                :key="option"
                @click="changeItemsPerPage(option)"
              >
                {{ option === 'all' ? 'All' : option }}
              </li>
            </ul>
          </div>
        </div>

        <!-- pencarian -->
        <div class="search-box">
          <input type="text" placeholder="Cari Nama Fasilitas" v-model="search" />
          <img src="/table/cari.svg" alt="Search" />
        </div>

        <!-- filter dan sorting -->
        <button class="button2" @click="showFilter = true">
          <img src="/table/filter.svg" alt="Filter" />
        </button>
        <button class="button2" @click="showSort = true">
          <img src="/table/sort.svg" alt="Sort" />
        </button>
      </div>

      <!-- kanan: export, import, sampah, hapus massal, tambah -->
      <div class="right-control">
        <button class="button1" @click="showFilter = true">
          <img src="/table/filter.svg" alt="Filter" />
        </button>
        <button class="button1" @click="showSort = true">
          <img src="/table/sort.svg" alt="Sort" />
        </button>
        <button class="button" @click="showExport = true">
          <img src="/table/export.svg" alt="Export" />
        </button>
        <button class="button" @click="showImport = true" v-if="isOperator">
          <img src="/table/import.svg" alt="Import" />
        </button>
        <button class="button" @click="onExportClick">
          <img src="/table/sampah.svg" alt="Sampah" />
        </button>
        <button class="button" @click="onMassDeleteClick" v-if="isOperator">
          <img src="/table/hapusMass.svg" alt="hapusMassal" />
          <span class="hilang">Hapus Massal</span>
        </button>
        <button class="button" @click="showTambah = true" v-if="isOperator">
          <img src="/table/tambah.svg" alt="Add" />
          <span class="hilang">Tambah Data</span>
        </button>
      </div>
    </div>
  </DefaultLayout>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import api from '../../api';
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import FormSortingDataFasilitas from '../../components/KelolaDataFasilitas/FormSortingDataFasilitas.vue';
import FormFilterDataFasilitas from '../../components/KelolaDataFasilitas/FormFilterDataFasilitas.vue';
import FormTambahDataFasilitas from '../../components/KelolaDataFasilitas/FormTambahDataFasilitas.vue';
import FormEditDataFasilitas from '../../components/KelolaDataFasilitas/FormEditDataFasilitas.vue';
import FormExportDataFasilitas from '../../components/KelolaDataFasilitas/FormExportDataFasilitas.vue';
import FormImportDataFasilitas from '../../components/KelolaDataFasilitas/FormImportDataFasilitas.vue';
import { ElNotification } from 'element-plus';

const getUserRole = (): string => localStorage.getItem('role') || ''
const isOperator = computed(() => getUserRole() === 'operator')

const tableData = ref<any[]>([]);
const selected = ref<any[]>([]);
const search = ref('');
const dropdownOpen = ref(false);
const showSort = ref(false);
const showFilter = ref(false);
const showExport = ref(false);
const showImport = ref(false);
const showTambah = ref(false);
const showEdit = ref(false);
const editData = ref(null);

const activeFilters = ref<{ [key: string]: string | number | null }>({});

const perPageOptions = [10, 20, 50, 100, 'all'];
const itemsPerPage = ref<number | string>(10);
const currentPage = ref(1);
const loading = ref(false);

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value;
}
function changeItemsPerPage(option: number | string) {
  itemsPerPage.value = option === 'all' ? filteredData.value.length : option;
  currentPage.value = 1;
  dropdownOpen.value = false;
}
const filterableColumns = computed(() => {
  if (!tableData.value.length) return [];
  const exclude = ['id', 'created_at', 'updated_at'];
  return Object.keys(tableData.value[0]).filter(key => !exclude.includes(key));
});
const filteredData = computed(() => {
  let data = tableData.value;
  if (search.value) {
    data = data.filter(item => item.nama?.toLowerCase().includes(search.value.toLowerCase()));
  }
  for (const key in activeFilters.value) {
    const val = activeFilters.value[key];
    if (val !== null && val !== '') {
      data = data.filter(row => String(row[key] || '').toLowerCase().includes(String(val).toLowerCase()));
    }
  }
  return data;
});
const pagedData = computed(() => {
  const perPage = typeof itemsPerPage.value === 'number' ? itemsPerPage.value : 1;
  const start = (currentPage.value - 1) * perPage;
  return filteredData.value.slice(start, start + perPage);
});
const totalPages = computed(() =>
  Math.ceil(filteredData.value.length / (typeof itemsPerPage.value === 'number' ? itemsPerPage.value : 1))
);
const visiblePages = computed(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  const delta = 2;
  const pages = [];
  if (total < 1) return pages;
  pages.push(1);
  let left = current - delta;
  let right = current + delta;
  if (left < 2) { right += 2 - left; left = 2; }
  if (right > total - 1) { left -= right - (total - 1); right = total - 1; }
  left = Math.max(left, 2);
  right = Math.min(right, total - 1);
  if (left > 2) pages.push('...');
  for (let i = left; i <= right; i++) pages.push(i);
  if (right < total - 1) pages.push('...');
  if (total > 1) pages.push(total);
  return pages;
});
function prevPage() { if (currentPage.value > 1) currentPage.value--; }
function nextPage() { if (currentPage.value < totalPages.value) currentPage.value++; }
function goToPage(p: number) { currentPage.value = p; }

function openEdit(row: any) {
  editData.value = { ...row };
  showEdit.value = true;
}
async function onMassDeleteClick() {
  if (!selected.value.length) return;
  loading.value = true;
  try {
    const ids = selected.value.map(item => item.id);
    await api.delete('/kelola/fasilitas', { data: { ids } });
    await fetchData();
    ElNotification({ title: 'Berhasil', message: 'Data berhasil dihapus', type: 'success' });
  } catch (err) {
    ElNotification({ title: 'Error', message: 'Gagal menghapus data.', type: 'error' });
  } finally {
    loading.value = false;
  }
}
async function onDelete(row: any) {
  loading.value = true;
  try {
    await api.delete(`/kelola/fasilitas/${row.id}`);
    await fetchData();
    ElNotification({ title: 'Berhasil', message: 'Data berhasil dihapus', type: 'success' });
  } catch (err) {
    ElNotification({ title: 'Error', message: 'Gagal menghapus data.', type: 'error' });
  } finally {
    loading.value = false;
  }
}
async function onExportClick() {
  window.location.href = '/data/fasilitas/sampah';
}
function onSelectionChange(rows: any[]) {
  selected.value = rows;
}
async function fetchData() {
  try {
    const res = await api.get('/kelola/fasilitas');
    tableData.value = Array.isArray(res) ? res : res.data || [];
  } catch (err) {
    ElNotification({ title: 'Error', message: 'Gagal memuat data.', type: 'error' });
  }
}
onMounted(async () => {
  document.addEventListener('click', e => {
    const path = (e as MouseEvent).composedPath() as HTMLElement[];
    if (!path.some(el => el.classList?.contains('select-box'))) dropdownOpen.value = false;
  });
  loading.value = true;
  await fetchData();
  loading.value = false;
});
onBeforeUnmount(() => {
  document.removeEventListener('click', () => {});
});
</script>

<style scoped>
@import './DataPelatihanView.css';
</style>
