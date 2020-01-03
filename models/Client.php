<?php
  class Client {
    // DB Stuff
    private $conn;
    private $table = 'clients';

    // Properties
    public $id;
    public $name;
    public $phone;
    public $email;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Add new client
    public function add() {
      // Create query
      $query = 'INSERT INTO ' .
          $this->table . '
          (name,
          phone,
          email)
        VALUES (
          :name,
          :phone,
          :email)';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->phone = htmlspecialchars(strip_tags($this->phone));
      $this->email = htmlspecialchars(strip_tags($this->email));

      // Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':email', $this->email);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Find client
    public function find() {
      // Create query
      $query = 'SELECT * FROM ' . 
        $this->table . 
        ' WHERE name LIKE :name LIMIT 5';

      // Prepare
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = '%'.htmlspecialchars(strip_tags($this->name)).'%';

      // Bind data
      $stmt->bindParam(':name', $this->name);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC';

      // Prepare
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
  }