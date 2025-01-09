<?php
$servername = "localhost";
$username = "root"; // Numele implicit pentru MySQL pe XAMPP
$password = ""; // Parola implicită este goală
$dbname = "recipe_manager";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifică conexiunea
if ($conn->connect_error) {
    die("Conexiunea la baza de date a eșuat: " . $conn->connect_error);
}
?>
