import axios from 'axios';

const api = axios.create({
    baseURL: 'http://192.168.173.83:8000/api',
});

api.interceptors.response.use(
    (response) => {
        return response.data;
    },
    (error) => {
        if (error.response) {
            const { status, data } = error.response;
            console.error(`Error ${status}:`, data);
        } else if (error.request) {
            console.error('Tidak Ada Respons dari Server. Periksa koneksi Anda.');
        } else {
            console.error('Kesalahan saat mengirim permintaan:', error.message);
        }

        return Promise.reject(error);
    }
);

export const STORAGE_URL = 'http://192.168.173.83:8000/storage/';
export default api;
