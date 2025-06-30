<?php
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
    // $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
    $image = htmlspecialchars($_POST['image'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

    // Validation des champs
    //empty() vérifie si les champs sont vides
    //filter_var() vérifie si l'URL de l'image est valide
    if (empty($titre) || empty($artiste) || empty($image) || empty($description)) {
        $erreur = "Tous les champs sont obligatoires.";
    // } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
    //     $erreur = "L'URL de l'image n'est pas valide.";
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
            
            // Redirection avec message de succès
            header('Location: index.php?success=Œuvre ajoutée avec succès');
            exit;
        } catch (Exception $e) {
            $erreur = "Erreur lors de l'ajout de l'œuvre : " . $e->getMessage();
        }
    }
}

// Si erreur, rediriger vers le formulaire avec le message d'erreur
if (isset($erreur)) {
    header('Location: formulaire.php?erreur=' . urlencode($erreur));
    exit;
}
?>