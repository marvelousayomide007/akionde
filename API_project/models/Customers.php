<?php

class Customers {

    private $conn;
    private $table = "customers";

    //Customer properties
    public $customer_id;
    public $customer_name;
    public $username;
    public $address;

    //To create a constructor that craetes a new customer instanse by passing the database object
    public function __construct($db) {
        $this->conn = $db;
    }

    //Method to get/read all customers
    public function read() {
        $query = 'SELECT customer_id, customer_name, username, address FROM ' 
        . $this->table . ' ORDER BY customer_id DESC';

        //Creating the prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get Single Customer
    public function read_single() {
        // Create query
        $query = 'SELECT customer_id FROM ' . $this->table . ' WHERE customer_id = ? LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind cutomer_id
        $stmt->bindParam(1, $this->customer_id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Set properties
        $this->customer_id = $row['customer_id'];
        $this->customer_name = $row['customer_name'];
        $this->username = $row['username'];
        $this->address = $row['address'];
        
    }
}