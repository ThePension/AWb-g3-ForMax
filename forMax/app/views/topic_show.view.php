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

	<?php
	if($topic->comments_on)
	{
	?>
	<section>
		<div class="container my-5 py-2">
			<div class="row d-flex justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="card text-dark">
						<div class="card-body p-4">
							<h4 class="mb-4">Comments</h4>

							<?php
							if(isset($_SESSION[User::$UserSessionId]))
							{
							?>
								<form method="post" action="comment_add" class="mb-5">
									<div class="d-flex flex-start w-100">
										<div class="form-outline w-100">
											<textarea placeholder="Message" class="form-control" id="comment_content" name="comment_content" rows="4" required></textarea>
										</div>
									</div>
									<input type="hidden" name="topic_id" id="topic_id" value="<?= $topic->id ?>" />
									<div class="float-end mt-2 pt-1">
										<button type="submit" class="btn btn-info btn-sm text-light">Post comment</button>
									</div>
								</form>
							<?php
							}
							if(count($comments) == 0)
							{
								echo "<p class='ps-4' >No comment yet</p>";
							}

							foreach ($comments as $comment)
							{
								echo $comment->getAsBootstrap($topic->fk_user);
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	}
	?>
</main>

<?php require('partials/footer.php'); ?>
