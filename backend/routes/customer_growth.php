<?php
/**
 * Customer Growth API Routes
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once __DIR__ . '/../services/CustomerGrowthService.php';

$service = new CustomerGrowthService();
$method = $_SERVER['REQUEST_METHOD'];

$response = ['success' => false];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['type']) && $_GET['type'] === 'chart') {
                // Get chart data
                $response = ['success' => true, 'data' => $service->getChartData()];
            } elseif (isset($_GET['type']) && $_GET['type'] === 'analysis') {
                // Get analysis
                $response = ['success' => true, 'data' => $service->generateAnalysis()];
            } else {
                // Get all data
                $response = ['success' => true, 'data' => $service->getAllData()];
            }
            break;

        case 'POST':
            // Add/Update growth data (Admin only)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['year']) || !isset($data['total_customers'])) {
                $response = ['success' => false, 'error' => 'Year and total_customers are required'];
                break;
            }

            $response = $service->updateGrowthData(
                intval($data['year']),
                intval($data['total_customers']),
                $data['growth_percentage'] ?? null
            );
            break;

        case 'DELETE':
            // Delete growth data (Admin only)
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!isset($data['year'])) {
                $response = ['success' => false, 'error' => 'Year is required'];
                break;
            }

            $response = $service->deleteGrowthData(intval($data['year']));
            break;
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

echo json_encode($response);
?>
