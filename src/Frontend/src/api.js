// src/frontend/src/api.js
import axios from 'axios'

// URL backend kamu (bisa langsung atau ambil dari .env)
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true // opsional, kalau nanti pakai auth/sanctum
})

export default api
