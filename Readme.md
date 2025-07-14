# Project Website DP3AP2KB Provinsi Sumatera Barat

<p align="center">
  <img src="assets/logo/logo.png" width="33%">
</p>

## 📌 Deskripsi Proyek
Website ini dibuat untuk **Dinas Pemberdayaan Perempuan & Perlindungan Anak Provinsi Sumatera Barat** dalam rangka **manajemen dan pengelolaan data internal kedinasan**. Proyek ini dibangun dengan arsitektur terpisah antara backend dan frontend.

## 🚀 Teknologi yang Digunakan
- **Backend:** Laravel 11
- **Frontend:** Vue 3 + Vite
- **Database:** MySQL
- **Version Control:** Git & GitHub

## 📂 Struktur Proyek
Proyek ini dibagi menjadi dua direktori utama:
- `src/Backend`: Berisi seluruh kode sumber untuk sisi server (API) yang dibangun dengan Laravel.
- `src/Frontend`: Berisi seluruh kode sumber untuk sisi klien yang dibangun dengan Vue.

## 🛠️ Instalasi dan Konfigurasi
### 1️⃣ Clone Repository
```bash
git clone https://github.com/Anlaharpanda2/AgileD3_2025.git
cd AgileD3_2025
```

### 2️⃣ Konfigurasi Backend (Laravel)
1.  Masuk ke direktori backend.
    ```bash
    cd src/Backend
    ```
2.  Install dependensi Composer.
    ```bash
    composer install
    ```
3.  Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```
4.  Sesuaikan konfigurasi database Anda di dalam file `.env`.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  Generate application key.
    ```bash
    php artisan key:generate
    ```
6.  Jalankan migrasi database.
    ```bash
    php artisan migrate --seed
    ```

### 3️⃣ Konfigurasi Frontend (Vue)
1.  Buka terminal baru dan masuk ke direktori frontend.
    ```bash
    cd src/Frontend
    ```
2.  Install dependensi NPM.
    ```bash
    npm install
    ```
3.  Pastikan file `.env` di frontend (jika ada) sudah menunjuk ke URL API backend yang benar. Contoh:
    ```env
    VITE_API_URL=http://127.0.0.1:8000/api
    ```

## 🖥️ Menjalankan Proyek
Anda perlu menjalankan dua proses secara terpisah di dua terminal.

1.  **Jalankan Server Backend (Laravel):**
    - Di dalam direktori `src/Backend`:
    ```bash
    php artisan serve
    ```
    Server backend akan berjalan di `http://127.0.0.1:8000`.

2.  **Jalankan Server Frontend (Vue):**
    - Di dalam direktori `src/Frontend`:
    ```bash
    npm run dev
    ```
    Aplikasi frontend akan dapat diakses melalui alamat yang ditampilkan di terminal (biasanya `http://localhost:5173`).

## 🤝 Kontribusi
Jika ingin berkontribusi dalam pengembangan proyek ini, silakan:
1.  **Fork** repositori ini.
2.  Buat branch baru (`git checkout -b fitur-baru`).
3.  Commit perubahan (`git commit -m 'Menambahkan fitur X'`).
4.  Push ke branch (`git push origin fitur-baru`).
5.  Buat **Pull Request** dan tunggu review dari tim.

## 📜 Lisensi
Proyek ini menggunakan lisensi **MIT License**.

---

Dikelola oleh **Anla Harpanda, Vania Ulimaz Rivani, Agel Deska Wisamulya & Nadya Hermalia Putri** 🎯