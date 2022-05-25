<?php
$title = "ForMax - topic";
$pageTitle = "Write a new topic";
$active = 'topics';
require('partials/header.php');
?>

<main>
	<div class="container">
        <form class="row" method="POST" action="/<?= Helper::createUrl("topic_add_do") ?>">
            <div class="col-12 mb-3">
                <label for="topic_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="topic_name" name="topic_name" required>
            </div>
            <div class="col-12 mb-3">
                <label for="topic_status" class="form-label">Status</label>
                <select class="form-select" id="topic_status" name="topic_status" onchange="topic_status_changed(this.value)">
                    <option selected value="PUBLIC">Public (Everyone can access your topic)</option>
                    <option value="PRIVATE">Private (Only people owning the topic's private key can access your topic)</option>
                    <option value="HIDDEN">Hidden (Only you can access your topic)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="topic_comments_on" class="form-label">Active comments ?</label>
                <input type="checkbox" checked name="topic_comments_on" id="topic_comments_on" />
            </div>

            <div id="private_key_box" class="col-12 mb-3 d-none">
                <label for="topic_private_key" class="form-label">Private key</label>
                <input type="text" class="form-control" id="topic_private_key" name="topic_private_key">
            </div>

            <div class="col-12 mb-3">
                <label for="topic_content" class="form-label">Content</label>
                <textarea rows="5" class="form-control" name="topic_content" id="topic_content" required></textarea>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/<?= Helper::createUrl("topic_show_all") ?>"><button class="btn btn-secondary me-md-2" type="button">Abort</button></a>
                <button type="submit" class="text-light btn btn-success">Create topic</button>
            </div>
        </form>
	</div>
</main>

<script>
    function topic_status_changed(val)
    {
        // Toggle private key input
        if(val == "PRIVATE")
        {
            document.getElementById("private_key_box").classList.remove("d-none");
        }
        else
        {
            document.getElementById("private_key_box").classList.add("d-none");
        }
    }
</script>

<?php require('partials/footer.php'); ?>
