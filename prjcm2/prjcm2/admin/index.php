<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

require '../db.php';


$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'manage_products':
        require 'admin_manage_products.php';
        break;
    case 'manage_orders':
        require 'admin_manage_orders.php';
        break;
    case 'add_product':
        require 'admin_add_product.php';
        break;
    case 'edit_product':
        require 'admin_edit_product.php';
        break;
    case 'delete_product':
        require 'admin_delete_product.php';
        break;
    case 'logout':
        session_destroy();
        header('Location: ../index.php');
        exit;
    
        case 'manage_categories':
            require 'admin_manage_categories.php';
            break;

    default:
        require 'admin_dashboard.php';
        break;

}
?>
