<?php
session_start();

// Resetăm lista de favorite, deci implicit și lista de cumpărături
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['favorites'] = [];
}

header('Location: shopping_list.php');
exit;
