<template>
  <DefaultLayout>
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

    <!-- Header -->
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
        <div class="search-box">
          <input type="text" placeholder="Cari Judul atau Jenis Konten" v-model="search" />
          <img src="/table/cari.svg" alt="Search" />
        </div>
        <div class="icon-group">
          <img src="/table/filter.svg" alt="Filter" @click="onFilterClick" />
          <img src="/table/sort.svg" alt="Sort" @click="onSortClick" />
        </div>
      </div>
      <div class="right-controls">
        <button class="button" @click="onExportClick">
          <img src="/table/sampah.svg" alt="Sampah" />
        </button>
        <button class="button" @click="onMassDeleteClick">
          <img src="/table/hapusMass.svg" alt="hapusMassal" />
          Hapus Massal
        </button>
        <button class="button" @click="openTambah" >
          <img src="/table/tambah.svg" alt="Add" />
          Tambah Berita
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
      <el-table
        ref="elTable"
        :data="pagedData"
        v-loading="loading"
        style="width: 100%"
        @selection-change="onSelectionChange"
        :header-cell-style="headerCellStyle"
        :row-style="rowStyle"
      >
        <el-table-column type="selection" width="55" show-overflow-tooltip />
        <el-table-column prop="judul" label="Judul" show-overflow-tooltip />
        <el-table-column prop="jenis_konten" label="Jenis Konten" show-overflow-tooltip />
        <el-table-column prop="isi" label="Isi Berita" show-overflow-tooltip />
        <el-table-column prop="updated_at" label="Tanggal Update" show-overflow-tooltip />
        <el-table-column prop="created_at" label="Tanggal Buat" show-overflow-tooltip />
        <el-table-column label="Gambar" width="120">
          <template #default="{ row }">
            <img :src="getImageUrl(row.foto)" alt="Gambar Berita" style="width: 60px; height: auto" />
          </template>
        </el-table-column>
        <el-table-column label="Aksi" width="120" fixed="right">
          <template #default="{ row }">
            <div class="action-buttons">
              <img src="/table/edit.svg" alt="Edit" class="action-icon" @click="openEdit(row)" title="Edit" />
              <img src="/table/hapus.svg" alt="Hapus" class="action-icon" @click="onDelete(row)" title="Hapus" />
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <button class="page-btn" :disabled="currentPage === 1" @click="prevPage">
        <img src="/table/sebelum.svg" alt="previous" />
      </button>
      <template v-for="item in visiblePages" :key="String(item)">
        <button
          v-if="item === '...'"
          class="page-number ellipsis"
          disabled
        >…</button>
        <button
          v-else
          class="page-number"
          :class="{ active: item === currentPage }"
          @click="goToPage(item)"
        >{{ item }}</button>
      </template>
      <button class="page-btn" :disabled="currentPage === totalPages" @click="nextPage">
        <img src="/table/next.svg" alt="next" />
      </button>
    </div>
  </DefaultLayout>
</template>

<script lang="ts" setup>
function getImageUrl(file: string): string {
  if (!file) return '/placeholder.jpg';
  if (file.startsWith('http')) return file;
  return `http://127.0.0.1:8000/storage/${file}`;
}

function onImageError(event: Event) {
  const target = event.target as HTMLImageElement;
  target.src = '/placeholder.jpg'; // fallback gambar error
}

import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import DefaultLayout from "../../layouts/DefaultLayout.vue";
import FormEditBerita from '../../components/DataBerita/FormEditDataBerita.vue'; 
import FormTambahBerita from '../../components/DataBerita/FormTambahBerita.vue'; 
import { ElNotification } from 'element-plus';

interface Berita {
  id: number;
  judul: string;
  jenis_konten: string;
  isi: string;
  /**
   * Nama file gambar yang disimpan di folder `storage/app/public/berita_foto/`.
   * Format: .jpg, .jpeg, .png, atau URL absolut.
   */
  gambar: string  | file;
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

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value;
}
function changeItemsPerPage(option: number | string) {
  itemsPerPage.value = option === "all" ? filteredData.value.length : option;
  currentPage.value = 1;
  dropdownOpen.value = false;
}

const filteredData = computed(() =>
  tableData.value.filter(
    (item) =>
      item.judul.toLowerCase().includes(search.value.toLowerCase()) ||
      item.jenis_konten.toLowerCase().includes(search.value.toLowerCase())
  )
);

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

async function onExportClick() {
  window.location.href = '/data/berita/sampah';
}

async function onDelete(row: Berita) {
  loading.value = true;
  await api.delete(`/kelola/berita/${row.id}`);
  await fetchData();
  loading.value = false;
}

function onFilterClick() {}
function onSortClick() {}
function onAddClick() {}

async function fetchData() {
  const res = await api.get('/kelola/berita');
  tableData.value = Array.isArray(res) ? res : res.data || [];
}

onMounted(async () => {
  document.addEventListener('click', (e) => {
    const path = (e as MouseEvent).composedPath() as HTMLElement[];
    if (!path.some((el) => el.classList?.contains('select-box'))) {
      dropdownOpen.value = false;
    }
  });
  loading.value = true;
  await fetchData();
  loading.value = false;
});

onBeforeUnmount(() => {
  document.removeEventListener('click', () => {});
});

const headerCellStyle = {
  backgroundImage: 'linear-gradient(to top, #FB9CB1, #FE6B99)',
  color: 'white',
  whiteSpace: 'nowrap',
  textAlign: 'left',
};

function rowStyle() {
  return { backgroundColor: '#F7F6FE' };
}
</script>

<style>
/* Gaya sama seperti sebelumnya */
</style>
