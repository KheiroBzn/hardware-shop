<?php

	function getAllImageArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_image FROM `image` where id_article=:id_article lIMIT 5;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetchAll();
	}

	function getNomArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_article FROM `article` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['nom_article'];
	}

    function getNombreExemplaireArticle($id_article) {
        $bdd = bddConnection();
        $req = $bdd->prepare('SELECT nombre_exemplaire_article FROM `article` where id_article=:id_article;');
        $req->execute( array( 'id_article' => $id_article ) );
        return $req->fetch(PDO::FETCH_ASSOC)['nombre_exemplaire_article'];
    }

	function getMarqueArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT marque_article FROM `article` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['marque_article'];
	}

	function getPrixArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT prix_article FROM `article` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['prix_article'];
	}
	
	function getDescriptionArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT description_article FROM `article` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['description_article'];
	}

	function getFicheArticle($id_article){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT fiche_technique_article FROM `article` where id_article=:id_article;');
		$req->execute( array( 'id_article' => $id_article ) );
		return $req->fetch(PDO::FETCH_ASSOC)['fiche_technique_article'];
	}

	function getArticleMostView($id_article,$limit_article){
		$bdd = bddConnection();
		// Avoir le sous categorie de l'article en question
		$stmt = $bdd->prepare('SELECT id_sous_categorie FROM article WHERE id_article = :id_article');
		$stmt->bindParam(':id_article',$id_article, PDO::PARAM_INT);
		$stmt->execute();
		$id_sous_categorie = $stmt->fetch(PDO::FETCH_ASSOC)['id_sous_categorie'];
		// Avoir les articles similaires
		$req = $bdd->prepare('SELECT 
								article.id_article, 
								article.nom_article, 
								article.prix_article,
								article.nombre_exemplaire_article 
							FROM `article`
							WHERE id_sous_categorie=:id_sous_categorie 
							ORDER BY vue_article DESC LIMIT :debut, :limit_article ;');
		$debut=0;
		$req->bindParam(':id_sous_categorie',$id_sous_categorie, PDO::PARAM_INT);
		$req->bindParam(':debut', intval($debut), PDO::PARAM_INT);
		$req->bindParam(':limit_article', intval($limit_article), PDO::PARAM_INT);
		$req->execute();
		return $req->fetchAll();
	}

	function getAllComments($id_article) {
		$bdd = bddConnection();
		$req = $bdd->prepare("SELECT * FROM `commentaire` WHERE id_article=:id_article
								ORDER BY id_commentaire DESC");
		$req->bindParam(':id_article',$id_article, PDO::PARAM_INT);
		$req->execute();
		return $req->fetchAll();
	}

	function getMemberByUserId($userId) {
		$bdd = bddConnection();
		$req = $bdd->prepare("SELECT * FROM `client` WHERE id_utilisateur=:id_utilisateur");
		$req->bindParam(':id_utilisateur',$userId, PDO::PARAM_INT);
		$req->execute();
		return $req->fetch();
	}

	function countItem($item, $table, $query = '', $value = null) {
		$bdd = bddConnection();
		$req = $bdd->prepare("SELECT COUNT($item) FROM $table $query");
		if( $value != null && $query != '' ) { $req->execute(array($value)); } 
		else { $req->execute(); }
		return $req->fetchColumn();
	}
	
	function addComment($id_article, $username, $comment) {
		$bdd = bddConnection();	
		// Avoir userID 
		$stmt = $bdd->prepare('SELECT id_utilisateur FROM client WHERE userlogin_client = :userlogin_client');
		$stmt->bindParam(':userlogin_client',$username);
		$stmt->execute();
		$userId = $stmt->fetch(PDO::FETCH_ASSOC)['id_utilisateur']; 
		$req = $bdd->prepare("INSERT INTO commentaire( date_ajout_commentaire,
														contenue_commentaire,
														id_utilisateur,
														id_article)
								VALUES(now(), :contenue_commentaire, :id_utilisateur, :id_article)");
		$req->execute(array('contenue_commentaire'   => $comment,
							'id_utilisateur'         => $userId,
							'id_article'             => $id_article 
							));
		//header('refresh: 1');
	}

	function deleteComment($commentID) {
		$bdd = bddConnection();	
		$req = $bdd->prepare("DELETE FROM commentaire WHERE id_commentaire = :zid");
		$req->bindParam(":zid", $commentID);
		$req->execute(); 
	}
	