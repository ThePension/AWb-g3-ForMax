<?php
    $title = "ForMax - register";
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
                        <h2 class="text-uppercase text-center mb-5">Create an account</h2>

                        <form method="POST" action="/<?= Helper::createUrl("register_do") ?>">
                            <div class="form-outline mb-4">
                                <input type="text" id="username"  name="username" class="form-control form-control-lg" />
                                <label class="form-label" for="username">Username</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password_repeat" name="password_repeat" class="form-control form-control-lg" />
                                <label class="form-label" for="password_repeat">Repeat your password</label>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-info btn-block btn-lg text-body text-light">Register</button>
                            </div>

                            <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="/<?= Helper::createUrl("login") ?>" class="fw-bold text-body"><u>Login here</u></a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?>
