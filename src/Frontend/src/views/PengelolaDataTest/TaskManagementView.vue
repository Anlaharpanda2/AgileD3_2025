<template>
  <Layout2>
    <div class="container mx-auto p-4">
      <h2 class="text-2xl font-bold mb-4">Pretest Management</h2>
      <PretestList />

      <h2 class="text-2xl font-bold mt-8 mb-4">Posttest Management</h2>
      <PosttestList />
    </div>
  </Layout2>
</template>

<script setup lang="ts">
import PretestList from '@/components/KelolaDataTest/PretestList.vue';
import PosttestList from '@/components/KelolaDataTest/PosttestList.vue';
import Layout2 from '@/layouts/Layout2.vue';
</script>
