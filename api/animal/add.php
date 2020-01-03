<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Animal.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instanse breed object
  $animal = new Animal($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $animal->name = $data->name;

  // Add breed
  if ($animal->add()) {
    echo json_encode(
      array('status' => 'success', 
            'message' => 'Animal added'));
  } else {
    echo json_encode(
      array('status' => 'error', 
            'message' => 'Animal not added'));
  }