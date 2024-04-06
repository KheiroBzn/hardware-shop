<?php if(!isset($_SESSION)){
        session_start();
    }

    function getArticleForPanier($id_article){
          $bdd = bddConnection();
          $req = $bdd->prepare('SELECT  
          article.id_article ,article.nom_article , article.prix_article , article.nombre_exemplaire_article  
           FROM `article` where article.id_article=:id_article  LIMIT :debut, :limit_nbr;');
           $debut=0;
          $limit=1;
          $req->bindParam(':id_article',$id_article, PDO::PARAM_INT);
          $req->bindParam(':debut', intval($debut), PDO::PARAM_INT);
          $req->bindParam(':limit_nbr', intval($limit), PDO::PARAM_INT);
          $req->execute();
          return $req->fetch(PDO::FETCH_ASSOC);
    }



    function ajouterArticle($id_article){


        //Si le produit existe déjà on ajoute seulement la quantité
          $positionArticle = array_search($id_article,  $_SESSION['panier']['id_article']);
          $result=getArticleForPanier($id_article);

          if ($positionArticle !== false)
          {//l article exsite deja
             $qte=$_SESSION['panier']['qte_article'][$positionArticle]+1;
             if($qte<=$result['nombre_exemplaire_article'])
                $_SESSION['panier']['qte_article'][$positionArticle] =$qte; ;

             $result['qte_article']=$_SESSION['panier']['qte_article'][$positionArticle];
          }
          else
          {

              if($result['nombre_exemplaire_article']>=1){
                $result['qte_article']=1;

                //Sinon on ajoute le produit
                array_push($_SESSION['panier']['id_article'],$result['id_article']);
                array_push($_SESSION['panier']['nom_article'],$result['nom_article']);
                array_push($_SESSION['panier']['prix_article'],$result['prix_article']);
                array_push($_SESSION['panier']['qte_article'],$result['qte_article']);
                array_push($_SESSION['panier']['nombre_exemplaire_article'],$result['nombre_exemplaire_article']);

              }



          }

          return  $result;


     }

     function calculerPrixTotal($array_prix,$array_qte){
        $prix_total=0;
        if(!empty($array_prix)){

          if(count($array_prix)==count($array_qte)){
             for ($i=0; $i < count($array_prix) ; $i++) {
                $prix_total += intval($array_prix[$i])* intval($array_qte[$i]);
                //echo "prix" . $array_prix[$i] ."  qte " . $array_qte[$i] ;
             }
          }

        }

       return $prix_total;

     }

     function calculerQteTotal($array_qte){
       $qte_total=0;
       if(!empty($array_qte)){
            for ($i=0; $i < count($array_qte) ; $i++) {
               $qte_total += intval($array_qte[$i]);
            }
       }

      return $qte_total;

    }

     function codeNewArticle($id_article,$nom_article,$prix_article,$qte_article){
        $code="  
       <li data-id=\"" . $id_article ."\" >
          <span class=\"item\">
             <img class=\"img-cart\" src=\"/public/images/articles/" . getImageArticle($id_article) ."\" alt=\"\">
                   <span class=\"d-block\" >
                      <a href=\"" . getUrlArticle($id_article). "\" class=\"title font-weight-bolder text-capitalize text-dark\" >" .
                         $nom_article ." </a>
                   </span>
                   <span class=\"price\" style=\"font-weight: 900;\" ><span class=\"text-muted qte\">" .$qte_article . " X </span>" . $prix_article . "DZD</span>
                   <button class=\"btn fa fa-trash-o d-block float-right delete-article\" style=\"font-size: 25px;\"></button>
          </span>
       </li>";

       return $code;

     }

     function supprimerArticlePanier($id_article,$panier){

          $positionArticle = array_search($id_article,  $panier['id_article']);
          if($positionArticle!==false){

             array_splice($panier['id_article'], $positionArticle , 1);
             array_splice($panier['nom_article'], $positionArticle , 1);
             array_splice($panier['prix_article'], $positionArticle , 1);
             array_splice($panier['qte_article'], $positionArticle , 1);
             array_splice($panier['nombre_exemplaire_article'], $positionArticle , 1);


          }

          return $panier;
     }


     function modifierQteArticlePanier($id_article,$panier,$qte){

       $positionArticle = array_search($id_article,  $panier['id_article']);
       if($positionArticle!==false){
          if($qte<=$panier['nombre_exemplaire_article'][$positionArticle])
             $panier['qte_article'][$positionArticle]=$qte;
          else
             $panier['qte_article'][$positionArticle]=$panier['nombre_exemplaire_article'][$positionArticle];

       }

       return $panier;
    }

    function CalculerSousTotalArticle($id_article,$panier,$qte){

       $positionArticle = array_search($id_article,  $panier['id_article']);
       $prix_sous_total=0;
       if($positionArticle!==false){
          $prix_sous_total=intval($panier['prix_article'][$positionArticle])*intval($panier['qte_article'][$positionArticle]);
       }

       return $prix_sous_total;
    }