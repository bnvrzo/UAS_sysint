<?php
/**
 * BTS Coverage API Routes
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once __DIR__ . '/../services/BTSCoverageService.php';

$service = new BTSCoverageService();
$method = $_SERVER['REQUEST_METHOD'];

$response = ['success' => false];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['type']) && $_GET['type'] === 'map') {
                // Get map data
                $response = ['success' => true, 'data' => $service->getMapData()];
            } elseif (isset($_GET['type']) && $_GET['type'] === 'stats') {
                // Get statistics
                $response = ['success' => true, 'data' => $service->getStatistics()];
            } elseif (isset($_GET['type']) && $_GET['type'] === 'report') {
                // Get coverage report
                $response = ['success' => true, 'data' => $service->generateReport()];
            } else {
                // Get all coverage data
                $response = ['success' => true, 'data' => $service->getAllCoverage()];
            }
            break;

        case 'POST':
            // Add coverage data (Admin only)
            $data = json_decode(file_get_contents("php://input"), true);
            
            $response = $service->addCoverage(
                $data['island_name'] ?? '',
                $data['bts_count'] ?? 0,
                $data['population'] ?? 0,
                $data['coverage_percentage'] ?? 0,
                $data['latitude'] ?? 0,
                $data['longitude'] ?? 0
            );
            break;

        case 'PUT':
            // Update coverage data (Admin only)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['id'])) {
                $response = ['success' => false, 'error' => 'ID is required'];
                break;
            }

            $response = $service->updateCoverage(
                intval($data['id']),
                $data['island_name'] ?? '',
                $data['bts_count'] ?? 0,
                $data['population'] ?? 0,
                $data['coverage_percentage'] ?? 0,
                $data['latitude'] ?? 0,
                $data['longitude'] ?? 0
            );
            break;

        case 'DELETE':
            // Delete coverage data (Admin only)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['id'])) {
                $response = ['success' => false, 'error' => 'ID is required'];
                break;
            }

            $response = $service->deleteCoverage(intval($data['id']));
            break;
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

echo json_encode($response);
?>
