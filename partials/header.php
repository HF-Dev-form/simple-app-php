<!doctype html>
<html lang="en">

<head>
    <title>LeBonAppart - Trouvez l'appartement de vos rêves</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">Lebonappart</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="add.php">Ajouter une annonce</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="list.php">Consulter les annonces</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-3">
        <div class="row">
            <div class="col">

                <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) : ?>
                    <?php foreach ($_SESSION['messages'] as $type => $messages) : ?>
                        <?php foreach ($messages as $message) : ?>
                            <div class="alert alert-<?= $type ?>"><?= $message ?></div>
                            <?php ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['messages']); ?>
                <?php endif; ?>