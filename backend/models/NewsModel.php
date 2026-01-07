<?php
/**
 * News Model
 * Handles database operations for news
 */

require_once __DIR__ . '/../config/database.php';

class NewsModel {
    private $db;
    private $table = 'news';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all published news with pagination
    public function getAllPublished($limit = 10, $offset = 0) {
        $query = "SELECT n.*, u.username as author_name 
                  FROM " . $this->table . " n
                  JOIN users u ON n.author_id = u.id
                  WHERE n.status = 'published'
                  ORDER BY n.published_at DESC
                  LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get news by slug
    public function getBySlug($slug) {
        $query = "SELECT n.*, u.username as author_name 
                  FROM " . $this->table . " n
                  JOIN users u ON n.author_id = u.id
                  WHERE n.slug = ? AND n.status = 'published'";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Get news by ID
    public function getById($id) {
        $query = "SELECT n.*, u.username as author_name 
                  FROM " . $this->table . " n
                  JOIN users u ON n.author_id = u.id
                  WHERE n.id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Get all news (for admin)
    public function getAll($limit = 10, $offset = 0) {
        $query = "SELECT n.*, u.username as author_name 
                  FROM " . $this->table . " n
                  JOIN users u ON n.author_id = u.id
                  ORDER BY n.created_at DESC
                  LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Create news
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (title, slug, content, image_url, author_id, category, status, published_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        // Generate slug from title
        $slug = $this->generateSlug($data['title']);
        $published_at = ($data['status'] == 'published') ? date('Y-m-d H:i:s') : null;

        // types: title(s), slug(s), content(s), image_url(s), author_id(i), category(s), status(s), published_at(s)
        $stmt->bind_param(
            "ssssisss",
            $data['title'],
            $slug,
            $data['content'],
            $data['image_url'],
            $data['author_id'],
            $data['category'],
            $data['status'],
            $published_at
        );

        if ($stmt->execute()) {
            $id = $this->db->insert_id;
            
            // Create XML backup
            $this->backupToXML($id);
            
            return ['success' => true, 'id' => $id];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Update news
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET title = ?, slug = ?, content = ?, image_url = ?, category = ?, status = ?, published_at = ?, updated_at = NOW()
                  WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $slug = isset($data['slug']) ? $data['slug'] : $this->generateSlug($data['title']);
        $published_at = ($data['status'] == 'published') ? date('Y-m-d H:i:s') : null;

        // types: title(s), slug(s), content(s), image_url(s), category(s), status(s), published_at(s), id(i)
        $stmt->bind_param(
            "sssssssi",
            $data['title'],
            $slug,
            $data['content'],
            $data['image_url'],
            $data['category'],
            $data['status'],
            $published_at,
            $id
        );

        if ($stmt->execute()) {
            // Create XML backup
            $this->backupToXML($id);
            
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Delete news
    public function delete($id) {
        // Create backup before deleting
        $this->backupToXML($id);

        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Get total count
    public function getTotalCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Generate slug from title
    private function generateSlug($title) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        $slug = substr($slug, 0, 100);
        
        // Check if slug already exists
        $counter = 1;
        $original_slug = $slug;
        while ($this->slugExists($slug)) {
            $slug = $original_slug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    // Check if slug exists
    private function slugExists($slug) {
        $query = "SELECT id FROM " . $this->table . " WHERE slug = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Backup current news to XML
    private function backupToXML($id) {
        $news = $this->getById($id);
        if ($news) {
            $database = new Database();
            $xml_path = $database->exportToXML('news', [$news], 'news_' . $id . '_backup');
            
            // Update xml_backup_path in database
            $query = "UPDATE " . $this->table . " SET xml_backup_path = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $xml_path, $id);
            $stmt->execute();
        }
    }

    // Search news
    public function search($keyword, $limit = 10, $offset = 0) {
        $query = "SELECT n.*, u.username as author_name 
                  FROM " . $this->table . " n
                  JOIN users u ON n.author_id = u.id
                  WHERE (n.title LIKE ? OR n.content LIKE ? OR n.category LIKE ?)
                  AND n.status = 'published'
                  ORDER BY n.published_at DESC
                  LIMIT ? OFFSET ?";

        $search_term = '%' . $keyword . '%';
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sssii", $search_term, $search_term, $search_term, $limit, $offset);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
