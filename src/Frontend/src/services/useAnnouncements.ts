import { ref } from 'vue';
import api from '../api';
/**
 * Interface untuk struktur data pengumuman.
 */
export interface Announcement {
  id: number;
  judul: string;
  isi: string;
  jenis_konten: string;
  foto?: string; 
  created_at: string;
  updated_at: string;
}
/**
 * Composable untuk mengelola state dan logika pengambilan data pengumuman.
 * @returns Objek reaktif yang berisi pengumuman, status loading, error, dan fungsi fetch.
 */
export function useAnnouncements() {
  const announcements = ref<Announcement[]>([]);
  const loading = ref(true);
  const error = ref<string | null>(null); 
  /**
   * Mengambil data pengumuman dari API.
   */
  const fetchAnnouncements = async () => {
    loading.value = true;
    error.value = null; 
    try {
      const response = await api.get('/kelola/berita');
      let rawData: any[] = [];
      if (response && response.data) {
        if (Array.isArray(response.data)) {
          rawData = response.data;
        } else if (response.data.data && Array.isArray(response.data.data)) {
          rawData = response.data.data;
        } else if (response.data.items && Array.isArray(response.data.items)) {
          rawData = response.data.items;
        } else if (response.data.results && Array.isArray(response.data.results)) {
          rawData = response.data.results;
        } else {
          if (typeof response.data === 'object' && response.data !== null) {
            rawData = [response.data];
          }
        }
      } else if (Array.isArray(response)) { 
        rawData = response;
      }
      if (!Array.isArray(rawData)) {
        throw new Error('Format data API tidak valid: Respons bukan array.');
      }
      const filteredAndSortedData = rawData
        .filter((item: Announcement) => item && item.jenis_konten === 'pengumuman')
        .sort((a: Announcement, b: Announcement) => {
          const dateA = new Date(a.created_at).getTime();
          const dateB = new Date(b.created_at).getTime();
          return dateB - dateA; 
        });
      announcements.value = filteredAndSortedData;
    } catch (err: any) {
      console.error('Error fetching announcements:', err);
      error.value = `Gagal memuat pengumuman: ${err.message || 'Terjadi kesalahan jaringan atau server.'}`;
    } finally {
      loading.value = false;
    }
  };
  return {
    announcements,
    loading,
    error,
    fetchAnnouncements,
  };
}
