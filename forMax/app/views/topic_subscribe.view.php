<?php
$title = "ForMax - subscribe";
$pageTitle = "Subscribe to private topic";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<div class="container">
        <form class="row g-2" method="POST" action="/<?= Helper::createUrl("topic_subscribe_do") ?>">
            <label for="privateTopicKey" class="form-label">Private topic key</label>
            <input type="text" class="form-control" id="privateTopicKey" name="private_topic_key" value="" required>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/<?= Helper::createUrl("topic_show_all") ?>"><button class="btn btn-secondary me-md-2" type="button">Abort</button></a>
                <button type="submit" class="text-light btn btn-info">Subscribe</button>
            </div>
        </form>
	</div>
</main>

<?php require('partials/footer.php'); ?>
