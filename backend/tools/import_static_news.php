<?php
/**
 * Import static articles from New.html into `news` table
 */
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';

$html = file_get_contents(__DIR__ . '/../../New.html');
if (!$html) {
    echo "Failed to read New.html\n";
    exit(1);
}

libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($html);
$xpath = new DOMXPath($doc);

// Find article sections (class contains 'article')
$sections = $xpath->query("//section[contains(@class,'article')]");

$db = (new Database())->connect();

$inserted = 0;

foreach ($sections as $sec) {
    // get id
    $idAttr = $sec->getAttribute('id');

    // title: h3.card-title or h1
    $h3 = $xpath->query('.//h3[contains(@class, "card-title")]', $sec);
    $title = $h3->length ? trim($h3->item(0)->textContent) : '';
    if (!$title) continue;

    // image
    $img = $xpath->query('.//img', $sec);
    $image = $img->length ? trim($img->item(0)->getAttribute('src')) : null;

    // content: collect inner HTML of .card-box or the section
    $cardBox = $xpath->query('.//div[contains(@class,"card-box")]', $sec);
    if ($cardBox->length) {
        $contentNode = $cardBox->item(0);
    } else {
        $contentNode = $sec;
    }
    $contentHtml = '';
    foreach ($contentNode->childNodes as $child) {
        $contentHtml .= $doc->saveHTML($child);
    }

    // basic fields
    $slug = StringHelper::slugify($title);
    // ensure slug uniqueness
    $counter = 1;
    $base = $slug;
    $stmtCheck = $db->prepare("SELECT id FROM news WHERE slug = ? LIMIT 1");
    while (true) {
        $stmtCheck->bind_param('s', $slug);
        $stmtCheck->execute();
        $res = $stmtCheck->get_result();
        if ($res && $res->num_rows > 0) {
            $slug = $base . '-' . $counter;
            $counter++;
        } else {
            break;
        }
    }

    $category = 'General';
    $author_id = 1;
    $status = 'published';
    $published_at = date('Y-m-d H:i:s');

    $query = "INSERT INTO news (title, slug, content, image_url, author_id, category, status, published_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ssssisds', $title, $slug, $contentHtml, $image, $author_id, $category, $status, $published_at);
    // Note: bind_param types corrected below via dynamic binding because of mixed types
    $stmt = $db->prepare($query);
    if ($stmt === false) {
        echo "Prepare failed: " . $db->error . "\n";
        continue;
    }
    $stmt->bind_param('ssssisss', $title, $slug, $contentHtml, $image, $author_id, $category, $status, $published_at);

    if ($stmt->execute()) {
        echo "Inserted: " . $db->insert_id . " - $title\n";
        $inserted++;
    } else {
        echo "Insert failed: " . $stmt->error . "\n";
    }
}

echo "Done. Inserted $inserted articles.\n";

?>