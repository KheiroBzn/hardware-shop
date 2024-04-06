<?php if(!isset($_SESSION)){
    session_start();
}

	include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';
	$categorie=getAssocCategorie();
	$sousCategorie=getAssocSousCategorie();
	
	include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/categorieModel.php";
	$LIMIT_ARTICLE_MOST_VIEW=10;

	$current_categorie=getNomCurrentCategorie($_GET['id_categorie']);

	
	if($current_categorie){
		$bdd_nom_categorie=getNomCategoriebyID($_GET['id_categorie']) ;
		if($_GET['url_categorie']!=str_replace(' ', '-',$bdd_nom_categorie['nom_categorie'])  ){
			header("Location: /" . $_GET['id_categorie'] ."-" . str_replace(' ', '-',$bdd_nom_categorie['nom_categorie']) );
		}	
		else{
			$resulta_sous_categorie=getSousCategorie();

			$article_most_view=getArticleMostViewCastegorie($_GET['id_categorie'],$LIMIT_ARTICLE_MOST_VIEW);
			//$url_sous_categorie=getUrlSousCategorie();
			include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Vue/categorieVue.php";
		}
	}
	else
		header("Location: /accueil");



