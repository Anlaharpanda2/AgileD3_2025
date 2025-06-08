// src/services/LoginPegawai.js
import api from '../api';

export async function loginPegawai(username, password) {
 try {
    const response = await api.post('/login/Pegawai', { username, password });

    // Tambahkan log di sini:
    console.log('[loginPegawai] response.data =', response.data);

    const data = response.data;
    if (!data || !data.user || !data.token) {
      throw new Error('Data login tidak lengkap dari server.');
    }

    const { user, token } = data;

    // Simpan ke localStorage
    localStorage.setItem('token', token);
    localStorage.setItem('isLoggedIn', 'true');
    localStorage.setItem('savedusername', user.username);
    localStorage.setItem('role', user.role);

    return { success: true, user };
  } catch (error) {
    const message = error.response?.data?.message || error.message || 'Terjadi kesalahan login.';
    return { success: false, message };
  }
}
