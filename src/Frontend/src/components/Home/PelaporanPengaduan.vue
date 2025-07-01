<template>
  <div class="form-overlay">
    <transition name="popup">
      <div class="form-popup">
        <div class="form-header background text-center text-white py-3 rounded-top">
          <h3 class="mb-0">Formulir Data Pengaduan</h3>
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
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="NIK" prop="nik" required>
                  <el-input v-model="form.nik" placeholder="Masukkan NIK" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Nama" prop="nama" required>
                  <el-input v-model="form.nama" placeholder="Masukkan Nama" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Jenis Kelamin" prop="jenis_kelamin" required>
                  <el-select v-model="form.jenis_kelamin" placeholder="Pilih Jenis Kelamin" clearable>
                    <el-option label="Laki-laki" value="Laki-laki" />
                    <el-option label="Perempuan" value="Perempuan" />
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Umur" prop="umur" required>
                  <el-input-number v-model="form.umur" :min="0" placeholder="Umur" style="width: 100%;" />
                </el-form-item>
              </el-col>
              <el-col :span="24" class="mb-3">
                <el-form-item label="Alamat" prop="alamat" required>
                  <el-input v-model="form.alamat" type="textarea" placeholder="Masukkan Alamat" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Nomor HP" prop="no_hp" required>
                  <el-input v-model="form.no_hp" placeholder="Masukkan Nomor HP" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Jenis Kasus" prop="jenis_kasus" required>
                  <el-input v-model="form.jenis_kasus" placeholder="Masukkan Jenis Kasus" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Kasus" prop="kasus">
                  <el-input v-model="form.kasus" placeholder="Masukkan Kasus (opsional)" />
                </el-form-item>
              </el-col>
              <el-col :span="24" class="mb-3">
                <el-form-item label="Deskripsi Laporan" prop="deskripsi_laporan" required>
                  <el-input v-model="form.deskripsi_laporan" type="textarea" placeholder="Deskripsi Laporan" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Waktu Kejadian" prop="waktu_kejadian" required>
                  <el-date-picker
                    v-model="form.waktu_kejadian"
                    type="datetime"
                    placeholder="Pilih Waktu Kejadian"
                    style="width: 100%;"
                  />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Nama Korban" prop="nama_korban">
                  <el-input v-model="form.nama_korban" placeholder="Nama Korban (opsional)" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Saksi" prop="saksi">
                  <el-input v-model="form.saksi" placeholder="Saksi (opsional)" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Jenis Pengaduan" prop="jenis_pengaduan" required>
                  <el-select v-model="form.jenis_pengaduan" placeholder="Pilih Jenis Pengaduan" clearable>
                    <el-option label="langsung" value="langsung" />
                    <el-option label="tidak langsung" value="tidak langsung" />
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Lampiran" prop="lampiran">
                  <input type="file" @change="onFileChange" />
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="12" class="mb-3">
                <el-form-item label="Tanggal Pengaduan" prop="tanggal_pengaduan">
                  <el-date-picker
                    v-model="form.tanggal_pengaduan"
                    type="date"
                    placeholder="Pilih Tanggal Pengaduan"
                    style="width: 100%;"
                  />
                </el-form-item>
              </el-col>
            </el-row>
            <el-form-item class="d-flex justify-content-end gap-3 mt-4">
              <el-button @click="$emit('close')" class="btn-cancel">Batal</el-button>
              <el-button type="primary" @click="submitForm" class="btn-submit">Kirim</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import api from '../../api.js'
import { ElNotification } from 'element-plus'

const emit = defineEmits(['close'])
const formRef = ref(null)

const form = reactive({
  nik: '',
  nama: '',
  jenis_kelamin: '',
  umur: null,
  alamat: '',
  no_hp: '',
  jenis_kasus: '',
  kasus: '',
  deskripsi_laporan: '',
  waktu_kejadian: null,
  nama_korban: '',
  saksi: '',
  jenis_pengaduan: '',
  lampiran: null,
  tanggal_pengaduan: null,
})

const rules = {
  nik: [{ required: true, message: 'NIK wajib diisi', trigger: 'blur' }],
  nama: [{ required: true, message: 'Nama wajib diisi', trigger: 'blur' }],
  jenis_kelamin: [{ required: true, message: 'Jenis kelamin wajib diisi', trigger: 'change' }],
  umur: [{ required: true, message: 'Umur wajib diisi', trigger: 'blur' }],
  alamat: [{ required: true, message: 'Alamat wajib diisi', trigger: 'blur' }],
  no_hp: [{ required: true, message: 'Nomor HP wajib diisi', trigger: 'blur' }],
  jenis_kasus: [{ required: true, message: 'Jenis kasus wajib diisi', trigger: 'blur' }],
  deskripsi_laporan: [{ required: true, message: 'Deskripsi wajib diisi', trigger: 'blur' }],
  waktu_kejadian: [{ type: 'date', required: true, message: 'Waktu kejadian wajib diisi', trigger: 'change' }],
  jenis_pengaduan: [{ required: true, message: 'Jenis pengaduan wajib diisi', trigger: 'change' }],
}

function onFileChange(e) {
  form.lampiran = e.target.files[0]
}

function formatDateTime(dt) {
  if (!dt) return ''
  const d = new Date(dt)
  const pad = n => n.toString().padStart(2, '0')
  return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`
}
function formatDate(dt) {
  if (!dt) return ''
  const d = new Date(dt)
  const pad = n => n.toString().padStart(2, '0')
  return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`
}

function submitForm() {
  formRef.value.validate(async valid => {
    if (!valid) {
      ElNotification({
        title: 'Validasi gagal',
        message: 'Periksa input form anda.',
        type: 'warning',
        duration: 3000,
      })
      return
    }

    try {
      const formData = new FormData()
      Object.keys(form).forEach(key => {
        if (form[key]) {
          if (key === 'waktu_kejadian') {
            formData.append(key, formatDateTime(form[key]))
          } else if (key === 'tanggal_pengaduan') {
            formData.append(key, formatDate(form[key]))
          } else {
            formData.append(key, form[key])
          }
        }
      })

      const response = await api.post('/pengaduan', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })

      ElNotification({
        title: 'Berhasil',
        message: response.data.message || 'Data berhasil disimpan',
        type: 'success',
        duration: 3000,
      })

      emit('close')
      window.location.reload()
    } catch (error) {
      ElNotification({
        title: 'Gagal',
        message: error.response?.data?.message || 'Gagal menyimpan data',
        type: 'error',
        duration: 0,
      })
    }
  })
}
</script>

<style scoped>
.background{
    background: #69C5C2;
}
.form-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(2px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
  padding: 1rem;
}
.form-popup {
  width: 100%;
  max-width: 850px;
  max-height: 95vh;
  background-color: #ffffff;
  border-radius: 1rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  animation: popupIn 0.3s ease;
  overflow: hidden;
}
.form-body {
  overflow-y: auto;
  padding: 1rem;
}
.btn-submit {
  background-color: #69C5C2;
  border: none;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-submit:hover {
  background-color: #1e8e86;
}
.btn-cancel {
  background-color: #eeeeee;
  color: #333;
  padding: 0.5rem 1.2rem;
  border-radius: 6px;
  transition: background-color 0.2s ease;
}
.btn-cancel:hover {
  background-color: #dddddd;
}
@keyframes popupIn {
  from {
    opacity: 0;
    transform: scale(0.92);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>