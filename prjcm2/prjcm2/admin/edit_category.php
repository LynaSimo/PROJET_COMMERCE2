<?php
require 'db.php';
include 'admin_navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$name = '';

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $category['name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    if ($id) {
        $stmt = $conn->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
    }
    header('Location: manage_categories.php');
    exit;
}
?>

<div class="container">
    <h1 class="my-4"><?= $id ? 'Modifier' : 'Ajouter' ?> une Catégorie</h1>
    <form method="post">
        <div class="form-group">
            <label for="name">Nom de la Catégorie</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?= $id ? 'Modifier' : 'Ajouter' ?></button>
    </form>
</div>

<?php
?>
