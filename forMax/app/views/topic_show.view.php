<?php
$title = 'ForMax - topic';
$active = 'topic';
$pageTitle = $topic->getTitleForTopicPage();
require('partials/header.php');
?>

<main>
	<div class="container">
		<a href="/<?= Helper::createUrl("topic_show_all") ?>" class='btn btn-info text-light'>Show all topics</a>
		<?= $topic->getAsBootstrapGridForTopicPage(); ?>
	</div>

	<section>
		<div class="container my-5 py-2">
			<div class="row d-flex justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="card text-dark">
						<div class="card-body p-4">
							<h4 class="mb-4">Comments</h4>

							<?php
							if(count($comments) == 0)
							{
								echo "<p class='ps-4' >No comment yet</p>";
							}

							foreach ($comments as $comment)
							{
								echo $comment->getAsBootstrap();
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>

<?php require('partials/footer.php'); ?>
