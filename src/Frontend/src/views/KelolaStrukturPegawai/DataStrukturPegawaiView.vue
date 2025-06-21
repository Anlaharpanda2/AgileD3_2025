<template>
  <DefaultLayout>
    <h1 class="h3 fw-bold text-secondary border-bottom pb-2 mb-4">
      Data Struktur Pegawai
    </h1>

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
          <input type="text" placeholder="Cari Nama Pegawai" v-model="search" />
          <img src="/table/cari.svg" alt="Search" />
        </div>
      </div>
    </div>

    <div class="table-wrapper">
      <el-table
        :data="pagedData"
        v-loading="loading"
        style="width: 100%"
        :header-cell-style="headerCellStyle"
        :row-style="rowStyle"
      >
        <el-table-column prop="nama" label="Nama" show-overflow-tooltip />
        <el-table-column prop="nip" label="NIP" show-overflow-tooltip />
        <el-table-column prop="jabatan" label="Jabatan" show-overflow-tooltip />
        <el-table-column prop="unit_kerja" label="Unit Kerja" show-overflow-tooltip />

        <el-table-column label="Aksi" width="60" fixed="right">
          <template #default="{ row }">
            <div class="action-buttons">
              <img src="/table/edit.svg" alt="Edit" class="action-icon" @click="editData(row)" title="Edit" />
              <img src="/table/hapus.svg" alt="Hapus" class="action-icon" @click="deleteData(row)" title="Hapus" />
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <div class="pagination">
      <button class="page-btn" :disabled="currentPage === 1" @click="prevPage">
        <img src="/table/sebelum.svg" alt="prev">
      </button>

      <template v-for="item in visiblePages" :key="String(item)">
        <button v-if="item === '...'" class="page-number ellipsis" disabled>…</button>
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

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import api from '../../api.js'
import DefaultLayout from '../../layouts/DefaultLayout.vue'
import { ElNotification } from 'element-plus'

interface Pegawai {
  id: number
  nama: string
  nip: string
  jabatan: string
  unit_kerja: string
}

const tableData = ref<Pegawai[]>([])
const search = ref('')
const loading = ref(false)
const currentPage = ref(1)
const itemsPerPage = ref<number | string>(10)
const perPageOptions = [10, 20, 50, 100, 'all']
const dropdownOpen = ref(false)

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}
function changeItemsPerPage(option: number | string) {
  itemsPerPage.value = option === 'all' ? Infinity : option
  currentPage.value = 1
  dropdownOpen.value = false
}

const filteredData = computed(() => {
  return tableData.value.filter(p => p.nama.toLowerCase().includes(search.value.toLowerCase()))
})
const totalPages = computed(() => Math.ceil(filteredData.value.length / (typeof itemsPerPage.value === 'number' ? itemsPerPage.value : 1)))
const pagedData = computed(() => {
  const perPage = typeof itemsPerPage.value === 'number' ? itemsPerPage.value : filteredData.value.length
  const start = (currentPage.value - 1) * perPage
  return filteredData.value.slice(start, start + perPage)
})

const visiblePages = computed<(number | '...')[]>(() => {
  const total = totalPages.value
  const current = currentPage.value
  const delta = 2
  const pages: (number | '...')[] = []
  if (total < 1) return pages
  pages.push(1)
  let left = current - delta
  let right = current + delta
  if (left < 2) {
    right += 2 - left
    left = 2
  }
  if (right > total - 1) {
    left -= right - (total - 1)
    right = total - 1
  }
  left = Math.max(left, 2)
  right = Math.min(right, total - 1)
  if (left > 2) pages.push('...')
  for (let i = left; i <= right; i++) pages.push(i)
  if (right < total - 1) pages.push('...')
  if (total > 1) pages.push(total)
  return pages
})

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}
function goToPage(page: number) {
  currentPage.value = page
}

async function fetchData() {
  loading.value = true
  try {
    const res = await api.get('/struktur-pegawai')
    tableData.value = res.data
  } catch (err) {
    ElNotification({
      title: 'Error',
      message: 'Gagal memuat data struktur pegawai.',
      type: 'error'
    })
  } finally {
    loading.value = false
  }
}

function editData(row: Pegawai) {
  ElNotification({ title: 'Edit', message: `Edit ${row.nama}`, type: 'info' })
}

async function deleteData(row: Pegawai) {
  loading.value = true
  try {
    await api.delete(`/struktur-pegawai/${row.id}`)
    await fetchData()
    ElNotification({ title: 'Sukses', message: 'Data dihapus.', type: 'success' })
  } catch (err) {
    ElNotification({ title: 'Error', message: 'Gagal menghapus.', type: 'error' })
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
