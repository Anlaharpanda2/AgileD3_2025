<template>
  <SimpleLayout>
    <div class="container mx-auto p-4">
      <PretestList />
      <PosttestList />
    </div>
  </SimpleLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
const userRole = ref(localStorage.getItem('role') || '');
const isOperator = computed(() => userRole.value === 'operator');
import PretestList from '@/components/KelolaDataTest/PretestList.vue';
import PosttestList from '@/components/KelolaDataTest/PosttestList.vue';
import SimpleLayout from '@/layouts/SimpleLayout.vue';
</script>
