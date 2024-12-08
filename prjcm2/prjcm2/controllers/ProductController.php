<?php
require_once '../models/Product.php';

class ProductController {
    private $conn;
    private $product;

    public function __construct($db) {
        $this->conn = $db;
        $this->product = new Product($db);
    }

    public function getProducts() {
        $stmt = $this->product->read();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    public function getProduct($id) {
        $this->product->id = $id;
        $stmt = $this->product->read_single();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function createProduct($data) {
        $this->product->name = $data['name'];
        $this->product->description = $data['description'];
        $this->product->price = $data['price'];
        $this->product->image = $data['image'];
        $this->product->category_id = $data['category_id'];

        if ($this->product->create()) {
            return true;
        }

        return false;
    }

    public function updateProduct($data) {
        $this->product->id = $data['id'];
        $this->product->name = $data['name'];
        $this->product->description = $data['description'];
        $this->product->price = $data['price'];
        $this->product->image = $data['image'];
        $this->product->category_id = $data['category_id'];

        if ($this->product->update()) {
            return true;
        }

        return false;
    }

    public function deleteProduct($id) {
        $this->product->id = $id;

        if ($this->product->delete()) {
            return true;
        }

        return false;
    }
}
?>
