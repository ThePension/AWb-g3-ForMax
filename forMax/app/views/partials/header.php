<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
	<title><?= htmlentities($title) ?></title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/082cac850c.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php require('nav.php') ?>

    <main class="container">
        <div class="row justify-content-md-center">
            <?php
                if(isset($pageTitle))
                {
                    echo '<h1 class="mb-3 mt-3" id="h1_' . $pageTitle . '">' . $pageTitle . '</h1>';
                }
                else
                {
                    echo '<h1 class="mb-3 mt-3" id="h1_' . $title . '">' . $title . '</h1>';
                }
            ?>

            <?php
                // Error display
                if(isset($_SESSION['error_title']) && isset($_SESSION['error_description']))
                {
                    echo 
                        "<div class='col-6 card text-white bg-danger mb-3 info_box'>" .
                            "<div class='card-body'>" .
                                "<h5 class='card-title'>" . $_SESSION['error_title'] . "</h5>" .
                                "<p class='card-text'>" . $_SESSION['error_description'] . " </p>" .
                                "<button type='button' class='btn btn-info text-light' onclick='close_box()'>" .
                                    "<span aria-hidden='true'>Dismiss</span>" .
                                "</button>" .
                            "</div>" .
                        "</div>";

                    unset($_SESSION['error_title']);
                    unset($_SESSION['error_description']);
                }
            ?>

            <?php
                // Information message display
                if(isset($_SESSION['message_title']) && isset($_SESSION['message_description']))
                {
                    echo 
                        "<div class='col-6 card text-white bg-success mb-3 info_box'>" .
                            "<div class='card-body'>" .
                                "<h5 class='card-title'>" . $_SESSION['message_title'] . "</h5>" .
                                "<p class='card-text'>" . $_SESSION['message_description'] . " </p>" .
                                "<button type='button' class='btn btn-info text-light' onclick='close_box()'>" .
                                    "<span aria-hidden='true'>Dismiss</span>" .
                                "</button>" .
                            "</div>" .
                        "</div>";

                    unset($_SESSION['message_title']);
                    unset($_SESSION['message_description']);
                }
            ?>
            
        
