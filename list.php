<?php

require_once('config/db.php');

$request = "SELECT advert.id, advert.title, advert.description, advert.postal_code, advert.city, advert.price, advert.created_at, advert.reservation_message,
                    type.id as typeId, type.title as typeTitle
            FROM advert
            INNER JOIN type ON advert.type_id = type.id
            ORDER BY created_at DESC";

$response = $bdd->prepare($request);
$response->execute();

$adverts = $response->fetchAll(PDO::FETCH_ASSOC);

// $numberFormatter = new NumberFormatter( 'de_DE', NumberFormatter::DECIMAL );

?>

<?php include_once('partials/header.php') ?>


<h1>Consultez toutes nos annonces</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Annonce</th>
            <th>Lieu</th>
            <th>Prix et type</th>
            <th></th>
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
                    <?php if(!empty($advert['reservation_message'])) :?>
                        <span class="badge badge-success">Ce bien a déjà été réservé !</span>
                    <?php endif;?>
                </td>
                <td>
                    <span class="badge badge-primary"><?= $advert['typeTitle'] ?></span>
                    <span class="badge badge-secondary"><?= $advert['price'] ?>€</span>
                </td>
                <td>
                    <a href="show.php?id=<?= $advert['id'] ?>" class="btn btn-success">Voir l'annonce</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php include_once('partials/footer.php') ?>

