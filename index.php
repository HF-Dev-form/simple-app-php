<?php
session_start();
require_once('config/db.php');

$request = "SELECT advert.id, advert.title, advert.description, advert.postal_code, advert.city, advert.price, advert.created_at,
                    type.id as typeId, type.title as typeTitle
            FROM advert
            INNER JOIN type ON advert.type_id = type.id
            ORDER BY created_at DESC
            LIMIT 0, 15";

$response = $bdd->prepare($request);
$response->execute();

$adverts = $response->fetchAll(PDO::FETCH_ASSOC);
// $numberFormatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);

?>

<?php include_once('partials/header.php') ?>

<div class="jumbotron">
    <h1 class="display-3">Le Bon Appart</h1>
    <p class="lead">Vendez, achetez, louez un appartement facilement avec Le Bon Appart !</p>
    <hr class="my-2">
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, impedit suscipit sapiente quod dolor tempora sit quas laboriosam sunt, temporibus soluta autem deserunt corporis qui et illo exercitationem voluptas beatae.<br>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea, dicta, tempora mollitia saepe sint asperiores eius omnis, reprehenderit amet dolorum officiis aliquam minima animi esse id incidunt odit? Assumenda, blanditiis!
    </p>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="add.php" role="button">J'ajoute mon annonce !</a>
        <a class="btn btn-success btn-lg" href="list.php" role="button">Voir la liste des annonces</a>
    </p>
</div>

<h1>Nos 15 dernières annonces ajoutées</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Annonce</th>
            <th>Lieu</th>
            <th>Prix et type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adverts as $advert) : ?>
            <tr>
                <td>
                    <strong><?= strtoupper($advert['title']) ?></strong>
                    <p>
                        <small>
                            <?= $advert['description'] ?>
                        </small>
                    </p>
                </td>
                <td>
                    <?= $advert['postal_code'] ?> <?= $advert['city'] ?>
                </td>
                <td>
                    <span class="badge badge-primary"><?= $advert['typeTitle'] ?></span>
                    <span class="badge badge-secondary"><?= $advert['price'] ?>€</span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php include_once('partials/footer.php') ?>

