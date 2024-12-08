<?php
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
}
header('Location: manage_categories.php');
?>
