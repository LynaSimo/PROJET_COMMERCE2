<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ob_start(); // Démarre le tampon de sortie

require 'db.php';
require 'includes/functions.php';

$url = "index.php?page=home";
$delay = 5; // délai en secondes avant redirection

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    
    <div class="container">
        <h1 class="my-4">Paiement Réussi</h1>
        <p>Merci pour votre achat ! Vous serez redirigé vers la page d'accueil.</p>
    </div>
   
</body>
</html>

<?php
header("refresh:$delay;url=$url");
ob_end_flush(); // Envoie le contenu du tampon de sortie et désactive le tampon de sortie
?>
