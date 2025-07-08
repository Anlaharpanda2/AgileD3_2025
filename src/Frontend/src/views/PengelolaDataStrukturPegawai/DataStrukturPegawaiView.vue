<template>
  <Layout2>
    <!-- Form Popups -->
    <FormSortingDataStrukturPegawai
      v-if="showSort"
      :visible="showSort"
      :columns="filterableColumns"
      :data="tableData"
      @update:visible="showSort = $event"
      class="sm:full-screen"
    />
    <FormFilterDataStrukturPegawai
      v-model="showFilter"
      :columns="filterableColumns"
      v-model:active-filters="activeFilters"
      class="sm:full-screen"
    />
    <FormTambahDataStrukturPegawai
      v-if="showTambah"
      @close="showTambah = false"
      class="sm:full-screen"
    />
    <FormEditDataStrukturPegawai
      v-if="showEdit && editData"
      :initialData="editData"
      @close="showEdit = false"
      class="sm:full-screen"
    />
    <FormExportDataStrukturPegawai
      v-if="showExport"
      :data="pagedData"
      @close="showExport = false"
      class="sm:full-screen"
    />
    <FormImportDataStrukturPegawai
      v-if="showImport"
      @close="showImport = false"
      class="sm:full-screen"
    />

    <!-- Main Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-6">
      <!-- Page Header -->
      <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Data StrukturPegawai</h1>
        <p class="text-gray-600 text-sm sm:text-base">Kelola dan pantau semua data struktur pegawai dalam satu tempat</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs sm:text-sm font-medium text-gray-600">Total Peserta</p>
              <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ tableData.length }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-pink-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h-10a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v11a2 2 0 01-2 2zM9 10h.01M9 14h.01M13 10h.01M13 14h.01M17 10h.01M17 14h.01M7 7h.01"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs sm:text-sm font-medium text-gray-600">Dipilih</p>
              <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ selected.length }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs sm:text-sm font-medium text-gray-600">Hasil Filter</p>
              <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ filteredData.length }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs sm:text-sm font-medium text-gray-600">Halaman</p>
              <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ currentPage }}/{{ totalPages }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Controls Section -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-4 sm:p-6">
          <!-- Top Controls -->
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Left Controls -->
            <div class="flex flex-col sm:flex-row gap-4">
              <!-- Items Per Page -->
              <div class="relative sm:flex-1 sm:max-w-[100px]">
                <div
                  class="
                    relative
                    flex items-center
                    gap-[6px]
                    cursor-pointer
                    select-none
                    bg-[#EC4899]
                    text-white
                    rounded-[6px]
                    px-[10px]
                  "
                >
                  <button
                    id="itemsPerPageBtn"
                    @click.stop="toggleDropdown('itemsPerPage')"
                    class="bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors w-full sm:min-w-[80px] touch-highlight"
                  >
                    {{ itemsPerPage === Infinity ? 'Semua' : itemsPerPage }}
                  </button>
                  <div class="absolute inset-y-0 right-4 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>

                  <!-- Dropdown Items Per Page -->
                  <transition name="dropdown">
                    <div v-show="dropdownOpen === 'itemsPerPage'" class="absolute z-30 mt-1 w-full bg-gradient-to-b from-gray-50 to-white shadow-lg border border-gray-200 rounded-lg dropdown-container">
                      <ul style="padding: 0;">
                        <li
                          v-for="(option, index) in perPageOptions"
                          :key="option"
                          @click.stop="changeItemsPerPage(option)"
                          class="px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 cursor-pointer transition-all duration-300 touch-highlight dropdown-item"
                          :style="{ 'animation-delay': `${index * 0.1}s` }"
                        >
                          {{ option === 'all' ? 'Semua' : option }}
                        </li>
                      </ul>
                    </div>
                  </transition>
                </div>
              </div>
            </div>

            <!-- Search Box -->
            <div class="flex-1 max-w-md">
              <div class="relative">
                <input
                  type="text"
                  placeholder="Cari nama pegawai..."
                  v-model="search"
                  class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-colors text-sm"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Filter & Sort (Mobile: Hamburger Menu) -->
            <div class="relative sm:flex sm:gap-2 mobile-menu">
              <label class="block text-sm font-medium text-gray-700 mb-2 sm:hidden">Aksi</label>
              <button
                id="mobileMenuBtn"
                @click.stop="toggleDropdown('mobileMenu')"
                class="sm:hidden flex items-center justify-center w-12 h-12 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors touch-highlight"
              >
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
              </button>
              <!-- Mobile Menu Dropdown -->
              <transition name="dropdown">
                <div v-show="dropdownOpen === 'mobileMenu'" class="sm:hidden absolute z-30 mt-1 w-48 bg-gradient-to-b from-gray-50 to-white shadow-lg border border-gray-200 rounded-lg dropdown-container" style="right: 15%; top: 20%;">
                  <div class="flex flex-col p-2">
                    <button
                      @click.stop="showFilter = true; closeAllDropdowns()"
                      class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                      :style="{ 'animation-delay': '0s' }"
                    >
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                      </svg>
                      Filter
                    </button>
                    <button
                      @click.stop="showSort = true; closeAllDropdowns()"
                      class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                      :style="{ 'animation-delay': '0.1s' }"
                    >
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                      </svg>
                      Urutkan
                    </button>
                  </div>
                </div>
              </transition>
              <!-- Desktop Filter & Sort -->
              <div class="hidden sm:flex sm:gap-2">
                <div>
                  <button
                    @click="showFilter = true"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                    </svg>
                    Filter
                  </button>
                </div>
                <div>
                  <button
                    @click="showSort = true"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                    </svg>
                    Urutkan
                  </button>
                </div>
              </div>
            </div>

            <!-- Right Controls -->
            <div class="flex flex-col sm:flex-row gap-3">
              <div class="relative sm:flex sm:gap-3 mobile-actions">
                <label class="block text-sm font-medium text-gray-700 mb-2 sm:hidden">Aksi Lain</label>
                <button
                  id="mobileActionsBtn"
                  @click.stop="toggleDropdown('mobileActions')"
                  class="sm:hidden flex items-center justify-center w-12 h-12 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors touch-highlight"
                >
                  <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"/>
                  </svg>
                </button>
                <!-- Mobile Actions Dropdown -->
                <transition name="dropdown">
                  <div v-show="dropdownOpen === 'mobileActions'" class="sm:hidden absolute z-30 mt-1 w-48 bg-gradient-to-b from-gray-50 to-white shadow-lg border border-gray-200 rounded-lg dropdown-container" style="right: 15%; top: 20%;">
                    <div class="flex flex-col p-2">
                      <button
                        @click.stop="showAllColumns = !showAllColumns; closeAllDropdowns()"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0s' }"
                      >
                        <component :is="showAllColumns ? EyeOff : Eye" class="w-4 h-4 mr-2" />
                        {{ showAllColumns ? 'Sembunyikan Kolom' : 'Tampilkan Semua Kolom' }}
                      </button>
                      <button
                        @click.stop="showExport = true; closeAllDropdowns()"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.1s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export Data
                      </button>
                      <button
                        @click.stop="showImport = true; closeAllDropdowns()"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.2s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Import Data
                      </button>
                      <button
                        @click.stop="goToTrash"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.3s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Data Sampah
                      </button>
                      <button
                        @click.stop="onMassDeleteClick"
                        :disabled="selected.length === 0"
                        class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.4s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Massal
                      </button>
                    </div>
                  </div>
                </transition>
                <!-- Desktop Right Controls -->
                <div class="hidden sm:flex sm:gap-3">
                  <button
                    @click="showAllColumns = !showAllColumns"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                    :title="showAllColumns ? 'Sembunyikan Kolom' : 'Tampilkan Semua Kolom'"
                  >
                    <component :is="showAllColumns ? EyeOff : Eye" class="w-4 h-4" />
                  </button>
                  <button
                    @click="showExport = true"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                    title="Export Data"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                  </button>
                  <button
                    @click="showImport = true"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                    title="Import Data"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                  </button>
                  <button
                    @click="goToTrash"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                    title="Data Sampah"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                  <button
                    @click="onMassDeleteClick"
                    :disabled="selected.length === 0"
                    class="inline-flex items-center px-4 py-2.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    title="Hapus Massal"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Massal
                  </button>
                </div>
                <button
                  @click.stop="showTambah = true"
                  class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-pink-500 to-pink-600 text-white rounded-lg text-sm font-medium hover:from-pink-600 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-md w-full sm:w-auto touch-highlight"
                >
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                  </svg>
                  Tambah Data
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Section (Desktop) -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sm:block hidden">
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
            <el-table-column type="selection" width="55" fixed="left" />

            <el-table-column prop="nama" label="Nama" min-width="150">
              <template #default="{ row }">
                <div class="font-medium text-gray-900 hover:text-pink-600 transition-colors full-width-content line-clamp-2">
                  {{ row.nama }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="nik" label="NIK" min-width="120">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.nik }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="jenis_bimtek" label="Jenis Bimtek" min-width="140">
              <template #default="{ row }">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 full-width-content">
                  {{ row.jenis_bimtek }}
                </span>
              </template>
            </el-table-column>

            <el-table-column label="Tanggal Kegiatan" min-width="160">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ formatTanggalKegiatan(row.kegiatan_dimulai, row.kegiatan_berakhir) }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="tempat_kegiatan" label="Tempat Kegiatan" min-width="140">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.tempat_kegiatan }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="angkatan" label="Angkatan" min-width="100">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.angkatan }}
                </div>
              </template>
            </el-table-column>

            <!-- Columns to be conditionally displayed -->
            <el-table-column v-if="showAllColumns" prop="tempat_tanggal_lahir" label="Tempat Tanggal Lahir" min-width="160">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.tempat_tanggal_lahir }}
                </div>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="pendidikan" label="Pendidikan" min-width="120">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.pendidikan }}
                </div>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="status" label="Status" min-width="100">
              <template #default="{ row }">
                <span :class="['status-badge', {
                  'bg-green-100 text-green-800': row.status === 'kawin',
                  'bg-yellow-100 text-yellow-800': row.status === 'lajang',
                  'bg-red-100 text-red-800': row.status === 'janda'
                }]">
                  {{ row.status }}
                </span>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="alamat" label="Alamat" min-width="180">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm line-clamp-2 full-width-content">
                  {{ row.alamat }}
                </div>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="jenis_usaha" label="Jenis Usaha" min-width="140">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.jenis_usaha }}
                </div>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="penghasilan_perbulan" label="Penghasilan/Bulan" min-width="150">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.penghasilan_perbulan }}
                </div>
              </template>
            </el-table-column>

            <el-table-column v-if="showAllColumns" prop="nomor_telefon" label="No. Telepon" min-width="130">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.nomor_telefon }}
                </div>
              </template>
            </el-table-column>

            <el-table-column label="Aksi" width="120" fixed="right">
              <template #default="{ row }">
                <div class="flex items-center gap-2 full-width-content">
                  <button
                    @click.stop="openEdit(row)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors"
                    title="Edit"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button
                    @click.stop="onDelete(row)"
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

      <!-- Card-based Data Display (Mobile) -->
      <div class="block sm:hidden space-y-4">
        <div
          v-for="row in pagedData"
          :key="row.id"
          class="bg-white rounded-xl shadow-sm border border-gray-100 p-4"
          @click="goToDetail(row, { type: 'data' }, $event)"
        >
          <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
              <input
                type="checkbox"
                class="w-5 h-5 text-pink-500 border-gray-300 rounded focus:ring-pink-500"
                :checked="selected.includes(row)"
                @click.stop
                @change="toggleSelection(row)"
              />
              <div>
                <p class="font-medium text-gray-900 text-sm">{{ row.nama }}</p>
                <p class="text-xs text-gray-600">{{ row.nik }}</p>
              </div>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
              {{ row.jenis_bimtek }}
            </span>
          </div>
          <div class="text-xs text-gray-600 mb-2">
            <p>{{ formatTanggalKegiatan(row.kegiatan_dimulai, row.kegiatan_berakhir) }}</p>
            <p>{{ row.tempat_kegiatan }} | Angkatan {{ row.angkatan }}</p>
          </div>
          <div class="flex gap-2">
            <button
              @click.stop="openEdit(row)"
              class="flex-1 py-2 bg-blue-100 text-blue-600 rounded-lg text-sm hover:bg-blue-200 transition-colors"
            >
              Edit
            </button>
            <button
              @click.stop="onDelete(row)"
              class="flex-1 py-2 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors"
            >
              Hapus
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-6 flex justify-center">
        <el-pagination
          background
          layout="prev, pager, next"
          :total="filteredData.length"
          :page-size="itemsPerPage"
          :current-page="currentPage"
          @current-change="handlePageChange"
          class="modern-pagination"
        />
      </div>
    </div>
  </Layout2>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { ElMessage, ElMessageBox } from 'element-plus'; // Menggunakan ElMessage dan ElMessageBox untuk notifikasi/konfirmasi
import { Eye, EyeOff } from 'lucide-vue-next'; // Menggunakan Lucide Icons

// Import komponen form popups (sesuaikan path jika berbeda di proyek Anda)
import Layout2 from '@/layouts/Layout2.vue';
import FormSortingDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormSortingDataStrukturPegawai.vue';
import FormFilterDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormFilterDataStrukturPegawai.vue';
import FormTambahDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormTambahDataStrukturPegawai.vue';
import FormEditDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormEditDataStrukturPegawai.vue';
import FormExportDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormExportDataStrukturPegawai.vue';
import FormImportDataStrukturPegawai from '@/components/KelolaDataStrukturPegawai/FormImportDataStrukturPegawai.vue';

const router = useRouter();

// --- Reactive State ---
const showSort = ref(false);
const showFilter = ref(false);
const showTambah = ref(false);
const showEdit = ref(false);
const editData = ref(null); // Data untuk form edit
const showExport = ref(false);
const showImport = ref(false);
const showAllColumns = ref(false); // State untuk menampilkan/menyembunyikan kolom tambahan
const dropdownOpen = ref(null); // Untuk mengontrol dropdown (itemsPerPage, mobileMenu, mobileActions)
const search = ref('');
const selected = ref([]); // Untuk menyimpan baris yang dipilih di tabel
const loading = ref(false); // Untuk indikator loading tabel

const itemsPerPage = ref(10); // Jumlah item per halaman
const currentPage = ref(1); // Halaman saat ini
const perPageOptions = [5, 10, 20, 50, 'all']; // Opsi jumlah item per halaman

// Dummy Data (Ganti dengan data asli dari API Anda)
const tableData = ref([
  {
    id: 1,
    nama: 'Budi Santoso',
    nik: '3273010101900001',
    jenis_bimtek: 'Bimtek A',
    kegiatan_dimulai: '2023-01-10',
    kegiatan_berakhir: '2023-01-12',
    tempat_kegiatan: 'Gedung Serbaguna',
    angkatan: 1,
    tempat_tanggal_lahir: 'Bandung, 10 Januari 1990',
    pendidikan: 'S1 Teknik Informatika',
    status: 'kawin',
    alamat: 'Jl. Merdeka No. 10, Bandung',
    jenis_usaha: 'Wiraswasta',
    penghasilan_perbulan: 'Rp 5.000.000',
    nomor_telefon: '081234567890'
  },
  {
    id: 2,
    nama: 'Siti Aminah',
    nik: '3273020202920002',
    jenis_bimtek: 'Bimtek B',
    kegiatan_dimulai: '2023-02-01',
    kegiatan_berakhir: '2023-02-03',
    tempat_kegiatan: 'Aula Kota',
    angkatan: 2,
    tempat_tanggal_lahir: 'Jakarta, 02 Februari 1992',
    pendidikan: 'D3 Akuntansi',
    status: 'lajang',
    alamat: 'Jl. Sudirman No. 20, Jakarta',
    jenis_usaha: 'Karyawan Swasta',
    penghasilan_perbulan: 'Rp 4.500.000',
    nomor_telefon: '081298765432'
  },
  {
    id: 3,
    nama: 'Joko Susilo',
    nik: '3273030303880003',
    jenis_bimtek: 'Bimtek A',
    kegiatan_dimulai: '2023-03-05',
    kegiatan_berakhir: '2023-03-07',
    tempat_kegiatan: 'Pusat Pelatihan',
    angkatan: 1,
    tempat_tanggal_lahir: 'Surabaya, 03 Maret 1988',
    pendidikan: 'SMA',
    status: 'kawin',
    alamat: 'Jl. Pahlawan No. 30, Surabaya',
    jenis_usaha: 'Pedagang',
    penghasilan_perbulan: 'Rp 3.000.000',
    nomor_telefon: '087811223344'
  },
  {
    id: 4,
    nama: 'Dewi Lestari',
    nik: '3273040404950004',
    jenis_bimtek: 'Bimtek C',
    kegiatan_dimulai: '2023-04-15',
    kegiatan_berakhir: '2023-04-17',
    tempat_kegiatan: 'Balai Desa',
    angkatan: 3,
    tempat_tanggal_lahir: 'Yogyakarta, 04 April 1995',
    pendidikan: 'S1 Sastra Inggris',
    status: 'lajang',
    alamat: 'Jl. Malioboro No. 40, Yogyakarta',
    jenis_usaha: 'Penulis',
    penghasilan_perbulan: 'Rp 6.000.000',
    nomor_telefon: '085755667788'
  },
  {
    id: 5,
    nama: 'Rina Wijaya',
    nik: '3273050505910005',
    jenis_bimtek: 'Bimtek B',
    kegiatan_dimulai: '2023-05-20',
    kegiatan_berakhir: '2023-05-22',
    tempat_kegiatan: 'Hotel Bintang',
    angkatan: 2,
    tempat_tanggal_lahir: 'Semarang, 05 Mei 1991',
    pendidikan: 'S1 Ekonomi',
    status: 'janda',
    alamat: 'Jl. Gajah Mada No. 50, Semarang',
    jenis_usaha: 'Pengusaha Kuliner',
    penghasilan_perbulan: 'Rp 7.500.000',
    nomor_telefon: '081399887766'
  },
]);

const activeFilters = ref({}); // Contoh: { jenis_bimtek: 'Bimtek A' }

const filterableColumns = computed(() => {
  // Anda bisa mendefinisikan kolom yang bisa difilter/disortir di sini
  // Ini harus sesuai dengan properti di objek data Anda
  return [
    { key: 'nama', label: 'Nama', type: 'text' },
    { key: 'nik', label: 'NIK', type: 'text' },
    { key: 'jenis_bimtek', label: 'Jenis Bimtek', type: 'select', options: ['Bimtek A', 'Bimtek B', 'Bimtek C'] },
    { key: 'angkatan', label: 'Angkatan', type: 'number' },
    { key: 'status', label: 'Status', type: 'select', options: ['kawin', 'lajang', 'janda'] },
    // Tambahkan kolom lain yang relevan
  ];
});

// --- Computed Properties ---
const filteredData = computed(() => {
  let data = tableData.value;

  // Apply search filter
  if (search.value) {
    data = data.filter(item =>
      item.nama.toLowerCase().includes(search.value.toLowerCase())
    );
  }

  // Apply active filters
  for (const key in activeFilters.value) {
    const filterValue = activeFilters.value[key];
    if (filterValue) {
      data = data.filter(item => item[key] == filterValue);
    }
  }

  return data;
});

const totalPages = computed(() => {
  if (itemsPerPage.value === Infinity) {
    return 1;
  }
  return Math.ceil(filteredData.value.length / itemsPerPage.value);
});

const pagedData = computed(() => {
  if (itemsPerPage.value === Infinity) {
    return filteredData.value;
  }
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredData.value.slice(start, end);
});

// --- Methods ---

// Mengatur dropdown
const toggleDropdown = (dropdownName) => {
  dropdownOpen.value = dropdownOpen.value === dropdownName ? null : dropdownName;
};

// Menutup semua dropdown
const closeAllDropdowns = () => {
  dropdownOpen.value = null;
};

// Mengubah jumlah item per halaman
const changeItemsPerPage = (option) => {
  itemsPerPage.value = option === 'all' ? Infinity : option;
  currentPage.value = 1; // Kembali ke halaman pertama saat item per halaman berubah
  closeAllDropdowns();
};

// Mengubah halaman
const handlePageChange = (page) => {
  currentPage.value = page;
};

// Mengubah seleksi baris tabel
const onSelectionChange = (selection) => {
  selected.value = selection;
};

// Navigasi ke halaman detail (contoh)
const goToDetail = (row) => {
  console.log('Navigasi ke detail:', row);
  // Contoh: router.push(`/detail-pegawai/${row.id}`);
  ElMessage.info(`Melihat detail pegawai: ${row.nama}`);
};

// Membuka form edit
const openEdit = (row) => {
  editData.value = { ...row }; // Salin data untuk diedit
  showEdit.value = true;
  console.log('Membuka edit untuk:', row);
};

// Menghapus data (contoh dengan konfirmasi)
const onDelete = async (row) => {
  try {
    await ElMessageBox.confirm(
      `Apakah Anda yakin ingin menghapus data pegawai ${row.nama}?`,
      'Konfirmasi Hapus',
      {
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        type: 'warning',
      }
    );
    // Logika penghapusan data di sini
    tableData.value = tableData.value.filter(item => item.id !== row.id);
    ElMessage.success(`Data ${row.nama} berhasil dihapus.`);
  } catch (error) {
    if (error === 'cancel') {
      ElMessage.info('Penghapusan dibatalkan.');
    } else {
      ElMessage.error('Gagal menghapus data.');
      console.error('Error deleting data:', error);
    }
  }
};

// Navigasi ke halaman data sampah
const goToTrash = () => {
  console.log('Navigasi ke Data Sampah');
  router.push('/data-sampah-pegawai'); // Contoh path
};

// Hapus massal data yang dipilih
const onMassDeleteClick = async () => {
  if (selected.value.length === 0) {
    ElMessage.warning('Pilih setidaknya satu data untuk dihapus massal.');
    return;
  }

  try {
    await ElMessageBox.confirm(
      `Apakah Anda yakin ingin menghapus ${selected.value.length} data pegawai yang dipilih secara massal?`,
      'Konfirmasi Hapus Massal',
      {
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        type: 'warning',
      }
    );

    const idsToDelete = selected.value.map(item => item.id);
    tableData.value = tableData.value.filter(item => !idsToDelete.includes(item.id));
    selected.value = []; // Kosongkan pilihan setelah dihapus
    ElMessage.success(`${idsToDelete.length} data berhasil dihapus secara massal.`);
  } catch (error) {
    if (error === 'cancel') {
      ElMessage.info('Penghapusan massal dibatalkan.');
    } else {
      ElMessage.error('Gagal menghapus data massal.');
      console.error('Error mass deleting data:', error);
    }
  }
};

// Format tanggal kegiatan
const formatTanggalKegiatan = (mulai, berakhir) => {
  const dateMulai = new Date(mulai);
  const dateBerakhir = new Date(berakhir);

  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const formattedMulai = dateMulai.toLocaleDateString('id-ID', options);
  const formattedBerakhir = dateBerakhir.toLocaleDateString('id-ID', options);

  if (mulai === berakhir) {
    return formattedMulai;
  }
  return `${formattedMulai} - ${formattedBerakhir}`;
};

// Menutup dropdown saat klik di luar
onMounted(() => {
  document.addEventListener('click', closeAllDropdowns);
});
</script>

<style scoped>
/* Transisi Dropdown */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.3s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0);
}

/* Animasi item dropdown */
.dropdown-item {
  opacity: 0;
  transform: translateY(-10px);
  animation: fadeInSlideUp 0.3s forwards;
}

@keyframes fadeInSlideUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Custom styles for Element Plus Table */
.modern-table .el-table__header-wrapper th {
  background-color: #3c4758 !important; /* Warna header */
  color: #ffffff !important; /* Warna teks header */
  font-weight: 700 !important;
  text-align: left !important;
  border-bottom: 2px solid #e5e7eb !important;
  padding: 16px 12px !important;
}

.modern-table .el-table__row {
  background-color: #ffffff !important;
}

.modern-table .el-table__cell {
  padding: 16px 12px !important;
  border-bottom: 1px solid #f3f4f6 !important;
}

.modern-table .el-table__body tr.hover-row > td {
  background-color: #fce7f3 !important; /* Warna hover */
}

/* Ensure full width content within cells */
.full-width-content {
  white-space: normal; /* Allow text to wrap */
  word-break: break-word; /* Break long words */
}

/* Status badge styling */
.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 0.25rem 0.75rem; /* px-3 py-1 */
  border-radius: 9999px; /* rounded-full */
  font-size: 0.75rem; /* text-xs */
  font-weight: 500; /* font-medium */
}

/* Responsive full-screen for popups */
.sm\:full-screen {
  /* Ini adalah placeholder. Implementasi sebenarnya mungkin melibatkan
     position: fixed, top, left, width, height, dll.
     Contoh sederhana untuk memastikan mereka terlihat di mobile: */
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000; /* Pastikan di atas konten lain */
  background-color: rgba(0, 0, 0, 0.5); /* Overlay gelap */
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Touch highlight (for better mobile UX) */
.touch-highlight {
  -webkit-tap-highlight-color: transparent; /* Menghilangkan highlight default di iOS */
  touch-action: manipulation; /* Memperbaiki responsifitas sentuhan */
}

/* Custom pagination styling (Element Plus) */
.modern-pagination .el-pager li.is-active {
  background-color: #EC4899 !important; /* Warna pink untuk halaman aktif */
  color: white !important;
  border-radius: 4px;
}
.modern-pagination .el-pager li:hover {
  color: #EC4899 !important; /* Warna pink saat hover */
}
.modern-pagination .btn-prev,
.modern-pagination .btn-next {
  background-color: #f3f4f6 !important;
  border-radius: 4px;
}
</style>
