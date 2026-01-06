<?php
/**
 * Dynamic News Page PHP
 * This file will be included by News.html to display news from database
 */

require_once __DIR__ . '/backend/config/database.php';
require_once __DIR__ . '/backend/models/NewsModel.php';
require_once __DIR__ . '/backend/services/NewsService.php';

$service = new NewsService();

// Get page from query string
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Get published news
$newsData = $service->getPublishedNews($page, 6);

// Generate HTML for news items
$newsHTML = '';

if (isset($newsData['data']) && count($newsData['data']) > 0) {
    foreach ($newsData['data'] as $index => $news) {
        $date = date('d M Y', strtotime($news['published_at']));
        $imageUrl = $news['image_url'] ?? 'assets/images/download-2-784x1168.jpeg';
        
        // Truncate content for preview
        $preview = substr(strip_tags($news['content']), 0, 150) . '...';
        
        // Alternate layout
        if ($index % 2 == 0) {
            $newsHTML .= '
            <section data-bs-version="5.1" class="article4 cid-dynamic-' . $news['id'] . '" id="article04-' . $news['id'] . '">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-5 image-wrapper">
                            <img class="w-100" src="' . htmlspecialchars($imageUrl) . '" alt="' . htmlspecialchars($news['title']) . '">
                        </div>
                        <div class="col-12 col-md-12 col-lg">
                            <div class="text-wrapper align-left">
                                <h1 class="mbr-section-title mbr-fonts-style mb-4 display-5"><strong>' . htmlspecialchars($news['title']) . '</strong></h1>
                                <p class="mbr-text mbr-fonts-style mb-2 display-7"><small class="text-muted">' . $date . ' | ' . htmlspecialchars($news['category']) . ' | By ' . htmlspecialchars($news['author_name']) . '</small></p>
                                <p class="mbr-text mbr-fonts-style mb-4 display-7">' . $preview . '</p>
                                <div class="mbr-section-btn mt-3"><a class="btn btn-lg btn-success-outline display-7" href="news_detail.php?slug=' . htmlspecialchars($news['slug']) . '">Read More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>';
        } else {
            $newsHTML .= '
            <section data-bs-version="5.1" class="article2 cid-dynamic-' . $news['id'] . '" id="article02-' . $news['id'] . '">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg">
                            <div class="text-wrapper align-right">
                                <h1 class="mbr-section-title mbr-fonts-style mb-4 display-5"><strong>' . htmlspecialchars($news['title']) . '</strong></h1>
                                <p class="mbr-text mbr-fonts-style mb-2 display-7"><small class="text-muted">' . $date . ' | ' . htmlspecialchars($news['category']) . ' | By ' . htmlspecialchars($news['author_name']) . '</small></p>
                                <p class="mbr-text mbr-fonts-style mb-4 display-7">' . $preview . '</p>
                                <div class="mbr-section-btn mt-3"><a class="btn btn-lg btn-success-outline display-7" href="news_detail.php?slug=' . htmlspecialchars($news['slug']) . '">Read More</a></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5 image-wrapper">
                            <img class="w-100" src="' . htmlspecialchars($imageUrl) . '" alt="' . htmlspecialchars($news['title']) . '">
                        </div>
                    </div>
                </div>
            </section>';
        }
    }
} else {
    $newsHTML = '<div class="alert alert-info" style="margin: 40px;">No news available yet.</div>';
}

// Pagination HTML
$pagination = '';
if (isset($newsData['pagination']) && $newsData['pagination']['pages'] > 1) {
    $pagination = '<nav aria-label="Page navigation" style="margin: 40px; text-align: center;"><ul class="pagination justify-content-center">';
    
    for ($i = 1; $i <= $newsData['pagination']['pages']; $i++) {
        $active = ($i == $page) ? 'active' : '';
        $pagination .= '<li class="page-item ' . $active . '"><a class="page-link" href="News.php?page=' . $i . '">' . $i . '</a></li>';
    }
    
    $pagination .= '</ul></nav>';
}

echo '<div id="dynamic-news-container">' . $newsHTML . '</div>';
echo $pagination;
?>
