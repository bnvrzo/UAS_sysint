# 🎯 How to Use - Panduan Penggunaan Aplikasi

## 🚀 Akses Aplikasi

### URL Aplikasi
```
Base URL: http://localhost/UAS_sysint/
```

### Halaman Utama
1. **Homepage**: `http://localhost/UAS_sysint/Index.html`
2. **About Us**: `http://localhost/UAS_sysint/About.html`
3. **News**: `http://localhost/UAS_sysint/News.php`
4. **Solutions**: `http://localhost/UAS_sysint/solution.html`

---

## 👨‍💼 Admin Panel Guide

### Akses Admin Panel
```
URL: http://localhost/UAS_sysint/admin/
```

### Login Credentials
```
Username: admin
Email: admin@towerindo.com
```

### Features dalam Admin Panel

#### 1. **📰 News Management**

**Membuat Article Baru:**
1. Click tombol "New Article" (biru)
2. Isi form:
   - **Title**: Judul artikel (max 255 karakter)
   - **Category**: Pilih kategori (Announcement, Press Release, Technology, Partnership)
   - **Content**: Isi artikel dengan rich text editor
   - **Image URL**: URL gambar artikel
   - **Status**: Pilih Draft atau Published
3. Click tombol "Save"
4. Artikel akan otomatis:
   - Disimpan ke MySQL
   - Dibackup ke XML
   - Slug di-generate otomatis

**Mengedit Article:**
1. Cari artikel di tabel
2. Click tombol "Edit"
3. Ubah data sesuai kebutuhan
4. Click "Save"
5. Data ter-update dan XML backup dibuat

**Menghapus Article:**
1. Click tombol "Delete" pada artikel
2. Confirm penghapusan
3. Artikel dihapus dan XML backup dibuat

**Melihat Published Articles:**
- Semua artikel dengan status "Published" akan muncul di `/News.php`
- Pagination otomatis jika > 6 artikel

---

#### 2. **📊 Customer Growth Management**

**Menambah Data Tahun Baru:**
1. Click tombol "Add Year"
2. Isi form:
   - **Year**: Tahun (2020-2100)
   - **Total Customers**: Jumlah pelanggan
   - **Growth %** (optional): Persentase pertumbuhan
3. Click "Save"
4. Data akan:
   - Muncul di tabel
   - Ter-update di grafik About.html otomatis
   - Disimpan ke MySQL

**Growth Summary:**
- **Period**: Tahun awal dan akhir
- **Total Growth %**: Pertumbuhan total
- **Average Annual**: Rata-rata pertumbuhan per tahun
- **Increase**: Total peningkatan pelanggan

**Menghapus Data:**
1. Click tombol "Delete" pada tahun
2. Data dihapus dari database

---

#### 3. **🗺️ BTS Coverage Management**

**Menambah Area Coverage Baru:**
1. Click tombol "Add Area"
2. Isi form:
   - **Island Name**: Nama pulau
   - **BTS Count**: Jumlah BTS
   - **Population**: Populasi (optional)
   - **Coverage %**: Persentase coverage
   - **Latitude & Longitude**: Koordinat GPS
3. Click "Save"
4. Area akan:
   - Muncul di tabel
   - Muncul di peta About.html sebagai marker
   - Disimpan ke MySQL

**Coverage Statistics:**
- **Total Islands**: Jumlah pulau
- **Total BTS**: Total menara
- **Avg BTS/Island**: Rata-rata menara per pulau
- **Avg Coverage**: Rata-rata cakupan

**Mengedit Coverage:**
1. Click "Edit" pada area
2. Ubah data
3. Click "Save"

**Menghapus Coverage:**
1. Click "Delete" pada area
2. Area dihapus dari database dan peta

---

## 📰 News Page Usage

### Mengakses News Page
```
URL: http://localhost/UAS_sysint/News.php
```

### Fitur News Page
1. **Automatic Loading**: Artikel ter-load otomatis dari database
2. **Pagination**: Navigate antar halaman (6 artikel per halaman)
3. **Read More**: Click untuk membaca artikel lengkap
4. **Admin Button**: Akses admin panel dari pojok bawah kanan

### Membaca Article Detail
1. Click "Read More" pada artikel
2. Halaman `news_detail.php` terbuka
3. Lihat artikel lengkap dengan:
   - Title
   - Author & date
   - Featured image
   - Full content
   - Back to news link

---

## 📊 About Us Page - Data Visualization

### Mengakses About Us
```
URL: http://localhost/UAS_sysint/About.html
```

### 1. **Customer Growth Chart**

**Visualisasi**:
- Line chart dengan dual axis
- Biru (kiri): Total customers
- Ungu (kanan): Growth percentage

**Interactive Features**:
- Hover untuk melihat data point
- Responsive design

**Statistics**:
- 2025 Total Customers
- Total Growth 2020-2025
- Average Annual Growth
- Customer Increase

**Update Otomatis**:
- Setiap tambah/edit data di admin panel
- Refresh halaman untuk update chart

---

### 2. **BTS Coverage Map**

**Google Maps Features**:
- Interactive map of Indonesia
- Dynamic markers (size = BTS count)
- Click marker untuk info popup

**Marker Information**:
- Island name
- BTS count
- Population
- Coverage percentage

**Coverage Statistics Cards**:
- Total Islands
- Total BTS Towers
- Average BTS per Island
- Average Coverage Percentage

**Island List**:
- Daftar semua pulau
- Progress bar untuk coverage
- Sortasi berdasarkan BTS count

**Update Otomatis**:
- Setiap tambah/edit data di admin panel
- Refresh halaman untuk update peta

---

## 🔍 How Data Flows

### News Creation Flow
```
Admin Panel (Form)
    ↓
Submit Data → JavaScript Fetch API
    ↓
/backend/routes/news.php (POST)
    ↓
NewsService → NewsModel → MySQL
    ↓
XML Backup → /storage/xml/
    ↓
Return Success
    ↓
Table Update → News.php Load → Display
```

### Growth Data Flow
```
Admin Panel (Form)
    ↓
Submit Data → Fetch API
    ↓
/backend/routes/customer_growth.php (POST)
    ↓
CustomerGrowthService → Model → MySQL
    ↓
Return Success
    ↓
Chart Update → About.html Load → Display
```

### Coverage Data Flow
```
Admin Panel (Form)
    ↓
Submit Data → Fetch API
    ↓
/backend/routes/bts_coverage.php (POST)
    ↓
BTSCoverageService → Model → MySQL
    ↓
Return Success
    ↓
Map Update → About.html Load → Display
```

---

## 💾 Backup & Recovery

### Automatic XML Backup
- **News**: Setiap create/update/delete
- **Coverage**: Setiap create/update/delete
- **Location**: `/storage/xml/`
- **Format**: `[table]_[id]_backup.xml`

### Manual Backup
1. Buka `/storage/xml/`
2. Download semua XML files
3. Simpan di tempat aman

### Recovery (Jika Diperlukan)
1. Hubungi administrator
2. Gunakan XML backup untuk restore
3. Database dapat di-rebuild dari XML files

---

## 🔐 Security Tips

1. **Password**: Ganti password default admin segera
2. **Folder Permissions**: `chmod 755 storage/xml`
3. **Backups**: Regular backup ke external storage
4. **HTTPS**: Gunakan HTTPS di production
5. **API Keys**: Keep Google Maps API key secret

---

## 📱 Mobile Access

Semua halaman responsive untuk:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (<768px)

**Admin Panel di Mobile**:
- Sidebar menjadi top navigation
- Form tetap responsive
- Semua fitur accessible

**News Page di Mobile**:
- Single column layout
- Easy navigation
- Touch-friendly buttons

---

## ⚡ Troubleshooting

### Problem: Chart tidak tampil di About.html
**Solution**: 
- Pastikan database sudah diisi data pertumbuhan
- Check browser console untuk error
- Refresh halaman

### Problem: Map marker tidak muncul
**Solution**:
- Verifikasi Google Maps API key valid
- Check koordinat latitude/longitude benar
- Browser console check untuk error

### Problem: News tidak ter-save di admin
**Solution**:
- Check `/storage/xml/` folder writable
- Verify database connection working
- Check form validation errors

### Problem: 404 pada article detail
**Solution**:
- Ensure article status = "published"
- Verify slug format correct
- Clear browser cache

---

## 📊 Sample Workflows

### Workflow 1: Publish News
```
1. Admin Panel → News Tab
2. Click "New Article"
3. Fill form (title, category, content, image)
4. Select "Published" status
5. Click "Save"
6. Go to /News.php → Article appears
7. Click article → Detail view loads
```

### Workflow 2: Update Customer Growth
```
1. Admin Panel → Customer Growth Tab
2. Click "Add Year"
3. Enter: Year = 2025, Customers = 35000
4. Click "Save"
5. Go to /About.html
6. Refresh page
7. Chart updates automatically
```

### Workflow 3: Add BTS Coverage
```
1. Admin Panel → BTS Coverage Tab
2. Click "Add Area"
3. Fill: Island = Jawa, BTS = 3500, Coverage = 98.5%
4. Fill coordinates (lat/lng)
5. Click "Save"
6. Go to /About.html
7. Refresh → Map marker appears
```

---

## 🎓 Best Practices

### For News Articles
- Use descriptive titles
- Add relevant images
- Write 100+ character content
- Use proper categories
- Save as draft first, then publish

### For Growth Data
- Update annually
- Verify numbers before saving
- System calculates growth % auto
- Keep historical data

### For Coverage Areas
- Use exact coordinates
- Add population data
- Verify BTS counts
- Update quarterly if possible

---

## 📞 Support

If you need help:
1. Check README.md for full documentation
2. Review QUICK_START.md for setup
3. Check browser console for errors
4. Verify all folders have correct permissions
5. Ensure database is running

---

## ✅ Verification Checklist

Before going live:
- [ ] Database created and data loaded
- [ ] `/storage/xml/` folder exists and writable
- [ ] Admin panel accessible
- [ ] Can create/edit/delete news
- [ ] News appears on /News.php
- [ ] Chart loads on /About.html
- [ ] Map loads with markers
- [ ] Google Maps API key configured
- [ ] All links working
- [ ] Mobile responsive working
- [ ] Backups being created

---

**Happy using Towerindo Admin System!** 🎉

Last Updated: January 6, 2025
