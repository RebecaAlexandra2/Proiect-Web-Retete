<?php
session_start();
require 'db_config.php';

// Preia rețetele din baza de date
$categoryFilter = $_GET['category'] ?? 'Toate';

try {
    $query = "SELECT * FROM recipes";
    if ($categoryFilter !== 'Toate') {
        $query .= " WHERE category = :category";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':category', $categoryFilter);
    } else {
        $stmt = $conn->prepare($query);
    }
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Eroare la preluarea rețetelor: " . $e->getMessage());
}

// Adaugă la favorite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_favorites'])) {
    $recipeid = $_POST['recipe_id'];

    try {
        $query = "INSERT INTO favorites (recipes_id, username) VALUES (:recipes_id, :username)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':recipes_id', $recipeid);
        $stmt->bindParam(':username', $_SESSION['username']);
        $stmt->execute();
    } catch (PDOException $e) {
        die("Eroare la adăugarea în favorite: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manager Rețete</title>
</head>
<body>
<header>
    <h1>Bucătăria Online</h1>
    <nav>
        <a href="favorites.php">Favorite</a>
        <a href="shopping_list.php" style="margin-left: 20px;">Lista de Cumpărături</a>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="logout.php" style="margin-left: 20px;">Deconectare</a>
        <?php else: ?>
            <a href="login.php" style="margin-left: 20px;">Autentificare</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">
    <h2>Rețetele noastre recomandate</h2>
    <div class="category-filter">
        <form method="GET" action="index.php">
            <select name="category">
                <option value="Toate">Toate</option>
                <option value="Mic Dejun" <?= $categoryFilter === 'Mic Dejun' ? 'selected' : '' ?>>Mic Dejun</option>
                <option value="Prânz" <?= $categoryFilter === 'Prânz' ? 'selected' : '' ?>>Prânz</option>
                <option value="Desert" <?= $categoryFilter === 'Desert' ? 'selected' : '' ?>>Desert</option>
            </select>
            <button type="submit">Filtrează Rețetele</button>
        </form>
    </div>
    <div class="recipe-grid">
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-card">
                <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                <p><strong>Descriere:</strong> <?= htmlspecialchars($recipe['description']) ?></p>
                <p><strong>Categorie:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
                <form method="POST" action="index.php">
                    <input type="hidden" name="recipe_id" value="<?= htmlspecialchars($recipe['id']) ?>">
                    <button type="submit" name="add_to_favorites" class="favorite-button">❤️ Adaugă la favorite</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
