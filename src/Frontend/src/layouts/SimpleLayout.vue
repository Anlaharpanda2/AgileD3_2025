<template>
  <div class="layout">
    <TheHeader />
    <!-- <SideBar /> -->
    <main class="layout-content">
      <slot /> 
    </main>
    <TheFooter /> 
  </div>
</template>

<script setup>
import TheHeader from '@/components/Layouts/TheHeader.vue';
import TheFooter from '@/components/Layouts/TheFooter.vue';
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
