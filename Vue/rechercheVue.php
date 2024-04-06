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
    <title>Recherche</title>
    <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <link rel="stylesheet" href="/public/css/footerbar.css">

    <link rel="stylesheet" href="/public/css/sous-categorie.css">

    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css">


 
</head>

<body>


    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php";  ?>
    <section class="section-content padding-y mb-5" style="text-align: -webkit-center;" >
        <div class="container" style="width: 100% !important;margin: 0px !important;margin-right: 10px !important;" >

            <div class="row">
                <main style="padding-top: 30px;width: -webkit-fill-available;">

                    <header class="border-bottom mb-4 pb-3">
                        <div class="form-inline">
                            <span id="nombre-article" class="mr-md-auto">Resulta De La Recherche : <?php echo  $nbr_article; ?>  Articles Trouve
                            </span>
                        </div>
                    </header>

                    <div id="display-article" class="row">
                        <?php echo $currentArticlesDisplay;?>
                    </div>

                    <div>
                        <nav class="mt-4 " aria-label="Page navigation sample">
                            <ul id="display-page" class="pagination float-right">
                                <?php echo $currentPaginationNumber ;?>
                            </ul>
                        </nav>
                    </div>

                </main>
            </div>
        </div>
    </section>

    
    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php"; ?>

    <script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>    
      
    <!-- script alert info-->
    <script src="/public/js/notie.js"></script>
    <script src="/public/includes/alert-info.js"></script>
    <!-- ajouter panier-->
    <script src="/public/includes/panier.js"></script>
    <!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css">
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>
     <!-- recherche pagination -->
     <script src="/public/includes/recherche-pagination.js"></script>

   

</body>


</html>