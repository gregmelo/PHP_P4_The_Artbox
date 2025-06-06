<?php
function connexion() {
try {
    // On se connecte à MySQL
    return new PDO('mysql:host=localhost;dbname=artbox;charset=utf8mb4', 'root', '');
} catch (Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : ' . $e->getMessage());
}
}
?>