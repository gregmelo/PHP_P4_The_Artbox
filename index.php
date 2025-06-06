<?php
require 'header.php';
// require 'oeuvres.php';
require 'connexion.php';

// On récupère les oeuvres depuis la base de données
$sqlQuery = 'SELECT * FROM oeuvres order by id ASC';
$oeuvresStatement = $mysqlClient->prepare($sqlQuery);
$oeuvresStatement->execute();
$oeuvres = $oeuvresStatement->fetchAll(PDO::FETCH_ASSOC);

// Si aucune oeuvre n'est trouvée
if (empty($oeuvres)) {
    echo '<p>Aucune oeuvre trouvée.</p>';
}
?>
<div id="liste-oeuvres">
    <?php foreach ($oeuvres as $oeuvre): ?>
        <article class="oeuvre">
            <a href="oeuvre.php?id=<?= $oeuvre['id'] ?>">
                <img src="<?= $oeuvre['image'] ?>" alt="<?= $oeuvre['titre'] ?>">
                <h2><?= $oeuvre['titre'] ?></h2>
                <p class="description"><?= $oeuvre['artiste'] ?></p>
            </a>
        </article>
    <?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>