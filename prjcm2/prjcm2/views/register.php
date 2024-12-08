<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';
require 'includes/functions.php';
require 'includes/header.php';
//require 'includes/navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = validate_input($_POST['username']);
    $password = validate_input($_POST['password']);
    $confirm_password = validate_input($_POST['confirm_password']);
    $email = validate_input($_POST['email']);
    
    // Validation du mot de passe
    if ($password !== $confirm_password) {
        echo "<p>Les mots de passe ne correspondent pas.</p>";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password)) {
        echo "<p>Le mot de passe doit contenir au moins 8 caractères, dont une majuscule.</p>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo "<p>Inscription réussie. Vous pouvez maintenant <a href='index.php?page=login'>vous connecter</a>.</p>";
        } else {
            echo "<p>Erreur: " . $conn->errorInfo()[2] . "</p>";
        }
    }
}
?>

<div class="container">
    <h1 class="my-4">Inscription</h1>
    <form action="index.php?page=register" method="post">
        <div class="form-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<?php
//require 'includes/footer.php';
?>
