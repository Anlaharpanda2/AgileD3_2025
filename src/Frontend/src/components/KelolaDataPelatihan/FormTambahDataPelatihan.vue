<template>
  <div class="form-overlay">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Form Data Pelatihan</h3>
        </div>

        <div class="form-body">
          <el-form
            :model="form"
            :rules="rules"
            ref="formRef"
            label-width="140px"
            label-position="top"
            class="p-4"
          >
            <el-row :gutter="20">
              <el-col
                v-for="field in fields"
                :key="field.key"
                :span="24"
                :md="12"
                class="mb-3"
              >
                <el-form-item
                  :label="field.label"
                  :prop="field.key"
                >
                  <component
                    :is="field.component"
                    v-model="form[field.key]"
                    :type="field.type"
                    :placeholder="field.label"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="form-control"
                    v-if="field.component !== 'el-select'"
                  />
                  <el-select
                    v-else-if="field.key === 'status'"
                    v-model="form.status"
                    placeholder="Pilih Status"
                    :id="field.key"
                    :name="field.key"
                    clearable
                    class="w-100 form-control-select"
                  >
                    <el-option
                      v-for="option in statusOptions"
                      :key="option"
                      :label="capitalize(option)"
                      :value="option"
                    />
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>

            <el-form-item class="d-flex justify-content-end gap-3 mt-4">
              <el-button @click="$emit('close')" class="btn-cancel">Batal</el-button>
              <el-button type="primary" @click="submitForm" class="btn-submit">Simpan</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
/* Latar belakang gelap untuk overlay */
.form-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px); /* Efek blur yang lebih kuat */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}

/* Kontainer popup form */
.form-popup {
  width: 100%;
  max-width: 900px; /* Sedikit lebih lebar untuk modernitas */
  max-height: 95vh;
  background: linear-gradient(145deg, #ffffff, #f0f2f5); /* Gradien lembut */
  border-radius: 1.25rem; /* Sudut lebih membulat */
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.5) inset; /* Bayangan lebih dalam dengan inner shadow */
  display: flex;
  flex-direction: column;
  animation: popupIn 0.4s ease-out; /* Animasi sedikit lebih lambat */
  overflow: hidden;
  transform: scale(1); /* Pastikan skala awal adalah 1 */
  transition: transform 0.3s ease-out; /* Transisi untuk skala saat interaksi */
}

/* Header form */
.form-header {
  background: linear-gradient(45deg, #69C5C2, #4CAF50); /* Gradien hijau yang menarik */
  color: white;
  padding: 1.5rem; /* Padding lebih banyak */
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
  font-weight: 600; /* Tebal sedikit */
  letter-spacing: 0.5px; /* Spasi huruf */
}

/* Bagian isi form scrollable */
.form-body {
  overflow-y: auto;
  padding: 2rem; /* Padding lebih banyak */
}

/* Styling untuk el-input dan el-date-picker */
.form-control {
  width: 100%;
  border-radius: 0.5rem; /* Sudut membulat */
  border: 1px solid #e0e0e0;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Bayangan dalam lembut */
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus-within {
  border-color: #69C5C2;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.05); /* Bayangan fokus yang modern */
}

/* Styling khusus untuk el-select */
.form-control-select .el-input__wrapper {
  border-radius: 0.5rem !important; /* Sudut membulat */
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
  transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
}

.form-control-select.is-focus .el-input__wrapper {
  border-color: #69C5C2 !important;
  box-shadow: 0 0 0 3px rgba(105, 197, 194, 0.25), inset 0 1px 3px rgba(0, 0, 0, 0.05) !important;
}

/* Tombol Submit */
.btn-submit {
  background: linear-gradient(45deg, #69C5C2, #4CAF50); /* Gradien yang sama dengan header */
  border: none;
  color: white;
  padding: 0.75rem 2rem; /* Padding lebih besar */
  border-radius: 0.75rem; /* Sudut lebih membulat */
  font-weight: 600;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3); /* Bayangan yang serasi */
  transition: all 0.3s ease;
}
.btn-submit:hover {
  background: linear-gradient(45deg, #4CAF50, #69C5C2); /* Gradien terbalik saat hover */
  box-shadow: 0 6px 15px rgba(76, 175, 80, 0.45); /* Bayangan lebih kuat */
  transform: translateY(-2px); /* Efek angkat */
}
.btn-submit:active {
  transform: translateY(0); /* Kembali ke posisi semula saat diklik */
  box-shadow: 0 2px 5px rgba(76, 175, 80, 0.2);
}

/* Tombol Batal */
.btn-cancel {
  background-color: #f0f2f5; /* Warna latar belakang abu-abu terang */
  color: #555;
  padding: 0.75rem 2rem;
  border-radius: 0.75rem;
  font-weight: 500;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}
.btn-cancel:hover {
  background-color: #e0e0e0;
  color: #333;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  transform: translateY(-2px);
}
.btn-cancel:active {
  transform: translateY(0);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

/* Animasi masuk */
@keyframes popupIn {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.9);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
</style>

<script setup>
import { reactive, ref, watch, onMounted } from 'vue'
import { ElNotification } from 'element-plus'
import api from '../../api.js'; // Mengimpor instance axios dari api.js Anda

const props = defineProps({
  initialData: Object, // Prop untuk data awal saat melakukan edit
})

const emit = defineEmits(['close']) // Emit event 'close' saat form ditutup

const formRef = ref(null) // Ref untuk instance form Element Plus

const statusOptions = ['kawin', 'lajang', 'janda'] // Pilihan untuk dropdown status

// Definisi bidang-bidang form
const fields = [
  { key: 'nama', label: 'Nama', component: 'el-input', type: 'text' },
  { key: 'nik', label: 'NIK', component: 'el-input', type: 'text' },
  { key: 'jenis_bimtek', label: 'Jenis Bimtek', component: 'el-input', type: 'text' },
  { key: 'kegiatan_dimulai', label: 'Kegiatan Dimulai', component: 'el-date-picker', type: 'date' },
  { key: 'kegiatan_berakhir', label: 'Kegiatan Berakhir', component: 'el-date-picker', type: 'date' },
  { key: 'tempat_kegiatan', label: 'Tempat Kegiatan', component: 'el-input', type: 'text' },
  { key: 'angkatan', label: 'Angkatan', component: 'el-input', type: 'number' },
  { key: 'tempat_tanggal_lahir', label: 'Tempat Tanggal Lahir', component: 'el-input', type: 'text' },
  { key: 'pendidikan', label: 'Pendidikan', component: 'el-input', type: 'text' },
  { key: 'status', label: 'Status', component: 'el-select', type: '' },
  { key: 'alamat', label: 'Alamat', component: 'el-input', type: 'textarea' },
  { key: 'jenis_usaha', label: 'Jenis Usaha', component: 'el-input', type: 'text' },
  { key: 'penghasilan_perbulan', label: 'Penghasilan Perbulan', component: 'el-input', type: 'text' },
  { key: 'nomor_telefon', label: 'Nomor Telefon', component: 'el-input', type: 'tel' },
]

// Objek form reaktif dengan nilai default
const form = reactive({
  nik: '',
  nama: '',
  jenis_bimtek: '',
  kegiatan_dimulai: null,
  kegiatan_berakhir: null,
  tempat_kegiatan: '',
  angkatan: null,
  tempat_tanggal_lahir: '',
  pendidikan: '',
  status: '',
  alamat: '',
  jenis_usaha: '',
  penghasilan_perbulan: '',
  nomor_telefon: '',
})

// Fungsi untuk mengaplikasikan data awal ke form dan mengkonversi tipe data
const applyInitialData = (data) => {
  if (data) {
    Object.assign(form, data); // Salin semua properti dari data awal ke form

    // Konversi string tanggal menjadi objek Date untuk el-date-picker
    if (form.kegiatan_dimulai && typeof form.kegiatan_dimulai === 'string') {
      form.kegiatan_dimulai = new Date(form.kegiatan_dimulai);
    }
    if (form.kegiatan_berakhir && typeof form.kegiatan_berakhir === 'string') {
      form.kegiatan_berakhir = new Date(form.kegiatan_berakhir);
    }
    // Konversi string angkatan menjadi number
    if (form.angkatan !== null && typeof form.angkatan === 'string') {
      form.angkatan = Number(form.angkatan);
    }
  }
};

// Mengaplikasikan data awal saat komponen dimuat pertama kali
// Menggunakan watch dengan immediate: true untuk menangani inisialisasi awal
// dan juga perubahan prop initialData
watch(() => props.initialData, (newVal) => {
  applyInitialData(newVal);
}, { deep: true, immediate: true });


// Aturan validasi form
const rules = {
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  jenis_bimtek: [{ required: true, message: 'Jenis bimtek wajib diisi', trigger: 'blur' }],
  kegiatan_dimulai: [{ type: 'date', required: true, message: 'Tanggal Mulai Kegiatan wajib diisi', trigger: 'change' }],
  kegiatan_berakhir: [{ type: 'date', required: true, message: 'Tanggal Berakhir Kegiatan wajib diisi', trigger: 'change' }],
  tempat_kegiatan: [{ required: true, message: 'Tempat wajib diisi', trigger: 'blur' }],
  angkatan: [
    { required: true, message: 'Angkatan wajib diisi', trigger: 'change' },
    {
      validator: (rule, value, callback) => {
        const number = Number(value)
        if (value === '' || value === null || value === undefined) {
          callback(new Error('Angkatan wajib diisi'));
        } else if (isNaN(number)) {
          callback(new Error('Angkatan harus berupa angka'));
        } else if (number <= 0) {
          callback(new Error('Angkatan harus lebih besar dari 0'));
        } else {
          callback();
        }
      },
      trigger: 'blur',
    },
  ],

  tempat_tanggal_lahir: [{ required: true, message: 'Tempat tanggal lahir wajib diisi', trigger: 'blur' }],
  pendidikan: [{ required: true, message: 'Pendidikan wajib diisi', trigger: 'blur' }],
  status: [{ required: true, message: 'Status wajib diisi', trigger: 'change' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  jenis_usaha: [{ required: true, message: 'Jenis usaha wajib diisi', trigger: 'blur' }],
  penghasilan_perbulan: [{ required: true, message: 'Penghasilan wajib diisi', trigger: 'blur' }],
  nomor_telefon: [{ required: true, message: 'Nomor telepon wajib diisi', trigger: 'blur' }],
}

// Fungsi helper untuk mengkapitalisasi string
const capitalize = s => s.charAt(0).toUpperCase() + s.slice(1)

// Fungsi untuk submit form
const submitForm = () => {
  formRef.value.validate(async valid => {
    if (!valid) {
      ElNotification({ title: 'Validasi gagal', message: 'Periksa input form Anda.', type: 'warning' });
      return;
    }

    // build payload
    const payload = {
      ...form,
      kegiatan_dimulai: form.kegiatan_dimulai instanceof Date
        ? form.kegiatan_dimulai.toISOString().slice(0, 10)
        : form.kegiatan_dimulai,
      kegiatan_berakhir: form.kegiatan_berakhir instanceof Date
        ? form.kegiatan_berakhir.toISOString().slice(0, 10)
        : form.kegiatan_berakhir,
      angkatan: Number(form.angkatan),
    };

    try {
      console.log('Kirim JSON:', JSON.stringify(payload));

      // Menggunakan instance `api` yang diimpor dari '../../api.js'
      // Route POST disesuaikan menjadi '/api/kelola/pelatihan'
      const response = await api.post('/kelola/pelatihan', payload);

      // Memeriksa status HTTP (2xx untuk sukses)
      if (response.status >= 190 && response.status < 300) {
        ElNotification({
          title: 'Berhasil',
          message: response.data.message || 'Data berhasil disimpan!', // Ambil pesan dari response.data.message
          type: 'success',
          duration: 3000,
        });
        emit('close'); // Tutup form setelah berhasil
      } else {
        // Jika status bukan 2xx, anggap sebagai kegagalan meskipun request sukses
        ElNotification({
          title: 'Gagal',
          message: response.data.message || 'Gagal menyimpan data karena kesalahan server.', // Ambil pesan dari response.data.message
          type: 'error',
          duration: 0, // Tampilkan selamanya sampai ditutup manual
        });
      }
    } catch (error) {
      console.error('Error submitting form:', error);
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menyimpan data. Terjadi kesalahan jaringan atau server.', // Ambil pesan dari error.response.data.message
        type: 'error',
        duration: 0, // Tampilkan selamanya sampai ditutup manual
      });
    }
  });
};
</script>