<?php
require_once '../db.php';
require_once '../includes/functions.php'; // Ajoutez cette ligne
require_once '../controllers/OrderController.php';

$orderController = new OrderController($conn);
$id = validate_input($_GET['id']);

if ($orderController->deleteOrder($id)) {
    echo "<p>Commande supprimée avec succès.</p>";
} else {
    echo "<p>Erreur lors de la suppression de la commande.</p>";
}

header('Location: index.php?page=manage_orders');
exit;
?>
