# 🚀 Pepsikuburger: Platform Layanan Masyarakat DP3AP2KB Provinsi Sumatera Barat

<p align="center">
  <img src="assets/Logo/logo.png" alt="Logo Pepsikuburger" width="300">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js" alt="Vue 3">
  <img src="https://img.shields.io/badge/Vite-B73BFE?style=for-the-badge&logo=vite" alt="Vite">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="License MIT">
</p>

<p align="center">
  <b>Pepsikuburger</b> (Pelayanan Publik Terintegrasi Kuat, Bergerak Responsif) adalah website resmi dari DP3AP2KB Sumatera Barat. Platform ini hadir untuk mendukung pelayanan publik yang lebih cepat, transparan, dan terintegrasi.
</p>

## 🌐 Link Demo

[pepsikuburger.vercel.app](https://pepsikuburger.vercel.app)

## 👩‍💻 Anggota Pengembang

* **Manajer Proyek**: Anla Harpanda (2311083015)
* **Tim Proyek**:
    * Agel Deska Wisamulya (2311082002)
    * Nadya Hermalia Putri (2311082034)
    * Vania Ulimaz Rivani (2311081038)
### ✨ Fitur Utama

#### Untuk Masyarakat:
- **Ikut Pelatihan**: Meningkatkan pemberdayaan perempuan melalui program pelatihan yang tersedia.
- **Lapor Kasus**: Melaporkan kasus kekerasan terhadap perempuan dan anak secara langsung melalui website.
- **Pre-test & Post-test**: Mengikuti ujian pelatihan secara online tanpa proses manual.

#### Untuk Internal Dinas:
- **Dashboard Admin**: Menyajikan visualisasi data yang komprehensif dan interaktif.
- **Manajemen Data**: Dilengkapi 11 fitur CRUD dan 16 *tools* interaktif untuk memudahkan pengelolaan data dinas.


---

## 📚 Third-Party / Library yang Digunakan

Proyek ini dibangun dengan arsitektur terpisah dan menggunakan beberapa pustaka utama untuk menunjang fungsionalitasnya.

### Backend (Laravel)
- **[Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)**: Untuk otentikasi API yang ringan.
- **[Maatwebsite/excel](https://docs.laravel-excel.com/3.1/getting-started/)**: Untuk fungsionalitas ekspor dan impor data dengan format Excel.

### Frontend (Vue)
- **[Vue Router](https://router.vuejs.org/)**: Pustaka routing resmi untuk Vue.js.
- **[Axios](https://axios-http.com/)**: Klien HTTP berbasis Promise untuk browser dan Node.js.
- **[Element Plus](https://element-plus.org/)**: Pustaka komponen UI yang lengkap untuk Vue 3.
- **[Vuetify](https://vuetifyjs.com/)**: Kerangka kerja Material Design untuk Vue.
- **[ApexCharts](https://apexcharts.com/)**: Komponen grafik untuk visualisasi data.
- **[Tailwind CSS](https://tailwindcss.com/)**: Kerangka kerja CSS untuk desain yang cepat dan kustom.

---

## 🛠️ Langkah Instalasi & Cara Menjalankan

Untuk memulai, clone repositori ini ke mesin lokal Anda.

```bash
git clone https://github.com/Anlaharpanda2/AgileD3_2025.git
cd AgileD3_2025
```

### 1. Konfigurasi Backend (Laravel)

- **Masuk ke direktori & install dependensi.**
  ```bash
  cd src/Backend
  composer install
  ```
- **Konfigurasi environment.**
  ```bash
  cp .env.example .env
  ```
  Lalu sesuaikan file `.env` dengan konfigurasi database Anda.
- **Generate key & migrasi database.**
  ```bash
  php artisan key:generate
  php artisan migrate --seed
  ```

### 2. Konfigurasi Frontend (Vue)

- **Masuk ke direktori & install dependensi.**
  ```bash
  cd src/Frontend
  npm install
  ```
- **Konfigurasi environment.** Pastikan file `.env` menunjuk ke URL API backend yang benar (contoh: `VITE_API_URL=http://127.0.0.1:8000/api`).

### 3. Menjalankan Proyek

Buka dua terminal terpisah:

- **Terminal 1 (Backend):**
  ```bash
  cd src/Backend
  php artisan serve
  ```
- **Terminal 2 (Frontend):**
  ```bash
  cd src/Frontend
  npm run dev
  ```

> ✨ Backend akan berjalan di `http://127.0.0.1:8000` dan Frontend di `http://localhost:5173`.

---

## 🔑 Akun untuk Akses Login

Setelah sistem berjalan, gunakan akun demo berikut untuk masuk:

| Peran       | Username / nama                | Password/NIK   |
| :---------- | :---------------------------- | :--------- |
| **Masyarakat** | nama: `Demo`        | NIK: `1234567890123456` |
| **Operator**  | Username: `Operator`          | `Aa12345!` |
| **Pegawai**   | Username: `Pegawai`           | `Aa12345!` |

---

## 🌐 Link Demo

[pepsikuburger.vercel.app](https://pepsikuburger.vercel.app)

---

<p align="center">
  Dikelola dengan ❤️ oleh <b>Anla Harpanda, Vania Ulimaz Rivani, Agel Deska Wisamulya & Nadya Hermalia Putri</b>
</p>