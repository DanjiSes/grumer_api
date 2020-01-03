<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Order.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate order object
  $order = new Order($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $order->status = 0;
  $order->grumer_id = $data->grumer_id;
  $order->client_id = $data->client_id;
  $order->date = $data->date;
  $order->breed_id = $data->breed_id;

  // Create post
  if ($order->create()) {
    echo json_encode(
      array('status' => 'success', 
            'message' => 'Order created'));
  } else {
    echo json_encode(
      array('status' => 'error', 
            'message' => 'Order not created'));
  }