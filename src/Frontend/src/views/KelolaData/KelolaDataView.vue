<template>
    <DefaultLayout>
    <div class="no-padding-container">
    <div class="dashboard-container">
    <!-- Header Section -->
    <div class="hero-section">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-8">
            <h1 class="hero-title">
              <el-icon class="hero-icon"><Management /></el-icon>
              Kelola Data
            </h1>
            <p class="hero-subtitle">
              Kelola semua aspek sistem dengan mudah dan efisien
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Cards Section -->
    <div class="cards-section">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div 
            v-for="(card, index) in crudCards" 
            :key="index"
            class="col-xl-4 col-lg-6 col-md-6"
          >
            <div 
              class="crud-card"
              @click="navigateToRoute(card.route)"
            >
              <div class="card-header">
                <div class="icon-container">
                  <el-icon class="card-icon">
                    <component :is="card.icon" />
                  </el-icon>
                </div>
                <div class="card-stats">
                  <span class="stats-number">{{ card.count }}</span>
                  <span class="stats-label">Items</span>
                </div>
              </div>
              
              <div class="card-body">
                <h3 class="card-title">{{ card.title }}</h3>
                <p class="card-description">{{ card.description }}</p>
                
                <div class="card-features">
                  <div class="feature-item" v-for="feature in card.features" :key="feature">
                    <el-icon class="feature-icon"><Check /></el-icon>
                    <span>{{ feature }}</span>
                  </div>
                </div>
              </div>
              
              <div class="card-footer">
                <div class="action-buttons">
                  <el-button 
                    type="primary" 
                    class="btn-show-data"
                    @click.stop="navigateToRoute(card.route)"
                  >
                    <el-icon><View /></el-icon>
                    Tampilkan Data
                  </el-button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
    </DefaultLayout>
</template>

<script setup lang="ts">
import DefaultLayout from '../../layouts/DefaultLayout.vue'
import { ref, computed } from 'vue'
import { 
  Management, 
  Edit, 
  View, 
  Check, 
  ArrowRight, 
  DataAnalysis, 
  Files, 
  User, 
  Trophy,
  Document,
  ChatLineRound,
  Service,
  UserFilled,
  OfficeBuilding,
  Promotion
} from '@element-plus/icons-vue'

// Gunakan array ref untuk card data
const crudCards = ref([
  {
    title: 'Pengelola Berita & Pengumuman',
    description: 'Kelola semua berita dan pengumuman untuk website dan aplikasi',
    icon: Document,
    route: '#',
    count: 42,
    features: ['Publikasi Berita', 'Jadwal Posting', 'Media Upload']
  },
  {
    title: 'Pengelola Pengaduan',
    description: 'Sistem manajemen pengaduan masyarakat yang terintegrasi',
    icon: ChatLineRound,
    route: '#',
    count: 28,
    features: ['Tracking Status', 'Respon Otomatis', 'Laporan Analitik']
  },
  {
    title: 'Pengelola Konsultasi',
    description: 'Platform konsultasi online untuk layanan masyarakat',
    icon: Service,
    route: '#',
    count: 35,
    features: ['Jadwal Konsultasi', 'Video Call', 'History Konsultasi']
  },
  {
    title: 'Pengelola Data Panitia Kegiatan',
    description: 'Manajemen data dan struktur panitia untuk berbagai kegiatan',
    icon: UserFilled,
    route: '#',
    count: 15,
    features: ['Struktur Panitia', 'Tugas & Wewenang', 'Evaluasi Kinerja']
  },
  {
    title: 'Pengelola Fasilitas',
    description: 'Sistem pengelolaan dan pemeliharaan fasilitas organisasi',
    icon: OfficeBuilding,
    route: '#',
    count: 67,
    features: ['Inventarisasi', 'Jadwal Maintenance', 'Booking Fasilitas']
  },
  {
    title: 'Pengelola Struktur Pegawai',
    description: 'Manajemen data pegawai dan struktur organisasi',
    icon: Promotion,
    route: '#',
    count: 124,
    features: ['Data Pegawai', 'Struktur Organisasi', 'Mutasi & Promosi']
  }
])

const totalItems = computed(() => {
  return crudCards.value.reduce((total, card) => total + card.count, 0)
})

const activeUsers = ref(89)

const navigateToRoute = (route: string) => {
  console.log('Navigating to:', route)
  // router.push(route) jika menggunakan useRouter()
}

const viewDetails = (card: { title: string }) => {
  console.log('Viewing details for:', card.title)
}
</script>


<style scoped>
.no-padding-container {
  margin: -20px;
}
.dashboard-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #b4f0ee 100%);
  overflow-x: hidden;
}

/* Hero Section */
.hero-section {
  background: linear-gradient(135deg, #ffa7c4 0%, #ff92b6 100%);
  color: white;
  padding: 4rem 0 3rem;
  margin-bottom: 3rem;
  position: relative;
}

.hero-section::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 30px;
  background: linear-gradient(135deg, transparent 49%, #ffffff 50%);
}

.hero-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hero-icon {
  font-size: 3.5rem;
  margin-right: 1rem;
  vertical-align: middle;
}

.hero-subtitle {
  font-size: 1.25rem;
  opacity: 0.9;
  font-weight: 300;
}

/* Cards Section */
.cards-section {
  padding: 2rem 0 4rem;
}


.crud-card {
animation: fadeInUp 0.6s ease forwards;
  position: relative;
  background: white;
  border-radius: 20px;
  padding: 0;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition:
    transform 0.4s ease,
    box-shadow 0.4s ease;
  cursor: pointer;
  overflow: hidden;
  border: none;
  height: 100%;
  min-height: 400px;
  display: flex;
  flex-direction: column;
  z-index: 1;
  will-change: transform, box-shadow;
  transform: translateY(0); 
}

.crud-card::before {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, #ffffff 0%, #e0fffd 100%);
  opacity: 0;
  transition: opacity 0.4s ease, transform 0.4s ease;
  z-index: 0;
}

/* Konten tetap di atas overlay */
.crud-card > * {
  position: relative;
  z-index: 1;
}

.crud-card:hover {
  transform: translateY(-10px) scale(1.015);
  box-shadow: 0 25px 50px rgba(105, 197, 194, 0.35);
  z-index: 5;
}


.crud-card:hover::before {
  opacity: 1;
}

.card-header {
  padding: 2rem 2rem 1rem;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.icon-container {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, #69C5C2 0%, #5ab3b0 100%);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 8px 16px rgba(105, 197, 194, 0.3);
}

.card-icon {
  font-size: 2.5rem;
  color: white;
}

.card-stats {
  text-align: right;
}

.stats-number {
  display: block;
  font-size: 2rem;
  font-weight: 700;
  color: #69C5C2;
  line-height: 1;
}

.stats-label {
  font-size: 0.875rem;
  color: #6c757d;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.card-body {
  padding: 0 2rem 1rem;
  flex: 1;
}

.card-title {
  font-size: 1.5rem;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 0.75rem;
  line-height: 1.3;
}

.card-description {
  color: #6c757d;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
}
.feature-item {
  display: flex;
  align-items: center;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
  color: #495057;
}

.feature-icon {
  color: #69C5C2;
  margin-right: 0.5rem;
  font-size: 1rem;
}

.card-footer {
  padding: 0 2rem 2rem;
  margin-top: auto;
}

.action-buttons {
  display: flex;
  gap: 0.75rem;
}

.btn-show-data {
  width: 100%;
  background: linear-gradient(135deg, #69C5C2 0%, #5ab3b0 100%);
  border: none;
  border-radius: 12px;
  padding: 0.75rem 1rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-show-data:hover {
  background: linear-gradient(135deg, #5ab3b0 0%, #4da6a3 100%);
  transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2rem;
  }
  
  .hero-icon {
    font-size: 2.5rem;
  }
  
  .crud-card {
    min-height: 350px;
  }
  
  .card-header {
    padding: 1.5rem 1.5rem 1rem;
  }
  
  .card-body {
    padding: 0 1.5rem 1rem;
    flex: 1;
  }
  
  .card-footer {
    padding: 0 1.5rem 1.5rem;
  }
  
  .icon-container {
    width: 60px;
    height: 60px;
  }
  
  .card-icon {
    font-size: 2rem;
  }
  
  .action-buttons {
    width: 100%;
  }
}

@media (max-width: 576px) {
  .hero-section {
    padding: 2rem 0;
  }
  
  .cards-section {
    padding: 1rem 0 2rem;
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    /* HAPUS transform agar tidak bentrok */
  }
  to {
    opacity: 1;
    /* transform: none */
  }
}


.crud-card {
  animation: fadeInUp 0.6s ease forwards;
}

.crud-card:nth-child(1) { animation-delay: 0.1s; }
.crud-card:nth-child(2) { animation-delay: 0.2s; }
.crud-card:nth-child(3) { animation-delay: 0.3s; }
.crud-card:nth-child(4) { animation-delay: 0.4s; }
.crud-card:nth-child(5) { animation-delay: 0.5s; }
.crud-card:nth-child(6) { animation-delay: 0.6s; }
</style>