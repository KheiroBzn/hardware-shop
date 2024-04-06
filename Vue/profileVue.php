<?php 
	if(isset($_SESSION['userlogin_client'])) {
        $userInformation = getInformationByUserName($_SESSION['userlogin_client']);
	} else {
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
	<title><?= $userInformation['prenom_client'] ?></title>
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
    <link rel="stylesheet" href="/public/css/profile.css">
</head>
<body>

	<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>

    <div class="container-fluid profile-fluid py-3 px-2">
        <div class="container profile bg-white border rounded-sm shadow-sm">
            <div class="row mb-5 px-4">
                <div class="col-md-4 mt-5 py-3 h-100 lateral border rounded-sm">
                    <?php if ($_SESSION['group'] == 'ADMIN') : ?>
                        <div class="row px-3">
                            <a href="http://admin" class="w-100">
                                <span class="btn btn-lg btn-primary mb-2 w-100 profile-btn btn-menu" data-class="infos">
                                    <i class="fa fa-tachometer"></i> Administration
                                </span>
                            </a>
                        </div>
                        <div class="dropdown-divider mb-2"></div>
                    <?php endif; ?>
                    <div class="row px-3">
                        <span class="btn btn-lg btn-primary mb-2 w-100 profile-btn btn-menu" data-class="infos">
                            Mes informations
                        </span>
                    </div>
                    <div class="row px-3">
                        <span href="" class="btn btn-lg btn-primary mb-2 w-100 profile-btn btn-menu" data-class="orders">
                            Mes commandes
                        </span>
                    </div>
                    <div class="row px-3">
                        <span class="btn btn-lg btn-primary mb-2 w-100 profile-btn btn-menu" data-class="history">
                            Mon historique d'achat
                        </span>
                    </div>
                    <div class="row px-3">
                        <span href="" class="btn btn-lg btn-primary mb-2 w-100 profile-btn btn-menu" data-class="livraison">
                            Mon adresse de livraison
                        </span>
                    </div>
                    <div class="dropdown-divider mb-2"></div>
                    <div class="row px-3">
                        <a href="<?= getUrlDeconnexion() ?>" class="fa fa-sign-out style-icon-short btn btn-lg btn-primary mx-auto w-100 profile-btn logout-btn">
                            Se déconnecter
                        </a>
                    </div>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-7 pt-4 welcome-div">
                    <div class="row card mb-4 p-3 profile-title" <?php if(!empty($displayForm)) echo 'style="display: none"' ?>>
                        <?php $genre = $userInformation['sexe_client'] == 'HOMME' ? 'M. ' : 'Mme '; ?>
                        <p>Bonjour <?php echo $genre ."\"". $userInformation['prenom_client'] ."\""; ?>.</p>
                        <p>
                            À partir du tableau de bord de votre compte, vous pouvez visualiser vos commandes récentes,
                            gérer vos adresses de livraison et de facturation ainsi que changer votre mot de passe
                            et les détails de votre compte.
                        </p>
                    </div>
                    <div class="row card mb-4 profile-card last-orders" <?php if(!empty($displayForm)) echo 'style="display: none"' ?>>
                        <div class="card-header profile-card-header">
                            Mes commandes récentes
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled latest">
                                <?php
                                $lastOrders =  getLastOrdersById($userInformation['id_client'], 3);
                                if(!empty($lastOrders)) {
                                    echo '<hr>';
                                    foreach($lastOrders as $order) {
                                        echo "<li class='latest-li border rounded-sm p-2 shadow-sm'>";
                                        echo "<h5>[".$order['date_commande']."] - Commande \"".$order['etat_commande']."\"</h5>";
                                        echo "<ul style='list-style-type : disc !important'>";
                                        $items = getArticlesLastOrdersById($order['id_commande']);
                                        $prix_total = 0;
                                        foreach($items as $item) {
                                            $prix_total += $item['prix_article']*$item['quantite_article_commande'];
                                            echo "<li><a href='".getUrlArticle($item['id_article'])."'>".getNomArticle($item['id_article'])."</a>";
                                            echo " [Qte: ". $item['quantite_article_commande'] ."]</li>";
                                        }
                                        echo "</ul>";
                                        echo "<div class=\"text-right\">
                                                <span class=\"btn btn-sm btn-info mb-2 btn-order-dettails toggle-info\" data-class=\"order-dettails\">
                                                    Dettails <i class='fa fa-angle-down'></i>
                                                </span>
                                            </div>";
                                        $adresse_livraison = !empty($userInformation['adresse_livraison'])? $userInformation['adresse_livraison'] : $userInformation['adresse_client'];
                                        $mode_payment = getModePayment($order['id_commande']);
                                        $frais_livraison = fraisLivraison($order['id_commande']);
                                        $prix_total_facture = (int) $prix_total+$frais_livraison;
                                        echo  "<div class=\"row card m-2 shadow rofile-card order-dettails\" style=\"display: none\">                                                    
                                                    <div class=\"card-header profile-card-header\">
                                                        Dettails de la commande
                                                    </div>
                                                    <div class=\"card-body\">
                                                        <div class='row'>
                                                            <div class='col-md-6'><h5>Adresse de livraison</h5>".
                                            $userInformation['nom_client'] ." ". $userInformation['prenom_client'] ."<br>".
                                            $adresse_livraison ."<br>Algérie<br>".
                                            $userInformation['numero_tel_client']
                                            ."</div>
                                                            <div class='col-md-6'><h5>Adresse de facturation</h5>".
                                            $userInformation['nom_client'] ." ". $userInformation['prenom_client'] ."<br>".
                                            $userInformation['adresse_client'] ."<br>Algérie<br>".
                                            $userInformation['numero_tel_client']
                                            ."</div>
                                                        </div><hr>
                                                        <div><h6>Date de la commande : ".$order['date_commande']."</h6></div>
                                                        <div class='table-responsive mt-2'>
                                                            <table class='table table-bordered table-hover'>
                                                                <tr class='bg-bill'>
                                                                    <td>Produit</td>
                                                                    <td>Prix U</td>
                                                                    <td>Qte</td>
                                                                    <td>Total</td>
                                                                </tr>";
                                        foreach($items as $item) {
                                            echo "<tr><td>".$item['nom_article']."</td><td>".
                                                $item['prix_article']." DZD</td><td>".
                                                $item['quantite_article_commande'].
                                                "</td><td>".$item['prix_article']*$item['quantite_article_commande']." DZD</td></tr>";
                                        }
                                        echo "</table>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-md-6'>
                                                                <div class='table-responsive'>
                                                                    <table class='table-bordered'>
                                                                        <tr>
                                                                            <td class='bg-bill'>Mode de paiement</td>
                                                                            <td class='text-center'>".$mode_payment."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Societé de livraison</td>
                                                                            <td class='text-center'> / </td>
                                                                        </tr>                                                                        
                                                                    </table>
                                                                </div>
                                                            </div>                                                            
                                                            <div class='col-md-6'>
                                                                <div class='table-responsive'>
                                                                    <table class='table-bordered border-dark'>
                                                                        <tr>
                                                                            <td class='bg-bill'>Total produits</td>
                                                                            <td class='text-center'>".$prix_total." DZD</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Frais de livraison</td>
                                                                            <td class='text-center'>".$frais_livraison." DZD</td>
                                                                        </tr>     
                                                                        <tr>
                                                                            <td class='bg-bill'>Total (HT)</td>
                                                                            <td class='text-center'>".$prix_total." DZD</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Total</td>
                                                                            <td class='text-center'>".$prix_total_facture." DZD</td>
                                                                        </tr>                                                                        
                                                                    </table>
                                                                </div>     
                                                            </div>
                                                        </div>                                                        
                                                    </div>                                                                       
                                                    <div class='card-footer text-right'>
                                                        <button class='btn btn-primary btn-sm btn-print'>Imprimer</button>
                                                    </div>   
                                                </div>";
                                        echo "</li><hr>";
                                    }
                                } else echo "Aucune commande pour le moment.";
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row card mb-4 profile-card last-comments" <?php if(!empty($displayForm)) echo 'style="display: none"' ?>>
                        <div class="card-header profile-card-header">
                            Mes derniers commentaires
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled latest">
                                <?php
                                $lastComments =  getLastCommentsByUsername($userInformation['userlogin_client'], 3);
                                if(!empty($lastComments)) {
                                    echo '<hr>';
                                    foreach($lastComments as $comment) {
                                        echo "<li class='latest-li border rounded-sm p-3 bg-light shadow-sm'>";
                                            echo "<h5>[".$comment['date_ajout_commentaire']."] - <a href='".getUrlArticle($comment['id_article'])."'>".getNomArticle($comment['id_article'])."</a></h5>";
                                            echo "<p class='bg-white p-2 border rounded-sm shadow' style='background-color: #f6f7f9 !important;'>".$comment['contenue_commentaire']."</p>";
                                            if(!empty($comment['reponse_admin'])) {
                                                echo '<i class="fa fa-reply px-2"></i>[Réponse de l\'équipe HWShop] - ['.$comment['date_reponse_admin'].']';
                                                echo "<p class='bg-white mx-3 p-2 border rounded-sm shadow' style='background-color: #f6f7f9 !important;'>".$comment['reponse_admin']."</p>";
                                            }
                                        echo "</li><hr>";
                                    }
                                } else echo "Aucun commentaire pour le moment.";
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row card mb-4 profile-card infos" <?php if(empty($displayForm)) echo 'style="display: none"' ?>>
                        <div class="card-header profile-card-header">
                            Mes informations
                        </div>
                        <div class="card-body">
                            <button class="btn btn-outline-info fa fa-edit p-1 float-right profile-edit-btn"></button>
                            <form class="sign" action="" method="POST">
                                <h3 class="text-center mt-3">Mes identifiants :</h3>
                                <div class="form-group ">
                                    <label>Email: </label>
                                    <?php if( !empty( $emailError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$emailError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $emailError ) ) echo 'border-danger' ?>" name="email" placeholder="Email" type="email"
                                        <?php if(isset($email)) echo 'value="'.$email.'"'; ?> <?= $disabled ?> required="required"/>
                                </div>
                                <div class="form-group ">
                                    <label>Nom d'utilisateur: </label>
                                    <?php if( !empty( $usernameError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$usernameError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $usernameError ) ) echo 'border-danger' ?>" name="username" placeholder="Nom d'utilisateur pour se connecter" type="text"
                                        <?php if(isset($oldUsername)) echo 'value="'.$oldUsername.'"'; ?> <?= $disabled ?> required="required"/>
                                </div>
                                <div class="form-group mini">
                                    <span></span>
                                </div>
                                <div class="identification-sep"></div>
                                <h3 class="text-center">Mes informations personnelles :</h3>

                                <div class="form-group mini">
                                    <label>Prénom: </label>
                                    <?php if( !empty( $prenomError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$prenomError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $prenomError ) ) echo 'border-danger' ?>" name="prenom" placeholder="Prénom" type="text"
                                        <?php if(isset($prenom)) echo 'value="'.$prenom.'"'; ?> <?= $disabled ?> required="required" />
                                </div>
                                <div class="form-group mini">
                                    <label>Nom: </label>
                                    <?php if( !empty( $nomError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$nomError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $nomError ) ) echo 'border-danger' ?>" name="nom" placeholder="Nom" type="text"
                                        <?php if(isset($nom)) echo 'value="'.$nom.'"'; ?> <?= $disabled ?> required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Adresse:</label>
                                    <input type="text" class="form-control" name="adresse" placeholder="Adresse"
                                        <?php if(isset($adresse)) echo 'value="'.$adresse.'"'; ?> <?= $disabled ?> required="required">
                                </div>
                                <div class="form-group mini select-group ville">
                                    <span></span>
                                    <label>Ville: </label>
                                    <select class="form-control" name="ville" <?= $disabled ?>>
                                        <option></option>
                                        <optgroup label="Algérie">
                                            <option value="Adrar" >Adrar</option>
                                            <option value="Adrar" >Adrar</option>
                                            <option value="Laghouat" >Laghouat</option>
                                            <option value="Oum el Bouaghi" >Oum el Bouaghi</option>
                                            <option value="Batna" >Batna</option>
                                            <option value="Béjaia" >Béjaia</option>
                                            <option value="Biskra" >Biskra</option>
                                            <option value="Bechar" >Bechar</option>
                                            <option value="Blida" >Blida</option>
                                            <option value="Bouira">Bouira</option>
                                            <option value="Tamanghasset">Tamanghasset</option>
                                            <option value="Tébessa">Tébessa</option>
                                            <option value="Tlemcen">Tlemcen</option>
                                            <option value="Tiaret">Tiaret</option>
                                            <option value="Tizi Ouzou">Tizi Ouzou</option>
                                            <option value="Alger">Alger</option>
                                            <option value="Djelfa">Djelfa</option>
                                            <option value="Jijel">Jijel</option>
                                            <option value="Setif">Setif</option>
                                            <option value="Saida">Saida</option>
                                            <option value="Skikda">Skikda</option>
                                            <option value="Sidi Bel Abbes">Sidi Bel Abbes</option>
                                            <option value="Annaba">Annaba</option>
                                            <option value="Guelma">Guelma</option>
                                            <option value="Constantine">Constantine</option>
                                            <option value="Médéa">Médéa</option>
                                            <option value="Mostaganem">Mostaganem</option>
                                            <option value="Msila">Msila</option>
                                            <option value="Mascara">Mascara</option>
                                            <option value="Ouargla">Ouargla</option>
                                            <option value="Oran">Oran</option>
                                            <option value="El Bayadh">El Bayadh</option>
                                            <option value="Illizi">Illizi</option>
                                            <option value="Bordj Bou Arreridj">Bordj Bou Arreridj</option>
                                            <option value="Boumerdès">Boumerdès</option>
                                            <option value="El Tarf">El Tarf</option>
                                            <option value="Tindouf">Tindouf</option>
                                            <option value="Tissemsilt">Tissemsilt</option>
                                            <option value="El Oued">El Oued</option>
                                            <option value="Khenchela">Khenchela</option>
                                            <option value="Souk Ahras">Souk Ahras</option>
                                            <option value="Tipaza">Tipaza</option>
                                            <option value="Mila">Mila</option>
                                            <option value="Ain Defla">Ain Defla</option>
                                            <option value="Naama">Naama</option>
                                            <option value="Ain Temouchent">Ain Temouchent</option>
                                            <option value="Ghardaia">Ghardaia</option>
                                            <option value="Relizane">Relizane</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="form-group mini">
                                    <label>Téléphone: </label>
                                    <?php if( !empty( $telephoneError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$telephoneError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $telephoneError ) ) echo 'border-danger' ?>" name="phone" placeholder="Téléphone" type="tel"
                                        <?php if(isset($telephone)) echo 'value="'.$telephone.'"'; ?> <?= $disabled ?> required="required"/>
                                </div>
                                <div class="form-group datepicker">
                                    <div class="input-group date" >
                                        <table>
                                            <tr>
                                                <td>
                                                    <label>Date de naissance : </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="ph form-control date-control" name="dateNaissance"
                                                           placeholder="Date de naissance" type="date" <?= $disabled ?> <?php if(isset($dateN)) echo 'value="'.$dateN.'"'; ?>"/>
                                                </td>
                                            </tr>
                                        </table>
                                        <span class="input-group-addon">
                                            <span class="icon icon-agenda-bold"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group mini genders">
                                    <div class="radio">
                                        <input checked="" name="genre" type="radio" value="1" <?= $disabled ?> />
                                        <label for="Mister">Homme</label>
                                    </div>
                                    <div class="radio">
                                        <input id="Madam" name="genre" type="radio" value="3" <?= $disabled ?> />
                                        <label for="Madam">Femme</label>
                                    </div>
                                </div>
                                <h4 class="text-center password-edit" style="display: none">Voulez-vous changer votre mot de passe?</h4>
                                <h6 class="text-center password-edit" style="display: none">(Laissez vide sinon)</h6>
                                <div class="form-group mini password-edit old-pass" <?php if(empty($displayForm)) echo 'style="display: none"' ?>>
                                    <?php if( !empty( $passError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$passError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $passError ) ) echo 'border-danger' ?>"
                                           name="oldPasss" placeholder="Mot de passe actuel" type="password" <?= $disabled ?>/>
                                </div>
                                <div class="form-group mini password-edit nv-pass" <?php if(empty($displayForm)) echo 'style="display: none"' ?>>
                                    <?php if( !empty( $nvPassError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$nvPassError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $nvPassError ) || !empty( $confirmNvPassError )) echo 'border-danger' ?>"
                                           name="nvPasss" placeholder="Nouveau mot de passe" type="password" <?= $disabled ?>/>
                                </div>
                                <div class="form-group mini password-edit confirm-nv-pass" <?php if(empty($displayForm)) echo 'style="display: none"' ?>>
                                    <?php if( !empty( $confirmNvPassError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$confirmNvPassError.'</span>'; ?>
                                    <input class="form-control <?php if( !empty( $confirmNvPassError ) ) echo 'border-danger' ?>"
                                           name="confirmNvPasss" placeholder="Nouveau mot de passe" type="password" <?= $disabled ?>/>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block profile-form-btn-submit" value="sign" <?= $disabled ?> >Valider</button>
                            </form>
                        </div>
                    </div>

                    <div class="row card mb-4 profile-card orders" style="display: none">
                        <div class="card-header profile-card-header">
                            Mes commandes
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled latest">
                                <?php
                                $lastOrders =  getLastOrdersById($userInformation['id_client'], 3);
                                if(!empty($lastOrders)) {
                                    echo '<hr>';
                                    foreach($lastOrders as $order) {
                                        echo "<li class='latest-li border rounded-sm p-2 shadow-sm'>";
                                        echo "<h5>[".$order['date_commande']."] - Commande \"".$order['etat_commande']."\"</h5>";
                                        echo "<ul style='list-style-type : disc !important'>";
                                        $items = getArticlesLastOrdersById($order['id_commande']);
                                        $prix_total = 0;
                                        foreach($items as $item) {
                                            $prix_total += $item['prix_article']*$item['quantite_article_commande'];
                                            echo "<li><a href='".getUrlArticle($item['id_article'])."'>".getNomArticle($item['id_article'])."</a>";
                                            echo " [Qte: ". $item['quantite_article_commande'] ."]</li>";
                                        }
                                        echo "</ul>";
                                        echo "<div class=\"text-right\">
                                                <span class=\"btn btn-sm btn-info mb-2 btn-order-dettails toggle-info\" data-class=\"order-dettails\">
                                                    Dettails <i class='fa fa-angle-down'></i>
                                                </span>
                                            </div>";
                                        $adresse_livraison = !empty($userInformation['adresse_livraison'])? $userInformation['adresse_livraison'] : $userInformation['adresse_client'];
                                        $mode_payment = getModePayment($order['id_commande']);
                                        $frais_livraison = fraisLivraison($order['id_commande']);
                                        $prix_total_facture = (int) $prix_total+$frais_livraison;
                                        echo  "<div class=\"row card m-2 shadow rofile-card order-dettails\" style=\"display: none\">                                                    
                                                    <div class=\"card-header profile-card-header\">
                                                        Dettails de la commande
                                                    </div>
                                                    <div class=\"card-body\">
                                                        <div class='row'>
                                                            <div class='col-md-6'><h5>Adresse de livraison</h5>".
                                            $userInformation['nom_client'] ." ". $userInformation['prenom_client'] ."<br>".
                                            $adresse_livraison ."<br>Algérie<br>".
                                            $userInformation['numero_tel_client']
                                            ."</div>
                                                            <div class='col-md-6'><h5>Adresse de facturation</h5>".
                                            $userInformation['nom_client'] ." ". $userInformation['prenom_client'] ."<br>".
                                            $userInformation['adresse_client'] ."<br>Algérie<br>".
                                            $userInformation['numero_tel_client']
                                            ."</div>
                                                        </div><hr>
                                                        <div><h6>Date de la commande : ".$order['date_commande']."</h6></div>
                                                        <div class='table-responsive mt-2'>
                                                            <table class='table table-bordered table-hover'>
                                                                <tr class='bg-bill'>
                                                                    <td>Produit</td>
                                                                    <td>Prix U</td>
                                                                    <td>Qte</td>
                                                                    <td>Total</td>
                                                                </tr>";
                                        foreach($items as $item) {
                                            echo "<tr><td>".$item['nom_article']."</td><td>".
                                                $item['prix_article']." DZD</td><td>".
                                                $item['quantite_article_commande'].
                                                "</td><td>".$item['prix_article']*$item['quantite_article_commande']." DZD</td></tr>";
                                        }
                                        echo "</table>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-md-6'>
                                                                <div class='table-responsive'>
                                                                    <table class='table-bordered'>
                                                                        <tr>
                                                                            <td class='bg-bill'>Mode de paiement</td>
                                                                            <td class='text-center'>".$mode_payment."</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Societé de livraison</td>
                                                                            <td class='text-center'> / </td>
                                                                        </tr>                                                                        
                                                                    </table>
                                                                </div>
                                                            </div>                                                            
                                                            <div class='col-md-6'>
                                                                <div class='table-responsive'>
                                                                    <table class='table-bordered border-dark'>
                                                                        <tr>
                                                                            <td class='bg-bill'>Total produits</td>
                                                                            <td class='text-center'>".$prix_total." DZD</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Frais de livraison</td>
                                                                            <td class='text-center'>".$frais_livraison." DZD</td>
                                                                        </tr>     
                                                                        <tr>
                                                                            <td class='bg-bill'>Total (HT)</td>
                                                                            <td class='text-center'>".$prix_total." DZD</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='bg-bill'>Total</td>
                                                                            <td class='text-center'>".$prix_total_facture." DZD</td>
                                                                        </tr>                                                                        
                                                                    </table>
                                                                </div>     
                                                            </div>
                                                        </div>                                                        
                                                    </div>                                                        
                                                    <div class='card-footer text-right'>
                                                        <button class='btn btn-primary btn-sm btn-print'>Imprimer</button>
                                                    </div>   
                                                </div>";
                                        echo "</li><hr>";
                                    }
                                } else echo "Aucune commande pour le moment.";
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row card mb-4 profile-card history" style="display: none">
                        <div class="card-header profile-card-header">
                            Mon historique d'achat
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled latest">
                                <?php
                                    $achats =  getHistoAchatById($userInformation['id_client']);
                                    if(!empty($achats)) {
                                        echo '<hr>';
                                        foreach($achats as $achat) {
                                            echo "<li class='latest-li border rounded-sm p-3 bg-light shadow-sm'>";
                                            echo "<h4>[".$achat['date_commande']."] - Commande \"".$achat['etat_commande']."\"</h4>";
                                            echo "<ul style='list-style-type : disc !important'>";
                                            $items = getArticlesLastOrdersById($achat['id_commande']);
                                            foreach($items as $item) {
                                                echo "<li>". $item['nom_article'];
                                                echo " [Qte: ". $item['quantite_article_commande'] ."]</li>";
                                            }
                                            echo "</ul>";
                                            echo "</li><hr>";
                                        }
                                    } else echo "<p>Aucun produit acheté pour le moment.</p>";
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="row card mb-4 profile-card livraison" style="display: none">
                        <div class="card-header profile-card-header">
                            Mon adresse de livraison
                        </div>
                        <div class="card-body">
                            <div class='livraison-body border rounded-sm shadow-sm p-2'>
                            <?php if(!empty($adresseLivraison)) { ?>
                                    <h4><?= '['.$adresseLivraison.']' ?></h4>
                                    <button class='btn-livraison btn btn-sm btn-info p-1 mt-3 fa fa-edit float-right'></button>
                            <?php } else { ?>
                                    <p>Vous n'avez pas encore remplir votre adresse de livraison</p>
                                    <button class='btn-livraison btn btn-sm btn-info p-1 mt-3 fa fa-edit float-right'></button>
                            <?php } ?>
                            </div>
                            <form class="form-livraison" action="" method="POST" style="display: none">
                                <div class="form-group">
                                    <label for="inputAddress">Adresse:</label>
                                    <input type="text" class="form-control" name="adresseLivraison" placeholder="Adresse de livraison"
                                        <?php if(isset($adresseLivraison)) echo 'value="'.$adresseLivraison.'"'; ?>/>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block btn-submit-livraison col-2 mx-auto my-2">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
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
    <script src="/public/js/printThis.js"></script>
    <script src="/public/js/notie.js"></script>
    <script src="/public/includes/alert-info.js"></script>
    <!-- ajouter panier-->
    <script src="/public/includes/panier.js"></script>
    <!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css">
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>

    <script src="/public/js/profile.js"></script>
</body>
</html>