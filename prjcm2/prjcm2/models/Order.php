<?php
class Order {
    private $conn;
    private $table = 'orders';

    public $id;
    public $user_id;
    public $total;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET user_id = :user_id, total = :total, created_at = :created_at';
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':created_at', $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
