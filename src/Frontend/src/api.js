// src/api.js (dengan interseptor Axios)
import axios from 'axios';
import { ElMessage } from 'element-plus'; // Pastikan Anda menginstal dan mengkonfigurasi Element Plus

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/api',
});

api.interceptors.response.use(
    (response) => {
        return response.data;
    },
    (error) => {
        if (error.response) {
            const { status, data } = error.response;
            console.error(`Error ${status}:`, data);
            switch (status) {
                case 400:
                    ElMessage.error(data.message || 'Permintaan Buruk');
                    break;
                case 401:
                    ElMessage.error(data.message || 'Tidak Diotorisasi');
                    break;
                case 422:
                    ElMessage.error(data.message || 'Validasi Gagal');
                    break;
                case 500:
                    ElMessage.error(data.message || 'Terjadi Kesalahan Server. Coba Lagi Nanti');
                    break;
                default:
                    ElMessage.error(`Terjadi Kesalahan (${status}). Coba Lagi Nanti`);
            }
        } else if (error.request) {
            ElMessage.error('Tidak Ada Respons dari Server. Periksa Koneksi Internet Anda.');
        } else {
            ElMessage.error('Terjadi Kesalahan Saat Mengirim Permintaan: ' + error.message);
        }
        return Promise.reject(error);
    }
);

export default api;
