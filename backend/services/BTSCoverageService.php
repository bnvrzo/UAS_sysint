<?php
/**
 * BTS Coverage Service
 * Handles business logic for BTS coverage operations
 */

require_once __DIR__ . '/../models/BTSCoverageModel.php';

class BTSCoverageService {
    private $model;

    public function __construct() {
        $this->model = new BTSCoverageModel();
    }

    // Get all coverage data
    public function getAllCoverage() {
        return $this->model->getAll();
    }

    // Get map data for visualization
    public function getMapData() {
        return $this->model->getMapData();
    }

    // Get coverage statistics
    public function getStatistics() {
        return $this->model->getStatistics();
    }

    // Add new coverage data
    public function addCoverage($island_name, $bts_count, $population, $coverage_percentage, $latitude, $longitude) {
        // Validate input
        if (empty($island_name)) {
            return ['success' => false, 'error' => 'Island name is required'];
        }

        if (!is_numeric($bts_count) || $bts_count < 0) {
            return ['success' => false, 'error' => 'Invalid BTS count'];
        }

        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            return ['success' => false, 'error' => 'Invalid coordinates'];
        }

        $data = [
            'island_name' => htmlspecialchars($island_name),
            'bts_count' => intval($bts_count),
            'population' => intval($population),
            'coverage_percentage' => floatval($coverage_percentage),
            'latitude' => floatval($latitude),
            'longitude' => floatval($longitude)
        ];

        return $this->model->create($data);
    }

    // Update coverage data
    public function updateCoverage($id, $island_name, $bts_count, $population, $coverage_percentage, $latitude, $longitude) {
        // Validate input
        if (empty($island_name)) {
            return ['success' => false, 'error' => 'Island name is required'];
        }

        if (!is_numeric($bts_count) || $bts_count < 0) {
            return ['success' => false, 'error' => 'Invalid BTS count'];
        }

        $data = [
            'island_name' => htmlspecialchars($island_name),
            'bts_count' => intval($bts_count),
            'population' => intval($population),
            'coverage_percentage' => floatval($coverage_percentage),
            'latitude' => floatval($latitude),
            'longitude' => floatval($longitude)
        ];

        return $this->model->update($id, $data);
    }

    // Delete coverage data
    public function deleteCoverage($id) {
        return $this->model->delete($id);
    }

    // Generate coverage report
    public function generateReport() {
        $stats = $this->model->getStatistics();
        $data = $this->model->getAll();

        $top_coverage = array_reduce($data, function($carry, $item) {
            return ($item['coverage_percentage'] > ($carry['coverage_percentage'] ?? 0)) ? $item : $carry;
        });

        return [
            'total_islands' => $stats['total_islands'],
            'total_bts' => $stats['total_bts'],
            'average_bts_per_island' => round($stats['avg_bts_per_island'], 2),
            'average_coverage' => round($stats['avg_coverage'], 2),
            'best_coverage_island' => $top_coverage['island_name'],
            'best_coverage_percentage' => round($top_coverage['coverage_percentage'], 2)
        ];
    }
}
?>
