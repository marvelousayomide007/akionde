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
include_once '../../models/Customers.php';
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
    $customer = new Customers($db);
    // Get ID
    $customer->customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die();
    // Get customer
    $customer->read_single();
    // Create array
    $customer_array = array(
      'customer_id' => $customer_id,
      'customer_name' => $customer_name,
      'username' => $username,
      'address' => $address,
    );

    // Make JSON
    print_r(json_encode($customer_array));
} else {
    echo json_encode(
        array("Message" => "Invalid API token supplied")
    );
}
