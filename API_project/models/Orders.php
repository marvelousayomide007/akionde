<?php

class Orders {

    private $conn;
    private $table = "orders";

    //Order properties
    public $id;
    public $order_id;
    public $customer_id;
    public $product_id;
    public $order_status;

    //To create a constructor that craetes a new order instanse by passing the database object
    public function __construct($db) {
        $this->conn = $db;
    }

    //Method to get/read all order
    public function read() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';

        //Creating the prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Get Single order
    public function read_single() {
        // Create query
        $query = 'SELECT order_id FROM ' . $this->table . ' WHERE order_id = ? LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind order_id
        $stmt->bindParam(1, $this->order_id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Set properties
        $this->order_id = $row['order_id'];
        $this->customer_id = $row['customer_id'];
        $this->product_id = $row['product_id'];
        $this->order_status = $row['order_status'];
        
    }
}