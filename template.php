<?php

	function bddConnection(){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=hwshop;charset=utf8', 'root', '');
			return $bdd;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}
	
	function phpAlert($msg) {
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}

	function unsetSessionSousCategorie(){

		if(isset($_SESSION['id_categorie']))
			unset($_SESSION['id_categorie']);

		if(isset($_SESSION['id_sous_categorie']))
			unset($_SESSION['id_sous_categorie']);

		if(isset($_SESSION['json-filter']))
			unset($_SESSION['json-filter']);

		if(isset($_SESSION['id_article_filter']))
			unset($_SESSION['id_article_filter']);

		if(isset($_SESSION['page']) )
			unset($_SESSION['page']);

		if(isset($_SESSION['number-per-page']))
			unset($_SESSION['number-per-page']);

		if(isset($_SESSION['order-select']))
			unset($_SESSION['order-select']);

		if(isset($_SESSION['price-range']))
			unset($_SESSION['price-range']);

		if(isset($_SESSION['marque-filter']))
			unset($_SESSION['marque-filter']);

		if(isset($_SESSION['url']))
			unset($_SESSION['url']);

		if(isset($_SESSION['more-filter']))
			unset($_SESSION['more-filter']);
	}
	
	function getAssocCategorie(){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_categorie , id_categorie  FROM `categorie` ');
		$req->execute();
		while( $donnee = $req->fetch(PDO::FETCH_ASSOC) ){
			$tab[$donnee['nom_categorie'] ] =  $donnee['id_categorie'];
		}
		return $tab;
	}

	function getAssocSousCategorieByID($id){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie , id_sous_categorie  FROM `sous_categorie` where id_categorie=:id_categorie ; ');
		$req->execute(array('id_categorie' => $id )  );
		return $req;
	}

	function getAssocSousCategorie(){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie , id_sous_categorie  FROM `sous_categorie` ');
		$req->execute();
		while( $donnee = $req->fetch(PDO::FETCH_ASSOC) ){
			$tab[$donnee['nom_sous_categorie'] ] =  $donnee['id_sous_categorie'];
		}
		return $tab;
	}

	function getNomCategoriebyID($id){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_categorie  FROM `categorie` where id_categorie = :id_categorie;');
		$req->execute( array('id_categorie' => $id ) );
		return $req->fetch();
	}

	function getNomSousCategoriebyID($id){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie  FROM `sous_categorie` where id_sous_categorie = :id_sous_categorie;');
		$req->execute( array('id_sous_categorie' => $id ) );
		return $req->fetch();
	}

	function getAllSousCategorieforCategorie($id_categorie){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie  FROM `sous_categorie` where id_categorie = :id_categorie;');
		$req->execute( array('id_categorie' => $id_categorie ) );
		return $req;
	}

	function getAllSousCategorie(){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie  FROM `sous_categorie` where id_categorie = :id_categorie;');
		$req->execute( array('id_categorie' => $_GET['id_categorie'] ) );
		return $req;
	}

	function getAllSousCategorieByCatID($id_categorie){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie  FROM `sous_categorie` where id_categorie = :id_categorie;');
		$req->execute( array('id_categorie' => $id_categorie) );
		return $req->fetchAll();
	}

	function getNomArticlebyID($id_article) {
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_article  FROM `article` where id_article = :id_article;');
		$req->execute( array('id_article' => $id_article ) );
		return $req->fetch();
	}

	/* recupere une image de un article */
	function getImageArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_image FROM `image` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['nom_image'];
	}

	/**/ 

	function getUrlAccueil(){
		return "/index.php?action=accueil";
	}

	function getUrlDeconnexion(){
		return "/index.php?action=deconnexion";
	}
	function getUrlConnexion(){
		return "/index.php?action=connexion";
	}
	function getUrlInscription(){
		return "/index.php?action=inscription";
	}
	function getUrlProfile(){
		return "/index.php?action=profile";
	}
    function getUrlPayment(){
        return "/index.php?action=payment";
    }

	function getUrlPanier(){
		return "/index.php?action=panier";
	}
	function getUrlFAQ(){
		return "/index.php?action=faq";
	}
	function getUrlCategorie(){
		$categorie=getAssocCategorie();
		$url_start_categorie="/index.php?action=categorie&url_categorie=";
		foreach($categorie as $nom_cat => $id_cat)
		{
			$url_categorie[$nom_cat] = $url_start_categorie . str_replace(' ', '-',$nom_cat) ."&id_categorie=". $id_cat;
		}
		return $url_categorie;
	}

	function getUrlSousCategorie(){
		$categorie=getAssocCategorie();
		$bdd = bddConnection();
		$url_start_souscategorie="/index.php?action=sousCategorie&url_categorie=";
		foreach($categorie as $nom_cat => $id_cat)
		{
			$req = $bdd->prepare('SELECT nom_sous_categorie , id_sous_categorie  FROM `sous_categorie` where id_categorie=:id_cat ');
			$req->execute( array('id_cat'=> $id_cat ));
			while( $donnee = $req->fetch(PDO::FETCH_ASSOC) ){
				$url_sous_categorie[ $donnee['nom_sous_categorie'] ] = $url_start_souscategorie . str_replace(' ', '-',$nom_cat) . "&id_categorie=". $id_cat . "&url_sous_categorie=" .  str_replace(' ', '-',$donnee['nom_sous_categorie'])   ."&id_sous_categorie=" . $donnee['id_sous_categorie'] . "&page=1";
			}
			
		}
		return $url_sous_categorie;
	}

	function getUrlArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_article FROM `article` where id_article=:id_article ;');
		$req->execute( array( 'id_article' => $id_article  ) );
		$donnee=$req->fetch();
		$url_article= "/index.php?action=article&url_article=" . str_replace( ' ', '-', $donnee['nom_article'] ) . "&id_article=" . $id_article;
		return $url_article;
		//return $url_sous_categorie;
	}

	$url_accueil = getUrlAccueil();
	$url_connexion = getUrlConnexion();
	$url_inscription = getUrlInscription();
	$url_categorie = getUrlCategorie() ;
	$url_sous_categorie = getUrlSousCategorie();

	$url_faq=getUrlFAQ();

	$categorie=getAssocCategorie();
	$sousCategorie=getAssocSousCategorie();