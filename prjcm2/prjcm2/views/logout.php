<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Destroy session and redirect to home page
session_destroy();
header('Location: index.php?page=home');
exit;
?>
