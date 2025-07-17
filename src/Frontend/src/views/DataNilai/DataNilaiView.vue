<template>
  <SimpleLayout>
    <CombinedScoreTable />
  </SimpleLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
const userRole = ref(localStorage.getItem('role') || '');
const isOperator = computed(() => userRole.value === 'operator');
import CombinedScoreTable from '@/components/DataNilai/CombinedScoreTable.vue';
import SimpleLayout from '@/layouts/SimpleLayout.vue';
</script>
