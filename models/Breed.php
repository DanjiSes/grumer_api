<?php
  class Breed {
    // DB Stuff
    private $conn;
    private $table = 'breeds';

    // Properties
    public $id;
    public $name;
    public $animal_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get breeds
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
      $query = 'SELECT b.id, b.name, a.name AS animal_name FROM ' .
        $this->table . ' AS b LEFT JOIN animals AS a ON b.animal_id = a.id ORDER BY id DESC';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function add() {
      // Create query
      $query = 'INSERT INTO ' .
          $this->table . '
          (name,
          animal_id)
        VALUES (
          :name,
          :animal_id)';

      // Prepare statment
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->animal_id = htmlspecialchars(strip_tags($this->animal_id));

      // Bitnd data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':animal_id', $this->animal_id);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }