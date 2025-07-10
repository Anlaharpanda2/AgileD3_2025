<template>
  <!-- Form pop up -->
  <SimpleLayout>
    <FormTambah 
      v-if="showTambah && TambahData" 
      :initial-data="TambahData" 
      @close="showTambah = false" 
    />
    <FormEdit 
      v-if="showEdit && editData" 
      :initial-data="editData" 
      @close="showEdit = false" 
    />
    <FormExport 
      v-if="showExport" 
      :data="pagedData" 
      @close="showExport = false" 
    />
    <FormImport
      v-if="showImport" 
      @close="showImport = false" 
    />
    <!-- pagination atas-->
    <div class="table-header">
      <div class="left-controls">
        <div class="show-wrapper">
          <div
            class="select-box"
            @click.stop="toggleDropdown"
          >
            <span>{{ itemsPerPage === Infinity ? 'All' : itemsPerPage }}</span>
            <img
              src="/table/panah.svg"
              alt="Dropdown"
              style="width:22px;height:22px"
            >
            <ul
              v-show="dropdownOpen"
              class="dropdown-list"
            >
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
          <input
            v-model="search"
            type="text"
            placeholder="Cari"
          >
          <img
            src="/table/cari.svg"
            alt="Search"
          >
        </div>

        <!-- filter dan sorting -->
        <div class="icon-group">
          <img
            src="/table/filter.svg"
            alt="Filter"
            @click="onFilterClick"
          >
          <img
            src="/table/sort.svg"
            alt="Sort"
            @click="onSortClick"
          >
        </div>
      </div>

      <!-- export, import, sampah, hapus masal dan tambah data disiko -->
      <div class="right-controls">
        <button
          class="button"
          @click="showExport = true"
        >
          <img
            src="/table/export.svg"
            alt="Export"
          >
        </button>
        <button
          class="button"
          @click="showImport = true"
        >
          <img
            src="/table/import.svg"
            alt="Import"
          >
        </button>
        <button
          class="button"
          @click="onExportClick"
        >
          <img
            src="/table/sampah.svg"
            alt="Sampah"
          >
        </button>
        <button
          class="button"
          @click="onMassDeleteClick"
        >
          <img
            src="/table/hapusMass.svg"
            alt="hapusMassal"
          >
          Hapus Massal
        </button>
        <button
          class="button"
          @click="openTambah"
        >
          <img
            src="/table/tambah.svg"
            alt="Add"
          >
          Tambah Data
        </button>
      </div>
    </div>

    <!-- sturktur tabel -->
    <div class="table-wrapper">
      <el-table
        ref="elTable"
        v-loading="loading"
        :data="pagedData"
        style="width: 100%"
        :header-cell-style="headerCellStyle"
        :row-style="rowStyle"
        @selection-change="onSelectionChange"
      >
        <el-table-column
          type="selection"
          width="55"
          show-overflow-tooltip
        />
        <el-table-column
          prop="name"
          label="Nama"
          show-overflow-tooltip
        />
        <el-table-column
          prop="email"
          label="email"
          show-overflow-tooltip
        />
        <el-table-column
          prop="role"
          label="akses"
          show-overflow-tooltip
        />
        <el-table-column
          prop="created_at"
          label="tanggal dibuat"
          show-overflow-tooltip
        />
        <el-table-column
          prop="updated_at"
          label="tanggal diperbarui"
          show-overflow-tooltip
        />

        <el-table-column
          label="Aksi"
          width="120"
          fixed="right"
        >
          <template #default="{ row }">
            <div class="action-buttons">
              <!-- edit data -->
              <img
                src="/table/edit.svg"
                alt="Edit"
                class="action-icon"
                title="Edit" 
                @click="openEdit(row)"
              >
              <!-- hapus data idividu -->
              <img
                src="/table/hapus.svg"
                alt="Hapus"
                class="action-icon"
                title="Hapus"
                @click="onDelete(row)"
              >
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <!-- pagination bawah -->
    <div class="pagination">
      <button
        class="page-btn"
        :disabled="currentPage === 1"
        @click="prevPage"
      >
        <img
          src="/table/sebelum.svg"
          alt="preview"
        >
      </button>

      <template
        v-for="item in visiblePages"
        :key="String(item)"
      >
        <button
          v-if="item === '...'"
          class="page-number ellipsis"
          disabled
        >
          …
        </button>
        <button
          v-else
          class="page-number"
          :class="{ active: item === currentPage }"
          @click="goToPage(item)"
        >
          {{ item }}
        </button>
      </template>

      <button
        class="page-btn"
        :disabled="currentPage === totalPages"
        @click="nextPage"
      >
        <img
          src="/table/next.svg"
          alt="next"
        >
      </button>
    </div>
  </SimpleLayout>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import SimpleLayout from "../../layouts/SimpleLayout.vue";
import { ElNotification } from 'element-plus';

interface Peserta {
  id: number;
  name: string;
  email: string;
  role: "pegawai" | "operator";
  created_at: string;
  updated_at?: string;
  nik: string;
}

const tableData = ref<Peserta[]>([]);
const selected = ref<Peserta[]>([]);
const search = ref("");
const loading = ref(false);
const itemsPerPage = ref<number | string>(10);
const currentPage = ref(1);
const dropdownOpen = ref(false);
const showExport = ref(false)
const showImport = ref(false)
const showEdit = ref(false)
const showTambah = ref(false)
const editData = ref(null)
const TambahData = ref(null)
const perPageOptions = [10, 20, 50, 100, "all"];

const openEdit = (row) => {
  editData.value = { ...row }
  showEdit.value = true
  loading.value = false;
}
const openTambah = (row) => {
  editData.value = { ...row }
  showEdit.value = true
  loading.value = false;
}

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
      item.name.toLowerCase().includes(search.value.toLowerCase()) ||
      item.email.toLowerCase().includes(search.value.toLowerCase())
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

function onSelectionChange(rows: Peserta[]) {
  selected.value = rows;
}

async function onMassDeleteClick() {
  if (!selected.value.length) return;

  loading.value = true;

  try {
    const niks = selected.value.map(p => p.nik);
    await api.delete('/kelola/pelatihan', {
      data: { niks }
    });
    await fetchData();
    ElNotification({
      title: 'Berhasil',
      message: 'Hapus Data Massal',
      type: 'success',
      duration: 3000,
    });
  } 
  catch (err) {
    console.error('Gagal menghapus data:', err);
  } 
  finally {
    loading.value = false;
  }
}


// Sampah route → GET /data/pelatihan/sampah
async function onExportClick() {
  window.location.href = '/data/pelatihan/sampah';
}

// Single delete → DELETE /kelola/pelatihan/{nik}
async function onDelete(row: Peserta) {
  loading.value = true;
  await api.delete(`/kelola/pelatihan/${row.nik}`);
  await fetchData();
  loading.value = false;
}

// other handlers unchanged
function onFilterClick() {}
function onSortClick() {}

async function fetchData() {
  const res = await api.get('/kelola/akses');
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

.table-container {
  padding: 40px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.table-header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 12px;
  padding-bottom: 20px;
}
.left-controls {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.right-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-left: auto;
}

.select-box {
  background: #69C5C2;
  padding: 6px 10px;
  border-radius: 6px;
  color: white;
  display: flex;
  align-items: center;
  gap: 6px;
  cursor: pointer;
  user-select: none;
  position: relative;
}
.dropdown-list {
  position: absolute;
  top: 100%;
  left: 0;
  background: white;
  border-radius: 6px;
  box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
  margin-top: 4px;
  width: 70px;
  color: black;
  z-index: 10;
  list-style: none;
  padding: 0;
}
.dropdown-list li {
  padding: 6px 10px;
  cursor: pointer;
}
.dropdown-list li:hover {
  background-color: #69C5C2;
  color: white;
}
.search-box {
  display: flex;
  align-items: center;
  gap: 4px;
  border: 2px solid #8a8a8a;
  border-radius: 6px;
  padding: 2px 6px;
}
.search-box input {
  border: none;
  outline: none;
  padding: 6px;
  flex: 1;
}
.icon-group img,
.button img {
  width: 18px;
  height: 18px;
  cursor: pointer;
  transition: transform 0.2s;
}
.button {
  background: #69C5C2;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
}
.button.danger {
  background: #e74c3c;
}

.pagination {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 20px;
  flex-wrap: wrap;
}
.page-btn,
.page-number {
  border: none;
  padding: 6px 10px;
  border-radius: 6px;
  cursor: pointer;
  min-width: 40px;
  text-align: center;
}
.page-btn:disabled {
  cursor: not-allowed;
  opacity: 0.5;
}
.page-number.active {
  background: #69C5C2;
  color: white;
}
.page-number.ellipsis {
  cursor: default;
}

.table-wrapper {
  overflow-x: auto;
  font-size: 10pt;
}
.el-table {
  width: 100% !important;
  table-layout: auto !important;
  font-size: inherit;
}

/* Header corner radius */
.el-table__header-wrapper thead th:first-child {
  border-top-left-radius: 15px !important;
}
.el-table__header-wrapper thead th:last-child {
  border-top-right-radius: 15px !important;
}
.el-table__header-wrapper {
  overflow: visible !important;
}

/* Body cell styles */
.el-table th > div,
.el-table td > div {
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  max-width: 150px;
  padding: 6px 12px;
  vertical-align: top !important;
  text-align: left !important;
  font-size: inherit;
  transition: background-color 0.3s ease;
}

/* Row background */
.el-table .el-table__body-wrapper tbody tr td {
  background-color: #ececec;
}

/* Selection column width */
.el-table-column--selection {
  width: 55px !important;
}

/* Action button styling */
.action-buttons {
  display: flex;
  gap: 8px;
  justify-content: center;
  align-items: center;
}
.action-icon {
  width: 20px;
  height: 20px;
  cursor: pointer;
  transition: transform 0.2s;
}
.action-icon:hover {
  transform: scale(1.1);
}
.button:hover{
  transform: scale(1.05);
  background: #549b98;
}
</style>
