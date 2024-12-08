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

    public function createCategory($data) {
        $this->category->name = $data['name'];

        if ($this->category->create()) {
            return true;
        }

        return false;
    }
}
?>
