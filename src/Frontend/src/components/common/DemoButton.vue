<template>
  <button
    v-if="isDevelopmentMode"
    type="button"
    class="px-4 py-2 bg-stone-700 text-white font-semibold rounded-lg hover:bg-stone-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-stone-500 transition-colors duration-300 shadow-md"
    @click="$emit('fill-data')"
  >
    <slot>Demo</slot>
  </button>
</template>

<script setup>
import { computed } from 'vue';

// Emit event untuk memberitahu parent component agar mengisi data
defineEmits(['fill-data']);

// Tombol ini hanya akan muncul jika mode bukan 'production'
const isDevelopmentMode = computed(() => import.meta.env.MODE !== 'production');
</script>

<style scoped>
/* Styling tambahan jika diperlukan */
</style>
