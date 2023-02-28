<?php

session_start();

/**
 * Je viens d'envoyer le formulaire :
 */
if (!empty($_POST)) {

    $error = false;

    /**
     * Je teste l'existence et la validation de chaque champ
     */
    if (!isset($_POST['title']) || strlen($_POST['title']) < 1) {
        $_SESSION['messages']['danger'][] = "Le titre est invalide.";
        $error = true;
    }

    if (!isset($_POST['title']) || strlen($_POST['description']) < 1) {
        $_SESSION['messages']['danger'][] = "La description est invalide.";
        $error = true;
    }

    if (!isset($_POST['postal_code']) || !ctype_alnum($_POST['postal_code']) || strlen($_POST['postal_code']) < 5) {
        $_SESSION['messages']['danger'][] = "Le code postal est invalide.";
        $error = true;
    }

    if (!isset($_POST['city']) || strlen($_POST['city']) < 1) {
        $_SESSION['messages']['danger'][] = "La ville est invalide.";
        $error = true;
    }

    if (!isset($_POST['price']) || !ctype_digit($_POST['price']) || $_POST['price'] < 1) {
        $_SESSION['messages']['danger'][] = "Le prix est invalide.";
        $error = true;
    }

    if (!isset($_POST['type_id']) || !in_array($_POST['type_id'], [1,  2])) {
        $_SESSION['messages']['danger'][] = "Le type est invalide.";
        $error = true;
    }

    /**
     * S'il n'y a pas d'erreur, je fais l'insert en base de données
     */
    if (!$error) {

        require_once('config/db.php');

        $request = "INSERT INTO advert(title, description, postal_code, city, price, type_id)
                    VALUES (:title, :description, :postal_code, :city, :price, :type_id)";

        $response = $bdd->prepare($request);
        $response->execute([
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'postal_code' => $_POST['postal_code'],
            'city' => $_POST['city'],
            'price' => $_POST['price'],
            'type_id' => $_POST['type_id'],
        ]);

        $createdAdvertId = $bdd->lastInsertId();

        $_SESSION['messages']['success'][] = "Votre annonce a bien été créée !";
        header('Location: show.php?id=' . $createdAdvertId);
        exit();
    }
}

?>


<?php include_once('partials/header.php') ?>

<h1>Ajouter une annonce</h1>

<form action="add.php" method="post">

    <div class="form-group">
        <label for="">Titre *</label>
        <input name="title" type="text" class="form-control" placeholder="Un nom attrayant pour votre annonce..." required value="<?= isset($_POST['title']) ? $_POST['title'] : null ?>">
    </div>

    <div class="form-group">
        <label for="">Description *</label>
        <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Une description qui donne envie !" required><?= isset($_POST['description']) ? $_POST['description'] : null ?></textarea>
    </div>

    <div class="form-group">
        <label for="">Code postal *</label>
        <input name="postal_code" type="text" class="form-control" placeholder="69002" value="<?= isset($_POST['postal_code']) ? $_POST['postal_code'] : null ?>" required>
    </div>

    <div class="form-group">
        <label for="">Ville *</label>
        <input name="city" type="text" class="form-control" placeholder="Lyon 2ème" value="<?= isset($_POST['city']) ? $_POST['city'] : null ?>" required>
    </div>

    <div class="form-group">
        <label for="">Tarif *</label>
        <div class="input-group">
            <input name="price" type="number" class="form-control" placeholder="500" <?= isset($_POST['price']) ? $_POST['price'] : null ?> required>
            <div class="input-group-append">
                <div class="input-group-text">€</div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="">Type *</label>
        <select name="type_id" id="" class="form-control" required>
            <option value="1" <?= isset($_POST['type_id']) && $_POST['type_id'] == 1 ? 'selected' : null ?>>Location</option>
            <option value="2" <?= isset($_POST['type_id']) && $_POST['type_id'] == 2 ? 'selected' : null ?>>Vente</option>
        </select>
    </div>

    <button class="btn btn-primary float-right">Créer une annonce</button>

</form>


<?php include_once('partials/footer.php') ?>