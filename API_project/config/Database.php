<?php 
/**
 * To create a database connection class using PHP PDO
 */
class Database {
    // Database Parameters
    private $host = 'localhost';
    private $db_name = 'clothing_company';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connect
    public function connect_database() {
    $this->conn = null;

    try {
        // Connecting to the MySQL database using PDO
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        // Setting the Database Connection Error Attributes
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {

        echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn;
    }
}