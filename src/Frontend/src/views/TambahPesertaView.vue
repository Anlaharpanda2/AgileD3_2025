<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api.js'

const router = useRouter()
const successMessage = ref('')
const errorMessage = ref('')
const loading = ref(false)

const form = ref({
  nik: '',
  peserta: '',
  tempat_tanggal_lahir: '',
  jenis_kelamin: '',
  alamat: '',
  pendidikan: '',
  pekerjaan: '',
  email: '',
  pelatihan: '',
  tanggal_mulai: '',
  tanggal_selesai: '',
  tempat_pelatihan: '',
})

const validateForm = () => {
  if (!form.value.nik || !form.value.peserta || !form.value.email) {
    return false
  }

  if (new Date(form.value.tanggal_selesai) < new Date(form.value.tanggal_mulai)) {
    errorMessage.value = '❌ Tanggal selesai tidak boleh sebelum tanggal mulai'
    return false
  }

  return true
}

const submit = async () => {
  errorMessage.value = ''

  if (!validateForm()) {
    return
  }

  loading.value = true
  try {
    const tanggal_pelatihan = `${form.value.tanggal_mulai} - ${form.value.tanggal_selesai}`

    const payload = {
      ...form.value,
      tanggal_pelatihan,
    }

    delete payload.tanggal_mulai
    delete payload.tanggal_selesai

    const response = await api.post('/peserta', payload)

    if (response.data) {
      successMessage.value = '✅ Data berhasil disimpan!'

      form.value = {
        nik: '',
        peserta: '',
        tempat_tanggal_lahir: '',
        jenis_kelamin: '',
        alamat: '',
        pendidikan: '',
        pekerjaan: '',
        email: '',
        pelatihan: '',
        tanggal_mulai: '',
        tanggal_selesai: '',
        tempat_pelatihan: '',
      }

      setTimeout(() => {
        router.push('/peserta')
      }, 1500)
    }
  } catch (e) {
    console.error('Gagal menyimpan:', e)
    errorMessage.value = e.response?.data?.message || '❌ Gagal menyimpan data. Silakan coba lagi.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="page">
    <h1>➕ Tambah Peserta</h1>
    <button class="back-btn" @click="router.push('/peserta')">⬅️ Kembali</button>

    <div v-if="successMessage" class="message success">{{ successMessage }}</div>
    <div v-if="errorMessage" class="message error">{{ errorMessage }}</div>

    <form @submit.prevent="submit" class="form">
      <input v-model="form.nik" placeholder="NIK" required maxlength="16" />
      <input v-model="form.peserta" placeholder="Nama Peserta" required />
      <input v-model="form.tempat_tanggal_lahir" placeholder="Tempat, Tanggal Lahir" required />
      <select v-model="form.jenis_kelamin" required>
        <option disabled value="">Pilih Jenis Kelamin</option>
        <option>Laki-laki</option>
        <option>Perempuan</option>
      </select>
      <textarea v-model="form.alamat" placeholder="Alamat" required rows="3"></textarea>
      <input v-model="form.pendidikan" placeholder="Pendidikan Terakhir" required />
      <input v-model="form.pekerjaan" placeholder="Pekerjaan" required />
      <input v-model="form.email" placeholder="Email" required type="email" />
      <input v-model="form.pelatihan" placeholder="Pelatihan Yang Diikuti" required />

      <label>Tanggal Pelatihan</label>
      <div class="date-range">
        <input v-model="form.tanggal_mulai" type="date" required />
        <span>s/d</span>
        <input v-model="form.tanggal_selesai" type="date" required />
      </div>

      <input v-model="form.tempat_pelatihan" placeholder="Tempat Pelatihan" required />

      <button type="submit" :disabled="loading">
        <span v-if="loading">⏳ Menyimpan...</span>
        <span v-else>💾 Simpan</span>
      </button>
    </form>
  </div>
</template>

<style scoped>
.page {
  padding: 40px;
  background: #fff0f0;
  min-height: 100vh;
}

h1 {
  margin-bottom: 20px;
}

.back-btn {
  background-color: #ffb5a7;
  border: none;
  color: white;
  padding: 10px 15px;
  margin-bottom: 20px;
  cursor: pointer;
  border-radius: 8px;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

input,
select,
textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background: #e6f0ff;
}

.date-range {
  display: flex;
  align-items: center;
  gap: 10px;
}

button[type="submit"] {
  background-color: #8ecae6;
  border: none;
  color: white;
  padding: 12px;
  cursor: pointer;
  border-radius: 8px;
  margin-top: 10px;
}

button[type="submit"]:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.message {
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}

.success {
  background: #d3f9d8;
  color: #1b5e20;
}

.error {
  background: #ffebee;
  color: #c62828;
}
</style>
