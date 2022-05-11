<?php
    $title = "ForMax - login";
    $pageTitle = "";
    require('partials/header.php')
?>

<!-- Based on https://mdbootstrap.com/docs/standard/extended/registration/ -->

<div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-5">
                        <h2 class="text-uppercase text-center mb-5">Login</h2>

                        <form method="POST" action="/<?= Helper::createUrl("login_do") ?>">
                            <div class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control form-control-lg" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-info btn-block btn-lg text-body text-light">Login</button>
                            </div>

                            <p class="text-center text-muted mt-5 mb-0">Haven't created an account yet ? <a href="/<?= Helper::createUrl("register") ?>" class="fw-bold text-body"><u>Register here</u></a></p>

                            <p class="text-center text-muted mt-5 mb-0">Just want to explore a bit ? <a href="/<?= Helper::createUrl("guest") ?>" class="fw-bold text-body"><u>log in as guest here</u></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>
