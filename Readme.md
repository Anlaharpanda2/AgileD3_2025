# Dinas Pemberdayaan Perempuan & Perlindungan Anak Provinsi Sumatera Barat

<p align="center">
  <img src="assets/logo/logo.png" width="33%">
</p>

## 📌 Deskripsi Proyek
Website ini dibuat untuk **Dinas Pemberdayaan Perempuan & Perlindungan Anak Provinsi Sumatera Barat** dalam rangka **manajemen dan pengelolaan data internal kedinasan**. 

Fitur utama dari sistem ini adalah:
- **CRUD** (Create, Read, Update, Delete) untuk **10 jenis data yang dikelola admin**.
- Sistem berbasis **Laravel** dengan **MySQL** sebagai database.
- Antarmuka admin yang mudah digunakan untuk mengelola data dinas.

## 🚀 Teknologi yang Digunakan
- **Framework:** Laravel 10
- **Database:** MySQL
- **Frontend:** Blade, Bootstrap
- **Version Control:** Git & GitHub

## 🛠️ Instalasi dan Konfigurasi
### 1️⃣ Clone Repository
```bash
git clone https://github.com/Anlaharpanda2/AgileD3_2025.git
cd proyek-dinas
```

### 2️⃣ Instal Dependensi
```bash
composer install
npm install
```

### 3️⃣ Konfigurasi Environment
Buat file `.env` dari contoh yang tersedia:
```bash
cp .env.example .env
```
Lalu, sesuaikan konfigurasi database di `.env` (kami kelompok 3 menggunakan database mysql):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Generate Key dan Migrasi Database
```bash
php artisan key:generate
php artisan migrate --seed
```

### 5️⃣ Jalankan Server
```bash
php artisan serve
```
Akses website melalui IP yang ditampilkan

## 🤝 Kontribusi
Jika ingin berkontribusi dalam pengembangan proyek ini, silakan:
1. **Fork** repositori ini.
2. Buat branch baru (`git checkout -b fitur-baru`).
3. Commit perubahan (`git commit -m 'Menambahkan fitur X'`).
4. Push ke branch (`git push origin fitur-baru`).
5. Buat **Pull Request** dan tunggu review dari tim.

## 📜 Lisensi
Proyek ini menggunakan lisensi **MIT License**. Lihat file `LICENSE` untuk informasi lebih lanjut.

---

Dikelola oleh **Anla Harpanda, Vania Ulimaz Rivani, Agel Deska Wisamulya & Nadya Hermalia Putri** 🎯