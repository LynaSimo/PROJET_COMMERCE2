<?php
require_once '../db.php';
require_once '../includes/functions.php';
include 'admin_navbar.php';


// Requête SQL pour récupérer les produits avec leurs catégories
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        LEFT JOIN categories ON products.category_id = categories.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1 class="my-4">Manage Products</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['category_name'] ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td><?= $product['description'] ?></td>
                    <td><img src="../assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50"></td>
                    <td>
                        <a href="index.php?page=edit_product&id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="index.php?page=delete_product&id=<?= $product['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>

                
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="button" id="btnAjout" value="Ajouter un produit" onclick="window.location.href='admin_add_product.php'" >
</div>
