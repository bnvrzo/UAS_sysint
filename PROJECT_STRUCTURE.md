# 📚 Complete Project Structure

```
UAS_sysint/
│
├── 📄 HTML Files (Frontend)
│   ├── Index.html              # Homepage dengan hero section
│   ├── About.html              # About Us dengan GRAFIK PERTUMBUHAN & PETA BTS
│   ├── News.php                # News page DINAMIS dari database
│   ├── news_detail.php         # Detail artikel (DINAMIS)
│   ├── solution.html           # Our Solution page
│   └── New.html                # Additional news (legacy)
│
├── 🔧 Admin Panel
│   └── admin/
│       └── index.html          # Admin Dashboard lengkap
│           ├── News CRUD (Create, Read, Update, Delete)
│           ├── Customer Growth Management
│           ├── BTS Coverage Management
│           └── Responsive UI dengan sidebar navigation
│
├── 🚀 Backend API & Services
│   └── backend/
│       ├── config/
│       │   ├── database.php    # Database connection + XML integration
│       │   ├── database.sql    # SQL schema (8 tables)
│       │   └── helpers.php     # Utility functions
│       │
│       ├── models/
│       │   ├── NewsModel.php
│       │   │   └── Methods: getAll(), getBySlug(), create(), update(), delete(), search()
│       │   ├── CustomerGrowthModel.php
│       │   │   └── Methods: getAll(), getByYear(), upsert(), delete(), getChartData()
│       │   └── BTSCoverageModel.php
│       │       └── Methods: getAll(), create(), update(), delete(), getMapData(), getStatistics()
│       │
│       ├── services/
│       │   ├── NewsService.php
│       │   │   └── Business logic: validation, search, CRUD operations
│       │   ├── CustomerGrowthService.php
│       │   │   └── Data management: chart data, analysis, statistics
│       │   └── BTSCoverageService.php
│       │       └── Coverage management: map data, reports, analytics
│       │
│       └── routes/
│           ├── news.php              # REST API untuk news
│           │   ├── GET /published    - Dapatkan published news
│           │   ├── GET /SLUG         - Detail by slug
│           │   ├── POST /create      - Create news
│           │   ├── PUT /ID           - Update news
│           │   └── DELETE /ID        - Delete news
│           │
│           ├── customer_growth.php    # REST API untuk growth data
│           │   ├── GET               - Get all data
│           │   ├── GET ?type=chart   - Chart data
│           │   ├── GET ?type=analysis- Analysis
│           │   ├── POST              - Add/update
│           │   └── DELETE            - Delete
│           │
│           ├── bts_coverage.php       # REST API untuk BTS coverage
│           │   ├── GET               - Get all coverage
│           │   ├── GET ?type=map     - Map data
│           │   ├── GET ?type=stats   - Statistics
│           │   ├── POST              - Add coverage
│           │   ├── PUT               - Update coverage
│           │   └── DELETE            - Delete coverage
│           │
│           └── auth.php              # Authentication
│               ├── POST ?action=login
│               ├── POST ?action=logout
│               └── GET ?action=status
│
├── 📦 Assets
│   └── assets/
│       ├── bootstrap/
│       │   ├── css/
│       │   │   ├── bootstrap.min.css
│       │   │   ├── bootstrap-grid.min.css
│       │   │   └── bootstrap-reboot.min.css
│       │   └── js/
│       │       └── bootstrap.bundle.min.js
│       │
│       ├── theme/
│       │   ├── css/style.css
│       │   └── js/script.js
│       │
│       ├── dropdown/
│       │   ├── css/style.css
│       │   └── js/navbar-dropdown.js
│       │
│       ├── animatecss/
│       │   └── animate.css
│       │
│       ├── images/
│       │   ├── download-96x143.jpeg  (logo)
│       │   ├── download-1-784x1168.jpeg
│       │   ├── download-2-784x1168.jpeg
│       │   ├── download-3-784x1168.jpeg
│       │   └── hashes.json
│       │
│       ├── mobirise/
│       │   └── css/mbr-additional.css
│       │
│       ├── smoothscroll/
│       │   └── smooth-scroll.js
│       │
│       ├── web/
│       │   └── assets/
│       │       └── mobirise-icons2/
│       │           └── mobirise2.css
│       │
│       └── ytplayer/
│           └── index.js
│
├── 💾 Storage
│   └── storage/
│       ├── xml/                 # XML backup files (auto-generated)
│       │   ├── news_*.xml
│       │   ├── bts_coverage_*.xml
│       │   └── news_backup_*.xml
│       │
│       ├── logs/               # Application logs
│       │   └── app.log
│       │
│       └── uploads/            # File uploads (future)
│
├── 📖 Documentation
│   ├── README.md              # Full documentation
│   ├── QUICK_START.md         # Quick start guide
│   ├── setup.html             # Interactive setup guide
│   └── FEATURES.md            # Feature list
│
├── ⚙️ Configuration
│   ├── .htaccess              # Apache rewrite rules & security
│   └── composer.json          # (Optional) For package management
│
└── 🔗 Helper Files
    ├── get_dynamic_news.php   # Dynamic news loader
    └── index.php              # (Optional) Router
```

## 🎯 Key Features by Component

### Frontend (HTML/JavaScript)
✅ Responsive Bootstrap 5 design
✅ Chart.js for customer growth visualization
✅ Google Maps API integration for BTS coverage
✅ Smooth scrolling navigation
✅ Mobile-friendly hamburger menu
✅ Admin quick access button

### Backend (PHP)
✅ MVC Architecture (Models, Services, Routes)
✅ RESTful API design
✅ Prepared statements (SQL injection protection)
✅ JSON request/response handling
✅ Session-based authentication
✅ CORS headers support

### Database (MySQL)
✅ 5 main tables + 1 log table
✅ Relationships with foreign keys
✅ Indexes for performance
✅ XML backup integration
✅ Automatic timestamps (created_at, updated_at)

### Security
✅ Password hashing (bcrypt)
✅ HTML sanitization (htmlspecialchars)
✅ Prepared statements (mysqli::prepare)
✅ .htaccess file restrictions
✅ Activity logging
✅ XML backup & recovery
✅ File permission management

## 📊 Database Tables

1. **users** (4 fields)
   - id, username, email, password, role, created_at, updated_at

2. **news** (10 fields)
   - id, title, slug, content, image_url, author_id, category, status, published_at, xml_backup_path

3. **customer_growth** (4 fields)
   - id, year, total_customers, growth_percentage, created_at

4. **bts_coverage** (9 fields)
   - id, island_name, bts_count, population, coverage_percentage, latitude, longitude, xml_backup_path

5. **admin_logs** (6 fields)
   - id, user_id, action, table_name, record_id, changes, created_at

## 🔄 Data Flow

```
Admin Panel (admin/index.html)
    ↓
    ├─→ News Form → API (routes/news.php) → NewsService → NewsModel → MySQL
    │                                                                      ↓
    │                                                                    XML Backup
    │
    ├─→ Growth Form → API (routes/customer_growth.php) → CustomerGrowthService → MySQL
    │
    └─→ Coverage Form → API (routes/bts_coverage.php) → BTSCoverageService → MySQL

Public Pages:
    ├─→ About.html → API (customer_growth.php) → Chart.js visualization
    │            → API (bts_coverage.php) → Google Maps with markers
    │
    ├─→ News.php → API (routes/news.php) → Dynamic article listing
    │
    └─→ news_detail.php → API (routes/news.php?slug=) → Article detail
```

## 🎨 Styling & Design

- **Color Scheme**:
  - Primary: #667eea (Blue)
  - Secondary: #764ba2 (Purple)
  - Success: #28a745 (Green)
  - Light BG: #f8f9fa

- **Typography**:
  - Font Family: 'Inter Tight' (Google Fonts)
  - Headings: Display styles
  - Body: Clear, readable sans-serif

- **Components**:
  - Cards with shadows
  - Gradient backgrounds
  - Responsive grid layouts
  - Progress bars
  - Interactive charts
  - Animated transitions

## 🚀 Performance Optimization

- CSS/JS minification
- Lazy loading images
- Chart.js on-demand
- Google Maps async loading
- Gzip compression (.htaccess)
- Browser caching (Cache-Control headers)
- Indexed database queries

## 📱 Responsive Breakpoints

- Desktop: ≥1200px
- Tablet: 768px - 1199px
- Mobile: <768px

All UI elements adapt automatically with Bootstrap's grid system.

## 🔐 User Roles

- **Admin**: Full access to CRUD operations, can manage all content
- **User**: Read-only access (future implementation)
- **Guest**: Can view published content only

## 📈 Scalability Features

- Modular architecture for easy expansion
- Service layer for business logic separation
- API endpoints for future mobile app
- XML backup for disaster recovery
- Activity logging for audit trail
- Database optimization with indexes

---

**Last Updated**: January 6, 2025
**Version**: 1.0.0
**Status**: Production Ready ✅
