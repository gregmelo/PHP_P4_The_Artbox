<?php
session_start(); // Démarre la session pour utiliser $_SESSION
require 'header.php';
?>

<?php
// Afficher le message d'erreur s'il existe
if (isset($_SESSION['erreur'])) {
    echo '<p style="color: red;">' . htmlspecialchars($_SESSION['erreur'], ENT_QUOTES, 'UTF-8') . '</p>';
    // Supprimer l'erreur après l'affichage pour éviter qu'elle persiste
    unset($_SESSION['erreur']);
}
?>

<form action="traitement.php" method="POST">
    <div class="champ-formulaire">
        <label for="titre">Titre de l'œuvre</label>
        <input type="text" name="titre" id="titre" value="<?php echo isset($_SESSION['form_data']['titre']) ? htmlspecialchars($_SESSION['form_data']['titre'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </div>
    <div class="champ-formulaire">
        <label for="artiste">Auteur de l'œuvre</label>
        <input type="text" name="artiste" id="artiste" value="<?php echo isset($_SESSION['form_data']['artiste']) ? htmlspecialchars($_SESSION['form_data']['artiste'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </div>
    <div class="champ-formulaire">
        <label for="image">URL de l'image</label>
        <input type="url" name="image" id="image" value="<?php echo isset($_SESSION['form_data']['image']) ? htmlspecialchars($_SESSION['form_data']['image'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    </div>
    <div class="champ-formulaire">
        <label for="description">Description</label>
        <textarea name="description" id="description" value="<?php echo isset($_SESSION['form_data']['description']) ? htmlspecialchars($_SESSION['form_data']['description'], ENT_QUOTES, 'UTF-8') : ''; ?>"></textarea>
    </div>

    <input type="submit" value="Valider" name="submit">
</form>

<?php
// Nettoyer les données du formulaire après affichage
//unset permet de supprimer une variable de session
// Il est important de faire cela pour éviter que les données restent dans la session après l'affichage du formulaire
// Cela permet de ne pas pré-remplir le formulaire avec les anciennes données lors d'une nouvelle soumission.
unset($_SESSION['form_data']); 
require 'footer.php';
?>