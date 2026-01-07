<?php
/**
 * News Service
 * Handles business logic for news operations
 */

require_once __DIR__ . '/../models/NewsModel.php';

class NewsService {
    private $model;

    public function __construct() {
        $this->model = new NewsModel();
    }

    // Get published news with pagination
    public function getPublishedNews($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $news = $this->model->getAllPublished($limit, $offset);
        $total = $this->model->getTotalCount();

        return [
            'data' => $news,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ];
    }

    // Get all news (admin view)
    public function getAllNews($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $news = $this->model->getAll($limit, $offset);
        $total = $this->model->getTotalCount();

        return [
            'data' => $news,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ];
    }

    // Get news by slug
    public function getNewsBySlug($slug) {
        $news = $this->model->getBySlug($slug);
        if (!$news) {
            return ['success' => false, 'error' => 'News not found'];
        }
        return ['success' => true, 'data' => $news];
    }

    // Get news by ID (for admin/edit)
    public function getNewsById($id) {
        $news = $this->model->getById($id);
        if (!$news) {
            return ['success' => false, 'error' => 'News not found'];
        }
        return ['success' => true, 'data' => $news];
    }

    // Create new article
    public function createNews($title, $content, $category, $author_id, $image_url = null, $status = 'draft') {
        if (empty($title) || empty($content)) {
            return ['success' => false, 'error' => 'Title and content are required'];
        }

        $data = [
            'title' => htmlspecialchars($title),
            'content' => $content, // Keep HTML for rich text editor
            'category' => htmlspecialchars($category),
            'author_id' => intval($author_id),
            'image_url' => $image_url,
            'status' => $status
        ];

        return $this->model->create($data);
    }

    // Update news
    public function updateNews($id, $title, $content, $category, $image_url = null, $status = 'draft') {
        if (empty($title) || empty($content)) {
            return ['success' => false, 'error' => 'Title and content are required'];
        }

        $data = [
            'title' => htmlspecialchars($title),
            'content' => $content,
            'category' => htmlspecialchars($category),
            'image_url' => $image_url,
            'status' => $status
        ];

        return $this->model->update($id, $data);
    }

    // Delete news
    public function deleteNews($id) {
        return $this->model->delete($id);
    }

    // Search news
    public function searchNews($keyword, $page = 1, $limit = 10) {
        if (empty($keyword)) {
            return ['success' => false, 'error' => 'Search keyword is required'];
        }

        $offset = ($page - 1) * $limit;
        $results = $this->model->search($keyword, $limit, $offset);

        return [
            'success' => true,
            'data' => $results,
            'query' => $keyword
        ];
    }

    // Validate news data
    public function validate($data) {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = 'Title is required';
        }
        if (strlen($data['title']) > 255) {
            $errors[] = 'Title must be less than 255 characters';
        }

        if (empty($data['content'])) {
            $errors[] = 'Content is required';
        }

        if (empty($data['category'])) {
            $errors[] = 'Category is required';
        }

        return count($errors) === 0 ? ['valid' => true] : ['valid' => false, 'errors' => $errors];
    }
}
?>
