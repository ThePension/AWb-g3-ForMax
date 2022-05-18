<?php
$title = "ForMax - topics";
$pageTitle = "Topics";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<div class="container">
		<?php
		if(isset($_SESSION[User::$UserAccessLevel]) && $_SESSION[User::$UserAccessLevel] == "logged")
		{
		?>
		<div class="d-grid gap-2 d-md-block">
			<a href='/<?= Helper::createUrl("topic_add") ?>'><button class='btn btn-success text-light' type="button">Create new topic</button></a>
			<a href='/<?= Helper::createUrl("topic_subscribe") ?>'><button class='btn btn-info text-light' type="button">Subscribe to private topic</button></a>
		</div>
		<?php
		}
		?>
		
		<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4">
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
