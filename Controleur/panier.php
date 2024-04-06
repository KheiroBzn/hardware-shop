<?php if(!isset($_SESSION)){
    session_start();
}

    include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';

    include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/panierModel.php";

    if (isset($_SESSION['panier'])) {
        if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['order'])) {
            if(isset($_SESSION['id_client']) and !empty($_SESSION['id_client'])) {
                redirect_Payment();
            } else redirect_Connexion();
        }
    } else {
        $_SESSION['panier']=array();
        $_SESSION['panier']['id_article'] = array();
        $_SESSION['panier']['nom_article'] = array();
        $_SESSION['panier']['prix_article'] = array();
        $_SESSION['panier']['qte_article'] = array();
        $_SESSION['panier']['nombre_exemplaire_article'] = array();
    }

	$request='';

	if ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {
		// on effectue un traitement spécifique pour une requete AJAX
        $request='AJAX';

        /* dans le cas pour ajouter un article */ 
        $codeArticle='';
        if(isset($_POST['idArticle']) and !empty($_POST['idArticle']) ){
            $positionArticle = array_search($_POST['idArticle'],  $_SESSION['panier']['id_article']);
            $article_ajoute=ajouterArticle($_POST['idArticle']);
            $codeArticle='';
            if($positionArticle!==false)
                $codeArticle='';
            else
                $codeArticle=codeNewArticle($article_ajoute['id_article'],$article_ajoute['nom_article'],$article_ajoute['prix_article'],$article_ajoute['qte_article']);
        
            $prix_total=calculerPrixTotal($_SESSION['panier']['prix_article'],$_SESSION['panier']['qte_article']);
            $_SESSION['panier']['prix_total']=$prix_total;

            
            $qte_total=calculerQteTotal($_SESSION['panier']['qte_article']);

            $etat=true;
            if(isset( $_SESSION['panier']['qte_total'] ) )
                if( intval( $qte_total )== intval( $_SESSION['panier']['qte_total'] ) )
                    $etat=false;

            $_SESSION['panier']['qte_total']=$qte_total;
    
            $currentPos= array_search($_POST['idArticle'],  $_SESSION['panier']['id_article']);
    
            header('Content-type: application/json');
            echo json_encode(array("etat"=>$etat,"nomArticle"=> ucwords($_SESSION['panier']['nom_article'][$currentPos]) 
            ,"codeArticle"=>$codeArticle,"prixTotal"=>$prix_total,"qteTotal"=>$qte_total,"qteArticle"=>$article_ajoute['qte_article']));

        }

        /* dans le cas pour supprimer un article */
        if(isset($_POST['idDeletArticle']) and !empty($_POST['idDeletArticle']) ){

            $_SESSION['panier']=supprimerArticlePanier($_POST['idDeletArticle'],$_SESSION['panier']);


            $prix_total=calculerPrixTotal($_SESSION['panier']['prix_article'],$_SESSION['panier']['qte_article']);
            $_SESSION['panier']['prix_total']=$prix_total;
            $qte_total=calculerQteTotal($_SESSION['panier']['qte_article']);
            $_SESSION['panier']['qte_total']=$qte_total;
    
            
            header('Content-type: application/json');
            echo json_encode(array("prixTotal"=>$prix_total,"qteTotal"=>$qte_total));

        }

        /* dans le cas pour modifier Qte de un article */
        if(isset($_POST['idQteArticle']) and isset($_POST['qteArticle']) ){

            $_SESSION['panier']=modifierQteArticlePanier($_POST['idQteArticle'], $_SESSION['panier'],$_POST['qteArticle']);

            $prix_total=calculerPrixTotal($_SESSION['panier']['prix_article'],$_SESSION['panier']['qte_article']);
            $_SESSION['panier']['prix_total']=$prix_total;
            $qte_total=calculerQteTotal($_SESSION['panier']['qte_article']);
            $_SESSION['panier']['qte_total']=$qte_total;
    
            $prix_sous_total=CalculerSousTotalArticle($_POST['idQteArticle'], $_SESSION['panier'],$_POST['qteArticle']);

            header('Content-type: application/json');
            echo json_encode(array("prixSousTotal"=>$prix_sous_total,"prixTotal"=>$prix_total,"qteTotal"=>$qte_total));

        }    
      
	}
	else {
        $request='HTTP';
        
        if(isset($_SESSION['panier']))
            $article_panier= $_SESSION['panier'];

        $last_url='';
        if(isset($_SESSION['last_url']) and !empty($_SESSION['last_url']) and $_SESSION['last_url']!="/Panier" )
            $last_url=$_SESSION['last_url'];
        else
            $last_url=$url_accueil;

        include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/panierVue.php" ;
    }  
	