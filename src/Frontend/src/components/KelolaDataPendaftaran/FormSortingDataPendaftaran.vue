<template>
  <!-- Menggunakan <transition> untuk animasi fade-in/fade-out saat form dibuka/ditutup secara manual -->
  <transition name="fade">
    <!-- Kontainer utama yang akan ditampilkan/disembunyikan -->
    <div v-if="visible" class="form-overlay-wrapper">
      <!-- Overlay gelap di belakang form -->
      <div class="overlay" @click.self="closeForm"></div>

      <!-- Kontainer form utama -->
      <div class="sorting-form-container p-6 rounded-xl shadow-2xl bg-white max-w-md font-inter">
        <!-- Tombol tutup form di pojok kanan atas -->
        <button @click="closeForm" class="close-button text-gray-500 hover:text-gray-700 transition-colors duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Pengurutan Data</h2>

        <el-form
          :model="form"
          label-position="top"
          class="space-y-6 text-base"
        >
          <el-form-item label="Kolom Data">
            <el-select
              v-model="form.column"
              placeholder="Pilih kolom yang akan diurutkan"
              class="w-full custom-select"
              filterable
              clearable
              size="large"
            >
              <el-option
                v-for="col in columns"
                :key="col"
                :label="formatLabel(col)"
                :value="col"
              />
            </el-select>
          </el-form-item>

          <el-form-item label="Arah Pengurutan">
            <el-radio-group
              v-model="form.order"
              class="flex flex-col gap-3 mt-1 text-gray-700 custom-radio-group"
              size="large"
            >
              <el-radio :value="'asc'">
                <span class="font-medium">Naik</span> (A-Z / 0-9 / Terlama)
              </el-radio>
              <el-radio :value="'desc'">
                <span class="font-medium">Turun</span> (Z-A / 9-0 / Terbaru)
              </el-radio>
            </el-radio-group>
          </el-form-item>
        </el-form>

        <div class="flex justify-end gap-3 pt-6 border-t mt-8">
          <el-button
            @click="cancelSort"
            class="px-5 py-2 rounded-lg font-semibold text-gray-800 custom-cancel-button transition-all duration-300 ease-in-out border border-transparent"
          >
            Batal
          </el-button>
          <el-button
            type="primary"
            @click="applySort"
            class="px-5 py-2 rounded-lg font-semibold text-white transition-all duration-300 ease-in-out custom-apply-button"
          >
            Terapkan
          </el-button>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
/* Transisi fade untuk overlay dan form */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Wrapper untuk overlay dan form, memastikan posisi tetap */
.form-overlay-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999; /* Z-index lebih rendah dari form, tapi di atas konten lain */
}

/* Overlay gelap */
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Warna gelap dengan transparansi */
  z-index: 998; /* Z-index di bawah form tapi di atas konten */
}

/* Kontainer utama formulir */
.sorting-form-container {
  position: relative; /* Penting untuk posisi tombol close */
  z-index: 1000; /* Pastikan form muncul di atas overlay */

  /* Warna latar belakang putih, bayangan, dan sudut membulat */
  background-color: #ffffff;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.18);
  border-radius: 16px;
  /* Padding internal */
  padding: 24px;

  /* --- Tambahan untuk Animasi Saat Halaman Dimuat/Direfresh --- */
  /* Animasi ini akan berjalan saat komponen 'mounted' dan 'visible' adalah true */
  animation: slideInFromBottom 0.5s ease-out forwards;
}

/* --- Keyframes untuk Animasi "slideInFromBottom" --- */
@keyframes slideInFromBottom {
  0% {
    opacity: 0;
    transform: translateY(20px); /* Mulai dari 20px di bawah posisi akhir */
  }
  100% {
    opacity: 1;
    transform: translateY(0); /* Berakhir di posisi aslinya */
  }
}

/* Tombol tutup form */
.close-button {
  position: absolute;
  top: 16px;
  right: 16px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  line-height: 1;
}

/* Judul formulir */
.sorting-form-container h2 {
  font-weight: 700;
  color: #333333;
  margin-bottom: 24px;
  padding-bottom: 16px;
  border-bottom: 1px solid #f0f0f0;
}

/* Item form */
.el-form-item {
  margin-bottom: 0; /* Menghilangkan margin bawah default item form */
}

/* Radio button yang terpilih */
.el-radio__input.is-checked + .el-radio__label {
  color: #333333 !important; /* Warna teks label saat radio button terpilih */
}
.el-radio__input.is-checked .el-radio__inner {
  /* Warna background dan border radio button saat terpilih */
  background-color: #FF5E93 !important; /* Warna pink #FF5E93 */
  border-color: #FF5E93 !important; /* Warna pink #FF5E93 */
}
.el-radio__inner:hover {
  /* Warna border radio button saat hover */
  border-color: #FF5E93 !important; /* Warna pink #FF5E93 */
}
.el-radio:hover .el-radio__inner {
  /* Warna border radio button saat hover */
  border-color: #FF5E93 !important; /* Warna pink #FF5E93 */
}

/* Input select */
.el-select .el-input__wrapper {
  border-radius: 10px !important; /* Sudut membulat */
  padding: 10px 14px !important; /* Padding internal */
  transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Transisi halus */
}
.el-select .el-input__wrapper.is-focused {
  /* Warna border dan shadow saat input select fokus */
  border-color: #FF5E93 !important; /* Warna pink #FF5E93 */
  box-shadow: 0 0 0 4px rgba(255, 94, 147, 0.2) !important; /* Warna pink #FF5E93 dengan opacity */
}
.el-select .el-input__inner {
  font-size: 1.05rem !important; /* Ukuran font input */
}
.el-select .el-select__caret {
  color: #999; /* Warna ikon panah */
  transition: color 0.3s ease-in-out; /* Transisi halus */
}
.el-select .el-select__caret.is-reverse {
  /* Warna ikon panah saat terbalik (dropdown terbuka) */
  color: #FF5E93; /* Warna pink #FF5E93 */
}

/* Tombol Terapkan (Apply) */
.custom-apply-button {
  background-color: #FF5E93; /* Warna pink #FF5E93 */
  border-color: #FF5E93; /* Warna pink #FF5E93 */
  box-shadow: 0 4px 10px rgba(255, 94, 147, 0.3); /* Bayangan dengan warna pink */
}
.custom-apply-button:hover {
  background-color: rgba(255, 94, 147, 0.9); /* Sedikit lebih transparan saat hover */
  border-color: rgba(255, 94, 147, 0.9);
  box-shadow: 0 6px 15px rgba(255, 94, 147, 0.4); /* Bayangan lebih besar saat hover */
  transform: translateY(-1px); /* Efek sedikit terangkat */
}
.custom-apply-button:active {
  background-color: #FF5E93; /* Kembali ke warna asli saat diklik */
  box-shadow: 0 2px 5px rgba(255, 94, 147, 0.2); /* Bayangan lebih kecil saat aktif */
  transform: translateY(0); /* Kembali ke posisi semula */
}

/* Tombol Batal (Cancel) */
.custom-cancel-button {
  color: #ff5d92; /* Warna teks pink #ff5d92 */
  background-color: transparent; /* Latar belakang transparan */
}
.custom-cancel-button:hover {
  background-color: rgba(255, 93, 146, 0.08); /* Latar belakang pink transparan saat hover */
  border-color: rgba(255, 93, 146, 0.3); /* Border pink transparan saat hover */
  color: #ff5d92; /* Warna teks pink */
}
.custom-cancel-button:active {
  background-color: rgba(255, 93, 146, 0.15); /* Latar belakang pink transparan lebih gelap saat aktif */
  border-color: rgba(255, 93, 146, 0.4); /* Border pink transparan lebih gelap saat aktif */
}

/* Dropdown untuk select (opsi pilihan) */
.el-select-dropdown {
  border-radius: 10px !important; /* Sudut membulat */
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important; /* Bayangan */
  padding: 8px 0 !important; /* Padding internal */
}
.el-select-dropdown__item {
  font-size: 1rem !important; /* Ukuran font */
  padding: 10px 20px !important; /* Padding internal */
  transition: background-color 0.2s ease-in-out; /* Transisi halus */
}
.el-select-dropdown__item.hover {
  /* Warna background item dropdown saat hover */
  background-color: rgba(255, 94, 147, 0.1) !important; /* Warna pink #FF5E93 dengan opacity */
  color: #333; /* Warna teks */
}
.el-select-dropdown__item.selected {
  /* Warna teks dan background item dropdown saat terpilih */
  color: #FF5E93 !important; /* Warna pink #FF5E93 */
  font-weight: 600; /* Tebal */
  background-color: rgba(255, 94, 147, 0.15) !important; /* Warna pink #FF5E93 dengan opacity */
}
</style>

<script setup lang="ts">
import { reactive } from 'vue';

const props = defineProps<{
  visible: boolean;   // Prop untuk mengontrol visibilitas form
  columns: string[]; // Daftar kolom yang tersedia untuk diurutkan
  data: any[];       // Data yang akan diurutkan
}>();

const emits = defineEmits<{
  // Event yang dipancarkan ketika pengurutan diterapkan
  (e: 'apply-sort', payload: { column: string; order: 'asc' | 'desc' }): void;
  // Event yang dipancarkan ketika tombol batal diklik (untuk memberikan notifikasi ke komponen parent)
  (e: 'cancel-sort'): void;
  // Event yang dipancarkan ketika visibilitas form berubah
  (e: 'update:visible', value: boolean): void;
}>();

// Objek reaktif untuk menyimpan pilihan form
const form = reactive({
  column: '', // Kolom yang dipilih untuk pengurutan
  order: 'asc' as 'asc' | 'desc', // Arah pengurutan (asc/desc)
});

// Fungsi untuk memformat label kolom (misal: "nama_lengkap" menjadi "Nama Lengkap")
function formatLabel(key: string): string {
  return key
    .split('_') // Pisahkan string berdasarkan underscore
    .map(w => w.charAt(0).toUpperCase() + w.slice(1)) // Kapitalisasi huruf pertama setiap kata
    .join(' '); // Gabungkan kembali dengan spasi
}

// Fungsi untuk menutup form
function closeForm(): void {
  emits('update:visible', false); // Memancarkan event untuk menyembunyikan form
}

// Fungsi untuk menerapkan pengurutan data
function applySort(): void {
  // Pastikan kolom pengurutan telah dipilih
  if (!form.column) {
    console.warn("Kolom pengurutan belum dipilih.");
    return;
  }

  // Mengurutkan data berdasarkan kolom dan arah yang dipilih
  props.data.sort((a, b) => {
    const valueA = a[form.column];
    const valueB = b[form.column]?.toString(); // Pastikan valueB adalah string untuk localeCompare

    // Memeriksa apakah nilai adalah tanggal atau angka untuk pengurutan yang benar
    const isDate = !isNaN(Date.parse(valueA)) && !isNaN(Date.parse(valueB));
    const isNumber = !isNaN(parseFloat(valueA)) && !isNaN(parseFloat(valueB));

    if (isDate) {
      // Pengurutan tanggal
      return form.order === 'asc'
        ? new Date(valueA).getTime() - new Date(valueB).getTime()
        : new Date(valueB).getTime() - new Date(valueA).getTime();
    } else if (isNumber) {
      // Pengurutan angka
      return form.order === 'asc'
        ? parseFloat(valueA) - parseFloat(valueB)
        : parseFloat(valueB) - parseFloat(valueA);
    } else {
      // Pengurutan string menggunakan localeCompare untuk penanganan bahasa yang tepat
      return form.order === 'asc'
        ? String(valueA).localeCompare(String(valueB))
        : String(valueB).localeCompare(String(valueA));
    }
  });

  // Memancarkan event 'apply-sort' dengan detail pengurutan
  emits('apply-sort', { column: form.column, order: form.order });
  closeForm(); // Tutup form setelah pengurutan diterapkan
}

// Fungsi untuk menangani pembatalan pengurutan
function cancelSort(): void {
  // Memancarkan event 'cancel-sort'
  emits('cancel-sort');
  form.column = ''; // Reset kolom
  form.order = 'asc'; // Reset arah
  closeForm(); // Tutup form
}
</script>
