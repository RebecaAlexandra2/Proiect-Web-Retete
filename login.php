<?php
session_start();

$users = [
    'admin' => 'password123',
    'user' => '12345'
];

$users = [
    'pop' => 'password123',
    'user' => '12345'
];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Nume utilizator sau parolă incorectă.';
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Autentificare</title>
</head>
<body>
<header>
    <h1>Autentificare</h1>
</header>
<div class="container">
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php" class="auth-form">
        <label for="username">Nume utilizator:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Autentificare</button>
    </form>
    <a href="index.php">Înapoi la pagina principală</a>
</div>
</body>
</html>
