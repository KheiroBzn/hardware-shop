<?php 
	if(!isset($_SESSION)){
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
	<title>Connexion</title>
	<link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
	<link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../public/css/identification.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <!-- pour accelerer le chargement utilise la version min -->
    <link rel="stylesheet" href="/public/css/footerbar.css">
    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css">
    <!-- modal -->
	<link rel="stylesheet" href="/public/css/navigationbar.css"><!-- pour accelerer le chargement utilise la version min -->
	<link rel="stylesheet" href="/public/css/footerbar.css">
</head>
<body>

	<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>

    <div class="container-fluid identification-fluid py-3">
        <div class="container row main-identification mx-auto w-50 border rounded-sm">
            <div class="col-md-1"></div>
            <div class="col-md-6 m-auto text-center border rounded-sm shadow p-3">
                <form action="" method="POST">
                    <h3 class="text-center">D&#233; j&#224; inscrit?</h3>
                    <div class="text-center error">
                        <span></span>
                    </div>
                    <div class="form-group mini">
                        <?php if( !empty( $usernameError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$usernameError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $usernameError ) ) echo 'border-danger' ?>" name="user" placeholder="Nom d'utilisateur" type="text"
                            <?php if(isset($username)) echo 'value="'.$username.'"'; ?> required="required"/>
                    </div>
                    <div class="form-group mini">
                        <?php if( !empty( $passError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$passError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $emailError ) ) echo 'border-danger' ?>" name="pass" placeholder="Mot de passe" type="password"
                            <?php if(isset($pass)) echo 'value="'.$pass.'"'; ?> required="required"/>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" value="login">Connexion</button>
                    <div class="border-top my-4">
                        <h3 class="text-center">Nouveau?</h3>
                        <a class="btn btn-primary btn-block" href="<?php echo $url_inscription ;?>" value="login">Cr&#233;ez un compte</a>
                    </div>
                </form>
            </div>
            <div class="col-md-5 mx-auto mt-5 text-right">
                <img class="mw-100" src="/public/images/identification/login.png" alt="">
            </div>
        </div>
    </div>

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