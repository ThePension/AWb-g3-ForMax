<?php
$title = "Topics page";
$active = 'topic';
require('partials/header.php');
?>

<main>
	<h1 id="h1_topic">Topic</h1>

	<div class="container">
		<?php
		Helper::display($topic);
		?>
	</div>
</main>

<?php require('partials/footer.php'); ?>
