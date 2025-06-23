<template>
  <div class="layout">
    <Header /> 
    <NavBar />
    <main class="layout-content">
      <slot /> 
    </main>
    
    <Footer /> 
  </div>
</template>

<script setup>
import Header from '@/components/layouts/Header.vue'
import Footer from '@/components/layouts/Footer.vue'
import NavBar from '@/components/layouts/NavBar.vue'
</script>

<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.layout-content {
  background-color: #ffffff;
  flex: 1;
  padding: 20px;
}
</style>
