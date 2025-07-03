<?php
/**
 * Établit une connexion à la base de données MySQL.
 *
 * Utilise PDO pour se connecter à la base de données `artbox` hébergée en local
 * avec l'encodage UTF-8. En cas d'échec, la fonction interrompt le script
 * et affiche un message d'erreur.
 *
 * @return PDO Objet PDO représentant la connexion à la base de données.
 * @throws void Cette fonction termine le script avec `die()` en cas d'erreur de connexion.
 */
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
