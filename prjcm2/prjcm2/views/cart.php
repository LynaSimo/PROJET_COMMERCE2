<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
require_once 'includes/functions.php';

$total_ht = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $total_ht += $item['price'] * $item['quantity'];
    }

    $tax_rate = 0.15; // Exemple de taux de taxe
    $tax_amount = $total_ht * $tax_rate;
    $total_ttc = $total_ht + $tax_amount;
}
?>
<div class="container">
    <h1 class="my-4">Votre Panier</h1>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td>
                            <a href="index.php?page=add_to_cart&id=<?= $id ?>" class="btn btn-primary">Ajouter</a>
                            <a href="index.php?page=remove_from_cart&id=<?= $id ?>" class="btn btn-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">Sous-total</td>
                    <td>$<?= number_format($total_ht, 2) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">Taxe (15%)</td>
                    <td>$<?= number_format($tax_amount, 2) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">Total TTC</td>
                    <td>$<?= number_format($total_ttc, 2) ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <a href="index.php?page=checkout" class="btn btn-primary">Passer à la Caisse</a>
    <?php endif; ?>
</div>

