<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/download-96x143.jpeg" type="image/x-icon">
  <title>News Article - Towerindo</title>
  <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="assets/animatecss/animate.css">
  <link rel="stylesheet" href="assets/dropdown/css/style.css">
  <link rel="stylesheet" href="assets/theme/css/style.css">
  <link rel="preload" href="https://fonts.googleapis.com/css?family=Inter+Tight:100,200,300,400,500,600,700,800,900,100i,200i,300i,400i,500i,600i,700i,800i,900i&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter+Tight:100,200,300,400,500,600,700,800,900,100i,200i,300i,400i,500i,600i,700i,800i,900i&display=swap"></noscript>
  <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css"><link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
  <style>
    .article-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 60px 20px;
      text-align: center;
      margin-top: 80px;
    }
    
    .article-header h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }
    
    .article-meta {
      font-size: 1rem;
      opacity: 0.9;
      margin-bottom: 20px;
    }
    
    .article-content {
      max-width: 800px;
      margin: 40px auto;
      padding: 0 20px;
      line-height: 1.8;
      font-size: 1.1rem;
      color: #333;
    }
    
    .article-image {
      max-width: 100%;
      height: auto;
      margin: 30px 0;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      color: #667eea;
      text-decoration: none;
    }
    
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <section data-bs-version="5.1" class="menu menu1 cid-v4CIh16WET" once="menu">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
      <div class="container">
        <div class="navbar-brand">
          <span class="navbar-logo">
            <a href="Index.html">
              <img src="assets/images/download-96x143.jpeg" alt="Towerindo" style="height: 4.1rem;">
            </a>
          </span>
          <span class="navbar-caption-wrap"><a class="navbar-caption text-black text-primary display-4" href="Index.html">Towerindo</a></span>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
          <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
          </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav nav-dropdown nav-right">
            <li class="nav-item">
              <a class="nav-link link text-black text-primary display-4" href="About.html">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link text-black text-primary display-4" href="solution.html">Our Solution</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link text-black text-primary display-4" href="News.html">News</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </section>

  <!-- Article Content -->
  <div class="article-header">
    <div class="container">
      <a href="News.html" class="back-link">&larr; Back to News</a>
      <h1 id="articleTitle">Loading...</h1>
      <div class="article-meta" id="articleMeta">Loading...</div>
    </div>
  </div>

  <div class="article-content">
    <img id="articleImage" src="" alt="" class="article-image" style="display:none;">
    <div id="articleBody">Loading...</div>
  </div>

  <!-- Footer -->
  <footer style="background: #1a1a2e; color: white; padding: 40px 20px; text-align: center; margin-top: 60px;">
    <p>&copy; 2025 PT Towerindo. All rights reserved.</p>
  </footer>

  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    // Get slug from URL
    const urlParams = new URLSearchParams(window.location.search);
    const slug = urlParams.get('slug');

    if (!slug) {
      document.getElementById('articleBody').innerHTML = '<p style="color: red;">Article not found.</p>';
    } else {
      // Fetch article data from API
      fetch(`backend/routes/news.php?route=${slug}`)
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            const article = data.data;
            document.getElementById('articleTitle').textContent = article.title;
            document.getElementById('articleMeta').textContent = 
              `${new Date(article.published_at).toLocaleDateString('id-ID')} | ${article.category} | By ${article.author_name}`;
            
            if (article.image_url) {
              const img = document.getElementById('articleImage');
              img.src = article.image_url;
              img.style.display = 'block';
            }
            
            document.getElementById('articleBody').innerHTML = article.content;
          } else {
            document.getElementById('articleBody').innerHTML = '<p style="color: red;">Article not found.</p>';
          }
        })
        .catch(err => {
          document.getElementById('articleBody').innerHTML = '<p style="color: red;">Error loading article.</p>';
        });
    }
  </script>
</body>
</html>
