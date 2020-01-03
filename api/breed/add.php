<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Breed.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instanse breed object
  $breed = new Breed($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $breed->name = $data->name;
  $breed->animal_id = $data->animal_id;

  // Add breed
  if ($breed->add()) {
    echo json_encode(
      array('status' => 'success', 
            'message' => 'Breed added'));
  } else {
    echo json_encode(
      array('status' => 'error', 
            'message' => 'Breed not added'));
  }