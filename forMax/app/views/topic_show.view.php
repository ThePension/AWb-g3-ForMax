<?php
$title = "Topic";
$active = 'topic';
require('partials/header.php');
?>

<main>
	<div class="container">
		<?= $topic->getAsBootstrapGridForTopicPage(); ?>
		<a href="/<?= $install_prefix ?>/topic_show_all" class='btn btn-info text-light'>Show all topics</a>
	</div>
</main>

<?php require('partials/footer.php'); ?>
