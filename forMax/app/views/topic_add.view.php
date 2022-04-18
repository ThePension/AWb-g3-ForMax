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
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/<?=$install_prefix?>/topic_show_all"><button class="btn btn-secondary me-md-2" type="button">Abort</button></a>
                <button type="submit" class="text-light btn btn-success">Create topic</button>
            </div>
        </form>
	</div>
</main>

<?php require('partials/footer.php'); ?>
