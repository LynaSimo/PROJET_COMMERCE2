<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../db.php';
require_once '../includes/functions.php';
include 'admin_navbar.php';

// Vérifiez si l'utilisateur est un administrateur


// Ajout d'une catégorie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = validate_input($_POST['category_name']);
    $sql = "INSERT INTO categories (name) VALUES (:name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $category_name);
    $stmt->execute();
}

// Suppression d'une catégorie
if (isset($_GET['delete_id'])) {
    $category_id = validate_input($_GET['delete_id']);
    $sql = "DELETE FROM categories WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $category_id);
    $stmt->execute();
}

// Récupérer les catégories
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<div class="container">
    <h1 class="my-4">Gérer les Catégories</h1>
    <form action="admin_manage_categories.php" method="post">
        <div class="form-group">
            <label for="category_name">Nom de la Catégorie</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button type="submit" class="btn btn-primary" name="add_category">Ajouter</button>
    </form>
    <br>
    <h2>Liste des Catégories</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td>
                        <a href="admin_manage_categories.php?delete_id=<?= $category['id'] ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
?>
