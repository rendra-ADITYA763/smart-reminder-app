# 🚀 Smart Reminder: Integrated Predictive Productivity Dashboard with Real-Time Weather Intelligence, Academic Scheduling, and Event Management Concierge

**Smart Reminder** adalah aplikasi manajemen produktivitas berbasis web (*Single Page Application*) yang dirancang untuk membantu Anda mengelola kebiasaan, jadwal kuliah, dan event perlombaan dalam satu dashboard yang elegan dan cerdas.

Aplikasi ini dilengkapi dengan fitur **Weather Concierge** yang mampu memberikan rekomendasi aktivitas berdasarkan kondisi cuaca real-time dari API.

---

## ✨ Fitur Utama

- **🧠 Predictive Habit Tracker**: Catat kebiasaan harian Anda. Sistem akan memberikan saran waktu terbaik dan peringatan cerdas.
- **☁️ Weather-Aware Integration**: Integrasi dengan API cuaca (Open-Meteo). Aplikasi akan memperingatkan Anda jika ingin melakukan aktivitas outdoor (seperti lari pagi) saat cuaca sedang hujan.
- **🎓 College Schedule**: Kelola jadwal kuliah mingguan Anda dengan tampilan kolom hari yang rapi.
- **🏆 Competition Tracker**: Pantau jadwal perlombaan, turnamen, atau event penting lainnya agar tidak terlewat.
- **🌓 Advanced Dark Mode**: Dukungan mode gelap otomatis dan manual yang tersinkronisasi di seluruh halaman.
- **💾 Local Persistence**: Semua data Anda disimpan secara lokal di browser menggunakan *LocalStorage*, sehingga data tetap aman tanpa perlu login.
- **📊 Analytics & Logs**: Lihat distribusi aktivitas Anda secara visual dan pantau riwayat interaksi sistem melalui logs.

---

## 🌐 API Reference

Aplikasi ini mengintegrasikan layanan pihak ketiga untuk fungsionalitas cerdasnya:

### **Open-Meteo API**
Digunakan untuk mengambil data cuaca secara real-time tanpa memerlukan API Key (Free for non-commercial use).

- **Base URL**: `https://api.open-meteo.com/v1/forecast`
- **Data yang diambil**:
    - `current`: Temperature, Relative Humidity, Weather Code, Wind Speed.
    - `daily`: Max/Min Temperature, Weather Code.
- **Fitur Cerdas**: Data ini digunakan sebagai basis logika peringatan jika pengguna memasukkan aktivitas luar ruangan saat kondisi cuaca tidak memungkinkan.

---

## 🛠️ Teknologi yang Digunakan

- **HTML5 & Vanilla JavaScript**: Logika aplikasi murni tanpa framework berat.
- **Tailwind CSS**: Untuk desain antarmuka yang modern, responsif, dan premium.
- **Google Material Symbols**: Untuk ikonografi yang bersih dan intuitif.
- **Open-Meteo API**: Untuk pengambilan data cuaca secara real-time.

---

## 🚀 Cara Menjalankan di Laptop

Karena aplikasi ini dibangun menggunakan teknologi web standar tanpa *backend* yang rumit, Anda bisa menjalankannya dengan sangat mudah:

1.  **Clone atau Download Repository ini**:
    ```bash
    git clone https://github.com/username/smart-reminder-app.git
    ```
    *Atau cukup download file ZIP dan ekstrak.*

2.  **Buka Folder Proyek**:
    Cari file bernama `activityApp.html`.

3.  **Jalankan di Browser**:
    - **Cara A**: Klik kanan pada `activityApp.html` dan pilih **Open With** > **Google Chrome** (atau browser favorit Anda).
    - **Cara B**: *Drag and drop* file `activityApp.html` langsung ke tab browser yang sedang terbuka.

4.  **Selesai!** Aplikasi siap digunakan. Tidak perlu instalasi database atau server tambahan.

---

## 📖 Cara Penggunaan

1.  **Tambah Kebiasaan**: Masukkan nama aktivitas dan jam (0-23) di User Panel, lalu klik "Tambah Kebiasaan".
2.  **Cek Cuaca**: Gunakan menu "Weather Concierge" untuk melihat ramalan cuaca 7 hari ke depan.
3.  **Atur Jadwal Kuliah**: Masuk ke menu "College Schedule" untuk memasukkan jadwal mata kuliah mingguan Anda.
4.  **Hapus Data**: Jika ada salah ketik, arahkan kursor ke kartu aktivitas atau jadwal, lalu klik ikon tempat sampah/tanda silang yang muncul.
5.  **Mode Gelap**: Klik ikon bulan di pojok kanan atas untuk kenyamanan mata di malam hari.

---

## 📄 Lisensi

Proyek ini dibuat untuk tujuan pembelajaran dan produktivitas pribadi. Silakan gunakan dan modifikasi sesuai kebutuhan Anda.

---
*Dibuat dengan ❤️ oleh Antigravity.*
