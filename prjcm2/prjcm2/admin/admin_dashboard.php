<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include 'admin_navbar.php';
?>

<div class="container">
    <h1 class="my-4">Admin Dashboard</h1>
    <a href="admin_manage_products.php" class="btn btn-primary">Manage Products</a>
    <a href="admin_manage_categories.php" class="btn btn-primary">Manage Categories</a> <!-- Ajouter cette ligne -->
    <a href="admin_manage_orders.php" class="btn btn-primary">Manage Orders</a>
    <a href="../index.php?page=logout" class="btn btn-danger">Logout</a>
</div>


