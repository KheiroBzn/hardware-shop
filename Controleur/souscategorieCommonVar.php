<?php if(!isset($_SESSION)){
    session_start();
}
    $url = ($request=='HTTP') ? $_SERVER['REQUEST_URI'] : $_SESSION['url'] ;
    $id_sous_categorie=  ($request=='HTTP') ? $_GET['id_sous_categorie'] : $_SESSION['id_sous_categorie'] ;


    $results_per_page= ( isset($_SESSION['number-per-page']) and !empty($_SESSION['number-per-page']) ) ? intval($_SESSION['number-per-page']) : $DEFAULT_NUMBER_PER_PAGE ;  
    $order= isset($_SESSION['order-select']) ? $_SESSION['order-select'] : NULL ;      
    $marque_filter= isset($_SESSION['marque-filter']) ? $_SESSION['marque-filter'] : array() ;   
    $json_tab= isset($_SESSION['json-filter']) ? $_SESSION['json-filter'] : NULL ;  
    $query_id_filter_article=isset($_SESSION['id_article_filter']) ? getQueryIDFilterArticle($_SESSION['id_article_filter']) : '' ;     

    if(isset($_SESSION['price-range']) and !empty($_SESSION['price-range'])){
        $price['min']=$_SESSION['price-range'][0];
        $price['max']=$_SESSION['price-range'][1];
    }

    if(isset($_SESSION['more-filter']) ){
        if(isset($_SESSION['more-filter']['disponible']) AND isset($_SESSION['more-filter']['indisponible'])){
            $more_filter['disponible']=$_SESSION['more-filter']['disponible'];
            $more_filter['indisponible']=$_SESSION['more-filter']['indisponible'];
        }
    }

    $total_pages=nombrePage($results_per_page,  $id_sous_categorie,$json_tab,$query_id_filter_article,$price,$marque_filter, $more_filter);

    if($request=='HTTP'){
        if ( isset($_GET["page"]) and  !empty($_GET["page"])){
            if( intval($_GET["page"])>$total_pages )
                header("Location: /" . $_GET['id_categorie'] ."-" . $_GET['url_categorie'] . "/" . $_GET['id_sous_categorie'] . "-" .  $_GET['url_sous_categorie'] ."/page" .$total_pages  );
            else
                $page  = $_GET["page"]; 	
        }
        else{
            header("Location: /" . $_GET['id_categorie'] ."-" . $_GET['url_categorie'] . "/" . $_GET['id_sous_categorie'] . "-" .  $_GET['url_sous_categorie'] ."/page1"  );
        }

        
    }
    else if($request=='AJAX'){

        if(isset($_SESSION['page']) and !empty($_SESSION['page'])){
            if( intval($_SESSION['page'])>$total_pages)
                $_SESSION['page']=$total_pages;

            $page=$_SESSION['page'];
        }
        else{
            $page=1;
            $_SESSION['page']=1;
        }
        
    }

    
    $start_from = ($page-1) * $results_per_page;
    $nbr_article=getNbrArticle($id_sous_categorie,$json_tab,$query_id_filter_article,$price,$marque_filter, $more_filter);

    $resulta_limit_article=FiltreArticle($id_sous_categorie,$order,
    $start_from,$results_per_page,$price,$marque_filter,$json_tab,$query_id_filter_article, $more_filter);

    $currentArticlesDisplay=displayArticle($resulta_limit_article);
    $currentPaginationNumber=$currentPaginationNumber=displayPagination($total_pages,$page,$url);;
    





			

   

