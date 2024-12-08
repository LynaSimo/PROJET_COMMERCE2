<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../db.php';
require '../includes/functions.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
include 'admin_navbar.php';

$sql = "SELECT * FROM orders";
$stmt = $conn->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="container">
    <h1 class="my-4">Manage Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Total</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_id'] ?></td>
                    <td>$<?= number_format($order['total'], 2) ?></td>
                    <td><?= $order['created_at'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <a href="admin_view_order.php?id=<?= $order['id'] ?>" class="btn btn-info">View</a>
                        <a href="admin_delete_order.php?id=<?= $order['id'] ?>" class="btn btn-danger">Deelete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
?>
