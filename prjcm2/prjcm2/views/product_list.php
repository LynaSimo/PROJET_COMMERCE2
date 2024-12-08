<?php
require 'db.php';
require 'includes/header.php';
require 'includes/navbar.php';

// Récupérer les produits selon le filtrage (si applicable)
$category = isset($_GET['category']) ? validate_input($_GET['category']) : '';
$price = isset($_GET['price']) ? validate_input($_GET['price']) : '';

$sql = "SELECT * FROM products WHERE 1=1";
if ($category) {
    $sql .= " AND category_id = :category";
}
if ($price) {
    $sql .= " ORDER BY price $price";
}
$stmt = $conn->prepare($sql);

if ($category) {
    $stmt->bindParam(':category', $category);
}
$stmt->execute();
?>

<div class="container">
    <h1 class="my-4">Catalogue de Produits</h1>
    <div class="row">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="product_detail.php?id=<?= $row['id'] ?>">
                        <img class="card-img-top" src="assets/images/<?= $row['image'] ?>" alt="">
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="product_detail.php?id=<?= $row['id'] ?>"><?= $row['name'] ?></a>
                        </h4>
                        <h5>$<?= $row['price'] ?></h5>
                        <p class="card-text"><?= $row['description'] ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
require 'includes/footer.php';
?>

<?php
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
