<?php if(!isset($_SESSION)){
    session_start();
}
    include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';
    include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/rechercheModel.php";

    $currentArticlesDisplay='';
    $currentPaginationNumber='';

    $results_per_page=12;

    $request='';
    $resulta_limit_article='';

	if ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {
		// on effectue un traitement spécifique pour une requete AJAX
        $request='AJAX';

        /* requete pagination pour avoir les articles*/ 
        if(isset($_POST['page']) and !empty($_POST['page']) and isset($_POST['nom']) ){

            $page  = $_POST['page']; 
            $nom=$_POST['nom'];
            $total_pages=nombrePageSearch($results_per_page,$nom);
            
            $start_from = ($page-1) * $results_per_page;
            

            $resulta_limit_article=getArticleSearch($nom,$start_from,$results_per_page) ;

            $currentArticlesDisplay=articleDisplaySearch($resulta_limit_article);
            
            $currentPaginationNumber=paginationDisplaySearch($total_pages,$page);

            header('Content-type: application/json');
            echo json_encode(array('pagination'=>$currentPaginationNumber,'article'=>$currentArticlesDisplay));

        }

        /* la barre de recherche autocomplete */
        if(isset($_GET['term']) ){

            $resulta=getArticleSearchAutocomplete($_GET['term']);
            $array = array(); // on créé le tableau

            while($donnee = $resulta->fetch()) // on effectue une boucle pour obtenir les données
            {
                array_push($array, $donnee['nom_article']); // et on ajoute celles-ci à notre tableau
            }

            echo json_encode($array); // il n'y a plus qu'à convertir en JSON

        }
    }
    else{

    
        if(isset($_GET['q']) and !empty($_GET['q'])){
            $start_from=0;
            
            $total_pages=nombrePageSearch($results_per_page,$_GET['q']);
            
            $page  = 1; 

            $start_from = ($page-1) * $results_per_page;
            $nbr_article=getNbrArticleSearch($_GET['q']);

    
            $resulta_limit_article=getArticleSearch($_GET['q'],$start_from,$results_per_page) ;
        }



        $currentArticlesDisplay=articleDisplaySearch($resulta_limit_article);
            
        $currentPaginationNumber=paginationDisplaySearch($total_pages,$page);

        include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/rechercheVue.php";
    }

   

    