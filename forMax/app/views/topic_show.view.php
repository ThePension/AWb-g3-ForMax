<?php
$title = 'ForMax - topic';
$active = 'topic';
$pageTitle = $topic->getTitleForTopicPage();
require('partials/header.php');
?>

<main>
	<div class="container">
		<?= $topic->getAsBootstrapGridForTopicPage(); ?>
		<br>
		<a href="/<?= Helper::createUrl("topic_show_all") ?>" class='btn btn-info text-light'>Show all topics</a>
	</div>
</main>

<?php require('partials/footer.php'); ?>
