<?php
$title = "Topics page";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<h1 id="h1_topics">Topics</h1>

	<div class="container">
		<?php
		foreach ($topics as $topic)
        {
			echo $topic->getAsBootstrapGridForHomePage(); // TO RENAME
		}
		?>
	</div>
</main>

<?php require('partials/footer.php'); ?>
