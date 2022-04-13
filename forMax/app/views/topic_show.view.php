<?php
$title = "Topics page";
$active = 'topic';
require('partials/header.php');
?>

<main>
	<h1 id="h1_topic">Topic</h1>

	<div class="container">
		<?= $topic->getAsBootstrapGridForTopicPage(); ?>
		<a href="/<?= $install_prefix ?>/topic_show_all" class='btn btn-info text-light'>Show all topics</a>
	</div>
</main>

<?php require('partials/footer.php'); ?>
