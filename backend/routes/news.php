<?php
/**
 * News API Routes
 * Handles all news CRUD operations
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

session_start();
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../services/NewsService.php';

$service = new NewsService();
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_GET['route'] ?? '', '/'));

$response = ['success' => false];

try {
    switch ($method) {
        case 'GET':
            // Search has priority when ?search= is provided
            if (isset($_GET['search'])) {
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $response = $service->searchNews($_GET['search'], $page);
            } elseif (isset($request[0]) && $request[0] === 'published') {
                // Get published news
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
                $response = $service->getPublishedNews($page, $limit);
            } elseif (isset($request[0]) && $request[0] === 'all') {
                // Admin: get all news
                if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
                    Response::unauthorized('Admin login required');
                }
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
                $response = $service->getAllNews($page, $limit);
            } elseif (isset($request[0]) && !is_numeric($request[0]) && $request[0] !== '') {
                // Get news by slug
                $response = $service->getNewsBySlug($request[0]);
            } elseif (isset($request[0]) && is_numeric($request[0])) {
                // Get news by ID (admin edit)
                $id = intval($request[0]);
                $response = $service->getNewsById($id);
            }
            break;

        case 'POST':
            if (isset($request[0]) && $request[0] === 'create') {
                // Create news (Admin only)
                if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
                    Response::unauthorized('Admin login required');
                }
                $data = json_decode(file_get_contents("php://input"), true);
                
                $validation = $service->validate($data);
                if (!$validation['valid']) {
                    $response = $validation;
                    break;
                }

                $response = $service->createNews(
                    $data['title'],
                    $data['content'],
                    $data['category'],
                    $data['author_id'],
                    $data['image_url'] ?? null,
                    $data['status'] ?? 'draft'
                );
            }
            break;

        case 'PUT':
            if (isset($request[0]) && is_numeric($request[0])) {
                // Update news (Admin only)
                if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
                    Response::unauthorized('Admin login required');
                }
                $id = intval($request[0]);
                $data = json_decode(file_get_contents("php://input"), true);

                $validation = $service->validate($data);
                if (!$validation['valid']) {
                    $response = $validation;
                    break;
                }

                $response = $service->updateNews(
                    $id,
                    $data['title'],
                    $data['content'],
                    $data['category'],
                    $data['image_url'] ?? null,
                    $data['status'] ?? 'draft'
                );
            }
            break;

        case 'DELETE':
            if (isset($request[0]) && is_numeric($request[0])) {
                // Delete news (Admin only)
                if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
                    Response::unauthorized('Admin login required');
                }
                $id = intval($request[0]);
                $response = $service->deleteNews($id);
            }
            break;
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

// Ensure consistent response shape for front-end
if (!isset($response['success'])) {
    if (isset($response['valid'])) {
        $response = array_merge(['success' => (bool)$response['valid']], $response);
    } elseif (isset($response['errors'])) {
        $response = array_merge(['success' => false], $response);
    } else {
        $response = array_merge(['success' => true], $response);
    }
}

echo json_encode($response);
?>
