<?php
/**
 * BTS Coverage Model
 * Handles database operations for BTS coverage data
 */

require_once __DIR__ . '/../config/database.php';

class BTSCoverageModel {
    private $db;
    private $table = 'bts_coverage';

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Get all BTS coverage data
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY island_name ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get BTS by island name
    public function getByIsland($island_name) {
        $query = "SELECT * FROM " . $this->table . " WHERE island_name = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $island_name);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create BTS coverage
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (island_name, bts_count, population, coverage_percentage, latitude, longitude)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "siiddd",
            $data['island_name'],
            $data['bts_count'],
            $data['population'],
            $data['coverage_percentage'],
            $data['latitude'],
            $data['longitude']
        );

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Update BTS coverage
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET island_name = ?, bts_count = ?, population = ?, coverage_percentage = ?, 
                      latitude = ?, longitude = ?, updated_at = NOW()
                  WHERE id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "siidddi",
            $data['island_name'],
            $data['bts_count'],
            $data['population'],
            $data['coverage_percentage'],
            $data['latitude'],
            $data['longitude'],
            $id
        );

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Delete BTS coverage
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success' => true];
        }

        return ['success' => false, 'error' => $stmt->error];
    }

    // Get map data for visualization
    public function getMapData() {
        $data = $this->getAll();
        
        $mapData = [];
        foreach ($data as $item) {
            $mapData[] = [
                'name' => $item['island_name'],
                'bts_count' => $item['bts_count'],
                'lat' => floatval($item['latitude']),
                'lng' => floatval($item['longitude']),
                'population' => $item['population'],
                'coverage' => floatval($item['coverage_percentage'])
            ];
        }

        return $mapData;
    }

    // Get total BTS count
    public function getTotalBTS() {
        $query = "SELECT SUM(bts_count) as total FROM " . $this->table;
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Get statistics
    public function getStatistics() {
        $query = "SELECT 
                    COUNT(*) as total_islands,
                    SUM(bts_count) as total_bts,
                    AVG(bts_count) as avg_bts_per_island,
                    AVG(coverage_percentage) as avg_coverage
                  FROM " . $this->table;
        
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }
}
?>
