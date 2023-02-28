<?php
session_start();

/**
 * On vérifie qu'un ID correct a été transmis en GET
 */
if (!isset($_GET['id']) || !ctype_digit($_GET['id']) | $_GET['id'] < 1) {
    $_SESSION['messages']['danger'][] = "Un problème est survenu à la consultation de ce lien.";
    header('Location: index.php');
    exit();
}

require_once('config/db.php');

$request = "SELECT advert.id, advert.title, advert.description, advert.postal_code, advert.city, advert.price, advert.created_at, advert.reservation_message,
                    type.id as typeId, type.title as typeTitle
            FROM advert
            INNER JOIN type ON advert.type_id = type.id
            WHERE advert.id = :id";

$response = $bdd->prepare($request);
$response->execute([
    'id' => $_GET['id']
]);

$advert = $response->fetch(PDO::FETCH_ASSOC);
// $numberFormatter = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);

/**
 * On vérifie si un message a été envoyé
 */


if (isset($_POST['reservation_message'])) {

    /**
     * Si le bien a déjà été réservé, on ne peut plus le réserver de nouveau, puis on redigire en GET sur la page
     */
    if (!empty($advert['reservation_message'])) {
        $_SESSION['messages']['danger'][] = "Ce bien a déjà été réservé. Désolé !";
        header('Location: show.php?id=' . $advert['id']);
        exit();
    }

    /**
     * On vérifie que le message ne soit pas vide
     */
    if (empty($_POST['reservation_message'])) {
        $_SESSION['messages']['warning'][] = "Votre message ne peut pas être vide.";
        header('Location: show.php?id=' . $advert['id']);
        exit();
    }

    /**
     * Dans les autres cas, le message est valide et peut être enregistré.
     */

    $request = "UPDATE advert SET reservation_message = :reservation_message WHERE id = :id";
    $response = $bdd->prepare($request);
    $response->execute([
        'reservation_message' => $_POST['reservation_message'],
        'id' => $advert['id']
    ]);

    $_SESSION['messages']['success'][] = "Votre reservation a bien été enregistrée !";
    header('Location: show.php?id=' . $advert['id']);
    exit();
}

?>

<?php include_once('partials/header.php') ?>


<h1><?= $advert['title'] ?></h1>

<a href="list.php">Retour à la liste des biens</a>
<hr>
<div class="card">
    <div class="card-header"><?= $advert['title'] ?> située à <?= $advert['city'] ?> (code postal: <?= $advert['postal_code'] ?>)</div>
    <div class="card-body">
        <?= $advert['description'] ?>
    </div>
    <div class="card-footer">
        <p>
            Ce bien est une <?= $advert['typeTitle'] ?> proposé à un tarif de <?= $advert['price'] ?>€
        </p>
    </div>
</div>

<hr>
<p>
    <?php if (!$advert['reservation_message']) : ?>
        <p>
            <strong>
                Ce bien n'est pas réservé ! Soyez les premiers à laisser un message afin que le propriétaire vous recontacte.
            </strong>

            <form action="show.php?id=<?= $advert['id'] ?>" method="post">
                <div class="form-group">
                    <label for="formReservationMessage">Message de réservation</label>
                    <textarea name="reservation_message" id="formReservationMessage" rows="5" class="form-control" placeholder="Donnez un maximum de coordonnées pour que le propriétaire vous recontacte !"></textarea>
                </div>

                <button class="btn btn-primary float-right">Je réserve ce bien !</button>
            </form>
        </p>
    <?php else : ?>
        <div class="alert alert-success">
            <p>
                Ce bien été reservé, voici le message du futur habitant :
                <hr>
                <em><?= $advert['reservation_message'] ?></em>
            </p>
        </div>
    <?php endif; ?>
</p>
<?php include_once('partials/footer.php') ?>