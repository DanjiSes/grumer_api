<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Client.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instanse client object
  $client = new Client($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $client->name = $data->name;
  $client->phone = $data->phone;
  $client->email = $data->email;

  // Add breed
  if ($client->add()) {
    echo json_encode(
      array('status' => 'success', 
            'message' => 'Client added'));
  } else {
    echo json_encode(
      array('status' => 'error', 
            'message' => 'Client not added'));
  }