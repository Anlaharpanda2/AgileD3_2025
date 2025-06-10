<template>
  <div class="layout">
    <Header /> 
    <main class="layout-content">
      <slot /> 
    </main>
    
    <Footer /> 
  </div>
</template>

<script setup>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
</script>

<style scoped>
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
.layout-content {
  flex: 1;
  padding: 20px;
}
</style>
