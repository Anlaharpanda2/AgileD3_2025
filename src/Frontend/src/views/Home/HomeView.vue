<script setup lang="ts">
import { onMounted } from 'vue'
import { useRouter } from 'vue-router'
import AOS from 'aos'
import 'aos/dist/aos.css' 
import SimpleLayout from '../../layouts/SimpleLayout.vue'
import Lokasi from '@/components/Home/LokasiPeta.vue'
import HomePengumuman from '../../components/Home/HomePengumuman.vue'
import LayananUtama from '../../components/Home/LayananUtama.vue'
import TentangKami from '../../components/Home/TentangKami.vue'
import BeritaTerbaru from '../../components/Home/BeritaTerbaru.vue'
import Kontak from '@/components/Home/KontakKami.vue'
import MainContent from '../../components/Home/MainContent.vue'
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const router = useRouter()
onMounted(() => {
  AOS.init({
    duration: 800, 
    easing: 'ease-in-out', 
    once: true, 
    offset: 100, 
    delay: 0 
  })
})
</script>
<template>
  <SimpleLayout>
    <MainContent />
    <!-- Layanan Utama -->
    <LayananUtama />
    <!-- Tentang Kami -->
    <TentangKami />
    <!-- Bagian Berita Terbaru (menggunakan komponen BeritaTerbaru) -->
    <BeritaTerbaru />
    <!-- Bagian Pengumuman dan Lokasi -->
    <section class="announcements-locations-section">
      <div class="container">
        <ElRow :gutter="32">
          <ElCol
            :xs="24"
            :lg="12"
            class="mb-4 lg:mb-0"
          >
            <div class="announcement-content h-[700px]">
              <HomePengumuman />
            </div>
          </ElCol>
          <ElCol
            :xs="24"
            :lg="12"
          >
            <div class="location-content h-[700px]">
              <Lokasi />
            </div>
          </ElCol>
        </ElRow>
      </div>
    </section>
    <!-- Bagian Kontak (menggunakan komponen Kontak yang dipisahkan) -->
    <Kontak />
  </SimpleLayout>
</template>
<style scoped>


.announcements-locations-section {
  padding: 2rem 0;
  background: #fafafa;
}
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}
.announcement-content,
.location-content {
  transform: scale(0.95);
  font-size: 0.875rem;
  padding-left: 2.5rem;
  padding-right: 2.5rem;
}



@media (max-width: 1024px) {
  .announcements-locations-section {
    padding: 4rem 0;
  }
  .container {
    padding: 0 1.5rem;
  }
}
@media (max-width: 768px) {
  .announcements-locations-section .container {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
  .announcement-content,
  .location-content {
    transform: scale(1);
    font-size: 1rem;
    padding-left: 1rem;
    padding-right: 1rem;
  }
}
</style>
