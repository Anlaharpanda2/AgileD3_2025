<template>
  <div class="layout">
    <Header />
    <!-- <SideBar /> -->
    <main class="layout-content">
      <slot /> 
    </main>
    
    <Footer /> 
  </div>
</template>

<script setup>
import Header from '@/components/layouts/Header.vue'
import Footer from '@/components/layouts/Footer.vue'
</script>

<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.layout-content {
  flex: 1;
}
</style>
