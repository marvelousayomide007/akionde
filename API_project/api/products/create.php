<?php 
  // Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Products.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect_database();

// Instantiate the product object
$product = new Product($db);

// Collecting the product details by key valued pairs
$product->product_name = $data->product_name;
$product->price = $data->price;
$product->product_size = $data->product_size;
$product->category_name = $data->category_name;
$product->category_id = $data->category_id;

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Create product
if($product->create()) {
    echo json_encode(
        array('message' => 'Product Created')
    );
} else {
    echo json_encode(
        array('message' => 'Product Not Created')
    );
}