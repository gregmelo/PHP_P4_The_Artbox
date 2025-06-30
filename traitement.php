<?php
// Démarrer la session pour stocker les messages et les données du formulaire
session_start();
// Inclusion du fichier de connexion à la base de données
require 'bdd.php';

// Connexion à la base de données
try {
    $pdo = connexion();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Récupération et nettoyage des données avec htmlspecialchars
    // htmlspecialchars() protège contre les attaques XSS en convertissant les caractères spéciaux en entités HTML
    // filter_input() est utilisé pour valider l'URL de l'image
    // ENT_QUOTES permet de convertir les guillemets simples et doubles
    // 'UTF-8' est l'encodage utilisé pour la conversion
    $titre = htmlspecialchars($_POST['titre'], ENT_QUOTES, 'UTF-8');
    $artiste = htmlspecialchars($_POST['artiste'], ENT_QUOTES, 'UTF-8');
    $image = filter_var($_POST['image'], FILTER_VALIDATE_URL);
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

    // Validation des champs
    //empty() vérifie si les champs sont vides
    //filter_var() vérifie si l'URL de l'image est valide
    if (empty($titre) || empty($artiste) || empty($image) || empty($description)) {
        $_SESSION['erreur'] = "Tous les champs sont obligatoires.";
        $_SESSION['form_data'] = $_POST; // Sauvegarde des données saisies
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $_SESSION['erreur'] = "L'URL de l'image n'est pas valide.";
        $_SESSION['form_data'] = $_POST; // Sauvegarde des données saisies
    } else {
        try {
            // Préparation de la requête SQL
            $sql = "INSERT INTO oeuvres (titre, artiste, image, description) VALUES (:titre, :artiste, :image, :description)";
            $stmt = $pdo->prepare($sql);
            
            // Liaison des paramètres
            // bindParam() lie les variables aux paramètres de la requête préparée cela permet d'éviter les injections SQL
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':artiste', $artiste);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':description', $description);
            
            // Exécution de la requête
            $stmt->execute();

            // Nettoyer la session et rediriger avec message de succès
            unset($_SESSION['erreur']);
            unset($_SESSION['form_data']);
            $_SESSION['success'] = "Œuvre ajoutée avec succès";
            
            // Redirection vers la page de l'œuvre ajoutée
            // header() envoie un en-tête HTTP pour rediriger l'utilisateur 
            // lastInsertId() récupère l'ID de la dernière insertion
            header('Location: oeuvre.php?id=' . $pdo->lastInsertId());
            exit;
        } catch (Exception $e) {
            $_SESSION['erreur'] = "Erreur lors de l'ajout de l'œuvre : " . $e->getMessage();
            $_SESSION['form_data'] = $_POST; // Sauvegarde des données saisies
        }
    }
    
    // Rediriger vers le formulaire en cas d'erreur
    header('Location: ajouter.php');
    exit;
}
?>