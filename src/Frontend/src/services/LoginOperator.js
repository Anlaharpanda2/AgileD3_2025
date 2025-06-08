// src/services/LoginOperator.js
import api from '../api';

export async function loginOperator(username, password) {
 try {
    const response = await api.post('/login/operator', { username, password });

    // Tambahkan log di sini:
    console.log('[loginOperator] response.data =', response.data);

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
