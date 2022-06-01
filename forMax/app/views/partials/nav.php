<!-- based on : https://getbootstrap.com/docs/4.0/components/navbar/ -->

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="/<?= Helper::createUrl("index") ?>">
      <img src="/<?= Helper::createUrl("public/images/formax_logo.svg")?>" alt="ForMax Logo" height="48" class="d-inline-block ms-3 me-3 align-text-top">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/<?= Helper::createUrl("about") ?>">About</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/<?= Helper::createUrl("topic_show_all") ?>">Topics</a>
        </li>

        <?php
        if(isset($_SESSION[User::$UserSessionId])) { ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/<?= Helper::createUrl("account") ?>">Account</a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/<?= Helper::createUrl("my_topics") ?>">My topics</a>
          </li>
          <?php } ?>

          <?php
          if(isset($_SESSION[User::$UserAccessLevel])) { ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/<?= Helper::createUrl("logout") ?>">Logout</a>
          </li>
        <?php } ?>

      </ul>
      <form method="get" action="/<?= Helper::createUrl("topic_show_all") ?>" class="d-flex">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" <?php if(isset($_GET['search'])) echo "value=\"". htmlentities($_GET['search']) ."\""; ?>aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>