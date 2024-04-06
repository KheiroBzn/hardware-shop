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
	<title>Inscription</title>
	<link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
	<link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/public/css/navigationbar.css">
    <!-- pour accelerer le chargement utilise la version min -->
    <link rel="stylesheet" href="/public/css/footerbar.css">
    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css">
    <!-- modal -->
	<link rel="stylesheet" href="/public/css/navigationbar.css"><!-- pour accelerer le chargement utilise la version min -->
	<link rel="stylesheet" href="/public/css/footerbar.css">
	<link rel="stylesheet" href="../public/css/identification.css">

</head>

<body>
	<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>
    <div class="container-fluid identification-fluid py-3">
        <div class="row container main-identification mx-auto w-75 border rounded-sm">
            <div class="col-md-6 m-auto">
                <img class="mw-100" src="public/images/identification/signup.png" alt="">
            </div>
            <div class="col-md-6 mx-auto border rounded-sm shadow m-3">
                <form class="sign" action="" method="POST">
                    <h3 class="text-center mt-3">Vos identifiants :</h3>
                    <div class="form-group ">
                        <?php if( !empty( $emailError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$emailError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $emailError ) ) echo 'border-danger' ?>" name="email" placeholder="Email" type="email"
                            <?php if(isset($email)) echo 'value="'.$email.'"'; ?> required="required"/>
                    </div>
                    <div class="form-group mini">
                        <?php if( !empty( $passError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$passError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $passError ) ) echo 'border-danger' ?>" name="pass" placeholder="Mot de passe" type="password" required="required"/>
                    </div>
                    <div class="form-group ">
                        <?php if( !empty( $usernameError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$usernameError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $usernameError ) ) echo 'border-danger' ?>" name="username" placeholder="Nom d'utilisateur pour se connecter" type="text"
                            <?php if(isset($username)) echo 'value="'.$username.'"'; ?> required="required"/>
                    </div>
                    <div class="form-group mini">
                        <span></span>
                    </div>
                    <div class="identification-sep"></div>
                    <h3 class="text-center">Vos informations personnelles :</h3>

                    <div class="form-group mini">
                        <?php if( !empty( $prenomError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$prenomError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $prenomError ) ) echo 'border-danger' ?>" name="prenom" placeholder="Prénom" type="text"
                            <?php if(isset($prenom)) echo 'value="'.$prenom.'"'; ?> required="required" />
                    </div>
                    <div class="form-group mini">
                        <?php if( !empty( $nomError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$nomError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $nomError ) ) echo 'border-danger' ?>" name="nom" placeholder="Nom" type="text"
                            <?php if(isset($nom)) echo 'value="'.$nom.'"'; ?> required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="inputAddress"></label>
                        <input type="text" class="form-control" name="adresse" placeholder="Adresse"
                            <?php if(isset($adresse)) echo 'value="'.$adresse.'"'; ?> required="required">
                    </div>
                    <div class="form-group mini select-group">
                        <span></span>
                        <select class="form-control" name="ville" <?php if(isset($ville)) echo 'value="'.$ville.'"'; ?> required="required">
                            <option></option>
                            <optgroup label="Algérie">
                                <option value="1000">Adrar</option>
                                <option value="2000">Chlef</option>
                                <option value="3000">Laghouat</option>
                                <option value="4000">Oum el Bouaghi</option>
                                <option value="5000">Batna</option>
                                <option value="6000">Béjaia</option>
                                <option value="7000">Biskra</option>
                                <option value="8000">Bechar</option>
                                <option value="9000">Blida</option>
                                <option value="10000">Bouira</option>
                                <option value="11000">Tamanghasset</option>
                                <option value="12000">Tébessa</option>
                                <option selected value="13000">Tlemcen</option>
                                <option value="14000">Tiaret</option>
                                <option value="15000">Tizi-Ouzou</option>
                                <option value="16000">Alger</option>
                                <option value="17000">Djelfa</option>
                                <option value="18000">Jijel</option>
                                <option value="19000">Setif</option>
                                <option value="20000">Saida</option>
                                <option value="21000">Skikda</option>
                                <option value="22000">Sidi Bel Abbes</option>
                                <option value="23000">Annaba</option>
                                <option value="24000">Guelma</option>
                                <option value="25000">Constantine</option>
                                <option value="26000">Médéa</option>
                                <option value="27000">Mostaganem</option>
                                <option value="28000">Msila</option>
                                <option value="29000">Mascara</option>
                                <option value="30000">Ouargla</option>
                                <option value="31000">Oran</option>
                                <option value="32000">El Bayadh</option>
                                <option value="33000">Illizi</option>
                                <option value="34000">Bordj-Bou-Arreridj</option>
                                <option value="35000">Boumerdès</option>
                                <option value="36000">El Tarf</option>
                                <option value="37000">Tindouf</option>
                                <option value="38000">Tissemsilt</option>
                                <option value="39000">El Oued</option>
                                <option value="40000">Khenchela</option>
                                <option value="41000">Souk-Ahras</option>
                                <option value="42000">Tipaza</option>
                                <option value="43000">Mila</option>
                                <option value="44000">Ain Defla</option>
                                <option value="45000">Naama</option>
                                <option value="46000">Ain Temouchent</option>
                                <option value="47000">Ghardaia</option>
                                <option value="48000">Relizane</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group mini">
                        <?php if( !empty( $telephoneError ) ) echo '<span class="text-danger fa fa-exclamation-triangle"> '.$telephoneError.'</span>'; ?>
                        <input class="form-control <?php if( !empty( $telephoneError ) ) echo 'border-danger' ?>" name="phone" placeholder="Téléphone" type="tel"
                            <?php if(isset($telephone)) echo 'value="'.$telephone.'"'; ?> required="required"/>
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
                                               placeholder="Date de naissance" type="date" <?php if(isset($dateN)) echo 'value="'.$dateN.'"'; ?>"/>
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
                            <input checked="" name="genre" type="radio" value="1" />
                            <label for="Mister">Homme</label>
                        </div>
                        <div class="radio">
                            <input id="Madam" name="genre" type="radio" value="3" />
                            <label for="Madam">Femme</label>
                        </div>
                    </div>
                    <div class="form-group mini newsletter">
                        <div class="checkbox">
                            <table>
                                <tr>
                                    <td style="width:5%" >
                                        <input name="accept" value="true" type="checkbox"/>
                                    </td>
                                    <td>
                                        <label>J&#39;accepte de recevoir des informations et des
                                            offres
                                            promotionnelles exclusives de la part de HWShop.
                                        </label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" value="sign">Valider</button>
                </form>

                <div class="text-center sfooter">
				<span>
					HWShop s&#39;engage &#224; garder ces informations strictement
					confidentielles.
				</span>
                </div>
            </div>

        </div>
    </div>

	<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>

	<script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>
    <script src="/public/js/identification.js"></script>

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