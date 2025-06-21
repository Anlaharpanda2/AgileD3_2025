import api from '@/api';
import { ElMessage } from 'element-plus';

export async function useMassDelete({ endpoint, key }) {
  const global = window.__VUE_APP_GLOBAL__;
  if (!global || !global.selected || !global.setLoading || !global.fetchData) {
    console.error('Global states (selected, setLoading, fetchData) belum disiapkan.');
    return;
  }

  if (!global.selected.length) return;

  global.setLoading(true);

  try {
    const keyArray = global.selected.map((item) => item[key]);
    await api.delete(endpoint, {
      data: { [`${key}s`]: keyArray },
    });
    ElMessage.success('Data berhasil dihapus');
    await global.fetchData();
  } catch (err) {
    console.error('Gagal menghapus data:', err);
    ElMessage.error('Gagal menghapus data');
  } finally {
    global.setLoading(false);
  }
}

// Fungsi ini digunakan di halaman utama untuk menyambungkan state ke composable ini
export function provideMassDeleteContext({ selected, setLoading, fetchData }) {
  window.__VUE_APP_GLOBAL__ = { selected, setLoading, fetchData };
}