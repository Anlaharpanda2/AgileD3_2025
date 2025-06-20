<template>
  <DefaultLayout2>
    <h1 class="headeratas">Data Berita Sampah</h1>

    <div class="table-header">
      <div class="left-controls">
        <div class="show-wrapper">
          <div class="select-box" @click.stop="toggleDropdown">
            <span>{{ itemsPerPage === Infinity ? 'All' : itemsPerPage }}</span>
            <img src="/table/panah.svg" alt="Dropdown" style="width:22px;height:22px" />
            <ul class="dropdown-list" v-show="dropdownOpen">
              <li v-for="option in perPageOptions" :key="option" @click="changeItemsPerPage(option)">
                {{ option === 'all' ? 'All' : option }}
              </li>
            </ul>
          </div>
        </div>

        <div class="search-box">
          <input type="text" placeholder="Cari Judul atau Jenis Konten" v-model="search" />
          <img src="/table/cari.svg" alt="Search" />
        </div>
      </div>

      <div class="right-controls">
        <button class="button" @click="onMassDeletePermanentClick" v-if="isOperator">
          <img src="/table/deleteForever.svg" alt="hapusPermanenMassal" />
          Hapus Permanen Massal
        </button>
        <button class="button" @click="onMassRestoreClick">
          <img src="/table/pulihkan.svg" alt="restoreMassal" />
          Pulihkan Massal
        </button>
      </div>
    </div>

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
        <el-table-column type="selection" width="55" show-overflow-tooltip/>
        <el-table-column prop="judul" label="Judul" show-overflow-tooltip/>
        <el-table-column prop="jenis_konten" label="Jenis Konten" show-overflow-tooltip/>
        <el-table-column prop="isi" label="Isi Berita" show-overflow-tooltip/>
        <el-table-column prop="updated_at" label="Tanggal Update" show-overflow-tooltip/>
        <el-table-column prop="created_at" label="Tanggal Buat" show-overflow-tooltip/>
        <el-table-column label="Gambar" width="120">
          <template #default="{ row }">
            <img :src="getImageUrl(row.gambar)" alt="Gambar Berita" style="width: 60px; height: auto" @error="onImageError" />
          </template>
        </el-table-column>

        <el-table-column label="Aksi" width="120" fixed="right">
          <template #default="{ row }">
            <div class="action-buttons">
              <img
                src="/table/pulihkan2.svg"
                alt="Restore"
                class="action-icon"
                @click="onRestore(row)"
                title="Pulihkan data"
              />
              <img
                src="/table/deleteForever2.svg"
                alt="HapusSelamanya"
                class="action-icon"
                @click="onDelete(row)"
                title="Hapus Selamanya"
              />
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <div class="pagination">
      <button class="page-btn" :disabled="currentPage === 1" @click="prevPage">
        <img src="/table/sebelum.svg" alt="prev" />
      </button>

      <template v-for="item in visiblePages" :key="String(item)">
        <button v-if="item === '...'" class="page-number ellipsis" disabled>…</button>
        <button v-else class="page-number" :class="{ active: item === currentPage }" @click="goToPage(item)">
          {{ item }}
        </button>
      </template>

      <button class="page-btn" :disabled="currentPage === totalPages" @click="nextPage">
        <img src="/table/next.svg" alt="next" />
      </button>
    </div>
  </DefaultLayout2>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted } from 'vue'
import api from '../../api.js'
import DefaultLayout2 from '../../layouts/DefaultLayout2.vue'
import { ElMessage } from 'element-plus';

const getUserRole = (): string => {
  return localStorage.getItem('role') || ''
}

const isOperator = computed(() => getUserRole() === 'operator')
const isPegawai = computed(() => getUserRole() === 'pegawai')
const isMasyarakat = computed(() => getUserRole() === 'masyarakat')
const isNotLogin = computed(() => !['operator', 'pegawai', 'masyarakat'].includes(getUserRole()))


interface Berita {
  id: number;
  judul: string;
  jenis_konten: string;
  isi: string;
  /**
   * Nama file gambar yang disimpan di folder `storage/app/public/berita_foto/`.
   * Format: .jpg, .jpeg, .png, atau URL absolut.
   */
  gambar: string | File;
  created_at?: string;
  updated_at?: string;
}

const tableData = ref<Berita[]>([])
const selected = ref<Berita[]>([])
const search = ref('')
const loading = ref(false)
const itemsPerPage = ref<number|string>(10)
const currentPage = ref(1)
const dropdownOpen = ref(false)

const perPageOptions = [10, 20, 50, 100, 'all']

function getImageUrl(file: string): string {
  if (!file) return '/placeholder.jpg'; // fallback jika kosong
  // Jika sudah URL lengkap (misal: https://...), pakai langsung
  if (file.startsWith('http')) return file;
  return `/storage/berita_foto/${file}`;
}

function onImageError(event: Event) {
  const target = event.target as HTMLImageElement;
  target.src = '/placeholder.jpg'; // fallback gambar error
}

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}
function changeItemsPerPage(opt: number | string) {
  itemsPerPage.value = opt === 'all' ? filteredData.value.length : opt
  currentPage.value = 1
  dropdownOpen.value = false
}

const filteredData = computed(() =>
  tableData.value.filter(i =>
    i.judul.toLowerCase().includes(search.value.toLowerCase()) ||
    i.jenis_konten.toLowerCase().includes(search.value.toLowerCase())
  )
)

const totalPages = computed(() =>
  Math.ceil(filteredData.value.length / (typeof itemsPerPage.value === 'number' ? itemsPerPage.value : 1))
)

const pagedData = computed(() => {
  const per = typeof itemsPerPage.value === 'number' ? itemsPerPage.value : 1
  return filteredData.value.slice((currentPage.value - 1) * per, (currentPage.value - 1) * per + per)
})

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}
function goToPage(p: number) {
  currentPage.value = p
}

const visiblePages = computed<(number | '...')[]>(() => {
  const total = totalPages.value,
    cur = currentPage.value,
    d = 2,
    pages: (number | '...')[] = []

  if (total > 0) {
    pages.push(1)
    let l = cur - d,
      r = cur + d
    if (l < 2) {
      r += 2 - l
      l = 2
    }
    if (r > total - 1) {
      l -= r - (total - 1)
      r = total - 1
    }
    l = Math.max(l, 2)
    r = Math.min(r, total - 1)
    if (l > 2) pages.push('...')
    for (let i = l; i <= r; i++) pages.push(i)
    if (r < total - 1) pages.push('...')
    if (total > 1) pages.push(total)
  }
  return pages
})

function onSelectionChange(rows: Berita[]) {
  selected.value = rows
}

// Permanent delete (mass/single)
async function onMassDeletePermanentClick() {
  if (!selected.value.length) return

  loading.value = true
  try {
    const ids = selected.value.map(p => p.id)
    await api.delete('/kelola/berita/permanent', { data: { ids } })
    await fetchData()
    ElMessage.success('Berhasil menghapus data secara permanen')
  } catch (err) {
    console.error('Gagal menghapus data:', err)
    ElMessage.error('Terjadi kesalahan saat menghapus data')
  } finally {
    loading.value = false
  }
}

async function onDelete(row: Berita) {
  loading.value = true
  try {
    await api.delete(`/kelola/berita/permanent/${row.id}`)
    await fetchData()
    ElMessage.success('Berhasil menghapus data secara permanen')
  } catch (err) {
    console.error('Gagal menghapus data:', err)
    ElMessage.error('Terjadi kesalahan saat menghapus data')
  } finally {
    loading.value = false
  }
}

// Restore (mass/single)
async function onMassRestoreClick() {
  if (!selected.value.length) return
  loading.value = true
  try {
    const ids = selected.value.map(p => p.id)
    await api.put('/kelola/berita/restore', { ids })
    await fetchData()
    ElMessage.success('Berhasil memulihkan data')
  } catch (err) {
    console.error('Gagal memulihkan data:', err)
    ElMessage.error('Terjadi kesalahan saat memulihkan data')
  } finally {
    loading.value = false
  }
}

async function onRestore(row: Berita) {
  loading.value = true
  try {
    await api.put(`/kelola/berita/restore/${row.id}`)
    await fetchData()
    ElMessage.success('Berhasil memulihkan data')
  } catch (err) {
    console.error('Gagal memulihkan data:', err)
    ElMessage.error('Terjadi kesalahan saat memulihkan data')
  } finally {
    loading.value = false
  }
}

async function fetchData() {
  loading.value = true
  try {
    const res = await api.get('/kelola/berita/trash')
    tableData.value = Array.isArray(res) ? res : res.data || []
    currentPage.value = 1
  } catch (err) {
    console.error('Gagal mengambil data:', err)
    ElMessage.error('Terjadi kesalahan saat mengambil data')
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)

const headerCellStyle = {
  backgroundImage: 'linear-gradient(to top, #FB9CB1, #FE6B99)',
  color: 'white',
  whiteSpace: 'nowrap',
  textAlign: 'left'
}
function rowStyle() {
  return { backgroundColor: '#F7F6FE' }
}
</script>

<style scoped>
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
.headeratas {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
  text-transform: uppercase;
  letter-spacing: 1px;
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
.button:hover {
  transform: scale(1.05);
  background: #549b98;
}
</style>
