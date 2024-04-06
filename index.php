<?php
    ob_start();

	if(isset($_SESSION['userlogin_client'])) {
        redirect_Accueil();
	} else {
		session_start();
	}
	
	include_once $_SERVER['DOCUMENT_ROOT'] . "/Controleur/Controleur.php";
	
	function redirect_Erreur(){
		erreur();
	}

	function redirect_Dashboard() {
        header("location: http://admin");
    }

	function redirect_Accueil(){
		if($_SERVER['REQUEST_URI']!="/Accueil")
			header("location: /Accueil");
		else
			accueil();
	}

	function redirect_Deconnexion(){
		include_once $_SERVER['DOCUMENT_ROOT'] . "/public/includes/logout.php" ;
		header("location: /Accueil");
	}

	function redirect_Connexion(){
		if($_SERVER['REQUEST_URI']!="/Connexion")
			header("location: /Connexion");
		else
			connexion();
	}

	function redirect_Profile(){
		if($_SERVER['REQUEST_URI']!="/Profile")
			header("location: /Profile");
		else
			profile();
	}

    function redirect_Payment(){
        if($_SERVER['REQUEST_URI']!="/Payment")
            header("location: /Payment");
        else
            payment();
    }

	function redirect_Inscription(){
		if($_SERVER['REQUEST_URI']!="/Inscription")
			header("location: /Inscription");
		else
			inscription();
	}				

	function redirect_Categorie(){
		if( isset($_GET['id_categorie']) ){
			if($_SERVER['REQUEST_URI']!="/$_GET[id_categorie]-$_GET[url_categorie]")
				header("location: /$_GET[id_categorie]-$_GET[url_categorie]");
			else
				categorie();
		}
		else
			redirect_Erreur();
	}

	function redirect_SousCategorie(){

		if( !empty($_GET['id_categorie']) and !empty( $_GET['id_sous_categorie'] ) ){
			if($_SERVER['REQUEST_URI']!="/$_GET[id_categorie]-$_GET[url_categorie]/$_GET[id_sous_categorie]-$_GET[url_sous_categorie]/page$_GET[page]"){
				if(isset($_GET['page']) and !empty($_GET['page']) ){
					header("location: /$_GET[id_categorie]-$_GET[url_categorie]/$_GET[id_sous_categorie]-$_GET[url_sous_categorie]/page$_GET[page]");
				}
				else{
					header("location: /$_GET[id_categorie]-$_GET[url_categorie]/$_GET[id_sous_categorie]-$_GET[url_sous_categorie]/page1");
				}
			}
			else
				sousCategorie();
		}
		else
			if(!empty($_GET['id_categorie']))
				header("location: /$_GET[id_categorie]-$_GET[url_categorie]");
	}

	function redirect_Article(){
		if($_SERVER['REQUEST_URI']!="/Article/$_GET[id_article]-$_GET[url_article]")
			header("location: /Article/$_GET[id_article]-$_GET[url_article]");
		else
			article();
	}

	function redirect_Panier(){
		if($_SERVER['REQUEST_URI']!="/Panier")
			header("location: /Panier");
		else
			panier();
	}

	function redirect_Recherche(){
		$q = urlencode($_GET['q']);
		if($_SERVER['REQUEST_URI']!="/Recherche/$q")
			header("location: /Recherche/$q");
		else
			recherche();
	}

	function redirect_FAQ(){
		if($_SERVER['REQUEST_URI']!="/FAQ")
			header("location: /FAQ");
		else
			faq();
	}

	if(!empty($_GET)){
		if(isset($_GET['action'])){

			if($_GET['action']!='sousCategorie' && $_GET['action']!='panier' )
				unsetSessionSousCategorie();

			switch ($_GET['action']) {

				case 'accueil':
					redirect_Accueil();
				break;

				case 'recherche':
					redirect_Recherche();
				break;

				case 'deconnexion':
					redirect_Deconnexion();
				break;

				case 'categorie':
					redirect_Categorie();
				break;

				case 'sousCategorie':
					redirect_SousCategorie();
				break;

				case 'connexion':
					redirect_Connexion();
				break;

				case 'profile':
					redirect_Profile();
				break;

                case 'payment':
                    redirect_Payment();
                break;

				case 'inscription':
					redirect_Inscription();
				break;

				case 'article':
					redirect_Article();
				break;

				case 'erreur':
					redirect_Erreur();
				break;

				case 'panier';
					redirect_Panier();
				break;
				
				case 'faq':
					redirect_FAQ();
				break;

                case 'dashboard':
                    redirect_Dashboard();
                break;

				default:
					//redirect_Accueil() ;
				break;
			}
		}
		else 
			redirect_Accueil() ;
	}
	else
		redirect_Accueil();

    ob_end_flush();
	