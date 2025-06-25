<template>
  <!-- Form pop up -->
  <Layout>
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
    
    <!-- Header Section -->
    <div class="page-header">
      <h1 class="page-title">Data Pelatihan</h1>
      <div class="header-divider"></div>
    </div>

    <!-- Controls Section -->
    <div class="controls-container">
      <div class="left-controls">
        <!-- Items per page selector -->
        <div class="items-per-page">
          <span class="control-label">Tampilkan:</span>
          <div class="select-wrapper" @click.stop="toggleDropdown">
            <div class="custom-select">
              <span class="select-value">{{ itemsPerPage === Infinity ? 'Semua' : itemsPerPage }}</span>
              <svg class="select-arrow" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </div>
            <ul class="dropdown-menu" v-show="dropdownOpen">
              <li
                v-for="option in perPageOptions"
                :key="option"
                @click="changeItemsPerPage(option)"
                class="dropdown-item"
              >
                {{ option === 'all' ? 'Semua' : option }}
              </li>
            </ul>
          </div>
        </div>

        <!-- Search box -->
        <div class="search-container">
          <div class="search-input-wrapper">
            <svg class="search-icon" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
            </svg>
            <input 
              type="text" 
              placeholder="Cari nama peserta..." 
              v-model="search"
              class="search-input"
            />
          </div>
        </div>

        <!-- Mobile filter/sort buttons -->
        <div class="mobile-controls">
          <button class="control-btn secondary" @click="showFilter = true">
            <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
            <span class="btn-text">Filter</span>
          </button>
          <button class="control-btn secondary" @click="showSort = true">
            <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
              <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1z" />
            </svg>
            <span class="btn-text">Urutkan</span>
          </button>
        </div>
      </div>

      <!-- Action buttons -->
      <div class="action-controls">
        <!-- Desktop filter/sort buttons -->
        <div class="desktop-controls">
          <button class="control-btn secondary" @click="showFilter = true" title="Filter Data">
            <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
            </svg>
          </button>
          <button class="control-btn secondary" @click="showSort = true" title="Urutkan Data">
            <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
              <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 8a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 12a1 1 0 011-1h4a1 1 0 110 2H4a1 1 0 01-1-1z" />
            </svg>
          </button>
        </div>

        <button class="control-btn primary" @click="showExport = true" title="Export Data">
          <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
          <span class="btn-text">Export</span>
        </button>
        
        <button class="control-btn primary" @click="showImport = true" title="Import Data">
          <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 11-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
          <span class="btn-text">Import</span>
        </button>
        
        <button class="control-btn danger" @click="onExportClick" title="Hapus ke Sampah">
          <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd" />
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
          <span class="btn-text">Sampah</span>
        </button>
        
        <button class="control-btn danger" @click="onMassDeleteClick" title="Hapus Massal">
          <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd" />
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <span class="btn-text">Hapus Massal</span>
        </button>
        
        <button class="control-btn accent" @click="showTambah = true" title="Tambah Data Baru">
          <svg class="btn-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          <span class="btn-text">Tambah Data</span>
        </button>
      </div>
    </div>

    <!-- Table Section -->
    <div class="table-container">
      <el-table
        ref="elTable"
        :data="pagedData"
        v-loading="loading"
        class="data-table"
        @selection-change="onSelectionChange"
        @row-click="goToDetail"
        :header-cell-style="headerCellStyle"
        :row-style="rowStyle"
      >
        <el-table-column type="selection" width="50" fixed="left" show-overflow-tooltip />

        <el-table-column prop="nama" show-overflow-tooltip min-width="150">
          <template #header>
            <el-tooltip content="Nama Peserta" placement="top">
              <span class="header-text">Nama</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="nik" show-overflow-tooltip min-width="120">
          <template #header>
            <el-tooltip content="Nomor Induk Kependudukan" placement="top">
              <span class="header-text">NIK</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="jenis_bimtek" show-overflow-tooltip min-width="140">
          <template #header>
            <el-tooltip content="Jenis Bimbingan Teknis" placement="top">
              <span class="header-text">Jenis Bimtek</span>
            </el-tooltip>
          </template>
        </el-table-column>
        
        <el-table-column label="Tanggal Kegiatan" show-overflow-tooltip min-width="160">
          <template #header>
            <el-tooltip content="Tanggal Mulai - Berakhir Kegiatan" placement="top">
              <span class="header-text">Tanggal Kegiatan</span>
            </el-tooltip>
          </template>
          <template #default="{ row }">
            <span class="date-range">{{ formatTanggalKegiatan(row.kegiatan_dimulai, row.kegiatan_berakhir) }}</span>
          </template>
        </el-table-column>

        <el-table-column prop="tempat_kegiatan" show-overflow-tooltip min-width="140">
          <template #header>
            <el-tooltip content="Lokasi Pelaksanaan Kegiatan" placement="top">
              <span class="header-text">Tempat Kegiatan</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="angkatan" show-overflow-tooltip min-width="100">
          <template #header>
            <el-tooltip content="Angkatan Pelatihan" placement="top">
              <span class="header-text">Angkatan</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="tempat_tanggal_lahir" show-overflow-tooltip min-width="160">
          <template #header>
            <el-tooltip content="Tempat dan Tanggal Lahir" placement="top">
              <span class="header-text">Tempat Tanggal Lahir</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="pendidikan" show-overflow-tooltip min-width="120">
          <template #header>
            <el-tooltip content="Tingkat Pendidikan" placement="top">
              <span class="header-text">Pendidikan</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="status" show-overflow-tooltip min-width="100">
          <template #header>
            <el-tooltip content="Status Peserta" placement="top">
              <span class="header-text">Status</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="alamat" show-overflow-tooltip min-width="180">
          <template #header>
            <el-tooltip content="Alamat Lengkap" placement="top">
              <span class="header-text">Alamat</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="jenis_usaha" show-overflow-tooltip min-width="140">
          <template #header>
            <el-tooltip content="Jenis Usaha yang Dijalankan" placement="top">
              <span class="header-text">Jenis Usaha</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="penghasilan_perbulan" show-overflow-tooltip min-width="150">
          <template #header>
            <el-tooltip content="Penghasilan Rata-rata per Bulan" placement="top">
              <span class="header-text">Penghasilan/Bulan</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column prop="nomor_telefon" show-overflow-tooltip min-width="130">
          <template #header>
            <el-tooltip content="Nomor Telepon/WhatsApp" placement="top">
              <span class="header-text">No. Telepon</span>
            </el-tooltip>
          </template>
        </el-table-column>

        <el-table-column label="Aksi" width="100" fixed="right">
          <template #header>
            <el-tooltip content="Aksi yang Tersedia" placement="top">
              <span class="header-text">Aksi</span>
            </el-tooltip>
          </template>
          <template #default="{ row }">
            <div class="action-buttons">
              <button
                class="action-btn edit"
                @click.stop="openEdit(row)"
                title="Edit Data"
              >
                <svg viewBox="0 0 20 20" fill="currentColor">
                  <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
              </button>
              <button
                class="action-btn delete"
                @click.stop="onDelete(row)"
                title="Hapus Data"
              >
                <svg viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd" />
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>

    <!-- Pagination Section -->
    <div class="pagination-container">
      <nav class="pagination-nav">
        <button 
          class="pagination-btn prev" 
          :disabled="currentPage === 1" 
          @click="prevPage"
          title="Halaman Sebelumnya"
        >
          <svg viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
          </svg>
          <span class="sr-only">Previous</span>
        </button>

        <div class="pagination-numbers">
          <template v-for="item in visiblePages" :key="String(item)">
            <button
              v-if="item === '...'"
              class="pagination-btn ellipsis"
              disabled
            >
              <span>…</span>
            </button>
            <button
              v-else
              class="pagination-btn number"
              :class="{ active: item === currentPage }"
              @click="goToPage(item)"
            >
              {{ item }}
            </button>
          </template>
        </div>

        <button 
          class="pagination-btn next" 
          :disabled="currentPage === totalPages" 
          @click="nextPage"
          title="Halaman Selanjutnya"
        >
          <svg viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
          <span class="sr-only">Next</span>
        </button>
      </nav>
    </div>
  </Layout>
</template>

<style scoped>
/* Color Variables */

/* Page Header */
.page-header {
  margin-bottom: 2rem;
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--color-gray-800);
  margin: 0 0 1rem 0;
  line-height: 1.2;
}

.header-divider {
  height: 3px;
  background: linear-gradient(90deg, var(--color-pink-500) 0%, var(--color-pink-300) 50%, var(--color-gray-200) 100%);
  border-radius: 2px;
}

/* Controls Container */
.controls-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 1.5rem;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: var(--color-white);
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--color-gray-200);
}

.left-controls {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  flex-wrap: wrap;
  flex: 1;
}

.action-controls {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}

/* Items Per Page */
.items-per-page {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.control-label {
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-gray-700);
  white-space: nowrap;
}

.select-wrapper {
  position: relative;
}

.custom-select {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  background: var(--color-white);
  border: 2px solid var(--color-gray-300);
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-gray-700);
  transition: all 0.2s ease;
  min-width: 80px;
}

.custom-select:hover {
  border-color: var(--color-pink-400);
  background: var(--color-pink-50);
}

.custom-select:focus-within {
  border-color: var(--color-pink-500);
  box-shadow: 0 0 0 3px var(--color-pink-100);
}

.select-value {
  flex: 1;
}

.select-arrow {
  width: 1.25rem;
  height: 1.25rem;
  color: var(--color-gray-500);
  transition: transform 0.2s ease;
}

.custom-select:hover .select-arrow {
  color: var(--color-pink-500);
}

.dropdown-menu {
  position: absolute;
  top: calc(100% + 0.25rem);
  left: 0;
  right: 0;
  background: var(--color-white);
  border: 1px solid var(--color-gray-200);
  border-radius: 8px;
  box-shadow: var(--shadow-lg);
  z-index: 50;
  overflow: hidden;
  list-style: none;
  margin: 0;
  padding: 0;
}

.dropdown-item {
  padding: 0.75rem;
  font-size: 0.875rem;
  color: var(--color-gray-700);
  cursor: pointer;
  transition: all 0.15s ease;
  border-bottom: 1px solid var(--color-gray-100);
}

.dropdown-item:last-child {
  border-bottom: none;
}

.dropdown-item:hover {
  background: var(--color-pink-50);
  color: var(--color-pink-700);
}

/* Search Container */
.search-container {
  flex: 1;
  max-width: 400px;
}

.search-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 0.75rem;
  width: 1.25rem;
  height: 1.25rem;
  color: var(--color-gray-400);
  pointer-events: none;
  z-index: 1;
}

.search-input {
  width: 100%;
  padding: 0.625rem 0.75rem 0.625rem 2.5rem;
  border: 2px solid var(--color-gray-300);
  border-radius: 8px;
  font-size: 0.875rem;
  color: var(--color-gray-700);
  background: var(--color-white);
  transition: all 0.2s ease;
}

.search-input::placeholder {
  color: var(--color-gray-400);
}

.search-input:focus {
  outline: none;
  border-color: var(--color-pink-500);
  box-shadow: 0 0 0 3px var(--color-pink-100);
}

.search-input:focus + .search-icon {
  color: var(--color-pink-500);
}

/* Control Buttons */
.control-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.625rem 1rem;
  border: none;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
  white-space: nowrap;
}

.control-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-icon {
  width: 1.125rem;
  height: 1.125rem;
  flex-shrink: 0;
}

.btn-text {
  font-size: 0.875rem;
  font-weight: 500;
}

/* Button Variants */
.control-btn.primary {
  background: var(--color-gray-600);
  color: var(--color-white);
}

.control-btn.primary:hover:not(:disabled) {
  background: var(--color-gray-700);
  transform: translateY(-1px);
  box-shadow: var(--shadow-md);
}

.control-btn.secondary {
  background: var(--color-gray-100);
  color: var(--color-gray-700);
  border: 1px solid var(--color-gray-300);
}

.control-btn.secondary:hover:not(:disabled) {
  background: var(--color-gray-200);
  border-color: var(--color-gray-400);
  transform: translateY(-1px);
}

.control-btn.accent {
  background: var(--color-pink-500);
  color: var(--color-white);
}

.control-btn.accent:hover:not(:disabled) {
  background: var(--color-pink-600);
  transform: translateY(-1px);
  box-shadow: var(--shadow-md);
}

.control-btn.danger {
  background: var(--color-red-500);
  color: var(--color-white);
}

.control-btn.danger:hover:not(:disabled) {
  background: var(--color-red-600);
  transform: translateY(-1px);
  box-shadow: var(--shadow-md);
}

/* Mobile/Desktop Controls */
.mobile-controls {
  display: none;
}

.desktop-controls {
  display: flex;
  gap: 0.5rem;
}

/* Table Container */
.table-container {
  background: var(--color-white);
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--color-gray-200);
  overflow: hidden;
  margin-bottom: 2rem;
}

/* Table Styling */
.data-table {
  width: 100% !important;
  font-size: 0.875rem;
}

/* Header Styling */
.data-table :deep(.el-table__header-wrapper) {
  background: var(--color-gray-50);
}

.data-table :deep(.el-table__header-wrapper .el-table__header) {
  background: var(--color-gray-50);
}

.data-table :deep(.el-table__header-wrapper th) {
  background: var(--color-gray-50) !important;
  border-bottom: 2px solid var(--color-gray-200);
  color: var(--color-gray-700);
  font-weight: 600;
  font-size: 0.875rem;
  padding: 1rem 0.75rem;
}

.data-table :deep(.el-table__header-wrapper th:first-child) {
  border-top-left-radius: 12px;
}

.data-table :deep(.el-table__header-wrapper th:last-child) {
  border-top-right-radius: 12px;
}

.header-text {
  color: var(--color-gray-700);
  font-weight: 600;
  font-size: 0.875rem;
}

/* Body Styling */
.data-table :deep(.el-table__body-wrapper .el-table__body tr) {
  transition: all 0.2s ease;
}

.data-table :deep(.el-table__body-wrapper .el-table__body tr:hover) {
  background: var(--color-pink-50) !important;
}

.data-table :deep(.el-table__body-wrapper .el-table__body tr td) {
  background: var(--color-white);
  border-bottom: 1px solid var(--color-gray-100);
  color: var(--color-gray-700);
  font-size: 0.875rem;
  padding: 0.875rem 0.75rem;
}

.data-table :deep(.el-table__body-wrapper .el-table__body tr:nth-child(even) td) {
  background: var(--color-gray-50);
}

.data-table :deep(.el-table__body-wrapper .el-table__body tr:hover td) {
  background: var(--color-pink-50) !important;
}

/* Selection Column */
.data-table :deep(.el-table-column--selection .el-checkbox) {
  --el-checkbox-checked-bg-color: var(--color-pink-500);
  --el-checkbox-checked-border-color: var(--color-pink-500);
}

.data-table :deep(.el-table-column--selection .el-checkbox__input.is-checked .el-checkbox__inner) {
  background-color: var(--color-pink-500);
  border-color: var(--color-pink-500);
}

.data-table :deep(.el-table-column--selection .el-checkbox__input.is-indeterminate .el-checkbox__inner) {
  background-color: var(--color-pink-500);
  border-color: var(--color-pink-500);
}

.data-table :deep(.el-table-column--selection .el-checkbox__input:hover .el-checkbox__inner) {
  border-color: var(--color-pink-400);
}

/* Date Range Styling */
.date-range {
  color: var(--color-gray-600);
  font-weight: 500;
}

/* Action Buttons */
.action-buttons {
  display: flex;
  gap: 0.5rem;
  justify-content: center;
  align-items: center;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2rem;
  height: 2rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease;
  padding: 0;
}

.action-btn svg {
  width: 1rem;
  height: 1rem;
}

.action-btn.edit {
  background: var(--color-gray-100);
  color: var(--color-gray-600);
}

.action-btn.edit:hover {
  background: var(--color-pink-100);
  color: var(--color-pink-600);
  transform: scale(1.05);
}

.action-btn.delete {
  background: var(--color-red-50);
  color: var(--color-red-500);
}

.action-btn.delete:hover {
  background: var(--color-red-100);
  color: var(--color-red-600);
  transform: scale(1.05);
}

/* Pagination Container */
.pagination-container {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}

.pagination-nav {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: var(--color-white);
  padding: 1rem;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  border: 1px solid var(--color-gray-200);
}

.pagination-numbers {
  display: flex;
  gap: 0.25rem;
}

.pagination-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 2.5rem;
  height: 2.5rem;
  padding: 0.5rem;
  border: none;
  border-radius: 8px;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  color: var(--color-gray-700);
  background: var(--color-white);
}

.pagination-btn:hover:not(:disabled) {
  background: var(--color-gray-100);
  color: var(--color-gray-900);
}

.pagination-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination-btn.active {
  background: var(--color-pink-500);
  color: var(--color-white);
}

.pagination-btn.active:hover {
  background: var(--color-pink-600);
}

.pagination-btn.ellipsis {
  cursor: default;
  background: transparent;
}

.pagination-btn.ellipsis:hover {
  background: transparent;
}

.pagination-btn svg {
  width: 1.25rem;
  height: 1.25rem;
}

.sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}

/* Loading State */
.data-table :deep(.el-loading-mask) {
  background-color: rgba(255, 255, 255, 0.8);
}

.data-table :deep(.el-loading-spinner) {
  color: var(--color-pink-500);
}

/* Tooltip Styling */
.data-table :deep(.el-tooltip__popper) {
  background: var(--color-gray-800);
  color: var(--color-white);
  border: none;
  border-radius: 6px;
  font-size: 0.75rem;
  padding: 0.5rem 0.75rem;
}

.data-table :deep(.el-tooltip__popper .el-popper__arrow::before) {
  background: var(--color-gray-800);
  border: none;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .controls-container {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }

  .left-controls {
    justify-content: space-between;
    width: 100%;
  }

  .action-controls {
    justify-content: center;
    width: 100%;
  }

  .btn-text {
    display: none;
  }
}

@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem;
  }

  .controls-container {
    padding: 1rem;
  }

  .left-controls {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }

  .items-per-page {
    justify-content: space-between;
  }

  .search-container {
    max-width: none;
  }

  .mobile-controls {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
  }

  .desktop-controls {
    display: none;
  }

  .action-controls {
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .control-btn {
    padding: 0.5rem;
    min-width: 2.5rem;
  }

  .table-container {
    border-radius: 8px;
    overflow-x: auto;
  }

  .data-table {
    min-width: 800px;
  }

  .pagination-nav {
    padding: 0.75rem;
    flex-wrap: wrap;
    justify-content: center;
  }

  .pagination-btn {
    min-width: 2rem;
    height: 2rem;
    font-size: 0.8125rem;
  }
}

@media (max-width: 640px) {
  .controls-container {
    padding: 0.75rem;
  }

  .page-title {
    font-size: 1.25rem;
  }

  .pagination-numbers {
    gap: 0.125rem;
  }

  .pagination-btn {
    min-width: 1.75rem;
    height: 1.75rem;
    font-size: 0.75rem;
  }

  .action-controls {
    gap: 0.25rem;
  }

  .control-btn {
    padding: 0.375rem;
    min-width: 2rem;
  }

  .btn-icon {
    width: 1rem;
    height: 1rem;
  }
}

/* Focus States for Accessibility */
.control-btn:focus,
.pagination-btn:focus,
.action-btn:focus,
.search-input:focus,
.custom-select:focus {
  outline: 2px solid var(--color-pink-500);
  outline-offset: 2px;
}

/* High Contrast Mode Support */
@media (prefers-contrast: high) {
  .data-table :deep(.el-table__body-wrapper .el-table__body tr:hover td) {
    background: var(--color-gray-200) !important;
  }
  
  .control-btn.accent {
    border: 2px solid var(--color-pink-700);
  }
  
  .pagination-btn.active {
    border: 2px solid var(--color-pink-700);
  }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
  * {
    transition: none !important;
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
  }
}
</style>

<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import Layout from "../../layouts/Layout.vue";
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