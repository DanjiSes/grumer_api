<?php
  class Animal {
    // DB Stuff
    private $conn;
    private $table = 'animals';

    // Properties
    public $id;
    public $name;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function add() {
      // Create query
      $query = 'INSERT INTO ' 
        . $this->table . '(name) VALUES (:name)';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));

      // Bitnd data
      $stmt->bindParam(':name', $this->name);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }