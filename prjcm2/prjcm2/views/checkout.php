<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'db.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$total_ht = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_ht += $item['price'] * $item['quantity'];
    }
}

$tax_rate = 0.15;
$tax_amount = $total_ht * $tax_rate;
$total_ttc = $total_ht + $tax_amount;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $sql = "INSERT INTO orders (user_id, total, created_at, status) VALUES (:user_id, :total, NOW(), 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':total' => $total_ttc
    ]);

    $order_id = $conn->lastInsertId();

    
    foreach ($_SESSION['cart'] as $item) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $item['id'],
            ':quantity' => $item['quantity'],
            ':price' => $item['price']
        ]);
    }

    // Process payment (mocked for now)
    $payment_successful = true; // This should be replaced with actual payment processing logic

    if ($payment_successful) {
        // Update order status to 'paid'
        $sql = "UPDATE orders SET status = 'paid' WHERE id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':order_id' => $order_id]);

        // Redirect to success page
        header('Location: index.php?page=success');
    } else {
        // Payment failed, keep status as 'pending'
        header('Location: index.php?page=checkout&error=payment_failed');
    }

    // Clear the cart
    unset($_SESSION['cart']);
    exit();
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Intégration du SDK PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AbZpOk7hm3ymgT9AL2LBJ9LYqVXudLeuNuSmgQlCQLJQWeKzmXx9ChdHsNT0pBM7pvEK8YTWxR3YmfJ0&currency=USD"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Passer à la Caisse</h1>
        <form id="checkout-form" action="index.php?page=checkout" method="post">
            <div class="form-group">
                <label for="address">Adresse de livraison</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Méthode de paiement</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="paypal">PayPal</option>
                    <option value="credit_card">Carte de crédit</option>
                </select>
            </div>
            <div id="paypal-button-container" style="display: none;"></div>

            <button id="checkout-button" class="btn btn-primary">Payer</button>
        </form>
    </div>

    <script>
    // Affichage conditionnel du bouton PayPal en fonction de la méthode de paiement sélectionnée
    document.getElementById('payment_method').addEventListener('change', function() {
        const paymentMethod = this.value;
        const paypalContainer = document.getElementById('paypal-button-container');
        const checkoutButton = document.getElementById('checkout-button');

        if (paymentMethod === 'paypal') {
            paypalContainer.style.display = 'block';
            checkoutButton.style.display = 'none';
            paypal.Buttons({
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?= $total_ttc ?>' // Montant à payer
                            }
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
                        alert('Transaction complétée par ' + details.payer.name.given_name + '!');
                        window.location.href = "index.php?page=success";
                    });
                },
                onError: function(err){
                    console.log("Erreur dans le paiement:", err);
                    alert("Paiement échoué");
                }
            }).render('#paypal-button-container');
        } else {
            paypalContainer.style.display = 'none';
            checkoutButton.style.display = 'block';
        }
    });
    </script>
</body>
</html>


