# 🚀 Quick Start Guide - Towerindo

## Setup Cepat

### 1. Buat Database
```bash
# macOS - Start MySQL
/Applications/XAMPP/bin/mysql.server start

# Import database schema
mysql -u root < backend/config/database.sql
```

### 2. Buat Folder XML Storage
```bash
mkdir -p storage/xml
chmod 755 storage/xml
```

### 3. Akses Aplikasi
- **Homepage**: `http://localhost/UAS_sysint/`
- **Admin Panel**: `http://localhost/UAS_sysint/admin/`
- **News Page**: `http://localhost/UAS_sysint/News.php`
- **About Us**: `http://localhost/UAS_sysint/About.html`
- **Setup Helper**: `http://localhost/UAS_sysint/setup.html`

## Default Admin Account
- **Username**: admin
- **Email**: admin@towerindo.com

## Fitur Utama

### ✨ Admin Panel Features
- 📰 **News Management**: CRUD untuk artikel berita
- 📊 **Customer Growth**: Kelola data pertumbuhan pelanggan 2020-2025
- 🗺️ **BTS Coverage**: Kelola data coverage area per pulau
- 📑 **Activity Logs**: Log semua aktivitas admin

### 📈 Halaman About Us
- **Grafik Pertumbuhan**: Chart.js visualization of customer growth
- **Peta BTS**: Google Maps dengan marker dinamis
- **Statistik**: Data ringkas coverage area

### 📰 Halaman News
- **Dynamic Content**: News dari database
- **Pagination**: Navigasi halaman
- **Detail View**: Halaman detail artikel lengkap

## API Endpoints

### News
```
GET  /backend/routes/news.php?route=published
GET  /backend/routes/news.php?route=SLUG
POST /backend/routes/news.php?route=create
PUT  /backend/routes/news.php?route=ID
DELETE /backend/routes/news.php?route=ID
```

### Customer Growth
```
GET  /backend/routes/customer_growth.php
POST /backend/routes/customer_growth.php
DELETE /backend/routes/customer_growth.php
```

### BTS Coverage
```
GET  /backend/routes/bts_coverage.php
POST /backend/routes/bts_coverage.php
PUT  /backend/routes/bts_coverage.php
DELETE /backend/routes/bts_coverage.php
```

## Struktur Project

```
UAS_sysint/
├── admin/               # Admin panel
├── backend/
│   ├── config/         # Database config & SQL
│   ├── models/         # Data models
│   ├── services/       # Business logic
│   └── routes/         # API endpoints
├── assets/             # CSS, JS, images
├── storage/
│   └── xml/           # XML backups
├── About.html         # About with charts & map
├── Index.html         # Homepage
├── News.php           # Dynamic news page
└── README.md          # Full documentation
```

## Troubleshooting

### ❌ Database Connection Error
```bash
# Verify MySQL is running
mysql -u root -p

# Check config in backend/config/database.php
```

### ❌ Maps Not Showing
- Get Google Maps API key from https://console.cloud.google.com/
- Add key in About.html: `key=YOUR_API_KEY`

### ❌ Admin Panel Not Saving
```bash
# Check folder permissions
chmod 755 storage/xml
ls -la storage/xml
```

## Database Tables

1. **users** - Admin users
2. **news** - News articles with XML backup
3. **customer_growth** - Growth data 2020-2025
4. **bts_coverage** - BTS locations by island
5. **admin_logs** - Activity tracking

## Security Features

✅ SQL Injection Protection (Prepared Statements)
✅ Password Hashing (bcrypt)
✅ HTML Sanitization
✅ XML Backup & Recovery
✅ Activity Logging
✅ CORS Headers
✅ File Upload Validation

## Next Steps

1. ✅ Setup database
2. ✅ Add sample news via admin panel
3. ✅ Update customer growth data
4. ✅ Configure BTS coverage areas
5. ✅ Set Google Maps API key
6. ✅ Customize branding/colors

---

**Need Help?** Check `README.md` for complete documentation.
