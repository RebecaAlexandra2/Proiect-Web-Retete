<?php
session_start();

require 'db_config.php'; // Conexiune la baza de date

// Lista de favorite
//Preia favoritele din baza de date
try {
    $query = "SELECT * FROM favorites INNER JOIN recipes ON recipes.id = favorites.recipes_id WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Eroare la preluarea favoritelor: " . $e->getMessage());
}

// Șterge toate favoritele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_all'])) {
    $_SESSION['favorites'] = [];
    $favorites = [];
}

// Șterge o rețetă specifică
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_favorite'])) {
    $recipeToRemove = $_POST['recipe'];
    if (($key = array_search($recipeToRemove, $favorites)) !== false) {
        unset($favorites[$key]);
        $_SESSION['favorites'] = $favorites;
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Favorite</title>
</head>
<body>
<header>
    <h1>Rețetele Favorite</h1>
    <a href="index.php">Înapoi la pagina principală</a>
</header>
<div class="container">
    <?php if (!empty($favorites)): ?>
        <form method="POST" action="favorites.php">
            <button type="submit" name="clear_all" class="clear-all-button">Șterge toate</button>
        </form>
        <ul>
            <?php foreach ($favorites as $favorite): ?>
                <li>
                    <?= htmlspecialchars($favorite ['title']) ?>
                    <form method="POST" action="favorites.php" style="display: inline;">
                        <input type="hidden" name="recipe" value="<?= htmlspecialchars($favorite) ?>">
                        <button type="submit" name="remove_favorite" class="remove-button">Șterge</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nu aveți nicio rețetă salvată ca favorită.</p>
    <?php endif; ?>
</div>
</body>
</html>
