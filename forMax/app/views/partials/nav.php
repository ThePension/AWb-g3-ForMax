<!-- based on : https://getbootstrap.com/docs/4.0/components/navbar/ -->

<nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="/<?= $install_prefix ?>/">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/<?= $install_prefix ?>/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/<?= $install_prefix ?>/topic_show_all">Topics</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/<?= $install_prefix ?>/account">Account</a>
        </li>
      </ul>
      <form method="get" action="/<?= $install_prefix ?>/topic_show_all" class="d-flex"><!-- un helper pour generer ces URLs? -->
        <input class="form-control me-2" name="search" type="search" placeholder="Search" <?php if(isset($_GET['search'])) echo "value=\"". htmlentities($_GET['search']) ."\""; ?>aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
