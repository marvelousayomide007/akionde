<?php
/**
 * To import the JWT class functionalities
 */
require_once('../../jwt/classes/JWT.php');
$jwt = (new JWT());
//Setting the headers

header("Access-Control-Allow_Origin: *");
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Orders.php';

// To instantiate and connect to database
$database = new Database();
$db = $database->connect_database();

// Instantiate order object
$order = new Orders($db);

// Order query
$result = $order->read();
$count = $result->rowCount();
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

    // Check if there are any Order
    if ($count > 0) {
        $order_array = array();
        $order_array["data"] = array();

        //To loop through the order data
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $order_item = array(
                "order_id"=> $order_id,
                "customer_id"=> $customer_id,
                "product_id" => $product_id,
                "order_status" => $order_status,
            );

            //Add the $corder_item array to the order_array
            array_push($order_array["data"], $order_item);
        }
        //Convert the data to JSON and output it.
        echo json_encode($order_array);
    } else {
        // If no order found
        echo json_encode(
            array("Message" => "No order Found")
            );
    }
} else {
    echo json_encode(
        array("Message" => "Invalid API token supplied")
    );
}
