<template>
  <Layout2>
    <!-- Form Popups -->
    <FormSortingDatapendaftaran
      v-if="showSort"
      :visible="showSort"
      :columns="filterableColumns"
      :data="tableData"
      @update:visible="showSort = $event"
      class="sm:full-screen"
    />
    <FormFilterDatapendaftaran
      v-model="showFilter"
      :columns="filterableColumns"
      v-model:active-filters="activeFilters"
      class="sm:full-screen"
    />
    <FormTerimaDataPendaftaran
      v-if="showEdit && TerimaData"
      :initialData="TerimaData"
      @close="showEdit = false"
      class="sm:full-screen"
    />
    <FormTerimaDataPendaftaranMassal
      v-if="showEditMassal && TerimaDataMassal"
      :initialData="TerimaDataMassal"
      @close="showEditMassal = false"
      class="sm:full-screen"
    />
    <FormExportDatapendaftaran
      v-if="showExport"
      :data="pagedData"
      @close="showExport = false"
      class="sm:full-screen"
    />
    <FormQuotaDataPendaftaran
      v-model:visible="showQuota"
      @quota-updated="handleQuotaUpdated"
      class="sm:full-screen"
      :data="pagedData"
    />


    <!-- Main Container -->
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-6">
      <!-- Page Header -->
      <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Data Pendaftaran</h1>
        <p class="text-gray-600 text-sm sm:text-base">Kelola dan pantau semua data pendaftaran dalam satu tempat</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 hover:shadow-md transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-xs sm:text-sm font-medium text-gray-600">Total Pendaftar</p>
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

              <!-- Search Box -->
              <div class="flex-1 max-w-md">
                <div class="relative">
                  <input
                    type="text"
                    placeholder="Cari nama pendaftar..."
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
                        @click.stop="showQuota = true; closeAllDropdowns()"
                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-all duration-300 touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.1s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Atur Pendaftaran
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
                        @click.stop="onMassDeleteClick"
                        :disabled="selected.length === 0"
                        class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.2s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Tolak Massal
                      </button>
                      <button
                        @click.stop="openEditMassal(selected)"
                        :disabled="selected.length === 0"
                        class="flex items-center px-4 py-2 text-sm text-green-700 hover:bg-green-50 hover:text-green-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed touch-highlight dropdown-item"
                        :style="{ 'animation-delay': '0.3s' }"
                      >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Terima Massal
                      </button>
                    </div>
                  </div>
                </transition>
                <!-- Desktop Right Controls -->
                <div class="hidden sm:flex sm:gap-3">
                  <button
                    @click="showQuota = true"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-colors"
                    title="Atur Quota"
                  >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.827 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.827-2.37-2.37a1.724 1.724 0 00-1.066-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.573-1.066z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
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
                    @click="onMassDeleteClick"
                    :disabled="selected.length === 0"
                    class="inline-flex items-center px-4 py-2.5 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    title="Tolak Massal"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Tolak Massal
                  </button>
                  <button
                    @click="openEditMassal(selected)"
                    :disabled="selected.length === 0"
                    class="inline-flex items-center px-4 py-2.5 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    title="Terima Massal"
                  >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Terima Massal
                  </button>
                </div>
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

            <!-- Columns always displayed as requested -->
            <el-table-column prop="pendidikan" label="Pendidikan" min-width="120">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.pendidikan }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="status" label="Status" min-width="100">
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

            <el-table-column prop="jenis_usaha" label="Jenis Usaha" min-width="140">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.jenis_usaha }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="penghasilan_perbulan" label="Penghasilan/Bulan" min-width="150">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.penghasilan_perbulan }}
                </div>
              </template>
            </el-table-column>

            <el-table-column prop="nomor_telefon" label="No. Telepon" min-width="130">
              <template #default="{ row }">
                <div class="text-gray-600 text-sm full-width-content">
                  {{ row.nomor_telefon }}
                </div>
              </template>
            </el-table-column>

            <el-table-column label="Aksi" width="100" fixed="right">
              <template #default="{ row }">
                <div class="flex items-center gap-2 full-width-content">
                  <button
                    @click.stop="openEdit(row)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition-colors"
                    title="Terima"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </button>
                  <button
                    @click.stop="onDelete(row)"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors"
                    title="Tolak"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
            <!-- Removed Tanggal Kegiatan, Tempat Kegiatan, Angkatan from mobile cards -->
            <p>Pendidikan: {{ row.pendidikan }}</p>
            <p>Status: {{ row.status }}</p>
            <p>Jenis Usaha: {{ row.jenis_usaha }}</p>
            <p>Penghasilan/Bulan: {{ row.penghasilan_perbulan }}</p>
          </div>
          <div class="flex gap-2">
            <button
              @click.stop="openEdit(row)"
              class="flex-1 py-2 bg-green-100 text-green-600 rounded-lg text-sm hover:bg-green-200 transition-colors touch-highlight"
            >
              Terima
            </button>
            <button
              @click.stop="onDelete(row)"
              class="flex-1 py-2 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors touch-highlight"
            >
              Tolak
            </button>
          </div>
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
            @click.stop="prevPage"
            :disabled="currentPage === 1"
            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors min-w-[44px] h-10 touch-highlight"
          >
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="sm:block hidden">Sebelum</span>
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
                @click.stop="goToPage(item)"
                :class="[
                  'px-3 py-2 text-sm font-medium rounded-lg transition-colors min-w-[44px] h-10 touch-highlight',
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
            @click.stop="nextPage"
            :disabled="currentPage === totalPages"
            class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors min-w-[44px] h-10 touch-highlight"
          >
            <span class="sm:block hidden">Selanjutnya</span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </Layout2>
</template>

<script lang="ts" setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import api from "../../api.js";
import Layout2 from "../../layouts/Layout2.vue"; // Menggunakan Layout2 dari kode1
import FormExportDatapendaftaran from "../../components/KelolaDataPendaftaran/FormExportDataPendaftaran.vue";
import FormQuotaDataPendaftaran from "@/components/KelolaDataPendaftaran/FormQuotaDataPendaftaran.vue";
import FormTerimaDataPendaftaran from "../../components/KelolaDataPendaftaran/FormTerimaDataPendaftaran.vue";
import FormTerimaDataPendaftaranMassal from "../../components/KelolaDataPendaftaran/FormTerimaDataPendaftaranMassal.vue";
import FormFilterDatapendaftaran from "../../components/KelolaDataPendaftaran/FormFilterDataPendaftaran.vue";
import FormSortingDatapendaftaran from "../../components/KelolaDataPendaftaran/FormSortingDataPendaftaran.vue";
import { ElNotification, ElMessageBox } from 'element-plus'; // Menggunakan ElNotification dan ElMessageBox dari kode2
import { Eye, EyeOff } from 'lucide-vue-next'; // Dari kode1
import { useRouter } from 'vue-router';

const router = useRouter();

// Fungsi goToDetail dari kode2, disesuaikan dengan event target dari kode1
const goToDetail = (row: any, column: any, event: MouseEvent) => {
  // Mencegah navigasi jika klik pada checkbox seleksi atau tombol aksi
  if (column.type === 'selection' || column.label === 'Aksi' || (event.target instanceof HTMLElement && (event.target.closest('button') || event.target.closest('input[type="checkbox"]')))) {
    return;
  }
  router.push({ name: 'DetailMasyarakat', params: { id: row.nik } });
};

// Interface untuk struktur data pendaftar (dari kode2)
interface pendaftar {
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

// Variabel state reaktif (gabungan dari kode1 dan kode2)
const tableData = ref<pendaftar[]>([]);
const selected = ref<pendaftar[]>([]);
const search = ref("");
const loading = ref(false);
const itemsPerPage = ref<number | string>(10);
const currentPage = ref(1);
const dropdownOpen = ref<string | null>(null); // Menggunakan string untuk ID dropdown
const showExport = ref(false);
const showQuota = ref(false);
const showEdit = ref(false); // Untuk FormTerimaDataPendaftaran
const showEditMassal = ref(false); // Untuk FormTerimaDataPendaftaranMassal
const showSort = ref(false);
const showFilter = ref(false);
const TerimaData = ref<pendaftar | null>(null); // Untuk data terima individu
const TerimaDataMassal = ref<pendaftar[] | null>(null); // Untuk data terima massal
const perPageOptions = [10, 20, 50, 100, "all"];

// Fungsi untuk membuka form terima data individu (dari kode2)
const openEdit = (row: pendaftar) => {
  TerimaData.value = { ...row };
  showEdit.value = true;
  // loading.value = false; // Baris ini mungkin berlebihan di sini
};

// Fungsi untuk membuka form terima data massal (dari kode2)
const openEditMassal = (rows: pendaftar[]) => {
  if (!rows.length) {
    ElNotification({
      title: 'Peringatan',
      message: 'Silakan pilih data terlebih dahulu untuk diterima secara massal.',
      type: 'warning',
    });
    return;
  }
  TerimaDataMassal.value = rows;
  showEditMassal.value = true;
};
function handleQuotaUpdated() {
  console.log('Kuota diperbarui di parent!');
  // Lakukan sesuatu setelah kuota diperbarui
}
// Toggles the visibility of a specific dropdown menu (dari kode1)
function toggleDropdown(dropdownId: string) {
  dropdownOpen.value = dropdownOpen.value === dropdownId ? null : dropdownId;

  // Add a bounce animation to dropdown items when opened
  if (dropdownOpen.value) {
    requestAnimationFrame(() => {
      const items = document.querySelectorAll('.dropdown-item');
      items.forEach((item, index) => {
        const el = item as HTMLElement;
        el.classList.remove('bounce');
        void el.offsetWidth; // Trigger reflow to restart animation
        el.classList.add('bounce');
      });
    });
  }
}

// Closes all currently open dropdown menus (dari kode1)
function closeAllDropdowns() {
  dropdownOpen.value = null;
}

// Changes the number of items displayed per page (dari kode1)
function changeItemsPerPage(option: number | string) {
  itemsPerPage.value = option === "all" ? filteredData.value.length : option;
  currentPage.value = 1; // Reset to first page
  closeAllDropdowns();
}

// Formats the start and end dates of an activity into a readable string (dari kode2)
function formatTanggalKegiatan(mulai: string, berakhir: string): string {
  if (!mulai || !berakhir) return '-';

  const tanggalMulai = new Date(mulai);
  const tanggalBerakhir = new Date(berakhir);

  const optionsBulan = { month: 'long' } as const;
  const optionsTahun = { year: 'numeric' } as const;

  const hariMulai = tanggalMulai.getDate();
  const hariBerakhir = tanggalBerakhir.getDate();

  const bulanMulai = tanggalMulai.toLocaleDateString('id-ID', optionsBulan);
  const bulanBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', optionsBulan);

  const tahunMulai = tanggalMulai.toLocaleDateString('id-ID', optionsTahun);
  const tahunBerakhir = tanggalBerakhir.toLocaleDateString('id-ID', optionsTahun);

  // If activity starts and ends in the same month and year
  if (bulanMulai === bulanBerakhir && tahunMulai === tahunBerakhir) {
    return `${hariMulai} - ${hariBerakhir} ${bulanMulai} ${tahunMulai}`;
  } else {
    // If activity spans across different months or years
    return `${hariMulai} ${bulanMulai} ${tahunMulai} - ${hariBerakhir} ${bulanBerakhir} ${tahunBerakhir}`;
  }
}

// Reactive object to store active filter criteria (dari kode2)
const activeFilters = ref<{ [key: string]: string | number | null }>({});

// Computed property to determine which columns can be filtered (dari kode2)
const filterableColumns = computed(() => {
  if (!tableData.value || tableData.value.length === 0) {
    return [];
  }
  const exclude = ['id', 'created_at', 'updated_at'];
  return Object.keys(tableData.value[0] || {}).filter(key => !exclude.includes(key));
});

// Computed property to apply search and active filters to the table data (dari kode2)
const filteredData = computed(() => {
  let data = tableData.value;

  // Apply search filter based on 'nama'
  if (search.value) {
    data = data.filter(item =>
      item.nama.toLowerCase().includes(search.value.toLowerCase())
    );
  }

  // Apply dynamic filters from activeFilters
  for (const key in activeFilters.value) {
    const filterValue = activeFilters.value[key];

    if (filterValue !== null && filterValue !== '') {
      data = data.filter(item => {
        const itemValue = (item as any)[key];
        if (itemValue === null || itemValue === undefined) {
          return false;
        }
        // Case-insensitive inclusion check
        return String(itemValue).toLowerCase().includes(String(filterValue).toLowerCase());
      });
    }
  }
  return data;
});

// Computed property for total number of pages (dari kode1)
const totalPages = computed(() =>
  Math.ceil(
    filteredData.value.length /
      (typeof itemsPerPage.value === "number" ? itemsPerPage.value : 1) // Handle "all" option
  )
);

// Computed property for data to display on the current page (dari kode1)
const pagedData = computed(() => {
  const perPage = typeof itemsPerPage.value === "number" ? itemsPerPage.value : 1;
  const start = (currentPage.value - 1) * perPage;
  return filteredData.value.slice(start, start + perPage);
});

// Pagination navigation functions (dari kode1)
function prevPage() {
  if (currentPage.value > 1) currentPage.value--;
}
function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++;
}
function goToPage(page: number) {
  currentPage.value = page;
}

// Computed property to generate visible pagination numbers (dari kode1)
const visiblePages = computed<(number | '...')[]>(() => {
  const total = totalPages.value;
  const current = currentPage.value;
  const delta = 2; // Number of pages to show around the current page
  const pages: (number | '...')[] = [];

  if (total < 1) return pages;
  pages.push(1); // Always include the first page

  let left = current - delta;
  let right = current + delta;

  // Adjust left/right bounds if they go too close to the edges
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

  // Add '...' if there's a gap between 1 and left
  if (left > 2) pages.push('...');
  // Add pages in the calculated range
  for (let i = left; i <= right; i++) pages.push(i);
  // Add '...' if there's a gap between right and total
  if (right < total - 1) pages.push('...');
  // Always include the last page if total > 1
  if (total > 1) pages.push(total);

  return pages;
});

// Handles selection change from El-Table (for desktop) (dari kode1)
function onSelectionChange(rows: pendaftar[]) {
  selected.value = rows;
}

// Toggles selection for mobile card view (dari kode1)
function toggleSelection(row: pendaftar) {
  const index = selected.value.findIndex(item => item.id === row.id);
  if (index >= 0) {
    selected.value.splice(index, 1); // Deselect
  } else {
    selected.value.push(row); // Select
  }
}

// Handles mass deletion (tolak massal) of selected items (dari kode2)
async function onMassDeleteClick() {
  if (!selected.value.length) {
    ElNotification({
      title: 'Peringatan',
      message: 'Silakan pilih data terlebih dahulu untuk ditolak.',
      type: 'warning',
    });
    return;
  }

  try {
    const { value: keterangan } = await ElMessageBox.prompt(
      `Masukkan keterangan penolakan untuk ${selected.value.length} peserta:`,
      'Konfirmasi Tolak Massal',
      {
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        inputPlaceholder: 'Contoh: Data tidak lengkap atau tidak valid',
        inputValidator: (value) => {
          if (!value) return 'Keterangan wajib diisi';
          if (value.length > 255) return 'Keterangan terlalu panjang (maks. 255 karakter)';
          return true;
        },
        type: 'warning',
      }
    );

    loading.value = true;

    const niks = selected.value.map((item) => item.nik);

    await api.post('/kelola/pendaftaran/massal', {
      niks,
      keterangan,
    });

    await fetchData();

    ElNotification({
      title: 'Berhasil',
      message: 'Data berhasil ditolak secara massal.',
      type: 'success',
      duration: 3000,
    });
    closeAllDropdowns(); // Tutup dropdown setelah aksi
  } catch (err) {
    if (err !== 'cancel') {
      console.error('Gagal menolak data massal:', err);
      ElNotification({
        title: 'Gagal',
        message: 'Terjadi kesalahan saat menolak data massal.',
        type: 'error',
        duration: 3000,
      });
    }
  } finally {
    loading.value = false;
  }
}

// Handles deletion (tolak individu) of a single row (dari kode2)
async function onDelete(row: pendaftar) {
  try {
    const { value: keterangan } = await ElMessageBox.prompt(
      `Masukkan keterangan penolakan untuk NIK ${row.nik}:`,
      'Konfirmasi Tolak',
      {
        confirmButtonText: 'Kirim',
        cancelButtonText: 'Batal',
        inputPlaceholder: 'Contoh: Data tidak valid atau ganda',
        inputPattern: /.+/,
        inputErrorMessage: 'Keterangan tidak boleh kosong.',
        type: 'warning',
      }
    );

    loading.value = true;

    await api.post(`/kelola/pendaftaran/${row.id}`, {
      keterangan: keterangan
    });

    await fetchData();

    ElNotification({
      title: 'Berhasil',
      message: 'Pendaftar berhasil ditolak dengan keterangan.',
      type: 'success',
      duration: 3000,
    });
  } catch (err: any) {
    if (err === 'cancel') {
      return;
    }

    console.error('Gagal menolak pendaftar:', err);
    ElNotification({
      title: 'Gagal',
      message: 'Terjadi kesalahan saat menolak pendaftar.',
      type: 'error',
      duration: 3000,
    });
  } finally {
    loading.value = false;
  }
}

/**
 * Fetches data from the API and sorts it by 'created_at' in descending order.
 * This ensures the newest data always appears first. (dari kode2, dengan penyesuaian sorting dari kode1 jika ada)
 */
async function fetchData() {
  loading.value = true;
  try {
    const res = await api.get('/kelola/pendaftaran');
    let fetchedData: pendaftar[] = Array.isArray(res) ? res : res.data || [];

    // Mengurutkan data berdasarkan 'created_at' secara descending (terbaru dulu)
    // Mengambil logika sorting dari DataPelatihanView.vue (kode1) untuk konsistensi
    fetchedData.sort((a, b) => {
      const dateA = a.updated_at ? new Date(a.updated_at) : new Date(0);
      const dateB = b.updated_at ? new Date(b.updated_at) : new Date(0);
      return dateB.getTime() - dateA.getTime();
    });

    tableData.value = fetchedData;
  } catch (error) {
    console.error('Error fetching data:', error);
    ElNotification({
      title: 'Error',
      message: 'Gagal memuat data dari server.',
      type: 'error',
      duration: 3000,
    });
  } finally {
    loading.value = false;
  }
}

let clickOutsideHandler: ((e: Event) => void) | null = null;

// Lifecycle hook: Called after the component has mounted (gabungan dari kode1 dan kode2)
onMounted(async () => {
  // Tambahkan listener klik global untuk menutup dropdown saat mengklik di luar (dari kode1)
  clickOutsideHandler = (e: Event) => {
    const path = (e as MouseEvent).composedPath() as HTMLElement[];
    // Periksa apakah klik terjadi di luar container dropdown atau tombol pemicunya
    if (!path.some((el) => el.classList?.contains('select-box') || el.classList?.contains('mobile-menu') || el.classList?.contains('mobile-actions') || el.classList?.contains('dropdown-container'))) {
      closeAllDropdowns();
    }
  };
  document.addEventListener('click', clickOutsideHandler);

  // Ambil data saat komponen dimuat
  await fetchData();
});

// Lifecycle hook: Called before the component is unmounted (gabungan dari kode1 dan kode2)
onBeforeUnmount(() => {
  // Hapus listener klik global untuk mencegah memory leaks
  if (clickOutsideHandler) {
    document.removeEventListener('click', clickOutsideHandler);
    clickOutsideHandler = null;
  }
});
</script>

<style scoped>
/* Custom styles for modern table (Desktop) */
.modern-table {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

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

.full-width-content {
  width: 100% !important;
  flex: 1 !important;
}

.full-width-cells :deep(.el-table-column--selection .cell) {
  justify-content: center !important;
}

.full-width-cells :deep(.el-table-fixed-column--right .cell) {
  justify-content: center !important;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  width: 100%;
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

.modern-table :deep(.el-loading-mask) {
  background-color: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(4px);
}

.modern-table :deep(.el-loading-spinner) {
  color: #ec4899;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Touch highlight for mobile */
.touch-highlight {
  position: relative;
  overflow: hidden;
}

.touch-highlight::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.2);
  opacity: 0;
  transition: opacity 0.2s ease;
  pointer-events: none;
}

.touch-highlight:active::after {
  opacity: 1;
}

.touch-highlight:active {
  transform: scale(0.95);
  opacity: 0.8;
}

/* Dropdown animations */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
}

.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-20px) scale(0.9);
}

.dropdown-enter-to,
.dropdown-leave-from {
  opacity: 1;
  transform: translateY(0) scale(1);
}

.dropdown-container {
  background: linear-gradient(to bottom, #f9fafb, #ffffff);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  border-radius: 8px;
  animation: shadow-pulse 1.5s ease-in-out infinite;
}

.dropdown-item {
  animation: bounce 0.4s ease-out forwards;
}

@keyframes bounce {
  0% {
    opacity: 0;
    transform: translateY(-10px) scale(0.9);
  }
  60% {
    opacity: 1;
    transform: translateY(3px) scale(1.05);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

@keyframes shadow-pulse {
  0% {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }
  50% {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
  }
  100% {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }
}

/* General styles */
* {
  transition: all 0.2s ease-in-out;
}

button:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

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

input:focus,
button:focus,
select:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

.hover\:shadow-md:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.bg-pink-gradient {
  background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
}

.text-pink-gradient {
  background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.card-shadow {
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.card-shadow-hover:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

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

@media (max-width: 640px) {
  .full-screen {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1000;
    width: 100%;
    height: 100%;
    overflow-y: auto;
  }
}
</style>
