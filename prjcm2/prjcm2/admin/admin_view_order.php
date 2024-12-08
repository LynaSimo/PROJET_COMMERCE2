<?php
require_once '../db.php';
require_once '../includes/functions.php';
include 'admin_navbar.php';


require_once '../controllers/OrderController.php';

$orderController = new OrderController($conn);

$id = validate_input($_GET['id']);
$order = $orderController->getOrder($id);
?>

<div class="container">
    <h1 class="my-4">Détails de la Commande</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID de la Commande</th>
                <th>ID de l'Utilisateur</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td>$<?= $order['total'] ?></td>
                <td><?= $order['created_at'] ?></td>
            </tr>
        </tbody>
    </table>

    <h2 class="my-4">Articles de la Commande</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order['items'] as $item): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= $item['price'] ?></td>
                    <td>$<?= $item['price'] * $item['quantity'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
?>
