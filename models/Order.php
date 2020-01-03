<?php
  class Order {
    // DB Stuff
    private $conn;
    private $table = 'orders';

    // Properties
    public $id;
    public $status;
    public $grumer_id;
    public $client_id;
    public $prise;
    public $date;
    public $time_spent;
    public $weigth;
    public $breed_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Create order 
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . 
          $this->table . ' 
          (status,
          grumer_id,
          client_id,
          date,
          breed_id)
        VALUES (
          :status,
          :grumer_id,
          :client_id,
          :date,
          :breed_id)';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->grumer_id = htmlspecialchars(strip_tags($this->grumer_id));
      $this->client_id = htmlspecialchars(strip_tags($this->client_id));
      $this->date = htmlspecialchars(strip_tags($this->date));
      $this->breed_id = htmlspecialchars(strip_tags($this->breed_id));

      // Bind data
      $stmt->bindParam(':status', $this->status);
      $stmt->bindParam(':grumer_id', $this->grumer_id);
      $stmt->bindParam(':client_id', $this->client_id);
      $stmt->bindParam(':date', $this->date);
      $stmt->bindParam(':breed_id', $this->breed_id);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Confirm order
    public function confirm() {
      // Create query
      $query = 'UPDATE ' .
          $this->table . '
        SET
          status = :status,
          prise = :prise,
          time_spent = :time_spent,
          weigth = :weigth
        WHERE
          id = :id';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->prise = htmlspecialchars(strip_tags($this->prise));
      $this->time_spent = htmlspecialchars(strip_tags($this->time_spent));
      $this->weigth = htmlspecialchars(strip_tags($this->weigth));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':status', $this->status);
      $stmt->bindParam(':prise', $this->prise);
      $stmt->bindParam(':time_spent', $this->time_spent);
      $stmt->bindParam(':weigth', $this->weigth);
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Cancle order
    public function cancle() {
      // Create query
      $query = 'UPDATE ' .
          $this->table . '
        SET
          status = :status
        WHERE
          id = :id';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':status', $this->status);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Read added orders
    public function read() {
      // Create query
      $query = 'SELECT
            o.id,
            c.name,
            o.date,
            a.name AS animal,
            b.name AS breed
          FROM
            (((' . $this->table . ' o
            LEFT JOIN breeds b ON o.breed_id = b.id)
            LEFT JOIN clients c ON o.client_id = c.id)
            LEFT JOIN animals a ON b.animal_id = a.id)
          WHERE
           o.grumer_id = :grumer_id AND o.status = :status
          ORDER BY o.id DESC';
      
      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->grumer_id = htmlspecialchars(strip_tags($this->grumer_id));

      // Bind data
      $stmt->bindParam(':grumer_id', $this->grumer_id);
      $stmt->bindParam(':status', $this->status);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Read confirmed orders
    public function read_confirmed() {
      // Create query
      $query = 'SELECT
            o.id,
            c.name,
            o.prise,
            o.time_spent,
            o.weigth,
            o.date,
            a.name AS animal,
            b.name AS breed
          FROM
            (((' . $this->table . ' o
            LEFT JOIN breeds b ON o.breed_id = b.id)
            LEFT JOIN clients c ON o.client_id = c.id)
            LEFT JOIN animals a ON b.animal_id = a.id)
          WHERE
           o.grumer_id = :grumer_id AND o.status = :status
          ORDER BY o.id DESC';
      
      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->grumer_id = htmlspecialchars(strip_tags($this->grumer_id));

      // Bind data
      $stmt->bindParam(':grumer_id', $this->grumer_id);
      $stmt->bindParam(':status', $this->status);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
  }