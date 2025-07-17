import axios from 'axios';

// Gunakan variabel lingkungan Vercel
// VITE_API_BASE_URL akan diatur di Vercel Dashboard
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';
const STORAGE_URL_ENV = import.meta.env.VITE_STORAGE_URL || 'http://127.0.0.1:8000/storage/';


const api = axios.create({
    baseURL: API_BASE_URL,
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

export const STORAGE_URL = STORAGE_URL_ENV ; // Gunakan variabel lingkungan di sini
export default api;