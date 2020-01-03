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

  $order->status = 1;
  $order->grumer_id = $data->grumer_id;

  // Order query
  $result = $order->read_confirmed();

  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if ($num > 0) {
    // Order array
    $orders_arr = array();
    $orders_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $order_item = array(
        'id' => $id,
        'name' => $name,
        'prise' => $prise,
        'time_spent' => $time_spent,
        'weigth' => $weigth,
        'date' => $date,
        'animal' => $animal,
        'breed' => $breed
      );

      array_push($orders_arr['data'], $order_item);
    }

  }
  // Turn to JSON & output
  echo json_encode($orders_arr);