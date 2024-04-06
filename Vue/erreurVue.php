<?php if(!isset($_SESSION)){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Erreur <?php echo $_GET['id_erreur'] ?></title>
    <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <!-- pour accelerer le chargement utilise la version min -->
    <link rel="stylesheet" href="/public/css/footerbar.css">

</head>

<body>

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>

  
    <hr>
    
    <hr>
    <div class="container">
        <div class="row text-center" style="justify-content: space-around;">

        <h2 class="text-center">Erreur <?php echo $_GET['id_erreur'] ?> : Page Non Trouve</h2>

        </div>
    </div>

    <hr>

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>


    <script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>

    <!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css">
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>
    
</body>


</html>