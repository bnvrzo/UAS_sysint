<?php
/**
 * Main Application Router
 * Handles routing untuk API dan pages
 */

// Set error handling
error_reporting(E_ALL);
ini_set('display_errors', false);

// Load configuration dan helpers
require_once __DIR__ . '/backend/config/database.php';
require_once __DIR__ . '/backend/config/helpers.php';

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get request path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_path = str_replace('/UAS_sysint', '', $request_uri);
$request_method = $_SERVER['REQUEST_METHOD'];

// Route requests
switch (true) {
    // News API
    case preg_match('/^\/api\/news/', $request_path):
        require __DIR__ . '/backend/routes/news.php';
        break;

    // Customer Growth API
    case preg_match('/^\/api\/growth/', $request_path):
        require __DIR__ . '/backend/routes/customer_growth.php';
        break;

    // BTS Coverage API
    case preg_match('/^\/api\/coverage/', $request_path):
        require __DIR__ . '/backend/routes/bts_coverage.php';
        break;

    // Auth API
    case preg_match('/^\/api\/auth/', $request_path):
        require __DIR__ . '/backend/routes/auth.php';
        break;

    // Default - serve static files or show error
    default:
        // Check if file exists
        $file = __DIR__ . $request_path;
        if (file_exists($file) && is_file($file)) {
            // Serve the file
            $mime_types = [
                'html' => 'text/html',
                'css' => 'text/css',
                'js' => 'text/javascript',
                'json' => 'application/json',
                'xml' => 'application/xml',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                'pdf' => 'application/pdf'
            ];
            
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $mime = $mime_types[$ext] ?? 'application/octet-stream';
            
            header('Content-Type: ' . $mime);
            readfile($file);
        } else {
            // 404 error
            http_response_code(404);
            Response::error('Not Found', null, 404);
        }
        break;
}
?>
