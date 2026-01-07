<?php
/**
 * Database Configuration with XML Integration
 * This file handles MySQL connection with XML data storage capabilities
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'towerindo_db';
    private $user = 'root';
    private $password = '';
    private $conn;

    // XML Storage Path
    private $xml_storage_path = __DIR__ . '/../../storage/xml/';

    public function connect() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);

        // Check connection
        if ($this->conn->connect_error) {
            die('Connection Failed: ' . $this->conn->connect_error);
        }

        // Set charset
        $this->conn->set_charset("utf8");
        
        return $this->conn;
    }

    public function getConnection() {
        return $this->conn;
    }

    // Export data to XML
    public function exportToXML($table_name, $data, $filename) {
        if (!is_dir($this->xml_storage_path)) {
            mkdir($this->xml_storage_path, 0755, true);
        }

        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><' . $table_name . '/>');
        
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $record) {
                $item = $xml->addChild('record');
                foreach ($record as $key => $value) {
                    $item->addChild(htmlspecialchars($key), htmlspecialchars($value));
                }
            }
        }

        $file_path = $this->xml_storage_path . $filename . '.xml';
        $xml->asXML($file_path);
        
        return $file_path;
    }

    // Import data from XML
    public function importFromXML($filename) {
        $file_path = $this->xml_storage_path . $filename . '.xml';
        
        if (!file_exists($file_path)) {
            return false;
        }

        $xml = simplexml_load_file($file_path);
        $data = [];

        foreach ($xml->record as $record) {
            $item = [];
            foreach ($record->children() as $child) {
                $item[(string)$child->getName()] = (string)$child;
            }
            $data[] = $item;
        }

        return $data;
    }

    // Store XML backup of database state
    public function backupToXML($table_name) {
        $result = $this->conn->query("SELECT * FROM $table_name");
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $timestamp = date('Y-m-d_H-i-s');
        return $this->exportToXML($table_name, $data, $table_name . '_backup_' . $timestamp);
    }
}
?>