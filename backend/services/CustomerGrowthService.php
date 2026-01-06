<?php
/**
 * Customer Growth Service
 * Handles business logic for customer growth data
 */

require_once __DIR__ . '/../models/CustomerGrowthModel.php';

class CustomerGrowthService {
    private $model;

    public function __construct() {
        $this->model = new CustomerGrowthModel();
    }

    // Get all growth data for chart
    public function getChartData() {
        return $this->model->getChartData();
    }

    // Get raw growth data
    public function getAllData() {
        return $this->model->getAll();
    }

    // Add or update growth data
    public function updateGrowthData($year, $total_customers, $growth_percentage = null) {
        // Validate input
        if (!is_numeric($year) || $year < 2000 || $year > 2100) {
            return ['success' => false, 'error' => 'Invalid year'];
        }

        if (!is_numeric($total_customers) || $total_customers < 0) {
            return ['success' => false, 'error' => 'Invalid customer count'];
        }

        return $this->model->upsert($year, intval($total_customers), floatval($growth_percentage));
    }

    // Delete growth data
    public function deleteGrowthData($year) {
        return $this->model->delete($year);
    }

    // Generate growth analysis
    public function generateAnalysis() {
        $data = $this->model->getAll();
        
        if (count($data) < 2) {
            return ['analysis' => 'Not enough data'];
        }

        $first = reset($data);
        $last = end($data);

        $total_growth = (($last['total_customers'] - $first['total_customers']) / $first['total_customers']) * 100;
        $years = count($data);
        $avg_growth = $total_growth / ($years - 1);

        return [
            'period_start' => $first['year'],
            'period_end' => $last['year'],
            'total_growth_percentage' => round($total_growth, 2),
            'average_annual_growth' => round($avg_growth, 2),
            'customer_increase' => $last['total_customers'] - $first['total_customers'],
            'data_points' => $data
        ];
    }
}
?>
