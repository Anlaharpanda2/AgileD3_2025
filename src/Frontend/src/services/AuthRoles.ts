import { computed, Ref } from 'vue';
function getUserRole(): string {
  return localStorage.getItem('role') || '';
}
export const isOperator: Ref<boolean> = computed(() => getUserRole() === 'operator');
export const isPegawai: Ref<boolean> = computed(() => getUserRole() === 'pegawai');
export const isMasyarakat: Ref<boolean> = computed(() => getUserRole() === 'masyarakat');
export const isNotLogin: Ref<boolean> = computed(() => {
  const role = getUserRole();
  return role !== 'masyarakat' && role !== 'operator' && role !== 'pegawai';
});