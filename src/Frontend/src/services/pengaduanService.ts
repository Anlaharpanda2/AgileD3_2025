import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/kelola/pengaduan';

export interface Pengaduan {
  id?: number;
  nama_pelapor: string;
  nama_korban?: string;
  deskripsi: string;
  alamat: string;
  waktu_kejadian: string;
  kasus: string;
  no_hp: string;
  saksi?: string;
  status: 'diproses' | 'selesai';
  lampiran?: string;
  kode_pengaduan?: string;
  lampiran_url?: string;
}

const pengaduanService = {
  async searchByKodePengaduan(kode: string): Promise<Pengaduan> {
    const response = await axios.get(`${API_URL}/search/${kode}`);
    return response.data;
  },
};

export default pengaduanService;
