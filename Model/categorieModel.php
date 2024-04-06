<?php
	function getSousCategorie(){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie,image_sous_categorie  FROM `sous_categorie` where sous_categorie.id_categorie = :get_id_categorie;');
		$req->execute( array('get_id_categorie' => $_GET['id_categorie'] ) );
	/*	while( $donnee = $req->fetch(PDO::FETCH_ASSOC) ){
			echo $donnee['nom_sous_categorie'] . " " . $donnee['image_sous_categorie'] ;
		}*/
		return $req;
	}

	function getNomCurrentCategorie($id_categorie){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_categorie  FROM `categorie` where id_categorie = :id_categorie;');
		$req->execute( array('id_categorie' => $id_categorie ) );
		return $req->fetch();
	}

	
	function getArticleMostViewCastegorie($id_categorie,$limit_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT  article.id_article ,article.nom_article , article.prix_article , article.nombre_exemplaire_article  FROM `categorie`  
		JOIN `sous_categorie` ON categorie.id_categorie= sous_categorie.id_categorie 
		JOIN `article` ON article.id_sous_categorie= sous_categorie.id_sous_categorie 
		where categorie.id_categorie=:id_categorie ORDER BY vue_article DESC LIMIT :debut, :limit_article ;');
		$debut=0;
		$req->bindParam(':id_categorie',$id_categorie, PDO::PARAM_INT);
		$req->bindParam(':debut', intval($debut), PDO::PARAM_INT);
		$req->bindParam(':limit_article', intval($limit_article), PDO::PARAM_INT);
		$req->execute();
		return $req;
	}

?>

