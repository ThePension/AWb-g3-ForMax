<?php
    $title = "Home";
    $pageTitle = "Welcome to ForMax !!!";
    require('partials/header.php')
?>

<?php
$install_prefix = App::get('config')['install_prefix'];

$pathToTopics = "/" . $install_prefix . "/topic_show_all";
$pathToWriteTopic = "/" . $install_prefix . "/topic_add";
?>

        <p class="lead">In this forum you will learn about various subjetcs.<br>Everyone can became a writer because everyone can expose his opinion through topics.<br>The ForMax team wishes you a pleasant time on our forum.</p>
        <p class="lead">
        <a href="<?= $pathToWriteTopic ?>" class="btn btn-lg btn-info text-light fw-bold">Write topic</a>
        <a href="<?= $pathToTopics ?>" class="btn btn-lg btn-info text-light fw-bold">Read topics</a>
        </p>
    </div>
</main>

<?php require('partials/footer.php') ?>
