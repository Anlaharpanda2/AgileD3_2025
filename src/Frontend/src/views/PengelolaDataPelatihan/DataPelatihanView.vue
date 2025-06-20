<template>
  <!-- Form pop up -->
  <DefaultLayout>
    <FormSortingDataPelatihan
      v-if="showSort"
      :visible="showSort"
      :columns="filterableColumns"
      :data="tableData"
      @update:visible="showSort = $event"
    />
    <FormFilterDataPelatihan
      v-model="showFilter"  :columns="filterableColumns"
      v-model:active-filters="activeFilters"
    />
    <FormTambahDataPeltihan 
      v-if="showTambah"
      @close="showTambah = false" 
    />
    <FormEditDataPelatihan
      v-if="showEdit && editData" 
      :initialData="editData" 
      @close="showEdit = false" 
    />
    <FormExportDataPelatihan
      v-if="showExport" 
      :data="pagedData" 
      @close="showExport = false" 
    />
    <FormImportDataPeltihan
      v-if="showImport" 
      @close="showImport = false" 
    />
    <!-- pagination atas-->
    <h1 class="h3 fw-bold text-secondary border-bottom pb-2 mb-4">
      Data Pelatihan
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
          <input type="text" placeholder="Cari Nama" v-model="search" />
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

      <!-- export, import, sampah, hapus masal dan tambah data disiko -->
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
        <button class="button" @click="showImport = true" >
          <img src="/table/import.svg" alt="Import" />
        </button>
        <button class="button" @click="onExportClick">
          <img src="/table/sampah.svg" alt="Sampah" />
        </button>
        <button class="button" @click="onMassDeleteClick" >
          <img src="/table/hapusMass.svg" alt="hapusMassal" />
          <span class="hilang">Hapus Massal</span>
        </button>
        <button class="button" @click="showTambah = true" >
          <img src="/table/tambah.svg" alt="Add" />
          <span class="hilang">Tambah Data</span>
        </button>
      </div>
    </div>

    <!-- sturktur tabel -->
  <div class="table-wrapper">
    <el-table
      ref="elTable"
      :data="pagedData"
      v-loading="loading"
      style="width: 100%"
      @selection-change="onSelectionChange"
      @row-click="goToDetail"
      :header-cell-style="headerCellStyle"
      :row-style="rowStyle"
    >
      <el-table-column type="selection" width="40" fixed="left" show-overflow-tooltip />

      <el-table-column prop="nama" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Nama" placement="top">
            <span class="header-tooltip-text">Nama</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="nik" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="NIK" placement="top">
            <span class="header-tooltip-text">NIK</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="jenis_bimtek" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Jenis Bimtek" placement="top">
            <span class="header-tooltip-text">Jenis Bimtek</span>
          </el-tooltip>
        </template>
      </el-table-column>
      
      <el-table-column label="Tanggal Kegiatan" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Tanggal Kegiatan" placement="top">
            <span class="header-tooltip-text">Tanggal Kegiatan</span>
          </el-tooltip>
        </template>
        <template #default="{ row }">
          <span>{{ formatTanggalKegiatan(row.kegiatan_dimulai, row.kegiatan_berakhir) }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="tempat_kegiatan" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Tempat Kegiatan" placement="top">
            <span class="header-tooltip-text">Tempat Kegiatan</span>
          </el-tooltip>
        </template>
      </el-table-column>
      <el-table-column prop="angkatan" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Angkatan" placement="top">
            <span class="header-tooltip-text">Angkatan</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="tempat_tanggal_lahir" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Tempat Tanggal Lahir" placement="top">
            <span class="header-tooltip-text">Tempat Tanggal Lahir</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="pendidikan" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Pendidikan" placement="top">
            <span class="header-tooltip-text">Pendidikan</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="status" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Status" placement="top">
            <span class="header-tooltip-text">Status</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="alamat" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Alamat" placement="top">
            <span class="header-tooltip-text">Alamat</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="jenis_usaha" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Jenis Usaha" placement="top">
            <span class="header-tooltip-text">Jenis Usaha</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="penghasilan_perbulan" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="Penghasilan per bulan" placement="top">
            <span class="header-tooltip-text">Penghasilan per bulan</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column prop="nomor_telefon" show-overflow-tooltip>
        <template #header>
          <el-tooltip content="No. Telp" placement="top">
            <span class="header-tooltip-text">No. Telp</span>
          </el-tooltip>
        </template>
      </el-table-column>

      <el-table-column label="Aksi" width="60" fixed="right" >
        <template #header>
          <el-tooltip content="Aksi" placement="top">
            <span class="header-tooltip-text">Aksi</span>
          </el-tooltip>
        </template>
        <template #default="{ row }">
          <div class="action-buttons">
            <img
              src="/table/edit.svg"
              alt="Edit"
              class="action-icon"
              @click="openEdit(row)"
              title="Edit"
            />
            <img
              src="/table/hapus.svg"
              alt="Hapus"
              class="action-icon"
              @click="onDelete(row)"
              title="Hapus"
            />
          </div>
        </template>
      </el-table-column>
    </el-table>
  </div>

    <!-- pagination bawah -->
    <div class="pagination">
      <button class="page-btn" :disabled="currentPage === 1" @click="prevPage">
        <img src="/table/sebelum.svg" alt="preview">
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
        <img src="/table/next.svg" alt="next">
      </button>
    </div>
  </DefaultLayout>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import DefaultLayout from "../../layouts/DefaultLayout.vue";
import FormExportDataPelatihan from "../../components/KelolaDataPelatihan/FormExportDataPelatihan.vue";
import FormImportDataPeltihan from "../../components/KelolaDataPelatihan/FormImportDataPelatihan.vue";
import FormEditDataPelatihan from "../../components/KelolaDataPelatihan/FormEditDataPelatihan.vue";
import FormTambahDataPeltihan from "../../components/KelolaDataPelatihan/FormTambahDataPelatihan.vue";
import FormFilterDataPelatihan from "../../components/KelolaDataPelatihan/FormFilterDataPelatihan.vue";
import FormSortingDataPelatihan from "../../components/KelolaDataPelatihan/FormSortingDataPelatihan.vue";
import { ElNotification } from 'element-plus';
import { useRouter } from 'vue-router'

const router = useRouter()
const goToDetail = (row: any, column: any, event: MouseEvent) => {
  // Abaikan klik jika berasal dari kolom selection (checkbox) atau kolom Aksi
  if (column.type === 'selection' || column.label === 'Aksi') {
    return
  }

  // Arahkan ke detail jika bukan dari kolom aksi/checkbox
  router.push({ name: 'DetailMasyarakat', params: { id: row.nik } })
}
 
interface Peserta {
  id: number;
  nama: string;
  nik: string;
  jenis_bimtek: string;
  kegiatan_dimulai: string;
  kegiatan_berakhir: string;
  tempat_kegiatan: string;
  angkatan: number;
  tempat_tanggal_lahir: string;
  pendidikan: string;
  status: "kawin" | "lajang" | "janda";
  alamat: string;
  jenis_usaha: string;
  penghasilan_perbulan: string;
  nomor_telefon: string;
  created_at?: string;
  updated_at?: string;
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
const showSort = ref(false)
const showFilter = ref(false)
const editData = ref(null)
const perPageOptions = [10, 20, 50, 100, "all"];

const openEdit = (row) => {
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
function formatTanggalKegiatan(mulai: string, berakhir: string): string {
  if (!mulai || !berakhir) return '-'

  const tanggalMulai = new Date(mulai)
  const tanggalBerakhir = new Date(berakhir)

  const optionsBulan = { month: 'long' } as const
  const optionsTahun = { year: 'numeric' } as const

  const hariMulai = tanggalMulai.getDate()
  const hariBerakhir = tanggalBerakhir.getDate()

  const bulanMulai = tanggalMulai.toLocaleDateString('id-ID', optionsBulan)
  const bulanBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', optionsBulan)

  const tahunMulai = tanggalMulai.toLocaleDateString('id-ID', optionsTahun)
  const tahunBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', optionsTahun)

  if (bulanMulai === bulanBerakhir && tahunMulai === tahunBerakhir) {
    // Contoh: 25 - 30 Juni 2025
    return `${hariMulai} - ${hariBerakhir} ${bulanMulai} ${tahunMulai}`
  } else {
    // Contoh: 25 Mei 2025 - 2 Juni 2025
    return `${hariMulai} ${bulanMulai} ${tahunMulai} - ${hariBerakhir} ${bulanBerakhir} ${tahunBerakhir}`
  }
}



// Inisialisasi activeFilters (baru ditambahkan)
const activeFilters = ref<{ [key: string]: string | number | null }>({});

// Perbaiki computed property filterableColumns (baru ditambahkan)
const filterableColumns = computed(() => {
  if (!tableData.value || tableData.value.length === 0) {
    return [ /* default columns */ ];
  }
  const exclude = ['id', 'created_at', 'updated_at'];
  return Object.keys(tableData.value[0] || {}).filter(key => !exclude.includes(key));
});

const filteredData = computed(() => {
  let data = tableData.value;

  if (search.value) {
    data = data.filter(item =>
      item.nama.toLowerCase().includes(search.value.toLowerCase())
    );
  }

  // Logika filter berdasarkan activeFilters (BARU)
  for (const key in activeFilters.value) {
    const filterValue = activeFilters.value[key];

    if (filterValue !== null && filterValue !== '') {
      data = data.filter(item => {
        const itemValue = (item as any)[key];
        if (itemValue === null || itemValue === undefined) {
          return false;
        }
        return String(itemValue).toLowerCase().includes(String(filterValue).toLowerCase());
      });
    }
  }
  return data;
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
    ElNotification({ // Notifikasi error (BARU)
      title: 'Error',
      message: 'Gagal menghapus data massal.',
      type: 'error',
      duration: 3000,
    });
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
  try { // Ditambahkan try-catch
    await api.delete(`/kelola/pelatihan/${row.id}`);
    await fetchData();
    ElNotification({ // Notifikasi sukses (sudah ada)
      title: 'Berhasil',
      message: 'Data berhasil dihapus',
      type: 'success',
      duration: 3000,
    });
  } catch (err) { // Notifikasi error (BARU)
    console.error('Gagal menghapus data:', err);
    ElNotification({
      title: 'Error',
      message: 'Gagal menghapus data.',
      type: 'error',
      duration: 3000,
    });
  } finally { // Pastikan loading diatur
    loading.value = false;
  }
}

async function fetchData() {
  try { // Ditambahkan try-catch
    const res = await api.get('/kelola/pelatihan');
    tableData.value = Array.isArray(res) ? res : res.data || [];
  } catch (error) { // Notifikasi error (BARU)
    console.error('Error fetching data:', error);
    ElNotification({
      title: 'Error',
      message: 'Gagal memuat data dari server.',
      type: 'error',
      duration: 3000,
    });
  }
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

.header-tooltip-text {
  display: inline-block;
  max-width: 100%;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  vertical-align: middle;
}
.table-container {
  padding: 40px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.table-header {
  display: flex;
  justify-content: space-between;
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
.right-control {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}

.select-box {
  height: 34px;
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
  width: 239px;
  height: 34px;
  display: flex;
  align-items: center;
  gap: 4px;
  border: 2px solid #8a8a8a;
  border-radius: 6px;
  padding: 2px 5px;
}
.search-box input {
  border: none;
  outline: none;
  padding: 6px;
  flex: 1;
}
.icon-group .img{
  width: 34px;
  height: 34px;
  cursor: pointer;
  transition: transform 0.2s;
}

.button img {
  width: 18px;
  height: 18px;
  cursor: pointer;
  transition: transform 0.2s;
}
.button2 img {
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
.button2 {
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
.button1 {
  display: none;
}
.button.danger {
  background: #e74c3c;
}
.button2.danger {
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
.button1:hover{
  transform: scale(1.05);
  background: #549b98;
}
.button2:hover{
  transform: scale(1.05);
  background: #549b98;
}

@media(max-width:700px){
  .hilang{
    display: none;
  }
  .search-box{
    width: 79%;
  }
  .table-header {
    flex-wrap: none;
  }
  .button2{
    display: none;
  }
  .button1 {
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
  .button1 img {
    width: 18px;
    height: 18px;
    cursor: pointer;
    transition: transform 0.2s;
  }
  .right-control{
    gap: 12px;
  }
  .left-controls{
    width: 100%;
  }
}
@media(max-width:365px){
  .hilang{
    display: none;
  }
  .search-box{
    width: 75%;
  }
  .table-header {
    flex-wrap: none;
  }
  .button2{
    display: none;
  }
  .button1 {
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
  .button1 img {
    width: 16px;
    height: 16px;
    cursor: pointer;
    transition: transform 0.2s;
  }
  .right-control{
    gap: 5px;
  }
}
</style>