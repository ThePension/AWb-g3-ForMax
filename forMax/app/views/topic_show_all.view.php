<?php
$title = "Topics page";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<h1 id="h1_topics">Topics</h1>

	<div class="container">
		<a href='/<?= $install_prefix?>/topic_add' class='btn btn-info text-light'>Add topic</a>

		<div class="row">
			<?php
			foreach ($topics as $topic)
			{
				echo $topic->getAsBootstrapGridForHomePage();
			}
			?>
		</div>
	</div>
</main>

<?php require('partials/footer.php'); ?>
