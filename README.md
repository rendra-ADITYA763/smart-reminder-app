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

- **PHP**: Backend untuk autentikasi dan API.
- **MySQL**: Database untuk penyimpanan data.
- **HTML5 & Vanilla JavaScript**: Logika aplikasi murni tanpa framework berat.
- **Tailwind CSS**: Untuk desain antarmuka yang modern, responsif, dan premium.
- **Google Material Symbols**: Untuk ikonografi yang bersih dan intuitif.
- **Open-Meteo API**: Untuk pengambilan data cuaca secara real-time.
- **Google Gemini API**: Untuk fitur AI Assistant.

---

## 🔐 Akun Default (Login)

Aplikasi memiliki sistem **Login & Register** dengan dua role:

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| 🛡️ **Admin** | `admin@smart-reminder.com` | `admin123` | Semua fitur (Dashboard, Analytics, Logs, Admin Panel, dll) |
| 👤 **User** | *(Buat via Register)* | *(Buat sendiri)* | Fitur standar (Dashboard, Schedule, Events, Weather, AI) |

> **Catatan**: Akun Admin otomatis dibuat saat pertama kali menjalankan aplikasi. Untuk akun User, silakan daftar melalui halaman Register.

### Perbedaan Akses per Role

| Fitur | Admin | User |
|-------|:-----:|:----:|
| Dashboard | ✅ | ✅ |
| College Schedule | ✅ | ✅ |
| Competitions | ✅ | ✅ |
| Weather Concierge | ✅ | ✅ |
| AI Assistant | ✅ | ✅ |
| Settings | ✅ | ✅ |
| **Analytics** | ✅ | ❌ |
| **Logs** | ✅ | ❌ |
| **Admin Panel** | ✅ | ❌ |

---

## 🚀 Cara Menjalankan di Laptop

### Prasyarat
- **XAMPP** (Apache + MySQL) terinstal di komputer Anda.

### Langkah-langkah

1.  **Clone atau Download Repository ini**:
    ```bash
    git clone https://github.com/username/smart-reminder-app.git
    ```
    *Atau cukup download file ZIP dan ekstrak ke folder `C:\xampp\htdocs\smart-reminder-app`*

2.  **Jalankan XAMPP**:
    - Buka XAMPP Control Panel
    - Start **Apache** dan **MySQL**

3.  **Buka di Browser**:
    ```
    http://localhost/smart-reminder-app/
    ```

4.  **Login**:
    - Halaman login akan muncul otomatis
    - Gunakan akun admin default: `admin@smart-reminder.com` / `admin123`
    - Atau klik tab **Register** untuk membuat akun baru

5.  **Selesai!** Database dan tabel akan otomatis dibuat saat pertama kali diakses.

---

## 📖 Cara Penggunaan

1.  **Login / Register**: Masuk dengan akun admin default atau buat akun baru di halaman Register.
2.  **Tambah Kebiasaan**: Masukkan nama aktivitas dan jam di Dashboard, lalu klik "Add Habit".
3.  **Cek Cuaca**: Gunakan menu "Weather Concierge" untuk melihat ramalan cuaca 7 hari ke depan.
4.  **Atur Jadwal Kuliah**: Masuk ke menu "College Schedule" untuk memasukkan jadwal mata kuliah.
5.  **AI Assistant**: Tanyakan tips kesehatan & kebugaran ke AI Assistant.
6.  **Mode Gelap**: Klik ikon bulan di pojok kanan atas.
7.  **Logout**: Klik tombol Logout di sidebar atau dropdown profil di pojok kanan atas.
