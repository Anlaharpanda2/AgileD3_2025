import { ref } from 'vue';
import api from '../api';
/**
 * Interface untuk struktur data berita.
 */
export interface BeritaItem {
  id: number;
  judul: string;
  isi: string;
  jenis_konten: string;
  foto: string;
  created_at: string;
  updated_at: string;
  deleted_at: string | null;
}
/**
 * Composable untuk mengelola state dan logika pengambilan data berita dari API.
 * @returns Objek reaktif yang berisi daftar berita, status loading, error, dan fungsi fetch.
 */
export function useBeritaData() {
  const news = ref<BeritaItem[]>([]);
  const loading = ref(true);
  const error = ref<string | null>(null);
  /**
   * Mengambil data berita dari API.
   */
  const fetchBerita = async () => {
    loading.value = true;
    error.value = null; 
    try {
      const response = await api.get('/kelola/berita');
      let beritaData: any[] = [];
      if (response && response.data) {
        if (Array.isArray(response.data)) {
          beritaData = response.data;
        } else if (response.data.data && Array.isArray(response.data.data)) {
          beritaData = response.data.data;
        } else if (response.data.items && Array.isArray(response.data.items)) {
          beritaData = response.data.items;
        } else if (response.data.results && Array.isArray(response.data.results)) {
          beritaData = response.data.results;
        } else if (typeof response.data === 'object' && response.data !== null) {
          for (const key of Object.keys(response.data)) {
            if (Array.isArray(response.data[key])) {
              beritaData = response.data[key];
              break;
            }
          }
        }
      } else if (Array.isArray(response)) { 
        beritaData = response;
      }
      if (!Array.isArray(beritaData)) {
        throw new Error('Format data API tidak valid: Respons bukan array yang diharapkan.');
      }
      const filteredBerita = beritaData.filter((item: any) => 
        item && item.jenis_konten === 'berita'
      );
      news.value = filteredBerita;
    } catch (err: any) {
      console.error('Error fetching berita:', err);
      error.value = `Gagal memuat berita: ${err.message || 'Terjadi kesalahan jaringan atau server.'}`;
    } finally {
      loading.value = false;
    }
  };
  return {
    news,
    loading,
    error,
    fetchBerita,
  };
}
