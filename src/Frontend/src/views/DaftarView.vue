<template>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
      <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Pendaftaran</h3>
        <form @submit.prevent="handleSubmit">
          <div class="mb-3">
            <label for="nik" class="form-label">NIK</label>
            <input
              v-model="nik"
              type="text"
              class="form-control"
              id="nik"
              placeholder="Masukkan NIK"
              required
            />
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Nama Lengkap</label>
            <input
              v-model="username"
              type="text"
              class="form-control"
              id="username"
              placeholder="Masukkan Nama Lengkap"
              required
            />
          </div>
          <button type="submit" class="btn btn-primary w-100">Daftar</button>
  
          <div v-if="error" class="alert alert-danger mt-3" role="alert">
            {{ error }}
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  
  const nik = ref('')
  const username = ref('')
  const error = ref('')
  
  const handleSubmit = async () => {
    error.value = ''
    
    // Cek NIK melalui RapidAPI
    try {
      const response = await axios.post('http://localhost:8000/api/cek-nik', {
        no: nik.value
      })
      
      if (response.data.isValid) {  // Periksa apakah NIK valid
        // Jika NIK valid, kirim data ke backend untuk disimpan
        await axios.post('http://localhost:8000/api/pendaftar', {
          nik: nik.value,
          nama: username.value
        })
        alert('Pendaftaran berhasil!')
      } else {
        error.value = 'NIK tidak valid.'
      }
    } catch (err) {
      error.value = 'Terjadi kesalahan saat verifikasi NIK.'
    }
  }
  </script>
  
  <style scoped>
  body {
    background-color: #f8f9fa;
  }
  </style>
  