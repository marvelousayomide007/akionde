<?php 
/**
 * To import the JWT class functionalities
 */
require_once('../../jwt/classes/JWT.php');
$jwt = (new JWT());
  // Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Orders.php';

/**
 * To manually insert the API payload
 */
$payload = [
  'id' => 1,
  'name' => 'Fortunatus Adegoke',
  'iss' => 'http://localhost/API_project/jwt/',
  'aud' => 'http://localhost/API_project'
];
/**
* To validate and protect the APi data
*/
$token = $jwt->generate($payload);
// echo $token ."<br>";
if($jwt->is_valid($token)) {
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect_database();
      // Instantiate customer object
    $order = new Orders($db);
      // Get ID
    $order->order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die();
      // Get order
    $order->read_single();
      // Create order array
    $order_array = array(
        'order_id' => $order_id,
        'customer_id' => $customer_id,
        'product_id' => $product_id,
        'order_status' => $order_status,
    );

      // Make JSON
    print_r(json_encode($order_array));
}else {
  echo json_encode(
      array("Message" => "Invalid API token supplied")
  );
}
