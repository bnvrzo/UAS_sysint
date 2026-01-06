# Towerindo - Dynamic Web Application

## 📋 Dokumentasi Lengkap

Sistem ini mengubah website statis menjadi aplikasi web dinamis dengan fitur admin, CRUD news, grafik pertumbuhan pelanggan, dan peta coverage area BTS.

## 🚀 Fitur Utama

### 1. **Admin Panel** (`/admin/index.html`)
- **News Management**: CRUD (Create, Read, Update, Delete) untuk artikel berita
- **Customer Growth Data**: Kelola data pertumbuhan pelanggan tahun 2020-2025
- **BTS Coverage Areas**: Kelola data coverage area BTS di berbagai pulau
- **Rich Text Editor**: Editor WYSIWYG untuk membuat artikel
- **Dashboard**: Statistik dan ringkasan data

### 2. **Grafik Pertumbuhan Pelanggan** (di About.html)
- Visualisasi data pertumbuhan dari tahun 2020-2025
- Chart.js untuk rendering grafik interaktif
- Tampil jumlah pelanggan dan persentase pertumbuhan
- Statistik ringkas: total pelanggan, total pertumbuhan, rata-rata tahunan

### 3. **Peta Coverage Area BTS** (di About.html)
- Google Maps integration untuk menampilkan lokasi BTS
- Marker dinamis berdasarkan jumlah BTS per pulau
- Info window popup dengan detail setiap pulau
- Daftar pulau dengan progress bar coverage
- Statistik coverage: total pulau, total BTS, rata-rata BTS per pulau

### 4. **Halaman News Dinamis** (`/News.html`)
- Menampilkan artikel dari database
- Pagination untuk navigasi artikel
- Tautan ke detail artikel
- Disortir berdasarkan tanggal publikasi terbaru

### 5. **Database dengan XML Integration**
- MySQL database untuk penyimpanan data
- XML backup otomatis untuk setiap perubahan data
- Log aktivitas admin

## 📁 Struktur Folder

```
UAS_sysint/
├── admin/
│   └── index.html                 # Admin Panel
├── backend/
│   ├── config/
│   │   ├── database.php          # Konfigurasi database
│   │   └── database.sql          # SQL script
│   ├── models/
│   │   ├── NewsModel.php         # Model untuk news
│   │   ├── CustomerGrowthModel.php
│   │   └── BTSCoverageModel.php
│   ├── services/
│   │   ├── NewsService.php       # Business logic
│   │   ├── CustomerGrowthService.php
│   │   └── BTSCoverageService.php
│   └── routes/
│       ├── news.php              # API endpoints
│       ├── customer_growth.php
│       └── bts_coverage.php
├── storage/
│   └── xml/                      # XML backup files
├── About.html                    # Tentang kami (dengan grafik & peta)
├── News.html                     # Halaman news (dinamis)
├── Index.html                    # Halaman utama
├── news_detail.php               # Detail artikel
└── get_dynamic_news.php          # Helper untuk load news

```

## 🗄️ Database Schema

### Table: `users`
- id (PK)
- username (UNIQUE)
- email (UNIQUE)
- password (hashed)
- role (admin/user)
- created_at, updated_at

### Table: `news`
- id (PK)
- title
- slug (UNIQUE)
- content (LONGTEXT)
- image_url
- author_id (FK)
- category
- status (draft/published)
- published_at
- xml_backup_path
- created_at, updated_at

### Table: `customer_growth`
- id (PK)
- year (UNIQUE)
- total_customers
- growth_percentage
- created_at

### Table: `bts_coverage`
- id (PK)
- island_name
- bts_count
- population
- coverage_percentage
- latitude, longitude
- xml_backup_path
- created_at, updated_at

### Table: `admin_logs`
- id (PK)
- user_id (FK)
- action
- table_name
- record_id
- changes (LONGTEXT)
- created_at

## 🔧 Setup & Instalasi

### 1. **Buat Database**
```sql
-- Jalankan SQL script di `/backend/config/database.sql`
```

### 2. **Konfigurasi Database** (Opsional)
Edit `/backend/config/database.php` jika perlu mengubah:
- Host
- Username
- Password
- Database name

### 3. **Buat Folder XML Storage**
```bash
mkdir -p storage/xml
chmod 755 storage/xml
```

### 4. **Akses Admin Panel**
- URL: `http://localhost/UAS_sysint/admin/`
- Default User:
  - Username: `admin`
  - Email: `admin@towerindo.com`
  - Password: (check database.sql)

## 📡 API Routes

### News API
- `GET /backend/routes/news.php?route=published` - Dapatkan news terpublikasi
- `GET /backend/routes/news.php?route=SLUG` - Dapatkan detail news by slug
- `POST /backend/routes/news.php?route=create` - Buat news baru
- `PUT /backend/routes/news.php?route=ID` - Update news
- `DELETE /backend/routes/news.php?route=ID` - Hapus news

### Customer Growth API
- `GET /backend/routes/customer_growth.php` - Dapatkan semua data
- `GET /backend/routes/customer_growth.php?type=chart` - Data untuk chart
- `GET /backend/routes/customer_growth.php?type=analysis` - Analisis pertumbuhan
- `POST /backend/routes/customer_growth.php` - Tambah/update data
- `DELETE /backend/routes/customer_growth.php` - Hapus data

### BTS Coverage API
- `GET /backend/routes/bts_coverage.php` - Dapatkan semua data
- `GET /backend/routes/bts_coverage.php?type=map` - Data untuk map
- `GET /backend/routes/bts_coverage.php?type=stats` - Statistik coverage
- `GET /backend/routes/bts_coverage.php?type=report` - Report coverage
- `POST /backend/routes/bts_coverage.php` - Tambah data
- `PUT /backend/routes/bts_coverage.php` - Update data
- `DELETE /backend/routes/bts_coverage.php` - Hapus data

## 📊 Contoh Data

### Customer Growth (2020-2025)
| Year | Total Customers | Growth % |
|------|-----------------|----------|
| 2020 | 5,000 | 0% |
| 2021 | 7,500 | 50% |
| 2022 | 12,000 | 60% |
| 2023 | 18,500 | 54.17% |
| 2024 | 26,500 | 43.24% |
| 2025 | 35,000 | 32.08% |

### BTS Coverage (Major Islands)
| Island | BTS Count | Coverage % |
|--------|-----------|-----------|
| Jawa | 3,500 | 98.5% |
| Sumatra | 1,200 | 85.3% |
| Kalimantan | 850 | 72.4% |
| Sulawesi | 680 | 68.9% |
| Papua | 450 | 45.2% |
| Bali-Nusa Tenggara | 620 | 92.1% |
| Maluku | 380 | 52.6% |
| Riau Islands | 290 | 88.3% |

## 🔐 Security Features

1. **SQL Injection Protection**: Menggunakan prepared statements
2. **HTML Sanitization**: `htmlspecialchars()` untuk output
3. **Password Hashing**: bcrypt untuk password user
4. **XML Backup**: Automatic backup setiap perubahan data
5. **Activity Logging**: Semua aksi admin dicatat

## 🔄 XML Integration

Setiap perubahan data di CRUD operations akan:
1. Disimpan di MySQL (primary storage)
2. Dibackup ke file XML (di `/storage/xml/`)
3. Dicatat dalam admin_logs table

### Format XML Backup
```xml
<?xml version="1.0" encoding="UTF-8"?>
<news>
  <record>
    <id>1</id>
    <title>Article Title</title>
    <slug>article-slug</slug>
    <content>Article content...</content>
    <author_id>1</author_id>
    <category>Technology</category>
    <status>published</status>
    <created_at>2025-01-06 10:00:00</created_at>
  </record>
</news>
```

## 📱 Responsive Design

- Desktop: Full layout dengan semua fitur
- Tablet: Grid responsive
- Mobile: Single column, hamburger menu

## 🎨 Styling

- **Color Scheme**: 
  - Primary: #667eea (biru)
  - Secondary: #764ba2 (ungu)
  - Accent: #28a745 (hijau)
- **Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons
- **Charts**: Chart.js
- **Maps**: Google Maps API

## 📝 Catatan Penting

1. **Google Maps API**: Perlu API key untuk menggunakan Google Maps
   - Dapatkan di: https://console.cloud.google.com/
   - Masukkan key di About.html: `<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY"></script>`

2. **XAMPP Server**: Pastikan server MySQL running
   ```bash
   # macOS
   /Applications/XAMPP/bin/mysql.server start
   ```

3. **File Permissions**: 
   ```bash
   chmod 755 storage/xml
   ```

## 🐛 Troubleshooting

### Database Connection Failed
- Cek MySQL running: `mysql -u root -p`
- Verifikasi credentials di `backend/config/database.php`

### Maps Tidak Tampil
- Pastikan Google Maps API key valid
- Check browser console untuk error messages

### Admin Panel Tidak Menyimpan Data
- Verifikasi folder `storage/xml/` writable
- Check file permissions: `chmod 755 storage/xml`

## 📞 Kontak & Support

- **Email**: corporate@towerindo.co.id
- **Phone**: 021-6722-6722
- **Address**: Jalan kebonsirih, Tower Hamawara, Lt. 23

## 📄 License

© 2025 PT Towerindo. All rights reserved.

---

**Developed with ❤️ for Towerindo**
