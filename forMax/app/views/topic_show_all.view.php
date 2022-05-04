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
		<a href='/<?= $install_prefix?>/topic_add' class='btn btn-success text-light'>Create new topic</a>
		<?php
		}
		?>
		
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
