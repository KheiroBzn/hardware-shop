<?php if(!isset($_SESSION)){
    session_start();
}
	include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';
	include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/souscategorieModel.php";


	$DEFAULT_NUMBER_PER_PAGE=9;
	$request='';

	if ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {
		// on effectue un traitement spécifique pour une requete AJAX
		$request='AJAX';
		$price= array();
		$more_filter= array();
		include_once  $_SERVER['DOCUMENT_ROOT'] . './Controleur/souscategorieAjax.php';
	}
	else {
		$request='HTTP';
		$price= array();
		$more_filter= array();
		// on effectue un traitement spécifique au chargement classique de la page requete http	
		if(isset($_SESSION['id_sous_categorie']) and isset($_GET['id_sous_categorie']) ){
			if( $_GET['id_sous_categorie']!=$_SESSION['id_sous_categorie'] ){
				unsetSessionSousCategorie();
			}	
		}

		if(isset($_GET['id_sous_categorie'])) $_SESSION['id_sous_categorie'] = $_GET['id_sous_categorie'];
	
		if(isset($_GET['id_categorie'])) $_SESSION['id_categorie'] = $_GET['id_categorie'];
	
		if(isset($_GET['page'])) $_SESSION['page'] = $_GET['page'];

		if(isset($_SERVER['REQUEST_URI'])) $_SESSION['url'] = $_SERVER['REQUEST_URI'];

		$current_sous_categorie=getNomCategorieSousCategorie($_GET['id_categorie'],$_GET['id_sous_categorie']);

		if($_GET['url_categorie']==str_replace(' ', '-',$current_sous_categorie['nom_categorie']) and
			$_GET['url_sous_categorie']==str_replace(' ', '-',$current_sous_categorie['nom_sous_categorie'])){
	
			$all_sous_categorie= getAllSousCategorieforCategorie($_GET['id_categorie']);
			$filter_xml=getFiltreXmlSousCategorie($_GET['id_sous_categorie']);
			$marque_sous_categorie=getMarqueSousCategorie($_GET['id_sous_categorie']);

			
			include_once  $_SERVER['DOCUMENT_ROOT'] . './Controleur/souscategorieCommonVar.php';


			include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Vue/souscategorieVue.php";

		}
		else{
			if($_GET['url_categorie']!=str_replace(' ', '-',$current_sous_categorie['nom_categorie'])  ){
				header("Location: /" . $_GET['id_categorie'] ."-" . str_replace(' ', '-',$current_sous_categorie['nom_categorie']) .
				"/" . $_GET['id_sous_categorie'] . "-" . $_GET['url_sous_categorie'] ."/" );
			}
			else if($_GET['url_sous_categorie']!=str_replace(' ', '-',$current_sous_categorie['nom_sous_categorie'])  ){
				header("Location: /" . $_GET['id_categorie'] ."-" . $_GET['url_categorie'] . "/" . $_GET['id_sous_categorie'] .
				"-" .  str_replace(' ', '-',$current_sous_categorie['nom_sous_categorie'] ) ."/"  );
			}
		}
}