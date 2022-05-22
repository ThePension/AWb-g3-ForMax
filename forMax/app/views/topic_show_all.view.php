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
		<div class="row justify-content-md-center mb-3">
			<div class="col-md-auto">
				<a href='/<?= Helper::createUrl("topic_add") ?>'><button class='btn btn-success text-light' type="button">Create new topic</button></a>
			</div>
			<div class="col-md-auto">
				<a href='/<?= Helper::createUrl("topic_subscribe") ?>'><button class='btn btn-info text-light' type="button">Subscribe to private topic</button></a>
			</div>
		</div>
		<?php
		}
		?>
		
		<div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
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
