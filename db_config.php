<?php
$host = 'localhost'; // Adresa serverului
$dbname = 'recipe_manager'; // Numele bazei de date
$username = 'root'; // Numele utilizatorului MySQL (implicit pentru XAMPP este "root")
$password = 'root'; // Parola MySQL (implicit este goală pentru XAMPP)

// Creează conexiunea la baza de date
// $conn=null;
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexiunea la baza de date a eșuat: " . $e->getMessage());
}
?>
