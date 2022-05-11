<?php
    $title = "ForMax - logout";
    $pageTitle = "";
    require('partials/header.php')
?>

<?php
$pathToLogin = "/" . Helper::createUrl("login");
?>

<div class="cover-container d-flex w-100 h-100 p-3 text-center mx-auto flex-column">
    <main class="px-3">
        <h1>You have been logged out.</h1>
        <p class="lead">
            <a href="<?= $pathToLogin ?>" class="btn btn-lg btn-info text-light fw-bold">log in</a>
        </main>
</div>

<?php require('partials/footer.php') ?>
