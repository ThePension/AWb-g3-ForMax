<?php
    $title = "ForMax - account";
    $pageTitle = "Hi " . htmlentities($user->username) . " !";
    require('partials/header.php')
?>

<main>
	<div class="container">
        <form class="row" method="POST" action="/<?= Helper::createUrl("account_update_do") ?>">
            
            <div class="col-12 mb-3">
                <label for="user_username" class="form-label">Username</label>
                <input type="text" class="form-control" id="user_username" name="user_username" required value="<?= htmlentities($user->username) ?>">
            </div>

            <div class="col-12 mb-3">
                <label for="user_description" class="form-label">Description</label>
                <input type="text" class="form-control" id="user_description" name="user_description" required value="<?= htmlentities($user->description) ?>">
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/<?= Helper::createUrl("index") ?>"><button class="btn btn-secondary me-md-2" type="button">Return to home</button></a>
                <button class="btn btn-success" type="submit">Save changes</button>
            </div>
        </form>
	</div>
</main>

<?php require('partials/footer.php') ?>
