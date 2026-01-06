# 🔗 Quick Links - Akses Cepat Aplikasi

Panduan akses cepat untuk semua halaman dan fitur aplikasi Towerindo.

---

## 🏠 Main Pages

| Halaman | URL | Deskripsi |
|---------|-----|-----------|
| Homepage | `http://localhost/UAS_sysint/Index.html` | Halaman utama dengan hero section |
| About Us | `http://localhost/UAS_sysint/About.html` | Tentang perusahaan + Grafik + Peta |
| News | `http://localhost/UAS_sysint/News.php` | Daftar artikel dari database |
| Solutions | `http://localhost/UAS_sysint/solution.html` | Solusi kami |
| Setup Helper | `http://localhost/UAS_sysint/setup.html` | Interactive setup guide |

---

## 👨‍💼 Admin Panel

| Fungsi | URL | Akses |
|--------|-----|-------|
| Admin Dashboard | `http://localhost/UAS_sysint/admin/` | [Buka](http://localhost/UAS_sysint/admin/) |
| News Manager | Dashboard → News Tab | Create/Edit/Delete Articles |
| Growth Manager | Dashboard → Growth Tab | Add/Edit Growth Data |
| Coverage Manager | Dashboard → Coverage Tab | Manage BTS Areas |

---

## 📚 Documentation Files

| File | Akses | Konten |
|------|-------|--------|
| README.md | [Buka](README.md) | Full documentation lengkap |
| QUICK_START.md | [Buka](QUICK_START.md) | Setup dalam 5 langkah |
| HOW_TO_USE.md | [Buka](HOW_TO_USE.md) | Panduan penggunaan detail |
| PROJECT_STRUCTURE.md | [Buka](PROJECT_STRUCTURE.md) | Arsitektur project |
| IMPLEMENTATION_SUMMARY.md | [Buka](IMPLEMENTATION_SUMMARY.md) | Checklist fitur |
| FILES_CREATED.md | [Buka](FILES_CREATED.md) | Listing semua file |
| SETUP_COMPLETE.md | [Buka](SETUP_COMPLETE.md) | Status implementasi |

---

## 🗄️ Database

### Import Database
```bash
mysql -u root < backend/config/database.sql
```

### Database Details
- **Name**: towerindo_db
- **Host**: localhost
- **User**: root
- **Password**: (empty - XAMPP default)

### Tables
1. users - Admin users
2. news - Articles with XML backup
3. customer_growth - Growth data 2020-2025
4. bts_coverage - Coverage areas
5. admin_logs - Activity tracking

---

## 🔐 Admin Access

### Default Credentials
```
Username: admin
Email: admin@towerindo.com
```

### Access Points
- Admin Panel: `/admin/`
- API Routes: `/backend/routes/`
- Models: `/backend/models/`
- Services: `/backend/services/`

---

## 📊 API Endpoints

### News API
```
GET    /backend/routes/news.php?route=published
GET    /backend/routes/news.php?route=SLUG
POST   /backend/routes/news.php?route=create
PUT    /backend/routes/news.php?route=ID
DELETE /backend/routes/news.php?route=ID
```

### Growth API
```
GET    /backend/routes/customer_growth.php
GET    /backend/routes/customer_growth.php?type=chart
GET    /backend/routes/customer_growth.php?type=analysis
POST   /backend/routes/customer_growth.php
DELETE /backend/routes/customer_growth.php
```

### Coverage API
```
GET    /backend/routes/bts_coverage.php
GET    /backend/routes/bts_coverage.php?type=map
GET    /backend/routes/bts_coverage.php?type=stats
POST   /backend/routes/bts_coverage.php
PUT    /backend/routes/bts_coverage.php
DELETE /backend/routes/bts_coverage.php
```

---

## 📱 Frontend Features

### About.html (Enhanced)
- **Customer Growth Chart**: Interactive visualization of 2020-2025 data
- **BTS Coverage Map**: Google Maps with dynamic markers
- **Statistics**: Cards showing key metrics

### News.php (Dynamic)
- Automatic article loading from database
- Pagination support
- Article preview with "Read More" links

### news_detail.php (Detail View)
- Full article content
- Author and date information
- Featured image display

---

## 🛠️ Setup Steps

### 1. Prepare Database
```bash
# Start MySQL
/Applications/XAMPP/bin/mysql.server start

# Create database
mysql -u root < backend/config/database.sql

# Create folders
mkdir -p storage/xml storage/logs storage/uploads
chmod 755 storage/xml
```

### 2. Verify Installation
- [ ] Database created
- [ ] Storage folders exist
- [ ] Admin panel accessible
- [ ] News articles visible
- [ ] Chart displays
- [ ] Map shows markers

### 3. Configure (Optional)
- Add Google Maps API key in `About.html`
- Update `.env.example` if needed
- Customize branding/colors

---

## 📁 Important Folders

| Folder | Tujuan | Permissions |
|--------|--------|-------------|
| `/backend/` | Backend code | 755 |
| `/admin/` | Admin panel | 755 |
| `/assets/` | CSS, JS, Images | 755 |
| `/storage/xml/` | XML backups | 755 (must be writable) |
| `/storage/logs/` | Application logs | 755 |
| `/storage/uploads/` | Uploaded files | 755 |

---

## 🔍 Monitoring & Debugging

### Check Database
```bash
mysql -u root
mysql> USE towerindo_db;
mysql> SHOW TABLES;
mysql> SELECT * FROM news;
```

### Check Logs
```bash
cat storage/logs/app.log
```

### Check XML Backups
```bash
ls -la storage/xml/
```

---

## 📞 Support Resources

### File References
- Database: `backend/config/database.sql`
- Models: `backend/models/*.php`
- Services: `backend/services/*.php`
- Routes: `backend/routes/*.php`
- Admin UI: `admin/index.html`

### Code Examples
- CRUD operations in Models
- Business logic in Services
- API handling in Routes
- Form submission in Admin UI

### Troubleshooting
- Check `.htaccess` for routing issues
- Verify folder permissions
- Check browser console for JS errors
- Review PHP error logs
- Test API endpoints in Postman

---

## 🎯 Common Tasks

### Add News Article
1. Go to `/admin/`
2. Click "New Article" button
3. Fill form (title, category, content, image)
4. Select status (Draft/Published)
5. Click "Save"
6. View on `/News.php`

### Update Growth Data
1. Go to `/admin/`
2. Switch to "Customer Growth" tab
3. Click "Add Year"
4. Enter year and total customers
5. Click "Save"
6. Check chart on `/About.html` (refresh)

### Add Coverage Area
1. Go to `/admin/`
2. Switch to "BTS Coverage" tab
3. Click "Add Area"
4. Enter island info (name, BTS count, coordinates)
5. Click "Save"
6. Check map on `/About.html` (refresh)

---

## 💻 System Requirements

### Minimum
- PHP 7.4+
- MySQL 5.7+
- Apache with mod_rewrite
- 50 MB disk space

### Recommended
- PHP 8.0+
- MySQL 8.0+
- SSD storage
- 4GB RAM
- HTTPS certificate

### Browsers
- Chrome/Chromium (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS/Android)

---

## 🚀 Deployment Checklist

Before going to production:
- [ ] Database fully configured
- [ ] All folders with correct permissions
- [ ] Admin password changed
- [ ] Google Maps API key added
- [ ] HTTPS certificate installed
- [ ] Backups strategy in place
- [ ] Error logging enabled
- [ ] Security headers configured
- [ ] Rate limiting implemented
- [ ] Load testing completed

---

## 📞 Contact Information

**Towerindo**
- Email: corporate@towerindo.co.id
- Phone: 021-6722-6722
- Address: Jalan kebonsirih, Tower Hamawara, Lt. 23

---

## 📝 Version Information

- **Version**: 1.0.0
- **Release Date**: January 6, 2025
- **Status**: Production Ready
- **Last Updated**: January 6, 2025
- **License**: © 2025 PT Towerindo

---

## ✨ Quick Navigation

```
[ Homepage ]    [ About Us ]    [ News ]    [ Admin ]    [ Docs ]
   Index.html   About.html      News.php    /admin/     README.md
```

---

**🎯 Start Here**: Read [QUICK_START.md](QUICK_START.md) untuk setup cepat!

---

Generated: January 6, 2025 ✅
