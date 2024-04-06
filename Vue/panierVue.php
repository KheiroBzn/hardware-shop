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

    <title>Panier</title>
    <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <!-- pour accelerer le chargement utilise la version min -->
    <link rel="stylesheet" href="/public/css/footerbar.css">
    <link rel="stylesheet" href="/public/css/panier.css">

</head>

<body style="background-color: #f6f7f9 !important;" >

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>

    <div class="container-fluid mb-5" style="margin-top: 162px;">
	    <div class="row">
	        <aside class="col-lg-9">
           
                <div class="card" style="min-height: 99px;">
                    <div class="justify-content-center row">
						<?php if(!empty($article_panier['qte_total']) and intval($article_panier['qte_total'])>0  )
								echo "<h2 class=\"font-weight-bold m-4 text-uppercase title-grid title-panier\">Votre Panier :</h2>";
							  else							
							 	 echo "<h2 class=\"font-weight-bold m-4 text-uppercase title-grid title-panier\">Votre Panier est Vide...</h2>";
						?>
		            </div>

					<div class="table-responsive" 
					<?php echo  (empty($article_panier['qte_total']) || intval($article_panier['qte_total'])==0  ) ? "style=\"display:none;\"" : "";?>>
	                    <table class="table  table-shopping-cart">
	                        <thead class="text-muted">
	                            <tr class="small text-uppercase">
	                                <th class="pl-5" scope="col">Article</th>
	                                <th scope="col" width="90">Quantite</th>
	                                <th scope="col" width="120">Prix</th>
                                    <th scope="col" width="120">Sous-Total</th>
	                                <th scope="col"  ></th>
	                            </tr>
	                        </thead>
	                        <tbody>
							<?php   if(!empty($article_panier['id_article'])) 
                    					for ($i=0; $i < count((array)$article_panier['id_article']) ; $i++) { ?>
	                            <tr  data-id="<?php echo $article_panier['id_article'][$i]; ?>" >
	                                <td >
	                                    <figure class="itemside align-items-center">
	                                        <div class="aside"><img src="/public/images/articles/<?php echo getImageArticle($article_panier['id_article'][$i]) ;?>" class="img-sm"></div>
	                                        <figcaption class="info"> <a href="<?php  echo getUrlArticle($article_panier['id_article'][$i])?>" class="title font-weight-bolder text-capitalize text-dark" data-abc="true"><?php echo $article_panier['nom_article'][$i]; ?></a>
	                                            <!--<p class="text-muted small">SIZE: L <br> Brand: MAXTRA</p>-->
	                                        </figcaption>
	                                    </figure>
	                                </td>
                                    <td data-th="Quantity">
                                        <input type="number" class="form-control text-center qte-number" min="1" max="<?php echo  $article_panier['nombre_exemplaire_article'][$i]; ?>" value="<?php echo  $article_panier['qte_article'][$i]; ?>">
										<small class="text-muted"> Max : <?php echo  $article_panier['nombre_exemplaire_article'][$i]; ?> </small>
									</td>
	                                <td>
	                                    <div class="price-wrap"> <var class="price"><?php echo $article_panier['prix_article'][$i]; ?> DZD</var><!-- <small class="text-muted"> 9.20 DZD Chaque </small>--> </div>
	                                </td>
                                    <td data-th="sous-total" >
										<div class="price-wrap"> <var class="price"><?php $sous_total=intval($article_panier['prix_article'][$i])*intval($article_panier['qte_article'][$i]);
																						 echo $sous_total; ?> DZD</var> 
										</div>
	                                </td>
	                                <td class="text-right"> 
                                    
                                    <button href="#" class="btn btn-light delete-article-page-panier" data-abc="true"> Supprimer</button> 
                                    </td>
	                            </tr>
                                <?php }?>

	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </aside>
	        <aside class="col-lg-3">
				<!--
	            <div class="card mb-3">
	                <div class="card-body">
	                    <form>
	                        <div class="form-group"> <label>Vous Disposez d'un Coupon?</label>
	                            <div class="input-group"> <input type="text" class="form-control coupon" name="" placeholder="Coupon code"> <span class="input-group-append"> <button class="btn btn-primary btn-apply coupon">Appliquer</button> </span> </div>
	                        </div>
	                    </form>
	                </div>
	            </div>-->

	            <div class="card">
	                <div class="card-body">
	                    <dl class="dlist-align"
							<?php echo  (empty($article_panier['qte_total']) || intval($article_panier['qte_total'])==0  ) ? "style=\"display:none;\"" : "";?>>
	                
	                        <dt>Prix Total:</dt>
							<dd class="text-right ml-3 dd-prix-total font-weight-bolder text-success"><?php 	if(isset($article_panier['prix_total']))
																	echo $article_panier['prix_total'] ;
																else 
																	echo "0";?> DZD</dd>
	                    </dl>
	                    <!--<dl class="dlist-align">
	                        <dt>Reduction:</dt>
	                        <dd class="text-right text-danger ml-3 dd-reduction">- 0 DZD</dd>
	                    </dl>-->
	                    <!--<dl class="dlist-align">
	                        <dt>Total A Payer:</dt>
	                        <dd class="text-right text-dark b ml-3 font-weight-bold dd-prix-a-payer"><?php 	/*if(isset($article_panier['prix_total']))
																						echo $article_panier['prix_total'] ;
																					else 
																						echo "0";*/?>  DZD</dd>
	                    </dl>-->
	                    <hr <?php echo  (empty($article_panier['qte_total']) || intval($article_panier['qte_total'])==0  ) ? "style=\"display:none;\"" : "";?>>
                        <form action="" method="post" <?php echo  (empty($article_panier['qte_total']) || intval($article_panier['qte_total'])==0  ) ? "style='display:none;'" : "";?> >
                            <input name="order" class="p-0 m-0 d-none order-input">
                            <button
                                    type="submit"
                                    class="btn btn-out btn-primary btn-square btn-main commander"
                                    <?php echo  (empty($article_panier['qte_total']) || intval($article_panier['qte_total'])==0  ) ? "style='display:none;'" : "";?>
                                    data-abc="true">
                               Commander
                            </button>
                        </form>

						<a href="<?php echo $last_url; ?>" class="btn btn-out btn-success btn-square btn-main mt-2 continuer-achat" data-abc="true">Continuer Les Achats</a>
	                </div>
	            </div>
	        </aside>
	    </div>
	</div>


    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>


    <script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>



    <!-- ajouter panier-->
    <script src="/public/includes/panier.js"></script>

	<!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css">
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>
	
</body>