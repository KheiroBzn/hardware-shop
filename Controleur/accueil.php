<?php if(!isset($_SESSION)){
    session_start();
}

    include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';

    include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/accueilModel.php";

    if ( (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ) {
        // on effectue un traitement spécifique pour une requete AJAX
        $request='AJAX';

        if(isset($_POST['filtre']) and !empty($_POST['filtre']) ){

            switch($_POST['filtre']){
                case "plus vues":
                    $_SESSION['order-select']="plus vues";
                break;
                case "plus vendus":
                    $_SESSION['order-select']="plus vendus";
                break;
                default:
                    $_SESSION['order-select']="plus recent";
                break;
            }

            header('Content-type: application/json');
            echo json_encode(array() );
        }
        else{

            if(isset($_POST['id-categorie']) and !empty($_POST['id-categorie'])){
                header('Content-type: application/json');
                echo json_encode(array(
                                        "allSousCategorie"=>getAssocSousCategorieByID($_POST['id-categorie'])->fetchAll(PDO::FETCH_ASSOC),
                                        "urlSousCategoire"=>$url_sous_categorie  ) );
            }
            else{
                header('Content-type: application/json');
                echo json_encode(array(
                                        "allCategorie"=>getAssocCategorie() ));
            }

        }

    }
    else {
        $LIMIT_ARTICLE=6;
        $article_plus_recent=getArticleOrderBy('plus recent',$LIMIT_ARTICLE);
        $article_plus_vendus=getArticleOrderBy('plus vendus',$LIMIT_ARTICLE);
        $article_plus_vues=getArticleOrderBy('plus vues',$LIMIT_ARTICLE);

        include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/accueilVue.php" ;
    }