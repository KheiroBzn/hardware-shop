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

    <title>FAQ</title>
    <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <!-- pour accelerer le chargement utilise la version min -->
    <link rel="stylesheet" href="/public/css/footerbar.css">
    <link rel="stylesheet" href="/public/css/accueil.css">

    <link rel="stylesheet" href="/public/css/sous-categorie.css">

    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css">

    <!-- modal -->
    <link rel="stylesheet" type="text/css" href="/public/css/modal.css">

</head>

<body>

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>

    <main class="content-home content-login content-product-details content-shopping-bag p-5">
		<div class="container bg-white p-4 border rounded-sm">
            <div class="std">
                <div id="content_container">
                    <div id="main_content">
                        <div class="wrapper">
                            <div id="content_single">
                                <div class="inner-wrapper">
                                    <h1 class="align-content-center no-margin">
                                        <span class="fa fa-question-circle style-icon-short" style="font-size: 35px;    padding-top: 22px;" aria-hidden="true"></span>FAQ
                                    </h1>
                                    <hr>
                                    <div>
                                        Vous recherchez des conseils, des bons plans ou encore un service après-vente de qualité, Fractal Shop et son équipe de professionnels, tous passionnés par l’informatique et l’univers High Tech, sauront répondre à vos besoins, que ce soit sur internet ou dans l’un de nos magasins près de chez vous.

                                        Nous travaillons à mettre à votre disposition chaque jour le meilleur catalogue produit possible. Que vous soyez utilisateur débutant, étudiant ou professionnel, nous avons forcément le produit qu’il vous faut.

                                        Du PC portable aux composants Informatiques ou aux imprimantes, en passant par l’assemblage de solutions PC Gaming sur mesure, les processeurs, les cartes mère, les cartes graphiques….etc, Fractal Shop propose une gamme complète de matériels informatiques destinés au grand public, ou aux geeks les plus exigeants.

                                        Ce qui distingue Fractal Shop de ses concurrents, depuis les offres d’entrée de gamme jusqu’aux configurations haut de gamme les plus avancées, grâce notamment à des solutions sur mesure qui s’appuient sur plus de 5000 références en stock, et sur l’expertise de plus de 75 collaborateurs expérimentés, choisir un PC monté et testé par Fractal Shop, c’est la garantie d’un choix intelligent de composants sélectionnés parmi les plus grandes marques pour leur excellent rapport performances/prix. Cette sélection répond également à un cahier des charges dédié à la conception d’un ordinateur équilibré pour chaque besoin : jeux, surf, bureautique, création graphique, montage vidéo, etc.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                      
        </div>  
    </main>
                            

 

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