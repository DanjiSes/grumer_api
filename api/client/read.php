<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Client.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate client object
  $client = new Client($db);

  // Get rew data
  $data = json_decode(file_get_contents("php://input"));

  // Client query
  $result = $client->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any clients
  if ($num > 0) {
    // Clients array
    $clients_arr = array();
    $clients_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $clients_item = array(
        'id' => $id,
        'name' => $name,
        'phone' => $phone,
        'email' => $email
      );

      array_push($clients_arr['data'], $clients_item);
    }

  }
  // Turn to JSON & output
  echo json_encode($clients_arr);