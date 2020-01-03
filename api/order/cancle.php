<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Order.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate order object
  $order = new Order($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to cancle
  $order->id = $data->id;
  $order->status = 2;

  // Cancle order
  if ($order->cancle()) {
    echo json_encode(
      array('status' => 'success', 
            'message' => 'Order cancled'));
  } else {
    echo json_encode(
      array('status' => 'error', 
            'message' => 'Order not cancled'));
  }