<!DOCTYPE html>
<html  >
<head>
  <!-- Site made with Mobirise Website Builder v5.9.6, https://mobirise.com -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="generator" content="Mobirise v5.9.6, mobirise.com">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  <link rel="shortcut icon" href="assets/images/download-96x143.jpeg" type="image/x-icon">
  <meta name="description" content="">
  
  
  <title>News</title>
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
    .news-loader {
      text-align: center;
      padding: 40px;
      font-size: 1.2rem;
      color: #666;
    }

    .pagination {
      margin: 40px 0;
    }

    .pagination .page-link {
      color: #667eea;
      border-color: #ddd;
    }

    .pagination .page-link:hover {
      color: white;
      background: #667eea;
      border-color: #667eea;
    }

    .pagination .page-item.active .page-link {
      background: #667eea;
      border-color: #667eea;
    }

    .admin-link {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px 20px;
      border-radius: 25px;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      transition: all 0.3s;
      z-index: 999;
      font-weight: bold;
    }

    .admin-link:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
      color: white;
    }

    @media (max-width: 768px) {
      .admin-link {
        padding: 10px 15px;
        font-size: 0.9rem;
      }
    }
  </style>
  
  
</head>
<body>
  
  <section data-bs-version="5.1" class="menu menu1 cid-v4CIh16WET" once="menu" id="menu01-1t">
	

	<nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg">
		<div class="container">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<a href="Index.html">
						<img src="assets/images/download-96x143.jpeg" alt="Mobirise Website Builder" style="height: 4.1rem;">
					</a>
				</span>
				<span class="navbar-caption-wrap"><a class="navbar-caption text-black text-primary display-4" href="Index.html">Towerindo</a></span>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-toggle="collapse" data-target="#navbarSupportedContent" data-bs-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true"><li class="nav-item">
						<a class="nav-link link text-black text-primary display-4" href="About.html" aria-expanded="false">About Us</a>
					</li><li class="nav-item">
						<a class="nav-link link text-black text-primary display-4" href="solution.html">Our Solution</a>
					</li>
					
					<li class="nav-item"><a class="nav-link link text-black text-primary display-4" href="News.php">News</a></li></ul>
				
				
			</div>
		</div>
	</nav>
</section>

<!-- Dynamic News Content Loader -->
<div id="newsContainer" class="news-loader">Loading news...</div>

<!-- Admin Link -->
<a href="admin/" class="admin-link">📊 Admin Panel</a>

<section class="display-7" style="padding: 0;align-items: center;justify-content: center;flex-wrap: wrap;    align-content: center;display: flex;position: relative;height: 4rem;"><a href="https://mobiri.se/4363774" style="flex: 1 1;height: 4rem;position: absolute;width: 100%;z-index: 1;"><img alt="" style="height: 4rem;" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a><p style="margin: 0;text-align: center;" class="display-7">&#8204;</p><a style="z-index:1" href="https://mobirise.com/builder/ai-website-generator.html">AI Website Generator</a></section><script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>  <script src="assets/smoothscroll/smooth-scroll.js"></script>  <script src="assets/ytplayer/index.js"></script>  <script src="assets/dropdown/js/navbar-dropdown.js"></script>  <script src="assets/theme/js/script.js"></script>  

<script>
// Load dynamic news content
document.addEventListener('DOMContentLoaded', function() {
  const page = new URLSearchParams(window.location.search).get('page') || 1;
  loadNews(page);
});

function loadNews(page = 1) {
  const container = document.getElementById('newsContainer');
  
  fetch(`backend/routes/news.php?route=published&page=${page}&limit=6`)
    .then(r => r.json())
    .then(data => {
      if (data.success && data.data && data.data.length > 0) {
        let html = '';
        
        data.data.forEach((news, index) => {
          const date = new Date(news.published_at).toLocaleDateString('id-ID');
          const imageUrl = news.image_url || 'assets/images/download-2-784x1168.jpeg';
          const preview = news.content.substring(0, 150) + '...';
          
          // Alternate layout
          if (index % 2 === 0) {
            html += `
            <section data-bs-version="5.1" class="article4 cid-news-${news.id}">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-md-12 col-lg-5 image-wrapper">
                    <img class="w-100" src="${imageUrl}" alt="${news.title}">
                  </div>
                  <div class="col-12 col-md-12 col-lg">
                    <div class="text-wrapper align-left">
                      <h1 class="mbr-section-title mbr-fonts-style mb-4 display-5"><strong>${news.title}</strong></h1>
                      <p class="mbr-text mbr-fonts-style mb-2 display-7">
                        <small class="text-muted">${date} | ${news.category} | By ${news.author_name}</small>
                      </p>
                      <p class="mbr-text mbr-fonts-style mb-4 display-7">${preview}</p>
                      <div class="mbr-section-btn mt-3">
                        <a class="btn btn-lg btn-success-outline display-7" href="news_detail.php?slug=${news.slug}">Read More</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>`;
          } else {
            html += `
            <section data-bs-version="5.1" class="article2 cid-news-${news.id}">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-12 col-md-12 col-lg">
                    <div class="text-wrapper align-right">
                      <h1 class="mbr-section-title mbr-fonts-style mb-4 display-5"><strong>${news.title}</strong></h1>
                      <p class="mbr-text mbr-fonts-style mb-2 display-7">
                        <small class="text-muted">${date} | ${news.category} | By ${news.author_name}</small>
                      </p>
                      <p class="mbr-text mbr-fonts-style mb-4 display-7">${preview}</p>
                      <div class="mbr-section-btn mt-3">
                        <a class="btn btn-lg btn-success-outline display-7" href="news_detail.php?slug=${news.slug}">Read More</a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-12 col-lg-5 image-wrapper">
                    <img class="w-100" src="${imageUrl}" alt="${news.title}">
                  </div>
                </div>
              </div>
            </section>`;
          }
        });

        // Add pagination
        if (data.pagination && data.pagination.pages > 1) {
          html += '<nav aria-label="Page navigation" style="margin: 40px; text-align: center;">';
          html += '<ul class="pagination justify-content-center">';
          
          for (let i = 1; i <= data.pagination.pages; i++) {
            const active = (i === parseInt(page)) ? 'active' : '';
            html += `<li class="page-item ${active}"><a class="page-link" href="News.php?page=${i}">${i}</a></li>`;
          }
          
          html += '</ul></nav>';
        }

        container.innerHTML = html;
      } else {
        container.innerHTML = '<p style="text-align: center; padding: 40px; color: #999;">No news articles available yet.</p>';
      }
    })
    .catch(err => {
      console.error('Error loading news:', err);
      container.innerHTML = '<p style="text-align: center; padding: 40px; color: red;">Error loading news. Please try again later.</p>';
    });
}
</script>
  
  
  <input name="animation" type="hidden">
  </body>
</html>
