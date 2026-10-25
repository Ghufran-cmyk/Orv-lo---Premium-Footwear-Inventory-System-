# Orvélo - Premium Footwear (E-Commerce & Inventory System)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)

## 1. Project overview
Orvélo adalah sistem informasi terintegrasi berbasis web yang memadukan etalase toko *online* (e-commerce) khusus produk alas kaki premium dengan sistem manajemen inventaris (gudang) di belakang layar. Proyek ini dikembangkan sebagai bentuk implementasi praktis untuk pemenuhan tugas Ujian Tengah Semester (UTS) mata kuliah Web Programming 2.

Aplikasi ini mengusung arsitektur *Role-Based Access Control* (RBAC) yang memisahkan antarmuka menjadi dua bagian utama: **Storefront** interaktif untuk pelanggan melakukan transaksi mandiri melalui fitur keranjang belanja, dan **Admin Dashboard** terpusat bagi staf untuk mengelola data master, arus barang masuk (restok), serta memantau laporan. Nilai utama dari sistem Orvélo adalah kemampuannya dalam melakukan sinkronisasi data secara otomatis; setiap pesanan yang berhasil di-*checkout* akan langsung memotong sisa stok di gudang secara *real-time*, lengkap dengan perlindungan validasi pencegahan stok minus.

## 2. Requirements
Kebutuhan sistem untuk menjalankan aplikasi ini di lingkungan lokal:
* PHP >= 8.1
* Composer
* XAMPP (untuk Apache dan MySQL/MariaDB)
* Git

## 3. Installation
Langkah-langkah untuk mengunduh proyek ke komputer Anda:
1. Buka terminal/Command Prompt dan arahkan ke folder `htdocs` pada XAMPP Anda.
2. *Clone* repositori ini (ganti URL di bawah dengan link GitHub Anda nanti):
   ```bash
   git clone [https://github.com/username-anda/nama-repo-anda.git](https://github.com/username-anda/nama-repo-anda.git)