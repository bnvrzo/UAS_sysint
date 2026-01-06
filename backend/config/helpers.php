<?php
/**
 * Utility Functions
 * Helper functions untuk aplikasi
 */

// Logging Helper
class Logger {
    private static $log_file = __DIR__ . '/../../storage/logs/app.log';

    public static function init() {
        $dir = dirname(self::$log_file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    public static function log($level, $message, $context = []) {
        self::init();
        
        $timestamp = date('Y-m-d H:i:s');
        $log_message = "[$timestamp] [$level] $message";
        
        if (!empty($context)) {
            $log_message .= " " . json_encode($context);
        }
        
        error_log($log_message . "\n", 3, self::$log_file);
    }

    public static function info($message, $context = []) {
        self::log('INFO', $message, $context);
    }

    public static function error($message, $context = []) {
        self::log('ERROR', $message, $context);
    }

    public static function warning($message, $context = []) {
        self::log('WARNING', $message, $context);
    }
}

// Activity Logger
class ActivityLogger {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function log($user_id, $action, $table_name, $record_id, $changes = null) {
        $query = "INSERT INTO admin_logs (user_id, action, table_name, record_id, changes)
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $changes_json = is_array($changes) ? json_encode($changes) : $changes;
        $stmt->bind_param("issis", $user_id, $action, $table_name, $record_id, $changes_json);
        
        return $stmt->execute();
    }

    public function getLog($limit = 100) {
        $query = "SELECT l.*, u.username FROM admin_logs l
                  JOIN users u ON l.user_id = u.id
                  ORDER BY l.created_at DESC
                  LIMIT ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// String Utilities
class StringHelper {
    public static function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');
        return strtolower($text);
    }

    public static function truncate($text, $length = 100, $suffix = '...') {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . $suffix;
    }

    public static function sanitize($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

// Validation Helper
class Validator {
    public static function email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function url($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public static function required($value) {
        return !empty(trim($value));
    }

    public static function minLength($value, $length) {
        return strlen($value) >= $length;
    }

    public static function maxLength($value, $length) {
        return strlen($value) <= $length;
    }

    public static function numeric($value) {
        return is_numeric($value);
    }

    public static function date($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}

// Response Helper
class Response {
    public static function json($data, $status_code = 200) {
        header('Content-Type: application/json');
        http_response_code($status_code);
        echo json_encode($data);
        exit;
    }

    public static function success($message, $data = null, $status_code = 200) {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }

    public static function error($message, $data = null, $status_code = 400) {
        self::json([
            'success' => false,
            'error' => $message,
            'data' => $data
        ], $status_code);
    }

    public static function notFound($message = 'Not Found') {
        self::error($message, null, 404);
    }

    public static function unauthorized($message = 'Unauthorized') {
        self::error($message, null, 401);
    }
}

// Format Helper
class Formatter {
    public static function currency($amount) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public static function date($date, $format = 'd M Y') {
        try {
            $d = new DateTime($date);
            return $d->format($format);
        } catch (Exception $e) {
            return $date;
        }
    }

    public static function number($number) {
        return number_format($number, 0, ',', '.');
    }

    public static function fileSize($bytes) {
        $units = array('B', 'KB', 'MB', 'GB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

// File Helper
class FileHelper {
    public static function isValidImage($filepath) {
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        return in_array($file_ext, $valid_extensions);
    }

    public static function uploadFile($file, $directory, $max_size = 5242880) {
        if ($file['size'] > $max_size) {
            return ['success' => false, 'error' => 'File too large'];
        }

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = time() . '_' . basename($file['name']);
        $filepath = $directory . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return ['success' => true, 'filename' => $filename, 'path' => $filepath];
        }

        return ['success' => false, 'error' => 'Upload failed'];
    }

    public static function deleteFile($filepath) {
        if (file_exists($filepath)) {
            return unlink($filepath);
        }
        return false;
    }
}

// Initialize storage directories
function initializeStorage() {
    $dirs = [
        __DIR__ . '/../../storage/xml',
        __DIR__ . '/../../storage/logs',
        __DIR__ . '/../../storage/uploads'
    ];

    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

initializeStorage();
?>
