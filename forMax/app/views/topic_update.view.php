<?php
$title = "ForMax - topic";
$pageTitle = "Update topic";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<div class="container">
        <form class="row" method="POST" action="/<?=$install_prefix?>/topic_update_do">
            <input type="hidden" name="id" value="<?= htmlentities($topic->id) ?>"/>
            <div class="col-12 mb-3">
                <label for="topic_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="topic_name" name="topic_name" required value="<?= htmlentities($topic->name) ?>">
            </div>

            <div class="col-12 mb-3">
                <label for="topic_status" class="form-label">Status</label>
                <select class="form-select" id="topic_status" name="topic_status">
                    <option <?= $topic->status == "PUBLIC" ? "selected" : "" ?> value="PUBLIC">Public (Everyone can access your topic)</option>
                    <option <?= $topic->status == "PRIVATE" ? "selected" : "" ?> value="PRIVATE">Private (Only people owning the topic's private key can access your topic)</option>
                    <option <?= $topic->status == "HIDDEN" ? "selected" : "" ?> value="HIDDEN">Hidden (Only you can access your topic)</option>
                </select>
            </div>

            <div class="col-12 mb-3">
                <label for="topic_content" class="form-label">Content</label>
                <textarea rows="5" class="form-control" name="topic_content" id="topic_content" required><?= htmlentities($topic->content) ?></textarea>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/<?=$install_prefix?>/topic_show?id=<?=  htmlentities($topic->id) ?>"><button class="btn btn-secondary me-md-2" type="button">Abort</button></a>
                <button class="btn btn-success" type="submit">Save changes</button>
            </div>
            
        </form>
	</div>
</main>

<?php require('partials/footer.php'); ?>
