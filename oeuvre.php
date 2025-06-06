<?php
require 'header.php';
// require 'oeuvres.php';
require 'bdd.php';

// Si l'URL ne contient pas d'id, on redirige sur la page d'accueil
if (empty($_GET['id'])) {
    header('Location: index.php');
}
// Connexion à la base de données
$bdd = connexion();
$requete = $bdd->prepare('SELECT * FROM oeuvres WHERE id = ?');
$requete->execute([$_GET['id']]);
$oeuvre = $requete->fetch();

// Si l'oeuvre n'existe pas, on redirige vers la page d'accueil
if ($oeuvre === false) {
    header('Location: index.php');
    exit();
}

?>

<article id="detail-oeuvre">
    <div id="img-oeuvre">
        <img src="<?= htmlspecialchars($oeuvre['image']) ?>" alt="<?= htmlspecialchars($oeuvre['titre']) ?>">
    </div>
    <div id="contenu-oeuvre">
        <h1><?= htmlspecialchars($oeuvre['titre']) ?></h1>
        <p class="description"><?= htmlspecialchars($oeuvre['artiste']) ?></p>
        <p class="description-complete"><?= htmlspecialchars($oeuvre['description']) ?></p>
    </div>
</article>

<?php require 'footer.php'; ?>