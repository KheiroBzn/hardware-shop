<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    
    function getArticleOrderBy($order,$limit){
        $bdd = bddConnection();
        $order_by=' ORDER BY ';
        $from=' FROM `article` ';
        $where=' WHERE article.nombre_exemplaire_article > 0 ';
        switch ($order) {
            
            case "plus recent":
                $order_by.=' date_modif_prix_article DESC ' ;
            break;
            
            case "plus vendus":

                $from.=' ,`historique_article` ';
                $where.=' AND article.id_article= historique_article.id_article ';
                $order_by.=' historique_article.nombre_article_vendu DESC ' ;
            
            break;

            case "plus vues":
                $order_by.=' vue_article DESC ' ;
            break;

            
            default:
                $order_by.=' date_modif_prix_article DESC ' ;
            break;
        }
        

        $query='SELECT  article.id_article ,article.nom_article , article.prix_article , article.nombre_exemplaire_article ' .  
		$from . $where . $order_by . ' LIMIT :debut, :limit_article ;';
		$req = $bdd->prepare($query);
		$debut=0;
		$req->bindParam(':debut', intval($debut), PDO::PARAM_INT);
		$req->bindParam(':limit_article', intval($limit), PDO::PARAM_INT);
		$req->execute();
		return $req;
    }