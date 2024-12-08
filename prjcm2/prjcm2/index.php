
<?php
// Vérifiez si la session est démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';
require 'includes/header.php';
require 'includes/navbar.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        require 'views/home.php';
        break;
    case 'login':  
        require 'views/login.php';
        break;
    case 'register':
        require 'views/register.php';
        break;
    case 'cart':
        require 'views/cart.php';
        break;
    case 'checkout':
        require 'views/checkout.php';
        break;
    case 'product_detail':
        require 'views/product_detail.php';
        break;
    case 'success':
        require 'views/success.php';
        break;
    case 'paypal_payment':
        require 'views/paypal_payment.php';
        break;
    case 'add_to_cart':
        require 'views/add_to_cart.php'; // Assurez-vous que ce fichier existe
        break;
    case 'remove_from_cart':
        require 'views/remove_from_cart.php'; // Assurez-vous que ce fichier existe
        break;
    case 'logout':
        session_destroy();
        header('Location: index.php?page=home');
        break;
    default:
        echo '<h1>Page non trouvée</h1>';
        break;
}

require 'includes/footer.php';
?>
