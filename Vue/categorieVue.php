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
	<title ><?php echo htmlspecialchars(ucfirst($current_categorie['nom_categorie']) ); ?></title>
	<link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
	<link rel="stylesheet" href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="/public/css/magnific-popup.css" />
	<link rel="stylesheet" href="/public/css/owl.carousel.min.css" />
	<link rel="stylesheet" href="/public/css/owl.theme.default.min.css" />

	<link rel="stylesheet" href="/public/css/navigationbar.css"><!-- pour accelerer le chargement utilise la version min -->
	<link rel="stylesheet" href="/public/css/footerbar.css">

	<link rel="stylesheet" href="/public/css/categorie.css">	
    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css">
	
</head>

<body >
	<?php include $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php" ; ?>
	
	<main class="col-lg-9 p-4 m-auto grid-categorie border rounded-sm shadow-sm" style="margin-bottom : 50px !important; ">
		
		<div class="row justify-content-center">
			<h2 class="font-weight-bold m-4 text-uppercase title-grid">
				<?php echo htmlspecialchars($current_categorie['nom_categorie']);  ?> :
			</h2>
		</div>		
		<div class="row" style="justify-content: center;">			
			<?php while($element = $resulta_sous_categorie->fetch(PDO::FETCH_ASSOC) ){ ?>
			<div class="col-lg-4 col-md-6 col-xs-6 px-4 col-range">
				<figure class="card card-product-grid shadow">
					<a class="toggle-list" href="<?php echo $url_sous_categorie[$element['nom_sous_categorie']] ?>">
						<div class="pic float-left m-2">
							<img 
								class="img-pic" 
								src="/public/images/sous categorie/<?php echo $element['image_sous_categorie'];?>" 
								alt="Sous Categorie <?php echo $element['nom_sous_categorie'];  ?>"
							>
						</div>
						<h5 class="font-weight-bold m-4 text-capitalize text-center text-grid">
							<?php echo htmlspecialchars($element['nom_sous_categorie']);  ?>
						</h5>
						<span class="icon icon-arrow-bottom-bold"></span>                    
					</a>
				</figure>
			</div>
			<?php } ?>			
		</div>	
	</main>

	<main class="col-lg-10 p-1 m-auto grid-categorie border rounded-sm shadow-sm">
		<div class="row justify-content-center">
			<h2 class="font-weight-bold m-4 text-uppercase title-grid">Les Plus Vues :</h2>
		</div>		
		<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/owl-carousel.php" ; ?>		
	</main>	
	
	<?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php" ; ?>

	<script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
	<script src="/public/js/tether.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
	
	<script src="/public/js/jquery.magnific-popup.min.js"></script>
    <script src="/public/js/owl.carousel.min.js"></script>
    <script src="/public/js/script.js"></script>

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

</body>
</html>