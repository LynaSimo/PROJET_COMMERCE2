<?php
require_once '../db.php';
require_once '../models/Order.php';

class OrderController {
    private $conn;
    private $order;

    public function __construct($db){
        $this->conn = $db;
        $this->order = new Order($db);
    }

    public function createOrder($data) {
        $this->order->user_id = $data['user_id'];
        $this->order->total = $data['total'];
        $this->order->created_at = date('Y-m-d H:i:s');

        if ($this->order->create()) {
            return true;
        }

        return false;
    }

    public function getOrders() {
        $query = 'SELECT * FROM orders';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    public function getOrder($id) {
        $query = 'SELECT * FROM orders WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $query = 'SELECT p.name, oi.quantity, oi.price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $order['items'] = $items;
        return $order;
    }

    public function deleteOrder($id) {
        $query = 'DELETE FROM orders WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getAllOrders() {
        $query = 'SELECT * FROM orders';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
