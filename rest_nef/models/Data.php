<?php
class Data {
    // DB stuff
    private $conn;
    private $table = 'data';

    // Data Properties
    public $id;
    public $customer_id;
    public $customer_name;
    public $ue;
    public $imsi;
    public $profile;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Data
    public function read() {
        // Create query
        $query = 'SELECT 
              c.name as customer_name,
              p.id,
              p.customer_id,
              p.ue,
              p.imsi,
              p.profile,
              p.created_at
            FROM
              ' . $this->table . ' p
            LEFT JOIN
              customer c ON p.customer_id = c.id
            ORDER BY
              p.created_at DESC';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single data
    public function read_single() {
      // Create query
      $query = 'SELECT 
      c.name as customer_name,
      p.id,
      p.customer_id,
      p.ue,
      p.imsi,
      p.profile,
      p.created_at
     FROM
       ' . $this->table . ' p
     LEFT JOIN
       customer c ON p.customer_id = c.id
     WHERE
       p.id = ?
     LIMIT 0,1';

     // Prepare statement
     $stmt = $this->conn->prepare($query);

     // Bind ID
     $stmt->bindParam(1, $this->id);

     // Execute query
     $stmt->execute();

     $row = $stmt->fetch(PDO::FETCH_ASSOC);

     // Set properties
     $this->ue = $row['ue'];
     $this->imsi = $row['imsi'];
     $this->profile = $row['profile'];
     $this->customer_id = $row['customer_id'];
     $this->customer_name = $row['customer_name'];


    }

    // Post requests
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . 
          $this->table . '
        SET
          ue = :ue,
          imsi = :imsi,
          profile = :profile,
          customer_id= :customer_id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // clean data
      $this->ue = htmlspecialchars(strip_tags($this->ue));
      $this->imsi = htmlspecialchars(strip_tags($this->imsi));
      $this->profile = htmlspecialchars(strip_tags($this->profile));
      $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));

      // Bind data
      $stmt->bindParam(':ue', $this->ue);
      $stmt->bindParam(':imsi', $this->imsi);
      $stmt->bindParam(':profile', $this->profile);
      $stmt->bindParam(':customer_id', $this->customer_id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;

    }

    // update requests
    public function update() {
      // Create query
      $query = 'UPDATE ' . 
          $this->table . '
        SET
          ue = :ue,
          imsi = :imsi,
          profile = :profile,
          customer_id= :customer_id
        WHERE
          id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // clean data
      $this->ue = htmlspecialchars(strip_tags($this->ue));
      $this->imsi = htmlspecialchars(strip_tags($this->imsi));
      $this->profile = htmlspecialchars(strip_tags($this->profile));
      $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':ue', $this->ue);
      $stmt->bindParam(':imsi', $this->imsi);
      $stmt->bindParam(':profile', $this->profile);
      $stmt->bindParam(':customer_id', $this->customer_id);
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Delete request
    public function delete() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;


    }
}