<template>
  <DefaultLayout>
    <FormTambahTest v-if="showTambah && TambahData" :initialData="TambahData" @close="showTambah = false" />
    <FormEditTest v-if="showEdit && editData" :initialData="editData" @close="showEdit = false" />
    <div class="table-header">
      <div class="left-controls">
        <div class="select-box" @click.stop="toggleDropdown">
          <span>{{ itemsPerPage === Infinity ? 'All' : itemsPerPage }}</span>
          <img src="/table/panah.svg" alt="Dropdown" />
          <ul class="dropdown-list" v-show="dropdownOpen">
            <li v-for="option in perPageOptions" :key="option" @click="changeItemsPerPage(option)">
              {{ option === 'all' ? 'All' : option }}
            </li>
          </ul>
        </div>
        <div class="search-box">
          <input type="text" placeholder="Cari" v-model="search" />
          <img src="/table/cari.svg" alt="Search" />
        </div>
        <div class="icon-group">
          <img src="/table/filter.svg" alt="Filter" @click="onFilterClick" />
          <img src="/table/sort.svg" alt="Sort" @click="onSortClick" />
        </div>
      </div>
      <div class="right-controls">
        <button class="button" @click="openTambah">
          <img src="/table/tambah.svg" alt="Add" />
          Tambah Data
        </button>
      </div>
    </div>
    <div class="table-wrapper">
      <el-table
        :data="pagedData"
        v-loading="loading"
        @selection-change="onSelectionChange"
        :header-cell-style="headerCellStyle"
        :row-style="rowStyle"
      >
        <el-table-column type="selection" width="55" />
        <el-table-column prop="nama" label="Nama Peserta" />
        <el-table-column prop="jenis_test" label="Jenis Test" />
        <el-table-column prop="nilai" label="Nilai" />
        <el-table-column prop="tanggal_test" label="Tanggal Test" />
        <el-table-column label="Aksi" width="120" fixed="right">
          <template #default="{ row }">
            <div class="action-buttons">
              <img src="/table/edit.svg" alt="Edit" class="action-icon" @click="openEdit(row)" />
              <img src="/table/hapus.svg" alt="Hapus" class="action-icon" @click="onDelete(row)" />
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="pagination">
      <button class="page-btn" :disabled="currentPage === 1" @click="prevPage">
        <img src="/table/sebelum.svg" alt="preview" />
      </button>
      <template v-for="item in visiblePages" :key="item">
        <button v-if="item === '...'" class="page-number ellipsis" disabled>…</button>
        <button v-else class="page-number" :class="{ active: item === currentPage }" @click="goToPage(item)">{{ item }}</button>
      </template>
      <button class="page-btn" :disabled="currentPage === totalPages" @click="nextPage">
        <img src="/table/next.svg" alt="next" />
      </button>
    </div>
  </DefaultLayout>
</template>
<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import api from '../../api';
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import FormEditTest from '../../components/FormEditPrePostTest.vue';
import FormTambahTest from '../../components/FormTambahPrePostTest.vue';
import { ElNotification } from 'element-plus';
interface TestData {
  id: number;
  nama: string;
  jenis_test: 'Pretest' | 'Postest';
  nilai: number;
  tanggal_test: string;
}
const tableData = ref<TestData[]>([]);
const selected = ref<TestData[]>([]);
const search = ref('');
const loading = ref(false);
const itemsPerPage = ref<number | string>(10);
const currentPage = ref(1);
const dropdownOpen = ref(false);
const showEdit = ref(false);
const showTambah = ref(false);
const editData = ref(null);
const TambahData = ref(null);
const perPageOptions = [10, 20, 50, 100, 'all'];
const toggleDropdown = () => (dropdownOpen.value = !dropdownOpen.value);
const changeItemsPerPage = (opt: number | string) => {
  itemsPerPage.value = opt === 'all' ? Infinity : opt;
  currentPage.value = 1;
  dropdownOpen.value = false;
};
const filteredData = computed(() =>
  tableData.value.filter((d) => d.nama.toLowerCase().includes(search.value.toLowerCase()))
);
const pagedData = computed(() => {
  const perPage = typeof itemsPerPage.value === 'number' ? itemsPerPage.value : Infinity;
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
  if (left < 2) {
    right += 2 - left;
    left = 2;
  }
  if (right > total - 1) {
    left -= right - (total - 1);
    right = total - 1;
  }
  if (left > 2) pages.push('...');
  for (let i = left; i <= right; i++) pages.push(i);
  if (right < total - 1) pages.push('...');
  if (total > 1) pages.push(total);
  return pages;
});
const onSelectionChange = (rows: TestData[]) => (selected.value = rows);
const prevPage = () => currentPage.value--;
const nextPage = () => currentPage.value++;
const goToPage = (n: number) => (currentPage.value = n);
const openEdit = (row: TestData) => {
  editData.value = { ...row };
  showEdit.value = true;
};
const openTambah = () => {
  TambahData.value = null;
  showTambah.value = true;
};
const onDelete = async (row: TestData) => {
  loading.value = true;
  await api.delete(`/kelola/test/${row.id}`);
  await fetchData();
  loading.value = false;
};
const onMassDeleteClick = async () => {
  if (!selected.value.length) return;
  loading.value = true;
  try {
    const ids = selected.value.map((p) => p.id);
    await api.delete('/kelola/test', { data: { ids } });
    await fetchData();
    ElNotification({ title: 'Berhasil', message: 'Hapus Data Massal', type: 'success' });
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};
const fetchData = async () => {
  const res = await api.get('/kelola/test');
  tableData.value = Array.isArray(res) ? res : res.data || [];
};
onMounted(fetchData);
const headerCellStyle = {
  backgroundImage: 'linear-gradient(to top, #FB9CB1, #FE6B99)',
  color: 'white',
  whiteSpace: 'nowrap',
  textAlign: 'left',
};
const rowStyle = () => ({ backgroundColor: '#F7F6FE' });
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
.el-table__header-wrapper thead th:first-child {
  border-top-left-radius: 15px !important;
}
.el-table__header-wrapper thead th:last-child {
  border-top-right-radius: 15px !important;
}
.el-table__header-wrapper {
  overflow: visible !important;
}
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
.el-table .el-table__body-wrapper tbody tr td {
  background-color: #ececec;
}
.el-table-column--selection {
  width: 55px !important;
}
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
