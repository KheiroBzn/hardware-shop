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

    <title>Accueil</title>
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

    <!-- carousel image defilante -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>

        </ol>
        <div class="carousel-inner" role="listbox">
            <!-- Slide One - Set the background image for this slide in the line below -->
            <div class="carousel-item active"
                style="background-image: url('../public/images/background-carousel/image1-1920x1080.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="display-4"></h3>
                    <p class="lead"></p>
                </div>
            </div>

            <!-- Slide Two - Set the background image for this slide in the line below -->
            <div class="carousel-item"
                style="background-image: url('../public/images/background-carousel/image2-1920x1080.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="display-4"></h3>
                    <p class="lead"></p>
                </div>
            </div>
            <!-- Slide Three - Set the background image for this slide in the line below -->
            <div class="carousel-item"
                style="background-image: url('../public/images/background-carousel/ryzen1-1920x1080.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="display-4"></h3>
                    <p class="lead"></p>
                </div>
            </div>

            <div class="carousel-item"
                style="background-image: url('../public/images/background-carousel/amd1-1920x1080.jpg')">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="display-4"></h3>
                    <p class="lead"></p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <hr>

    <!--<button id="modal-btn" class="button">Click Here</button>-->

    <div id="my-modal" class="modal" >
        <div class="modal-content"  >

            <div class="modal-header d-inline-block" >    
                <h2 class="text-center text-uppercase d-block" >Choisir Une Categorie :</h2>
                <span class="close" >×</span>
            </div>

            <div class="modal-body text-center" >
                <!--<div>
                        <figure class="card">
                            <a class="toggle-list" href="/index.php?action=sousCategorie&amp;url_categorie=composant&amp;id_categorie=2&amp;url_sous_categorie=alimentation&amp;id_sous_categorie=5&amp;page=1" >
                                <h5 class="font-weight-bold m-4 text-capitalize text-center text-grid">alimentation</h5>
                            </a>
                        </figure>
                </div>-->
            </div>

            <div class="modal-footer border-0" >
                <!-- <h3>Modal Footer</h3>-->
            </div>

        </div>
    </div>  

    <!---->
    <h2 class="text-center">NOUVEAUTÉS</h2>
    <hr>
    <div class="container">
        <div class="row text-center">
            <?php  while( $element = $article_plus_recent->fetch() ){    ?>
            
            <div class="col-lg-4 col-md-6">
                <figure class="card card-product-grid shadow">
                    <div class="img-wrap img-height">
                        <img class="img-height" src="/public/images/articles/<?php echo getImageArticle($element['id_article'])?>.jpg">
                        <a class="btn-overlay" href="<?php  echo getUrlArticle($element['id_article'])?>">
                            <i class="fa fa-search-plus"></i>Voir Article
                        </a>
                    </div> <!-- img-wrap.// -->
                    <figcaption class="info-wrap" >
                        <div class="text-center" style="height: 85px !important;" >
                            <a
                                href="<?php  echo getUrlArticle($element['id_article'])?>"
                                class="title h5 text-capitalize mw-100 mh-100 embed-responsive"><?php echo $element['nom_article'] ?>
                            </a>
                            <div class="price-wrap mt-2 price-product">
                                <span class="price"><?php echo $element['prix_article'] ?> DZD</span>
                            </div> <!-- price-wrap.// -->
                        </div>
                        <a 
                            href="#" class="btn btn-block btn-primary mt-2 ajouter-panier" 
                            data-id="<?php echo $element['id_article'] ?>"><i class="fa fa-cart-plus"></i> Ajouter au Panier 
                        </a>
                    </figcaption>
                </figure>
            </div> <!-- col.// -->

            <?php } ?>



        </div>
    </div>
    <div class="product-more text-right"><a
            class="btn btn-danger all-product-link pull-md-right h4 product-more text-right m-3 voir-plus-produit"  data-filtre="plus recent" href="#">
            Voir plus de produits
        </a></div>
    <hr>

    <h2 class="text-center">MEILLEURS VENTES</h2>
    <hr>
    <div class="container">
        <div class="row text-center">


        <?php  while( $element = $article_plus_vendus->fetch() ){    ?>

        <div class="col-lg-4 col-md-6">
            <figure class="card card-product-grid shadow">
                <div class="img-wrap img-height">
                    <img class="img-height" src="/public/images/articles/<?php echo getImageArticle($element['id_article'])?>.jpg">
                    <a class="btn-overlay" href="<?php  echo getUrlArticle($element['id_article'])?>">
                        <i class="fa fa-search-plus"></i>Voir Article
                    </a>
                </div> <!-- img-wrap.// -->
                <figcaption class="info-wrap" >
                    <div class="text-center" style="height: 85px !important;" >
                        <a href="<?php  echo getUrlArticle($element['id_article'])?>"
                           class="title h5 text-capitalize mw-100 mh-100 embed-responsive"><?php echo $element['nom_article'] ?></a>
                        <div class="price-wrap mt-2 price-product">
                            <span class="price"><?php echo $element['prix_article'] ?> DZD</span>
                        </div> <!-- price-wrap.// -->
                    </div>
                    <a href="#" class="btn btn-block btn-primary mt-2 ajouter-panier"  data-id="<?php echo $element['id_article'] ?>">
                        <i class="fa fa-cart-plus"></i> Ajouter au Panier 
                    </a>
                </figcaption>
            </figure>
        </div> <!-- col.// -->

        <?php } ?>



        </div>
    </div>
    <div class="product-more text-right"><a
            class="btn btn-danger all-product-link pull-md-right h4 product-more text-right m-3 voir-plus-produit"  data-filtre="plus vendus" href="#">
            Voir plus de produits
        </a></div>
    <hr>


    <h2 class="text-center">LES PLUS VUES</h2>
    <hr>
    <div class="container pb-4">
        <div class="row text-center ">
           
        <?php  while( $element = $article_plus_vues->fetch() ){    ?>

        <div class="col-lg-4 col-md-6">
            <figure class="card card-product-grid shadow">
                <div class="img-wrap img-height">
                    <img class="img-height" src="/public/images/articles/<?php echo getImageArticle($element['id_article'])?>.jpg">
                    <a class="btn-overlay" href="<?php  echo getUrlArticle($element['id_article'])?>">
                        <i class="fa fa-search-plus"></i>Voir Article
                    </a>
                </div> <!-- img-wrap.// -->
                <figcaption class="info-wrap" >
                    <div class="text-center" style="height: 85px !important;" >
                        <a href="<?php  echo getUrlArticle($element['id_article'])?>"
                           class="title h5 text-capitalize mw-100 mh-100 embed-responsive"><?php echo $element['nom_article'] ?></a>
                        <div class="price-wrap mt-2 price-product">
                            <span class="price"><?php echo $element['prix_article'] ?> DZD</span>
                        </div> <!-- price-wrap.// -->
                    </div>
                    <a href="#" class="btn btn-block btn-primary mt-2 ajouter-panier"  data-id="<?php echo $element['id_article'] ?>">
                        <i class="fa fa-cart-plus"></i> Ajouter au Panier 
                    </a>
                </figcaption>
            </figure>
        </div> <!-- col.// -->

        <?php } ?>
        </div>

    </div>
    <div class="product-more text-right"><a
            class="btn btn-danger all-product-link pull-md-right h4 product-more text-right m-3 voir-plus-produit"  data-filtre="plus vues" href="#">
            Voir plus de produits
        </a></div>
    <hr>

    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h3 class="section-title text-uppercase p-3">Nos Marques</h3>
            </header><!-- sect-heading -->

            <div class="row">
                <div class="col-md-2 col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque AMD" src="/public/images/marque/svg/amd-2.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque INTEL" src="/public/images/marque/svg/intel.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque GEFORCE-"
                                src="/public/images/marque/svg/geforce-experience-2.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque MSI-GAMING" src="/public/images/marque/svg/msi-gaming.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque RYZEN" src="/public/images/marque/svg/ryzen.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque NZXT" src="/public/images/marque/svg/nzxt-1.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque ASUS" src="/public/images/marque/svg/asus-6630.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque RAZER" src="/public/images/marque/svg/razer-1.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque STEELSERIES" src="/public/images/marque/svg/steelseries.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque THERMALTAKE" src="/public/images/marque/svg/thermaltake.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque CORSAIR" src="/public/images/marque/svg/corsair-3.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->

                <div class="col-md-2  col-6">
                    <figure class="box item-logo shadow">
                        <img alt="marque LOGITECH" src="/public/images/marque/svg/logitech-5.svg">
                    </figure> <!-- item-logo.// -->
                </div> <!-- col.// -->
            </div> <!-- row.// -->
        </div><!-- container // -->
    </section>

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>


    <script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>

    <!-- boutton voir plus de produit -->
    <script src="/public/includes/accueil.js"></script>

    <!-- script alert info-->
    <script src="/public/js/notie.js"></script>
    <script src="/public/includes/alert-info.js"></script>
    <!-- ajouter panier-->
    <script src="/public/includes/panier.js"></script>
    <!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css">
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>

    
</body>


</html>