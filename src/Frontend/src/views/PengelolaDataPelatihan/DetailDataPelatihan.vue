<template>
  <DefaultLayout2 >
  <div class="detail-page">
    <div class="hero-section">
      <div class="hero-background"></div>
      <div class="hero-content">
        <div class="back-button-container">
          <button @click="goBack" class="back-button">
            <i class="el-icon-arrow-left"></i>
            <span>Kembali</span>
          </button>
        </div>
        <h1 class="page-title">Detail Peserta Pelatihan</h1>
        <p class="page-subtitle">Informasi lengkap data peserta</p>
      </div>
    </div>

    <div class="main-content">
      <div class="content-wrapper">
        <template v-if="pesertaData">
          <!-- Profile Card -->
          <div class="profile-card">
            <div class="profile-header">
              <div class="profile-photo-container">
                <div class="photo-wrapper" @click="triggerFileInput">
                  <el-avatar :size="120" class="profile-avatar">
                    <img
                      :src="pesertaData.photo_url || '/table/profile.svg'"
                      alt="Foto Peserta"
                      class="peserta-photo"
                      @error="handleImageError"
                    />
                  </el-avatar>
                  <div class="photo-hover-overlay">
                    <img src="/table/updatedetail.svg" alt="Edit foto" class="edit-icon" />
                  </div>
                </div>
                <input type="file" ref="fileInput" accept="image/*" class="hidden" @change="uploadPhoto" />
              </div>
              
              <div class="profile-info">
                <h2 class="profile-name">{{ pesertaData.nama }}</h2>
                <p class="profile-nik">NIK: {{ pesertaData.nik }}</p>
                <div class="profile-badges">
                  <span class="badge badge-primary">{{ pesertaData.jenis_bimtek }}</span>
                  <span class="badge badge-secondary">Angkatan {{ pesertaData.angkatan }}</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Information Cards -->
          <div class="info-grid">
            <!-- Informasi Pelatihan -->
            <div class="info-card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="el-icon-reading"></i>
                  Informasi Pelatihan
                </h3>
              </div>
              <div class="card-content">
                <div class="info-item">
                  <span class="info-label">Jenis Pelatihan</span>
                  <span class="info-value">{{ pesertaData.jenis_bimtek }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Angkatan</span>
                  <span class="info-value">{{ pesertaData.angkatan }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Mulai Kegiatan</span>
                  <span class="info-value">{{ pesertaData.kegiatan_dimulai }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Berakhir</span>
                  <span class="info-value">{{ pesertaData.kegiatan_berakhir }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Tempat Kegiatan</span>
                  <span class="info-value">{{ pesertaData.tempat_kegiatan }}</span>
                </div>
              </div>
            </div>

            <!-- Data Pribadi -->
            <div class="info-card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="el-icon-user"></i>
                  Data Pribadi
                </h3>
              </div>
              <div class="card-content">
                <div class="info-item">
                  <span class="info-label">Tempat, Tanggal Lahir</span>
                  <span class="info-value">{{ pesertaData.tempat_tanggal_lahir }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Pendidikan</span>
                  <span class="info-value">{{ pesertaData.pendidikan }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Status</span>
                  <span class="info-value status-badge" :class="getStatusClass(pesertaData.status)">
                    {{ pesertaData.status }}
                  </span>
                </div>
                <div class="info-item">
                  <span class="info-label">Nomor Telepon</span>
                  <span class="info-value">{{ pesertaData.nomor_telefon }}</span>
                </div>
                <div class="info-item full-width">
                  <span class="info-label">Alamat</span>
                  <span class="info-value">{{ pesertaData.alamat }}</span>
                </div>
              </div>
            </div>

            <!-- Informasi Usaha -->
            <div class="info-card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="el-icon-office-building"></i>
                  Informasi Usaha
                </h3>
              </div>
              <div class="card-content">
                <div class="info-item">
                  <span class="info-label">Jenis Usaha</span>
                  <span class="info-value">{{ pesertaData.jenis_usaha }}</span>
                </div>
                <div class="info-item">
                  <span class="info-label">Penghasilan/Bulan</span>
                  <span class="info-value income-value">{{ pesertaData.penghasilan_perbulan }}</span>
                </div>
              </div>
            </div>

            <!-- Metadata -->
            <div class="info-card" v-if="pesertaData.created_at || pesertaData.updated_at">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="el-icon-time"></i>
                  Informasi Sistem
                </h3>
              </div>
              <div class="card-content">
                <div class="info-item" v-if="pesertaData.created_at">
                  <span class="info-label">Dibuat Pada</span>
                  <span class="info-value">{{ formatDate(pesertaData.created_at) }}</span>
                </div>
                <div class="info-item" v-if="pesertaData.updated_at">
                  <span class="info-label">Diperbarui Pada</span>
                  <span class="info-value">{{ formatDate(pesertaData.updated_at) }}</span>
                </div>
              </div>
            </div>
          </div>
        </template>

        <template v-else>
          <div class="loading-section">
            <div class="loading-spinner">
              <div class="spinner"></div>
            </div>
            <p class="loading-text">Memuat data peserta...</p>
          </div>
        </template>
      </div>
    </div>
  </div>
  </DefaultLayout2>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import api from '../../api'
import DefaultLayout2 from "../../layouts/DefaultLayout2.vue";

interface Peserta {
  id: number
  nama: string
  nik: string
  jenis_bimtek: string
  kegiatan_dimulai: string
  kegiatan_berakhir: string
  tempat_kegiatan: string
  angkatan: number
  tempat_tanggal_lahir: string
  pendidikan: string
  status: 'kawin' | 'lajang' | 'janda'
  alamat: string
  jenis_usaha: string
  penghasilan_perbulan: string
  nomor_telefon: string
  created_at?: string
  updated_at?: string
  photo?: string
  photo_url?: string
}

const route = useRoute()
const router = useRouter()
const pesertaData = ref<Peserta | null>(null)
const fileInput = ref<HTMLInputElement | null>(null)
const uploading = ref(false)

onMounted(async () => {
  try {
    const id = route.params.id
    const res = await api.get(`/peserta/${id}`)
    pesertaData.value = res.data
    console.log('Data peserta:', res.data)
  } catch (err) {
    console.error('Gagal memuat data peserta:', err)
  }
})

const goBack = () => {
  router.push('/data/pelatihan')
}

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement
  img.src = '/table/profile.svg'
  img.alt = 'Foto tidak tersedia'
}

const triggerFileInput = () => {
  fileInput.value?.click()
}

const getStatusClass = (status: string) => {
  const statusMap: { [key: string]: string } = {
    'kawin': 'status-married',
    'lajang': 'status-single',
    'janda': 'status-widow'
  }
  return statusMap[status] || 'status-default'
}

const formatDate = (dateString: string) => {
  if (!dateString) return '-'
  return new Date(dateString).toLocaleDateString('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

const uploadPhoto = async (event: Event) => {
  const input = event.target as HTMLInputElement
  const file = input.files?.[0]

  if (!file) {
    ElMessage.error('File tidak ditemukan.')
    return
  }

  // Validasi ukuran file (maksimal 5MB)
  if (file.size > 5 * 1024 * 1024) {
    ElMessage.error('Ukuran file terlalu besar. Maksimal 5MB.')
    return
  }

  // Validasi tipe file
  const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']
  if (!allowedTypes.includes(file.type)) {
    ElMessage.error('Format file harus JPEG, PNG, JPG, atau WebP.')
    return
  }

  uploading.value = true

  const formData = new FormData()
  formData.append('photo', file)
  formData.append('_method', 'PATCH')

  try {
    const id = pesertaData.value?.id
    const res = await api.post(`/peserta/${id}/ubah-foto`, formData)

    ElMessage.success('Foto berhasil diperbarui')
    
    if (res?.data?.data?.photo_url) {
      pesertaData.value!.photo_url = res.data.data.photo_url
    } else if (res?.data?.photo_url) {
      pesertaData.value!.photo_url = res.data.photo_url
    } else {
      const refreshRes = await api.get(`/peserta/${id}`)
      pesertaData.value = refreshRes.data
    }
    
    input.value = ''
  } catch (err: any) {
    console.error('Upload error:', err)
    const errorMsg = err.response?.data?.message || 'Gagal mengunggah foto.'
    ElMessage.error(errorMsg)
  } finally {
    uploading.value = false
  }
}
</script>

<style scoped>
/* Global Styles */
* {
  box-sizing: border-box;
}

.detail-page {
  min-height: 100vh;
  background: #ffffff;
  position: relative;
}

/* Hero Section */
.hero-section {
  position: relative;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: linear-gradient(135deg, #69C5C2 0%, #5bb8b5 100%);
}

.hero-background {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: transparent;
}

.hero-background::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-image: 
    radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
    radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.hero-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: white;
  width: 100%;
}

.back-button-container {
  padding: 20px;
  position: absolute;
  top: -60px;
  left: 20px;
  z-index: 3;
}

.back-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255, 255, 255, 0.9);
  color: #69C5C2;
  border: none;
  padding: 10px 16px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.back-button:hover {
  background: white;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}

.back-button i {
  font-size: 1.1rem;
}

.page-title {
  font-size: 2.5rem;
  font-weight: 700;
  margin: 0 0 8px 0;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.page-subtitle {
  font-size: 1.1rem;
  margin: 0;
  opacity: 0.9;
  font-weight: 300;
}

/* Main Content */
.main-content {
  position: relative;
  z-index: 1;
  margin-top: -50px;
  background: #f8f9fa;
  min-height: calc(100vh - 150px);
}

.content-wrapper {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px 40px;
}

/* Profile Card */
.profile-card {
  background: white;
  border-radius: 20px;
  padding: 30px;
  margin-bottom: 30px;
  box-shadow: 0 8px 25px rgba(43, 108, 106, 0.207);
  border: 2px solid rgba(105, 197, 194, 0.1);
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 30px;
}

.profile-photo-container {
  position: relative;
}

.photo-wrapper {
  position: relative;
  display: inline-block;
}

.profile-avatar {
  border: 4px solid #69C5C2;
  box-shadow: 0 8px 25px rgba(105, 197, 194, 0.2);
  transition: all 0.3s ease;
}

.profile-avatar:hover {
  transform: scale(1.05);
  box-shadow: 0 12px 35px rgba(105, 197, 194, 0.3);
}

.photo-wrapper:hover .photo-hover-overlay {
  opacity: 1;
}

.photo-hover-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(105, 197, 194, 0.8);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: all 0.3s ease;
  cursor: pointer;
}

.edit-icon {
  width: 40px;
  height: 40px;
  filter: invert(1);
  transition: transform 0.3s ease;
}

.photo-hover-overlay:hover .edit-icon {
  transform: scale(1.1);
}

.peserta-photo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.profile-info {
  flex: 1;
}

.profile-name {
  font-size: 2rem;
  font-weight: 700;
  color: #2c3e50;
  margin: 0 0 8px 0;
}

.profile-nik {
  font-size: 1.1rem;
  color: #6c757d;
  margin: 0 0 15px 0;
  font-weight: 500;
}

.profile-badges {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}

.badge {
  padding: 8px 16px;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  text-transform: capitalize;
}

.badge-primary {
  background: #69C5C2;
  color: white;
}

.badge-secondary {
  background: rgba(105, 197, 194, 0.1);
  color: #69C5C2;
  border: 1px solid rgba(105, 197, 194, 0.3);
}

/* Info Grid */
.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 25px;
}

.info-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(53, 95, 93, 0.382);
  transition: all 0.3s ease;
  border: 1px solid rgba(105, 197, 194, 0.1);
}

.info-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(105, 197, 194, 0.15);
  border-color: rgba(105, 197, 194, 0.2);
}

.card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, rgba(105, 197, 194, 0.05) 100%);
  padding: 20px 25px;
  border-bottom: 1px solid rgba(105, 197, 194, 0.1);
}

.card-title {
  margin: 0;
  font-size: 1.2rem;
  font-weight: 600;
  color: #495057;
  display: flex;
  align-items: center;
  gap: 10px;
}

.card-title i {
  font-size: 1.3rem;
  color: #69C5C2;
}

.card-content {
  padding: 25px;
}

.info-item {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid rgba(105, 197, 194, 0.1);
}

.info-item:last-child {
  margin-bottom: 0;
  padding-bottom: 0;
  border-bottom: none;
}

.info-item.full-width {
  flex-direction: column;
  gap: 8px;
}

.info-label {
  font-weight: 600;
  color: #69C5C2;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  min-width: 140px;
}

.info-value {
  font-weight: 500;
  color: #2c3e50;
  text-align: right;
  flex: 1;
}

.full-width .info-value {
  text-align: left;
}

.status-badge {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: capitalize;
}

.status-married {
  background: rgba(105, 197, 194, 0.1);
  color: #69C5C2;
}

.status-single {
  background: rgba(40, 167, 69, 0.1);
  color: #28a745;
}

.status-widow {
  background: rgba(220, 53, 69, 0.1);
  color: #dc3545;
}

.income-value {
  font-weight: 700;
  color: #69C5C2;
  font-size: 1.1em;
}

/* Loading */
.loading-section {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 400px;
  background: white;
  border-radius: 20px;
  margin: 20px;
  box-shadow: 0 8px 25px rgba(105, 197, 194, 0.1);
  border: 2px solid rgba(105, 197, 194, 0.1);
}

.loading-spinner {
  margin-bottom: 20px;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 4px solid rgba(105, 197, 194, 0.1);
  border-top: 4px solid #69C5C2;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.loading-text {
  color: #6c757d;
  font-size: 1.1rem;
  margin: 0;
}

.hidden {
  display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
  
  .back-button-container {
    top: -50px;
    left: 15px;
  }
  
  .back-button {
    padding: 8px 12px;
    font-size: 0.8rem;
  }
  
  .profile-header {
    flex-direction: column;
    text-align: center;
    gap: 20px;
  }
  
  .profile-name {
    font-size: 1.5rem;
  }
  
  .info-grid {
    grid-template-columns: 1fr;
  }
  
  .info-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 6px;
  }
  
  .info-label {
    min-width: unset;
  }
  
  .info-value {
    text-align: left;
  }
  
  .content-wrapper {
    padding: 0 15px 30px;
  }
}

@media (max-width: 480px) {
  .hero-section {
    height: 150px;
  }
  
  .page-title {
    font-size: 1.5rem;
  }
  
  .page-subtitle {
    font-size: 0.9rem;
  }
  
  .back-button-container {
    top: -40px;
    left: 10px;
  }
  
  .profile-card {
    padding: 20px;
  }
  
  .card-content {
    padding: 20px;
  }
}
</style>