<?php
session_start();

// Verificăm dacă există favorite
if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

// Citește rețetele din `recipes.json`
$recipes = json_decode(file_get_contents('recipes.json'), true);

// Filtrăm rețetele favorite
$favorites = array_filter($recipes, function ($recipe) {
    return in_array($recipe['title'], $_SESSION['favorites']);
});

// Colectăm toate ingredientele din rețetele favorite
$shoppingList = [];
foreach ($favorites as $recipe) {
    $ingredients = explode(',', $recipe['ingredients']);
    foreach ($ingredients as $ingredient) {
        $ingredient = trim($ingredient);
        if (!in_array($ingredient, $shoppingList)) {
            $shoppingList[] = $ingredient;
        }
    }
}

// Șterge lista de cumpărături
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_shopping_list'])) {
    $shoppingList = [];
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lista de Cumpărături</title>
</head>
<body>
<header>
    <h1>Lista de Cumpărături</h1>
    <a href="index.php">Înapoi la Pagina Principală</a>
</header>

<div class="container">
    <?php if (empty($shoppingList)): ?>
        <p>Nu ai adăugat nicio rețetă la favorite. Adaugă rețete pentru a vedea ingredientele necesare!</p>
    <?php else: ?>
        <h2>Ingrediente Necesare</h2>
        <ul>
            <?php foreach ($shoppingList as $ingredient): ?>
                <li><?= htmlspecialchars($ingredient) ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="POST" action="shopping_list.php">
            <button type="submit" name="clear_shopping_list">Șterge Lista de Cumpărături</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
