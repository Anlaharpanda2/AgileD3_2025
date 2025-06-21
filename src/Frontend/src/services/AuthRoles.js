import { computed } from 'vue';

function getUserRole() {
  return localStorage.getItem('role') || '';
}

export const isOperator = computed(() => getUserRole() === 'operator');
export const isPegawai = computed(() => getUserRole() === 'pegawai');
export const isMasyarakat = computed(() => getUserRole() === 'masyarakat');
export const isNotLogin = computed(() => getUserRole() === '!masyarakat');