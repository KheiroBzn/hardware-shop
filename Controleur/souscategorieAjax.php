<?php if(!isset($_SESSION)){
    session_start();
}
    //code a executer pour une requete ajax
        
    if(isset($_POST['order-select'])) $_SESSION['order-select'] = $_POST['order-select'];
    if(isset($_POST['number-per-page'])) $_SESSION['number-per-page'] = $_POST['number-per-page'];

    if(isset($_POST['marque-filter'])){
        $result_decode=json_decode( $_POST['marque-filter'],true  );
        if($result_decode == NULL)
            unset($_SESSION['marque-filter']);// = NULL;
        else
            $_SESSION['marque-filter']=$result_decode;
    }

    
    if(isset($_POST['price-min']) and isset($_POST['price-max'])  ){
        $_SESSION['price-range'][0] = $_POST['price-min'];
        $_SESSION['price-range'][1] = $_POST['price-max'];
        $price['min']=$_POST['price-min'];
        $price['max']=$_POST['price-max'];
    }

    if( isset($_POST['showArticleDisponible']) and isset($_POST['showArticleIndisponible'])   ){
        $more_filter['disponible']=$_POST['showArticleDisponible'];
        $more_filter['indisponible']=$_POST['showArticleIndisponible'];
        if($more_filter['disponible']!=false || $more_filter['indisponible']!=false){
            $_SESSION['more-filter']['disponible']= $more_filter['disponible'];
            $_SESSION['more-filter']['indisponible']= $more_filter['indisponible'];
        }       
    }

    if(isset($_POST['json-filter'])){
        $result_decode=json_decode( $_POST["json-filter"],true  );
        if($result_decode == NULL){
            $_SESSION['json-filter'] = NULL;
            $_SESSION['id_article_filter']= NULL;
        }
        else{

            $_SESSION['json-filter'] = $result_decode;
            $_SESSION['id_article_filter']=getIDFilterArticle($_SESSION['id_sous_categorie'],$_SESSION['json-filter']);
        }
    }


    include_once  $_SERVER['DOCUMENT_ROOT'] . './Controleur/souscategorieCommonVar.php';

    $result_json= !empty($json_tab) ? json_encode($json_tab) : array() ;  /* pour stocke le json et l affiche si il change de page */

    header('Content-type: application/json');
    echo json_encode(array(
                            "nbrArticle"=>$nbr_article,"filterjson"=>$result_json,'pagination'=>$currentPaginationNumber,
                            'article'=>$currentArticlesDisplay,'currentpage'=>$page));