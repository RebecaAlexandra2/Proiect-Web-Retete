<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $ingredients = explode(',', $_POST['ingredients']);
    $instructions = $_POST['instructions'];

    $newRecipe = [
        'title' => $title,
        'author' => $author,
        'ingredients' => array_map('trim', $ingredients),
        'instructions' => $instructions
    ];

    $recipesFile = 'recipes.json';
    $recipes = [];

    if (file_exists($recipesFile)) {
        $jsonData = file_get_contents($recipesFile);
        $recipes = json_decode($jsonData, true);
    }

    $recipes[] = $newRecipe;
    file_put_contents($recipesFile, json_encode($recipes, JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Recipe</title>
</head>
<body>
    <header>
        <h1>Add a New Recipe</h1>
    </header>
    <div class="container">
        <form method="POST" action="add_recipe.php">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>
            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>
            <label for="ingredients">Ingredients (comma-separated):</label>
            <input type="text" name="ingredients" id="ingredients" required>
            <label for="instructions">Instructions:</label>
            <textarea name="instructions" id="instructions" rows="5" required></textarea>
            <input type="submit" value="Add Recipe">
        </form>
        <a href="index.php" class="back-button">← Back to Home</a>
    </div>
    <footer>
        <p>&copy; 2025 Recipe Manager. All rights reserved.</p>
    </footer>
</body>
</html>
