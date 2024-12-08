<?php
require_once '../db.php';
require_once '../includes/functions.php'; // Ajoutez cette ligne pour inclure functions.php
require_once '../controllers/ProductController.php';

$productController = new ProductController($conn);
$id = validate_input($_GET['id']);

if ($productController->deleteProduct($id)) {
    echo "<p>Produit supprimée avec succès.</p>";
} else {
    echo "<p>Erreur lors de la suppression dy produit.</p>";
}

header('Location: admin_manage_products.php');
exit;
?>
