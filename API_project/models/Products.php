<?php
/**
 * Class of Products containing different database modelling for products
 */
class Product {
    /**
     * To declare database connection variable
     *
     * @var --
     */
    private $conn;
    /**
     * To specify the database table to work with
     *
     * @var string
     */
    private $table = "products";

    //Product properties
    public $product_id;
    public $product_name;
    public $price;
    public $product_size;
    public $category_name;
    public $category_id;
    public $created_at;
    /**
     * To instantiate a product object with database connection
     *
     * @param [type] $db
     */
    //To create a constructor that craetes a new product by passing the database object
    public function __construct($db) {
        $this->conn = $db;
    }
    /**
     * Function to read all the product data from the database
     *
     * 
     */
    
    //Method to get/read all products
    public function read() {
        $query = 'SELECT product_id, product_name, price, product_size, category_name, category_id, created_at FROM ' 
        . $this->table . ' ORDER BY created_at DESC';

        //Creating the prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    /**
     * Fucntion to read single product from the database
     *
     * @return void
     */

    // Get Single Product
    public function read_single() {
        // Create query
        $query = 'SELECT product_id, product_name, price, product_size, category_name, category_id, created_at FROM ' . $this->table . ' WHERE product_id = ? LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Bind PRODUCT_ID
        $stmt->bindParam(1, $this->product_id);
        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Set properties
        $this->product_id = $row['product_id'];
        $this->product_name = $row['product_name'];
        $this->price = $row['price'];
        $this->product_size = $row['product_size'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    /**
     * Function to create a new product
     *
     * @return void
     */
    // Create a product
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . ' SET product_name = :product_name, price = :price, product_size = :product_size, category_name = :category_name, category_id = :category_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Cleaning the data supplied.
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->product_size = htmlspecialchars(strip_tags($this->product_size));
        $this->category_name = htmlspecialchars(strip_tags($this->category_name));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));      

        // Binding parameters
        $stmt->bindParam(':product_name', $this->product_name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':product_size', $this->product_size);
        $stmt->bindParam(':category_name', $this->category_name);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if an error occurs
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}