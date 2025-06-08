<template>
    <DefaultLayout>
        <Slider></Slider>
        <div class="text-center p-3 fw-bold text-secondary">LAYANAN</div>
        <div class="d-flex flex-md-row flex-column">
            <button v-if="isOperator">operator</button>
            <button v-if="isPegawai">Pegawai</button>
            <button v-if="isNotLogin">tidak login</button>
            <Layanan1 v-if="isOperator"></Layanan1>
            <Layanan1 v-if="isPegawai"></Layanan1>
            <Layanan2 v-if="isNotLogin"></Layanan2>
        </div>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import Slider from '../../components/Home/Slider.vue';
import Layanan1 from '../../components/Home/Layanan1.vue';
import Layanan2 from '../../components/Home/Layanan2.vue';
import Layanan3 from '../../components/Home/Layanan3.vue';

import { computed } from 'vue'

function getUserRole() {
  return localStorage.getItem('role') || ''
}

const isOperator = computed(() => getUserRole() === 'operator')
const isPegawai = computed(() => getUserRole() === 'pegawai')
const isMasyarakat = computed(() => getUserRole() === 'masyarakat')
const isNotLogin = computed(() => {
  const role = getUserRole()
  return role !== 'operator' && role !== 'pegawai' && role !== 'masyarakat'
})

</script>