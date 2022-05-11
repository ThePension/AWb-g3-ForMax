<?php
    $title = "ForMax - home";
    $pageTitle = "";
    require('partials/header.php')
?>

<?php
$pathToTopics = "/" . Helper::createUrl("topic_show_all");
$pathToWriteTopic = "/" . Helper::createUrl("topic_add");
?>

<div class="cover-container d-flex w-100 h-100 p-3 text-center mx-auto flex-column">
    <main class="px-3">
        <h1>Welcome to ForMax !!!</h1>
        <?php
        if(isset($_SESSION[User::$UserAccessLevel]) && $_SESSION[User::$UserAccessLevel] == "guest")
        {
        ?>
        <p class="lead">You just enter the forum with our special guest mode.<br>It enables you to explore and read public topics without beeing logged.<br>The ForMax team wishes you a pleasant time on our forum.</p>
        <p class="lead">
            <a href="<?= $pathToTopics ?>" class="btn btn-lg btn-info text-light fw-bold">Read topics</a>
    </main>
        <?php
        }
        elseif(isset($_SESSION[User::$UserAccessLevel]) && $_SESSION[User::$UserAccessLevel] == "logged")
        {
        ?>
        <p class="lead">In this forum you will learn about various subjetcs.<br>Everyone can became a writer because everyone can expose his opinion through topics.<br>The ForMax team wishes you a pleasant time on our forum.</p>
        <p class="lead">
            <a href="<?= $pathToWriteTopic ?>" class="btn btn-lg btn-info text-light fw-bold">Write topic</a>
            <a href="<?= $pathToTopics ?>" class="btn btn-lg btn-info text-light fw-bold">Read topics</a>
    </main>
        <?php
        }
        ?>
        
</div>

<?php require('partials/footer.php') ?>
