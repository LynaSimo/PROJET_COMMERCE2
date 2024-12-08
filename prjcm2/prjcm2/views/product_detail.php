<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
require 'includes/functions.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<p>Produit non trouvé</p>";
} else {
?>
<div class="container">
    <h1 class="my-4"><?= $product['name'] ?></h1>
    <div class="row">
        <div class="col-md-8">
            <img class="img-fluid" src="assets/images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
        </div>
        <div class="col-md-4">
            <h3 class="my-3">Description</h3>
            <p><?= $product['description'] ?></p>
            <h3 class="my-3">Détails</h3>
            <ul>
                <li>Prix: $<?= $product['price'] ?></li>
            </ul>
            <a href="index.php?page=add_to_cart&id=<?= $product['id'] ?>" class="btn btn-primary">Ajouter au Panier</a>
        </div>
    </div>
</div>
<?php
}
?>
