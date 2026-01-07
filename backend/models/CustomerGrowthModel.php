<?php
/**
 * Customer Growth Model
 * Handles database operations for customer growth data
 */

require_once __DIR__ . '/../config/database.php';

class CustomerGrowthModel {
    private $db;
    private $table = 'customer_growth';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all customer growth data
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY year ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get data by year
    public function getByYear($year) {
        $query = "SELECT * FROM " . $this->table . " WHERE year = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create or update customer growth
    public function upsert($year, $total_customers, $growth_percentage) {
        // Calculate growth percentage if not provided
        if (!$growth_percentage) {
            $previous = $this->getByYear($year - 1);
            if ($previous) {
                $growth_percentage = (($total_customers - $previous['total_customers']) / $previous['total_customers']) * 100;
            } else {
                $growth_percentage = 0;
            }
        }

        $query = "INSERT INTO " . $this->table . "
                  (year, total_customers, growth_percentage)
                  VALUES (?, ?, ?)
                  ON DUPLICATE KEY UPDATE
                  total_customers = VALUES(total_customers),
                  growth_percentage = VALUES(growth_percentage)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iid", $year, $total_customers, $growth_percentage);

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Delete customer growth data
    public function delete($year) {
        $query = "DELETE FROM " . $this->table . " WHERE year = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $year);

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Get growth data as JSON for Chart
    public function getChartData() {
        $data = $this->getAll();
        
        $labels = [];
        $customers = [];
        $growth = [];

        foreach ($data as $item) {
            $labels[] = $item['year'];
            $customers[] = $item['total_customers'];
            $growth[] = round($item['growth_percentage'], 2);
        }

        return [
            'labels' => $labels,
            'customers' => $customers,
            'growth' => $growth
        ];
    }
}
?>
