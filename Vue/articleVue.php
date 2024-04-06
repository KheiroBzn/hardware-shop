<?php if(!isset($_SESSION)){
    session_start();
  }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="HWSop" />

  <title>Article</title>
  <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
  <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="/public/css/magnific-popup.css" />
  <link rel="stylesheet" href="/public/css/owl.carousel.min.css" />
  <link rel="stylesheet" href="/public/css/owl.theme.default.min.css" />

  <link rel="stylesheet" href="/public/css/navigationbar.css"><!-- pour accelerer le chargement utilise la version min -->
  <link rel="stylesheet" href="/public/css/footerbar.css">
  <link rel="stylesheet" href="/public/css/style.css" />
  <link rel="stylesheet" href="/public/css/article.css" />
</head>

<body class="article-body">
<?php  include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>	

  <div class="container-fluid py-3 px-4 my-4">
    <article class="product-details col-lg-10 p-1 m-auto grid-categorie bg-white border rounded-sm shadow-sm">
      <div class="row">
        <!-- gallery and tabs column -->
        <div class="col-md-8 mt-4">
          <div class="zoom-gallery row">
            <ul class="list-unstyled product-gallery col-md-2">
              <li class="list-item" style="height: 100px"></li>
              <?php
                $i = 1;
                while(!empty(getAllImageArticle($_GET['id_article'])[$i]['nom_image'])) {
                  echo '<li class="list-item m-2">';
                    echo '<a href="/public/images/articles/'.getAllImageArticle($_GET['id_article'])[$i]['nom_image'].'.jpg">';
                      echo '<img src="/public/images/articles/'.getAllImageArticle($_GET['id_article'])[$i]['nom_image'].'.jpg" class="img-fluid" />';
                    echo '</a>';
                  echo '</li>';
                  $i++;
                } 
              ?>
            </ul>
            <div class="col-md-10">
              <a href="/public/images/articles/<?php echo getImageArticle($_GET['id_article'])?>.jpg">
                <img src="/public/images/articles/<?php echo getImageArticle($_GET['id_article'])?>.jpg" class="img-fluid" /></a>
            </div>
          </div>
        </div>
        <!-- product name and add to cart -->
        <div class="col-md-4 pt-5">
          <h4 class="product-heading w-100 px-3">
            <?php echo  getNomArticle($_GET['id_article']);  ?>
          </h4>
          <!-- product attributes -->
          <ul class="list-unstyled text-muted w-100 px-3">
            <li>Marque: <span><?php echo  getMarqueArticle($_GET['id_article']);  ?></span></li>
              <?php
                if (getNombreExemplaireArticle($_GET['id_article']) > 1) { ?>
                  <li style="margin-top: 20px; margin-bottom: 20px;">
                      <a href="#" class="btn btn-sm btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fa fa-check"></i>
                    </span>
                          <span class="text">En stock</span>
                      </a>
                  </li>
              <?php } else { ?>
                  <li style="margin-top: 20px; margin-bottom: 20px;">
                      <a href="#" class="btn btn-sm btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                          <i class="fa fa-check"></i>
                        </span>
                          <span class="text">Non disponible</span>
                      </a>
                  </li>
              <?php } ?>
          </ul>
          <div class="price-group w-100 px-3" style="font-size: larger; font-weight: bold;">
            <div class="old-price" style="color: #F8694A; font-size: 80%; text-decoration: line-through;" hidden>
              <span class="currency">DZD</span>
              <span>30.000</span>
            </div>
            <div class="price text-success">
              <span class="currency">DZD</span>
              <span><?php echo  getPrixArticle($_GET['id_article']);  ?></span>
            </div>
          </div>
          <div class="w-100 px-3">
            <a href="#comment-tab" class="go-to-comment">
              <?php
                $count = countItem('id_commentaire', 'commentaire', 'WHERE id_article = ?', $_GET['id_article']);
                echo $count.' ';
                ?>Avis(s) / Donnez votre avis
            </a>
          </div>
          <hr />
          <div class="w-100 px-3 py-1">
            <p class=" mb-0" style="height: 150px; overflow: hidden; text-overflow: ellipsis !important;">
              <?php echo  getDescriptionArticle($_GET['id_article']); ?>
            </p>
          </div>
          <div class="text-right mb-3 mr-3">
            <a href="#description-tab" class="go-to-description">...Lire la suite</a>
          </div>
          <div class="row">
              <button
                  type="button"
                  class="btn btn-primary fa fa-shopping-cart mx-auto ajouter-panier"
                  data-id="<?php echo $_GET['id_article'] ?>"
                  title="Ajouter au panier">
                  Ajouter au panier
              </button>
          </div>
          <div class="btngroup"></div>
        </div>
      </div>
    </article>
    <!-- product-details -->
  </div>
  <div class="container-fluid product-details col-lg-10 grid-categorie w-100 px-4 my-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link selected" id="description-tab" data-class="description" data-toggle="tab">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="fiche-tab" data-class="fiche" data-toggle="tab">Fiche technique</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="comment-tab" data-class="comment" data-toggle="tab">
          Commentaires (<?= countItem('id_commentaire', 'commentaire', 'WHERE id_article = ?', $_GET['id_article']) ?>)
        </a>
      </li>
    </ul>
    <div class="tab-content w-100 bg-white my-0 border-bottom border-left border-right shadow-sm" id="myTabContent">
      <div role="tabpanel" class="tab-pane tab-details description p-4 " id="description">
        <p class="description-text p-3 border rounded-sm">
          <?php echo  getDescriptionArticle($_GET['id_article']); ?>
        </p>
      </div>
      <div class="tab-pane tab-details fiche p-4" id="fiche">
        <?php
          $fiche = getFicheArticle($_GET['id_article']).'.xml';
          $directory = $_SERVER['DOCUMENT_ROOT'].'/public/fiche technique/xml/'.$fiche;
          if (file_exists($directory)) {
              $xml = simplexml_load_file($directory);
              echo  "<div class='table-responsive'>";
                echo "<table class='table table-bordered description-table'>";
                $i = 1;
                foreach( $xml->children() as $element ) {
                    $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                    echo '<tr class="'. $parity .'">';
                      echo "<td>".$element->Attribut."</td><td>".$element->Valeur."</td>" ;
                    echo "</tr>";
                }
                echo "</table>";
              echo "</div>";
          } else {
            exit('Echec lors de l\'ouverture du fichier fiche.xml.');
          }
        ?>
      </div>
      <div id="comment" class="tab-pane tab-details container-fluid comment p-4">
        <div class="row">
          <div class="col-md-6" style="display: inline-block;">
            <div class="product-reviews border rounded-sm shadow-sm p-2 bg-light">
              <?php 
                $commentaires = getAllComments($_GET['id_article']);
                if(!empty($commentaires)) {
                    echo '<hr class="m-1 p-1">';
                  foreach($commentaires as $comment) { 
                    $user = getMemberByUserId($comment['id_utilisateur'])?>
                    <div class="comment-area">
                      <div class="single-review border p-3 m-2 rounded-sm shadow-sm">
                        <div class="review-heading">
                          <div>
                            <a href="">
                              <i class="fa fa-user-o"></i><?= ' '.$user['userlogin_client'] ?></a>
                            <a href="" class="float-right">
                              <i class="fa fa-clock-o"></i><?= ' '.$comment['date_ajout_commentaire'] ?> 
                            </a>
                          </div>
                        </div>
                          <hr class="p-0 m-1">
                        <div class="review-body mt-2 p-2">
                          <p>
                            <?= $comment['contenue_commentaire'] ?>
                          </p>
                        </div>
                         <?php if($user['userlogin_client'] === $_SESSION['userlogin_client']) : ?>
                             <hr class="p-0 m-1">
                            <div class="review-footer pb-3">
                              <form action="" method="POST">
                                <input type="number" name="commentID" value="<?= $comment['id_commentaire'] ?>" class="p-0 m-0" hidden>
                                <button type="submit" class="btn btn-sm btn-info fa fa-trash float-right p-0 confirm"></button>
                              </form>
                            </div>
                         <?php endif; ?>
                      </div>
                      <?php if(!empty($comment['reponse_admin'])) { ?>
                        <div class="row">
                          <div class="col-1">
                            <i class="fa fa-reply pl-3 reply-icon"></i>
                          </div>
                          <div class="col-11">
                            <div class="single-review border p-3 my-2 mr-2 ml-0 rounded-sm shadow-sm">
                              <div class="review-heading">
                                <div>
                                  <a href=""><i class="fa fa-user-o"></i> L'équipe HWShop</a>
                                  <a href="" class="float-right">
                                    <i class="fa fa-clock-o"></i><?= ' '.$comment['date_reponse_admin'] ?>
                                  </a>
                                </div>
                              </div>
                                <hr class="p-0 m-1">
                              <div class="review-body mt-2 p-2">
                                <p>
                                  <?= $comment['reponse_admin'] ?>
                                </p>
                              </div>
                            </div> 
                          </div>
                        </div>
                      <?php } ?>
                        <hr class="m-1 p-1">
                    </div>
              <?php }
                } else echo '<h5 class="w-100 text-center">Aucun commentaire</h5>'?>
              </div>
            </div>
          <?php 
            if(isset($_SESSION['userlogin_client'])) { ?>
              <div class="col-md-6">
                  <div class="row">
                      <form class="col-md-12" action="" method="POST" class="review-form">
                          <label for="#review" id="review">Donnez votre avis:</label>
                          <div class="form-group shadow-sm">
                              <textarea class="input form-control comment-text" rows="2" name="commentContent" placeholder="Votre avis.." required></textarea>
                          </div>
                          <button type="submit" class="btn btn-sm btn-primary" style="margin-bottom: 30px;">Envoyer</button>
                      </form>
                  </div>
                  <div class="row">
                      <img class="col-md-12 mw-100" src="/public/images/commentaires/comments.png" alt="">
                  </div>
              </div>
          <?php } else { ?>
                <div class="col-md-6 my-auto text-center">
                  <h5>
                    <a href="<?= $url_connexion ;?>" target="_blank">S'identifier pour pouvoir écrire un commentaire</a>
                  </h5>
                </div>
          <?php } ?>          
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid my-4">
    <main class="col-lg-10 p-1 m-auto grid-categorie bg-white border rounded-sm shadow-sm">
      <div class="row justify-content-center">
        <h2 class="font-weight-bold m-4 text-uppercase title-grid">Les Plus Vues :</h2>
      </div>		
      <div class="tab-pane fade show active" id="nav-home">
        <section class="products clearfix text-center">
          <div class="owl-carousel owl-theme align-content-around">
            <?php   
              $element = getArticleMostView($_GET['id_article'], 10);
              foreach($element as $item){ //var_dump($element);?>
                <div class="item p-2">
                  <article class="product">
                    <div class="container" style="height: 200px !important; width: 200px !important;">
                      <a href="<?php  echo getUrlArticle($item['id_article'])?>">
                        <img
                          src="/public/images/articles/<?php echo getImageArticle($item['id_article'])?>.jpg"
                          class="mw-100 mh-100"
                        />
                      </a>                    
                    </div> 
                    <div class="container" style="height: 50px !important; width: 200px">
                      <h5 class="mw-100 mh-100 embed-responsive">
                        <a href="<?php echo getUrlArticle($item['id_article'])?>">
                          <?php echo $item['nom_article'] ?>
                        </a>
                      </h5>
                    </div>                 
                    <div class="price-group">
                      <!--<div class="old-price" style="color: #F8694A; font-size: 80%; text-decoration: line-through;">
                        <span class="currency">DZD</span>
                        <span>30.000</span>
                      </div>-->
                      <div class="price text-success">
                        <span class="currency">DZD</span>
                        <span><?php echo $item['prix_article'] ?></span>
                      </div>
                    </div>
                    <div class="btngroup">
                      <button 
                        type="button"
                        class="btn btn-primary fa fa-shopping-cart ajouter-panier" 
                        data-id="<?php echo $item['id_article'] ?>" 
                        title="Ajouter au panier">
                        Ajouter au panier
                      </button>
                    </div>
                  </article>
                </div>
            <?php } ?>         
          </div>
        </section>
      </div>
    </main>	
  </div>

  
  <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>
  
      <script src="/public/js/jquery.min.js"></script>
      <script src="/public/js/tether.min.js"></script>
      <script src="/public/js/popper.min.js"></script>
      <script src="/public/js/bootstrap.min.js"></script>
      <script src="/public/js/navigationbar.js"></script>
      <script src="/public/js/article.js"></script>
      <script src="/public/js/jquery.magnific-popup.min.js"></script>
      <script src="/public/js/owl.carousel.min.js"></script>
      <script src="/public/js/script.js"></script>

        <script src="/public/js/notie.js"></script>
        <script src="/public/includes/alert-info.js"></script>
        <script src="/public/includes/panier.js"></script>

          <!-- recherche autcomplete -->
        <link rel="stylesheet" href="/public/css/jquery-ui.css">
        <script src="/public/js/jquery-ui.js"></script>
        <script src="/public/includes/recherche-autocomplete.js"></script>



</body>

</html>