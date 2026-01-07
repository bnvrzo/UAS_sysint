<?php
/**
 * Authentication Handler
 * Menangani login, logout, dan session management
 */

session_start();

require_once __DIR__ . '/../config/database.php';

class AuthHandler {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Login user
    public function login($username, $password) {
        $query = "SELECT id, username, email, password, role FROM users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return ['success' => false, 'error' => 'User tidak ditemukan'];
        }

        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = time();

            return ['success' => true, 'role' => $user['role']];
        }

        return ['success' => false, 'error' => 'Password salah'];
    }

    // Logout user
    public function logout() {
        session_destroy();
        return ['success' => true];
    }

    // Check if user is logged in
    public static function isLoggedIn() {
        // Session timeout (seconds)
        $timeout = 3600; // 1 hour

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            return false;
        }

        if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
            // Session expired
            session_unset();
            session_destroy();
            return false;
        }

        // refresh login time
        $_SESSION['login_time'] = time();

        return true;
    }

    // Check if user is admin
    public static function isAdmin() {
        return self::isLoggedIn() && $_SESSION['role'] === 'admin';
    }

    // Get current user
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }

    // Register user (admin only)
    public function register($username, $email, $password, $role = 'user') {
        // Check if user exists
        $query = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'error' => 'Username atau email sudah digunakan'];
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->insert_id];
        }

        return ['success' => false, 'error' => $stmt->error];
    }
}

// Handle requests
$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($action === 'login') {
        $auth = new AuthHandler();
        $result = $auth->login($data['username'] ?? '', $data['password'] ?? '');
        echo json_encode($result);
    } elseif ($action === 'logout') {
        $auth = new AuthHandler();
        $result = $auth->logout();
        echo json_encode($result);
    } elseif ($action === 'register') {
        if (AuthHandler::isAdmin()) {
            $auth = new AuthHandler();
            $result = $auth->register(
                $data['username'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? '',
                $data['role'] ?? 'user'
            );
            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
        }
    }
} elseif ($method === 'GET') {
    if ($action === 'status') {
        echo json_encode([
            'loggedIn' => AuthHandler::isLoggedIn(),
            'isAdmin' => AuthHandler::isAdmin(),
            'user' => AuthHandler::getCurrentUser()
        ]);
    }
}
?>
