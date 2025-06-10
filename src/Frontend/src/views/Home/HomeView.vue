<template>
    <DefaultLayout>
        <Slider></Slider>
        <div class="text-center p-3 fw-bold text-secondary">LAYANAN</div>
        <!-- ini conth nya aja -->
        <div class="col-1 mx-auto">
          <el-button type="primary" v-if="isOperator">Operator</el-button>
          <el-button type="primary" v-if="isPegawai">Pegawai</el-button>
          <el-button type="primary" v-if="isMasyarakat">Masyarakat</el-button>
          <el-button type="primary" v-if="isNotLogin">kalau ndak login</el-button>
        </div>

        <div class="d-flex flex-md-row flex-column">
            <Layanan1></Layanan1>
            <Layanan2></Layanan2>
            <Layanan3></Layanan3>
        </div>
    </DefaultLayout>
</template>

<script setup>
import { computed } from 'vue'
import DefaultLayout from '../../layouts/DefaultLayout.vue';
import Slider from '../../components/Home/Slider.vue';
import Layanan1 from '../../components/Home/Layanan1.vue';
import Layanan2 from '../../components/Home/Layanan2.vue';
import Layanan3 from '../../components/Home/Layanan3.vue';
import { Delete, Edit, Search, Share, Upload } from '@element-plus/icons-vue'


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