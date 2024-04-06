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

    <title>Payment</title>
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
    <div class="container mx-auto">
        <div class="card" style="min-height: 99px;">
            <div class="justify-content-center row">
                <?php if(!empty($_SESSION['panier']['id_article']) and isset($_SESSION['userlogin_client']))
                    echo "<h2 class=\"font-weight-bold m-4 text-uppercase title-grid title-panier\">Mode de payement :</h2>";
                else
                    if(isset($_SESSION['userlogin_client'])) {
                        echo "<h2 class=\"font-weight-bold m-4 text-uppercase title-grid title-panier\">Votre Panier est Vide..</h2>";
                    } else {
                        echo "<h2 class=\"font-weight-bold m-4 text-uppercase title-grid title-panier\">Aucune opération autorisée en accées anonyme!</h2>";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if(!empty($_SESSION['panier']['id_article']) and isset($_SESSION['userlogin_client'])) : ?>
        <div class="card my-4 p-4 justify-content-center">
            <form class="row" action="" method="post">
                <div class="col-md-8">
                    <div class="form-row mx-auto my-3 font-weight-bold">
                        <input type="radio" value="ccp" name="payment" checked/>
                        <span class="ml-2">Payement par CCP</span>
                    </div>
                    <div class="form-row mx-auto my-3 font-weight-bold">
                        <input type="radio" value="livraison" name="payment"/>
                        <span class="ml-2">Payement à la livraison</span>
                    </div>
                    <div class="form-row mx-auto my-3 font-weight-bold">
                        <input type="radio" value="ccredit" name="payment" disabled/>

                        <span class="ml-2 text-muted">Payement par carte crédit (Non disponible actuellement)</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <dl class="dlist-align"
                        <?php echo  (empty($_SESSION['panier']['id_article'])  ) ? "style=\"display:none;\"" : "";?>>

                    <dt>Prix Total:</dt>
                    <dd class="text-right ml-3 dd-prix-total font-weight-bolder text-success">
                        <?= $prix_total ; ?> DZD
                    </dd>
                    </dl>
                    <hr <?php echo  (empty($_SESSION['panier']['id_article'])) ? "style=\"display:none;\"" : "";?>>
                    <input name="finaliser" class="p-0 m-0 d-none order-input">
                    <button
                        type="submit"
                        class="btn btn-out btn-primary btn-square btn-main commander"
                        <?php echo  (empty($_SESSION['panier']['id_article'])) ? "style='display:none;'" : "";?>
                        data-abc="true">
                        Finaliser l'achat
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </div>
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