<template>
  <div class="overlay">
    <div class="dialog">
      <p>Yakin ingin menghapus {{ items.length }} data secara permanen?</p>
      <button @click="$emit('confirm')">Ya, Hapus</button>
      <button @click="$emit('cancel')">Batal</button>
    </div>
  </div>
</template>
<script setup lang="ts">
defineProps<{ items: any[] }>()
</script>
