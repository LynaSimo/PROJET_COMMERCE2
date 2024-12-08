<?php
require_once 'db.php';
require_once 'models/Category.php';

class CategoryController {
    private $conn;
    private $category;

    public function __construct($db) {
        $this->conn = $db;
        $this->category = new Category($db);
    }

    public function getCategories() {
        $stmt = $this->category->read();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getCategory($id) {
        $this->category->id = $id;
        $stmt = $this->category->read_single();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        return $category;
    }

    public function createCategory($data) {
        $this->category->name = $data['name'];

        if ($this->category->create()) {
            return true;
        }

        return false;
    }

    public function updateCategory($data) {
        $this->category->id = $data['id'];
        $this->category->name = $data['name'];

        if ($this->category->update()) {
            return true;
        }

        return false;
    }

    public function deleteCategory($id) {
        $this->category->id = $id;

        if ($this->category->delete()) {
            return true;
        }

        return false;
    }
}
?>
