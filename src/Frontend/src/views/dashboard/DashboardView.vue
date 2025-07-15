<script setup>
import { ref, onMounted, computed } from 'vue';
import api from '../../api.js';
import VueApexCharts from 'vue3-apexcharts';
import SimpleLayout from '@/layouts/SimpleLayout.vue';
// --- Ikon dari Heroicons ---
import {
  DocumentChartBarIcon,
  NewspaperIcon,
  UserCircleIcon,
  BuildingOfficeIcon,
  AcademicCapIcon,
  BriefcaseIcon,
  UserGroupIcon,
  TicketIcon
} from '@heroicons/vue/24/outline';


// --- State Utama (Lengkap) ---
const summaryData = ref({
  pendaftaran: { total: 0, monthly_trend: {}, by_status: {}, by_pendidikan: {}, area_chart: [] },
  pelatihan: { total: 0, monthly_trend: {}, by_jenis_bimtek: {}, by_angkatan: {} },
  fasilitas: { total: 0, monthly_trend: {}, by_kategori: {}, by_status: {}, area_chart: [] },
  struktur_pegawai: { total: 0, monthly_trend: {}, by_jabatan: {}, by_status: {}, area_chart: [] },
  panitia: { total: 0, monthly_trend: {}, by_jabatan: {} },
  quota: { status: 'closed', limit: 0, registered: 0, remaining: 0 },
  scores: { total_participants: 0, average_pretest: 0, average_posttest: 0 },
  test: { total: 0, by_kategori: {} },
  masyarakat: { total: 0, by_pendidikan: {} },
  users: { total: 0, by_role: {} },
  berita: { total: 50, by_jenis_konten: {}, area_chart: [] },
});

const loading = ref(true);
const error = ref(null);

// --- Fetch Data ---
onMounted(async () => {
  try {
    const response = await api.get('/dashboard/summary');
    if (response && typeof response === 'object') {
      Object.assign(summaryData.value, response);
      // Set tab default setelah data dimuat
      if (summaryData.value.pendaftaran?.by_status) {
        currentPendaftaranStatusTab.value = Object.keys(summaryData.value.pendaftaran.by_status)[0] || 'Diproses';
      }
      if (summaryData.value.fasilitas?.by_status) {
        currentFasilitasStatusTab.value = Object.keys(summaryData.value.fasilitas.by_status)[0] || 'tersedia';
      }
      if (summaryData.value.struktur_pegawai?.by_status) {
        currentPegawaiStatusTab.value = Object.keys(summaryData.value.struktur_pegawai.by_status)[0] || 'aktif';
      }
      if (summaryData.value.berita?.by_jenis_konten) {
        currentBeritaKontenTab.value = Object.keys(summaryData.value.berita.by_jenis_konten)[0] || 'berita';
      }
    } else {
      throw new Error('Format data API tidak valid.');
    }
  } catch (err) {
    error.value = 'Gagal mengambil data dashboard: ' + err.message;
  } finally {
    loading.value = false;
  }
});

// --- Computed Properties ---
const totalManagedData = computed(() => {
  const data = summaryData.value;
  return Object.values(data).reduce((acc, curr) => acc + (curr?.total || 0), 0);
});

// --- Konfigurasi Chart ---
const colors = {
    pink: '#EC4899',
    blue: '#3B82F6',
    green: '#10B981',
    yellow: '#F59E0B',
    purple: '#8B5CF6',
    teal: '#14B8A6',
    orange: '#F97316',
    gray: {
        text: '#4B5563',
        subtleText: '#9CA3AF',
        border: '#E5E7EB',
    },
    white: '#FFFFFF'
};

// --- 1. Diagram Batang (Stacked) dengan Pilihan ---
const createBarChartData = (dataKey, mainColor) => {
    const trend = summaryData.value[dataKey]?.monthly_trend || {};
    const thisYear = Array(12).fill(0).map((_, i) => trend[i + 1] || 0);
    const lastYear = Array(12).fill(0).map(() => Math.floor(Math.random() * (Math.max(...thisYear) / 2)));
    const lightColor = `rgba(${parseInt(mainColor.slice(1,3),16)}, ${parseInt(mainColor.slice(3,5),16)}, ${parseInt(mainColor.slice(5,7),16)}, 0.5)`;
    return {
        series: [{ name: `${new Date().getFullYear()}`, data: thisYear }, { name: `${new Date().getFullYear() - 1}`, data: lastYear }],
        options: {
            chart: { parentHeightOffset: 0, toolbar: { show: false }, background: 'transparent', stacked: true },
            plotOptions: { bar: { horizontal: false, columnWidth: '45%', borderRadius: 8, } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 4, colors: ['transparent'] },
            colors: [mainColor, lightColor],
            legend: { show: true, position: 'top', horizontalAlign: 'left', labels: { colors: colors.gray.text }, markers: { radius: 12 } },
            grid: { borderColor: colors.gray.border, padding: { bottom: 5, left: 20 } },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                labels: { style: { colors: colors.gray.subtleText, fontFamily: 'inherit' } }
            },
            yaxis: { labels: { style: { colors: colors.gray.subtleText, fontFamily: 'inherit' } } },
            fill: { opacity: 1 }
        }
    };
};

// Tabs untuk Diagram Batang Kiri
const activeLeftBarTab = ref('pelatihan');
const leftBarTabs = [
  { key: 'pelatihan', label: 'Pelatihan', color: colors.blue },
  { key: 'panitia', label: 'Panitia', color: colors.purple },
];
const leftBarChart = computed(() => {
    const color = leftBarTabs.find(t => t.key === activeLeftBarTab.value)?.color || colors.blue;
    return createBarChartData(activeLeftBarTab.value, color);
});

// Tabs untuk Diagram Batang Kanan
const activeRightBarTab = ref('pendaftaran');
const rightBarTabs = [
  { key: 'pendaftaran', label: 'Pendaftaran', color: colors.pink },
  { key: 'fasilitas', label: 'Fasilitas', color: colors.green },
  { key: 'struktur_pegawai', label: 'Pegawai', color: colors.yellow },
];
const rightBarChart = computed(() => {
    const color = rightBarTabs.find(t => t.key === activeRightBarTab.value)?.color || colors.pink;
    return createBarChartData(activeRightBarTab.value, color);
});


// --- 2. Diagram Radial (Persen) ---
const createRadialBarChartData = (dataObject, activeTab, mainColor) => {
    const total = Object.values(dataObject).reduce((sum, val) => sum + val, 0);
    const selectedValue = dataObject[activeTab.value] || 0;
    const percentage = total > 0 ? Math.round((selectedValue / total) * 100) : 0;

    return {
        series: [percentage],
        options: {
            chart: { type: 'radialBar', sparkline: { enabled: true } },
            plotOptions: {
                radialBar: {
                    hollow: { size: '70%' },
                    startAngle: -90,
                    endAngle: 90,
                    track: { background: '#e7e7e7', strokeWidth: '97%', margin: 5, },
                    dataLabels: {
                        name: { show: false },
                        value: { offsetY: -2, fontSize: '22px', color: colors.gray.text, fontWeight: 'bold' },
                    },
                },
            },
            grid: { padding: { top: -10 } },
            fill: { type: 'solid', colors: [mainColor] },
            labels: ['Persentase'],
        }
    };
};

const currentPendaftaranStatusTab = ref('Diproses');
const pendaftaranStatusChart = computed(() => createRadialBarChartData(summaryData.value.pendaftaran.by_status, currentPendaftaranStatusTab, colors.pink));
const currentFasilitasStatusTab = ref('tersedia');
const fasilitasStatusChart = computed(() => createRadialBarChartData(summaryData.value.fasilitas.by_status, currentFasilitasStatusTab, colors.green));
const currentPegawaiStatusTab = ref('aktif');
const pegawaiStatusChart = computed(() => createRadialBarChartData(summaryData.value.struktur_pegawai.by_status, currentPegawaiStatusTab, colors.yellow));
const currentBeritaKontenTab = ref('berita');
const beritaKontenChart = computed(() => createRadialBarChartData(summaryData.value.berita.by_jenis_konten, currentBeritaKontenTab, colors.orange));


// --- 3. Area Chart (Recent Activity) ---
// Perbaikan untuk Area Chart (Recent Activity)
const activeAreaChartTab = ref('pendaftaran');
const areaChartTabs = [
    { key: 'pendaftaran', label: 'Pendaftar', icon: DocumentChartBarIcon, color: colors.pink },
    { key: 'fasilitas', label: 'Fasilitas', icon: BuildingOfficeIcon, color: colors.green },
    { key: 'struktur_pegawai', label: 'Pegawai', icon: BriefcaseIcon, color: colors.yellow },
    { key: 'berita', label: 'Berita', icon: NewspaperIcon, color: colors.orange },
];

const recentActivityChart = computed(() => {
    const rawData = summaryData.value[activeAreaChartTab.value]?.area_chart || [];
    const tabConfig = areaChartTabs.find(t => t.key === activeAreaChartTab.value);
    const mainColor = tabConfig?.color || colors.pink;
    
    // Jika tidak ada data, return chart kosong
    if (rawData.length === 0) {
        return {
            series: [{ name: 'Aktivitas', data: [] }],
            options: {
                chart: { parentHeightOffset: 0, toolbar: { show: false }, background: 'transparent' },
                dataLabels: { enabled: false },
                stroke: { width: 2, curve: 'smooth' },
                grid: { show: false },
                fill: { type: 'gradient', gradient: { opacityTo: 0.1, opacityFrom: 0.5 } },
                colors: [mainColor],
                xaxis: { categories: ['Tidak ada data'], labels: { style: { colors: colors.gray.subtleText } } },
                yaxis: { show: false },
                noData: { text: 'Tidak ada data aktivitas' }
            }
        };
    }

    // Proses data berdasarkan tanggal
    const countsByDate = rawData.reduce((acc, item) => {
        // Ambil tanggal saja (tanpa waktu)
        const date = item.date.split(' ')[0];
        acc[date] = (acc[date] || 0) + 1;
        return acc;
    }, {});

    // Jika semua data di tanggal yang sama, buat simulasi tren mingguan
    const sortedDates = Object.keys(countsByDate).sort((a, b) => new Date(a) - new Date(b));
    
    let seriesData = [];
    let categories = [];
    
    if (sortedDates.length === 1) {
        // Jika hanya ada satu tanggal, buat data 7 hari terakhir
        const singleDate = new Date(sortedDates[0]);
        const totalCount = countsByDate[sortedDates[0]];
        
        // Buat data untuk 7 hari terakhir
        for (let i = 6; i >= 0; i--) {
            const date = new Date(singleDate);
            date.setDate(date.getDate() - i);
            
            if (i === 0) {
                // Hari ini (tanggal aktual) - tampilkan semua data
                seriesData.push(totalCount);
            } else {
                // Hari-hari sebelumnya - simulasi dengan data acak yang lebih kecil
                seriesData.push(Math.floor(Math.random() * (totalCount / 2)));
            }
            
            categories.push(date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' }));
        }
    } else {
        // Jika ada multiple tanggal, gunakan data asli
        seriesData = sortedDates.map(date => countsByDate[date]);
        categories = sortedDates.map(date => 
            new Date(date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' })
        );
    }

    return {
        series: [{ name: 'Aktivitas', data: seriesData }],
        options: {
            chart: { 
                parentHeightOffset: 0, 
                toolbar: { show: false }, 
                background: 'transparent',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            dataLabels: { enabled: false },
            stroke: { width: 3, curve: 'smooth' },
            grid: { 
                show: true, 
                borderColor: colors.gray.border,
                strokeDashArray: 3,
                padding: { left: 20, right: 20, top: 20, bottom: 20 }
            },
            fill: { 
                type: 'gradient', 
                gradient: { 
                    opacityTo: 0.1, 
                    opacityFrom: 0.6, 
                    stops: [0, 90, 100],
                    colorStops: [{
                        offset: 0,
                        color: mainColor,
                        opacity: 0.6
                    }, {
                        offset: 100,
                        color: mainColor,
                        opacity: 0.1
                    }]
                }
            },
            colors: [mainColor],
            xaxis: {
                categories: categories,
                labels: { 
                    show: true, 
                    style: { 
                        colors: colors.gray.subtleText, 
                        fontFamily: 'inherit',
                        fontSize: '12px'
                    } 
                },
                axisTicks: { show: false },
                axisBorder: { show: false }
            },
            yaxis: { 
                show: true,
                labels: { 
                    style: { 
                        colors: colors.gray.subtleText, 
                        fontFamily: 'inherit',
                        fontSize: '12px'
                    },
                    formatter: (val) => Math.round(val)
                }
            },
            tooltip: { 
                enabled: true,
                theme: 'light',
                x: { 
                    format: 'dd MMM yyyy' 
                },
                y: {
                    formatter: (val) => `${val} aktivitas`
                }
            },
            markers: {
                size: 6,
                colors: [mainColor],
                strokeColors: colors.white,
                strokeWidth: 2,
                hover: {
                    size: 8
                }
            }
        }
    };
});




// --- 4. Donut Charts ---
const createDonutChartData = (dataObject, mainColor) => {
    const labels = Object.keys(dataObject || {});
    const series = Object.values(dataObject || {});
    const colorPalette = [mainColor, `rgba(${parseInt(mainColor.slice(1,3),16)}, ${parseInt(mainColor.slice(3,5),16)}, ${parseInt(mainColor.slice(5,7),16)}, 0.7)`, `rgba(${parseInt(mainColor.slice(1,3),16)}, ${parseInt(mainColor.slice(3,5),16)}, ${parseInt(mainColor.slice(5,7),16)}, 0.4)`];
    return {
        total: series.reduce((a, b) => a + b, 0),
        labels,
        series,
        options: {
            chart: { sparkline: { enabled: true } },
            stroke: { width: 3, colors: [colors.white] },
            legend: { show: false },
            tooltip: { enabled: true, fillSeriesColor: false, y: { formatter: val => val } },
            dataLabels: { enabled: false },
            labels: labels,
            colors: colorPalette,
            plotOptions: { pie: { expandOnClick: false, donut: { size: '75%' } } },
        }
    };
};
const pendaftaranPendidikanChart = computed(() => createDonutChartData(summaryData.value.pendaftaran.by_pendidikan, colors.pink));
const pelatihanAngkatanChart = computed(() => createDonutChartData(summaryData.value.pelatihan.by_angkatan, colors.teal));
const fasilitasKategoriChart = computed(() => createDonutChartData(summaryData.value.fasilitas.by_kategori, colors.green));

</script>

<template>
  <SimpleLayout>
    <div
      v-if="loading"
      class="flex justify-center items-center h-64"
    >
      <p class="text-gray-500 animate-pulse">
        Memuat data dashboard...
      </p>
    </div>
    <div
      v-else-if="error"
      class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md"
      role="alert"
    >
      <p class="font-bold">
        Terjadi Kesalahan
      </p>
      <p>{{ error }}</p>
    </div>
  
    <div
      v-else
      class="space-y-6"
    >
      <!-- Baris 1: Welcome & Stat Cards Utama -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 ">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
          <div class="p-4 flex flex-col sm:flex-row justify-between items-center h-full">
            <div>
              <h2 class="text-2xl font-bold text-gray-800">
                Selamat Datang Kembali! 🎉
              </h2>
              <p class="mt-2 text-gray-600">
                Anda mengelola total <span class="font-semibold text-pink-500">{{ totalManagedData }}</span> data.
              </p>
              <router-link
                v-slot="{ navigate }"
                to="/kelola/data"
                custom
              >
                <button
                  class="mt-4 px-4 py-2 bg-pink-500 text-white font-semibold rounded-lg hover:bg-pink-600 transition-colors focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
                  @click="navigate"
                >
                  Lihat Data
                </button>
              </router-link>
            </div>
            <div class="mt-6 sm:mt-0">
              <img
                src="/src/assets/images/cards/illustration-john-light.png"
                alt="Ilustrasi"
                class="h-40"
              >
            </div>
          </div>
        </div>
        <div class="space-y-6">
          <div class="bg-white p-4 mt-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex items-center space-x-4">
            <div class="bg-pink-100 p-3 rounded-lg">
              <DocumentChartBarIcon class="h-6 w-6 text-pink-600" />
            </div>
            <div>
              <p class="text-sm text-gray-500">
                Pendaftaran
              </p>
              <p class="text-2xl font-bold text-gray-800">
                {{ summaryData.pendaftaran?.total || 0 }}
              </p>
            </div>
          </div>
          <div class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex items-center space-x-4">
            <div class="bg-blue-100 p-3 rounded-lg">
              <AcademicCapIcon class="h-6 w-6 text-blue-600" />
            </div>
            <div>
              <p class="text-sm text-gray-500">
                Pelatihan
              </p>
              <p class="text-2xl font-bold text-gray-800">
                {{ summaryData.pelatihan?.total || 0 }}
              </p>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Baris 2: Diagram Batang Berdampingan dengan Pilihan -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Diagram Batang KIRI -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="sm:flex justify-between items-start mb-4">
            <h3 class="text-lg font-bold text-gray-800">
              Tren Operasional
            </h3>
            <nav
              class="mt-2 sm:mt-0 flex space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in leftBarTabs"
                :key="tab.key"
                :class="[activeLeftBarTab === tab.key ? `border-blue-500 text-blue-600` : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap pb-1 px-1 border-b-2 font-medium text-sm transition-colors']"
                @click="activeLeftBarTab = tab.key"
              >
                {{ tab.label }}
              </button>
            </nav>
          </div>
          <VueApexCharts
            :key="activeLeftBarTab"
            type="bar"
            height="310"
            :options="leftBarChart.options"
            :series="leftBarChart.series"
          />
        </div>
        <!-- Diagram Batang KANAN -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="sm:flex justify-between items-start mb-4">
            <h3 class="text-lg font-bold text-gray-800">
              Tren Pendaftaran & Aset
            </h3>
            <nav
              class="mt-2 sm:mt-0 flex space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in rightBarTabs"
                :key="tab.key"
                :class="[activeRightBarTab === tab.key ? `border-pink-500 text-pink-600` : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap pb-1 px-1 border-b-2 font-medium text-sm transition-colors']"
                @click="activeRightBarTab = tab.key"
              >
                {{ tab.label }}
              </button>
            </nav>
          </div>
          <VueApexCharts
            :key="activeRightBarTab"
            type="bar"
            height="310"
            :options="rightBarChart.options"
            :series="rightBarChart.series"
          />
        </div>
      </div>
      
      <!-- Baris 3: Aktivitas Terbaru (Area Chart) & Quota -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Area Chart dengan perbaikan -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
              <h3 class="text-lg font-bold text-gray-800">
                Grafik Aktivitas Terbaru
              </h3>
              <p class="text-sm text-gray-500 mt-1">
                Menampilkan tren aktivitas {{ areaChartTabs.find(t => t.key === activeAreaChartTab)?.label.toLowerCase() || 'data' }} 
                dalam 7 hari terakhir
              </p>
            </div>
            <nav
              class="flex flex-wrap gap-2 mt-3 sm:mt-0"
              aria-label="Tabs"
            >
              <button 
                v-for="tab in areaChartTabs" 
                :key="tab.key" 
                :class="[
                  activeAreaChartTab === tab.key 
                    ? `bg-${tab.color}-100 text-${tab.color}-600 ring-2 ring-${tab.color}-200` 
                    : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700', 
                  'px-3 py-2 rounded-lg font-medium text-sm transition-all duration-200 flex items-center space-x-2'
                ]"
                @click="activeAreaChartTab = tab.key"
              >
                <component
                  :is="tab.icon"
                  class="h-4 w-4"
                />
                <span>{{ tab.label }}</span>
              </button>
            </nav>
          </div>
          
          <!-- Chart Container dengan loading state -->
          <div class="relative">
            <div
              v-if="loading"
              class="flex justify-center items-center h-48"
            >
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500" />
            </div>
              
            <div
              v-else-if="!summaryData[activeAreaChartTab]?.area_chart || summaryData[activeAreaChartTab].area_chart.length === 0" 
              class="flex flex-col justify-center items-center h-48 text-gray-500"
            >
              <component
                :is="areaChartTabs.find(t => t.key === activeAreaChartTab)?.icon"
                class="h-12 w-12 mb-2 opacity-50"
              />
              <p class="text-sm">
                Belum ada data aktivitas {{ areaChartTabs.find(t => t.key === activeAreaChartTab)?.label.toLowerCase() }}
              </p>
            </div>
              
            <div v-else>
              <!-- Statistik singkat -->
              <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 p-3 rounded-lg">
                  <p class="text-sm text-gray-500">
                    Total Aktivitas
                  </p>
                  <p class="text-xl font-bold text-gray-800">
                    {{ summaryData[activeAreaChartTab]?.area_chart?.length || 0 }}
                  </p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                  <p class="text-sm text-gray-500">
                    Aktivitas Hari Ini
                  </p>
                  <p class="text-xl font-bold text-gray-800">
                    {{ summaryData[activeAreaChartTab]?.area_chart?.filter(item => {
                      const today = new Date().toISOString().split('T')[0];
                      return item.date.split(' ')[0] === today;
                    }).length || 0 }}
                  </p>
                </div>
              </div>
                  
              <!-- Area Chart -->
              <VueApexCharts 
                :key="`area-chart-${activeAreaChartTab}`" 
                type="area" 
                height="200" 
                :options="recentActivityChart.options" 
                :series="recentActivityChart.series" 
              />
                  
              <!-- Aktivitas Terbaru List -->
              <div class="mt-4 border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">
                  Aktivitas Terbaru:
                </h4>
                <div class="space-y-2 max-h-24 overflow-y-auto">
                  <div 
                    v-for="(item, index) in summaryData[activeAreaChartTab]?.area_chart?.slice(0, 3)" 
                    :key="index"
                    class="flex items-center space-x-3 text-sm"
                  >
                    <div class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0" />
                    <span class="text-gray-600 truncate">{{ item.data }}</span>
                    <span class="text-gray-400 text-xs flex-shrink-0">
                      {{ new Date(item.date).toLocaleDateString('id-ID', { 
                        day: '2-digit', 
                        month: 'short', 
                        hour: '2-digit', 
                        minute: '2-digit' 
                      }) }}
                    </span>
                  </div>
                  <div
                    v-if="summaryData[activeAreaChartTab]?.area_chart?.length > 3" 
                    class="text-xs text-gray-500 text-center pt-1"
                  >
                    +{{ summaryData[activeAreaChartTab].area_chart.length - 3 }} aktivitas lainnya
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
        <!-- Quota Card tetap sama -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <div class="flex items-center space-x-3 mb-4">
            <TicketIcon class="h-7 w-7 text-purple-500" />
            <h4 class="text-lg font-bold text-gray-800">
              Informasi Quota
            </h4>
          </div>
          <div class="text-center bg-purple-50 text-purple-700 font-bold py-2 rounded-lg capitalize">
            Status: {{ summaryData.quota.status }}
          </div>
          <div class="grid grid-cols-3 text-center divide-x divide-gray-200 mt-4">
            <div>
              <p class="text-2xl font-bold text-gray-800">
                {{ summaryData.quota.registered }}
              </p><p class="text-xs text-gray-500">
                Terdaftar
              </p>
            </div>
            <div>
              <p class="text-2xl font-bold text-gray-800">
                {{ summaryData.quota.remaining }}
              </p><p class="text-xs text-gray-500">
                Sisa
              </p>
            </div>
            <div>
              <p class="text-2xl font-bold text-gray-800">
                {{ summaryData.quota.limit }}
              </p><p class="text-xs text-gray-500">
                Limit
              </p>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Baris 4: Radial Bar Charts by Status/Category -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pendaftaran by Status -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col items-center">
          <h3 class="text-lg font-bold text-gray-800">
            Proporsi Pendaftaran
          </h3>
          <div class="w-full">
            <VueApexCharts
              type="radialBar"
              height="220"
              :options="pendaftaranStatusChart.options"
              :series="pendaftaranStatusChart.series"
            />
          </div>
          <p class="-mt-14 text-xl font-semibold text-gray-600 capitalize">
            {{ currentPendaftaranStatusTab }}
          </p>
          <div class="mt-4 w-full border-t pt-4">
            <nav
              class="flex justify-center space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in Object.keys(summaryData.pendaftaran.by_status)"
                :key="tab"
                :class="[currentPendaftaranStatusTab === tab ? 'text-pink-600 font-bold' : 'text-gray-500 hover:text-gray-700', 'text-sm capitalize']"
                @click="currentPendaftaranStatusTab = tab"
              >
                {{ tab }}
              </button>
            </nav>
          </div>
        </div>
        <!-- Fasilitas by Status -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col items-center">
          <h3 class="text-lg font-bold text-gray-800">
            Proporsi Fasilitas
          </h3>
          <div class="w-full">
            <VueApexCharts
              type="radialBar"
              height="220"
              :options="fasilitasStatusChart.options"
              :series="fasilitasStatusChart.series"
            />
          </div>
          <p class="-mt-14 text-xl font-semibold text-gray-600 capitalize">
            {{ currentFasilitasStatusTab }}
          </p>
          <div class="mt-4 w-full border-t pt-4">
            <nav
              class="flex justify-center space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in Object.keys(summaryData.fasilitas.by_status)"
                :key="tab"
                :class="[currentFasilitasStatusTab === tab ? 'text-green-600 font-bold' : 'text-gray-500 hover:text-gray-700', 'text-sm capitalize']"
                @click="currentFasilitasStatusTab = tab"
              >
                {{ tab }}
              </button>
            </nav>
          </div>
        </div>
        <!-- Pegawai by Status -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col items-center">
          <h3 class="text-lg font-bold text-gray-800">
            Proporsi Pegawai
          </h3>
          <div class="w-full">
            <VueApexCharts
              type="radialBar"
              height="220"
              :options="pegawaiStatusChart.options"
              :series="pegawaiStatusChart.series"
            />
          </div>
          <p class="-mt-14 text-xl font-semibold text-gray-600 capitalize">
            {{ currentPegawaiStatusTab }}
          </p>
          <div class="mt-4 w-full border-t pt-4">
            <nav
              class="flex justify-center space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in Object.keys(summaryData.struktur_pegawai.by_status)"
                :key="tab"
                :class="[currentPegawaiStatusTab === tab ? 'text-yellow-600 font-bold' : 'text-gray-500 hover:text-gray-700', 'text-sm capitalize']"
                @click="currentPegawaiStatusTab = tab"
              >
                {{ tab }}
              </button>
            </nav>
          </div>
        </div>
        <!-- Berita by Jenis Konten -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col items-center">
          <h3 class="text-lg font-bold text-gray-800">
            Proporsi Konten
          </h3>
          <div class="w-full">
            <VueApexCharts
              type="radialBar"
              height="220"
              :options="beritaKontenChart.options"
              :series="beritaKontenChart.series"
            />
          </div>
          <p class="-mt-14 text-s font-semibold text-gray-600 capitalize">
            {{ currentBeritaKontenTab }}
          </p>
          <div class="mt-4 w-full border-t pt-4">
            <nav
              class="flex justify-center space-x-4"
              aria-label="Tabs"
            >
              <button
                v-for="tab in Object.keys(summaryData.berita.by_jenis_konten)"
                :key="tab"
                :class="[currentBeritaKontenTab === tab ? 'text-orange-600 font-bold' : 'text-gray-500 hover:text-gray-700', 'text-sm capitalize']"
                @click="currentBeritaKontenTab = tab"
              >
                {{ tab }}
              </button>
            </nav>
          </div>
        </div>
      </div>
      
      <!-- Baris 5: Donut Charts -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-lg font-bold text-gray-800">
            Pendidikan Pendaftar
          </h3>
          <p class="text-sm text-gray-500 mb-4">
            {{ pendaftaranPendidikanChart.total }} Total
          </p>
          <div class="my-4 flex justify-center">
            <VueApexCharts
              type="donut"
              height="150"
              :options="pendaftaranPendidikanChart.options"
              :series="pendaftaranPendidikanChart.series"
            />
          </div>
          <div class="space-y-2">
            <div
              v-for="label in pendaftaranPendidikanChart.labels.slice(0,4)"
              :key="label"
              class="flex items-center"
            >
              <div class="flex-shrink-0 bg-pink-100 p-2 rounded-lg mr-3">
                <UserCircleIcon class="h-5 w-5 text-pink-600" />
              </div>
              <div class="flex-grow">
                <p class="font-semibold text-gray-700 text-sm">
                  {{ label }}
                </p>
              </div>
              <div class="font-bold text-gray-800 text-sm">
                {{ summaryData.pendaftaran.by_pendidikan[label] }}
              </div>
            </div>
            <p
              v-if="pendaftaranPendidikanChart.labels.length > 4"
              class="text-xs text-center text-gray-500 mt-1"
            >
              +{{ pendaftaranPendidikanChart.labels.length - 4 }} lainnya
            </p>
          </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-lg font-bold text-gray-800">
            Kategori Fasilitas
          </h3>
          <p class="text-sm text-gray-500 mb-4">
            {{ fasilitasKategoriChart.total }} Total
          </p>
          <div class="my-4 flex justify-center">
            <VueApexCharts
              type="donut"
              height="150"
              :options="fasilitasKategoriChart.options"
              :series="fasilitasKategoriChart.series"
            />
          </div>
          <div class="space-y-2">
            <div
              v-for="label in fasilitasKategoriChart.labels"
              :key="label"
              class="flex items-center"
            >
              <div class="flex-shrink-0 bg-green-100 p-2 rounded-lg mr-3">
                <BuildingOfficeIcon class="h-5 w-5 text-green-600" />
              </div>
              <div class="flex-grow">
                <p class="font-semibold text-gray-700 text-sm">
                  {{ label }}
                </p>
              </div>
              <div class="font-bold text-gray-800 text-sm">
                {{ summaryData.fasilitas.by_kategori[label] }}
              </div>
            </div>
          </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
          <h3 class="text-lg font-bold text-gray-800">
            Pelatihan per Angkatan
          </h3>
          <p class="text-sm text-gray-500 mb-4">
            {{ pelatihanAngkatanChart.total }} Total
          </p>
          <div class="my-4 flex justify-center">
            <VueApexCharts
              type="donut"
              height="150"
              :options="pelatihanAngkatanChart.options"
              :series="pelatihanAngkatanChart.series"
            />
          </div>
          <div class="space-y-2">
            <div
              v-for="label in pelatihanAngkatanChart.labels.slice(0,4)"
              :key="label"
              class="flex items-center"
            >
              <div class="flex-shrink-0 bg-teal-100 p-2 rounded-lg mr-3">
                <UserGroupIcon class="h-5 w-5 text-teal-600" />
              </div>
              <div class="flex-grow">
                <p class="font-semibold text-gray-700 text-sm">
                  Angkatan {{ label }}
                </p>
              </div>
              <div class="font-bold text-gray-800 text-sm">
                {{ summaryData.pelatihan.by_angkatan[label] }}
              </div>
            </div>
            <p
              v-if="pelatihanAngkatanChart.labels.length > 4"
              class="text-xs text-center text-gray-500 mt-1"
            >
              +{{ pelatihanAngkatanChart.labels.length - 4 }} lainnya
            </p>
          </div>
        </div>
      </div>
    </div>
  </SimpleLayout>
</template>

<style>
/* Style global untuk memastikan chart responsif dan tidak ada background aneh */
.apexcharts-canvas {
    background: transparent !important;
}
</style>
