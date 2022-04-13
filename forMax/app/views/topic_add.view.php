<?php
$title = "Add topic";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<div class="container">
        <form class="row" method="POST" action="/<?=$install_prefix?>/topic_add_do">
            <div class="col-12 mb-3">
                <label for="topic_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="topic_name" name="topic_name" required>
            </div>
            <div class="col-12 mb-3">
                <label for="topic_content" class="form-label">Content</label>
                <textarea rows="5" class="form-control" name="topic_content" id="topic_content" required></textarea>
            </div>
            <button type="submit" class="text-light btn btn-info">Create topic</button>
        </form>
	</div>
</main>

<?php require('partials/footer.php'); ?>
