<?php

    function getArticleSearch($nom,$start_from,$results_per_page){
        $bdd = bddConnection();
        $req;
        
        $keyword = "%".$nom."%";
        $where=' where  article.nom_article LIKE :keyword ';
        $order_by=' ORDER BY nom_article ';
        
        $query='SELECT article.nom_article,article.prix_article,article.id_article,article.date_modif_prix_article,article.filtre_article , article.marque_article , article.nombre_exemplaire_article  
	    FROM `article`'. $where . $order_by . ' LIMIT :start_from , :nbr_resulta_page  ;';

        $req = $bdd->prepare($query);   
        
        $req->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $req->bindParam(':nbr_resulta_page', $results_per_page, PDO::PARAM_INT);
        $req->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $req->execute(  );
        return $req;
	}
	
	function getArticleSearchAutocomplete($nom){
        $bdd = bddConnection();
        $req;
        
        $keyword = "%".$nom."%";
        $where=' where  article.nom_article LIKE :keyword ';
        $order_by=' ORDER BY nom_article ';
        
        $query='SELECT article.nom_article  FROM `article`'. $where . $order_by . ' ;';

        $req = $bdd->prepare($query);   
        
        $req->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $req->execute(  );
        return $req;
    }

    function nombrePageSearch($article_per_page,$nom){
		$bdd = bddConnection();
	
        $keyword = "%".$nom."%";

        $query='SELECT COUNT(*) as total FROM `article`  where  article.nom_article LIKE :keyword ;';

        $req = $bdd->prepare($query);
        $req->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $req->execute(  );
        $resulta=$req->fetch(PDO::FETCH_ASSOC);
        $nbr_page= ceil( $resulta['total']/$article_per_page );
        if( intval($nbr_page)==0)
            $nbr_page=1;
        return intval($nbr_page);
		
    }
    
    function getNbrArticleSearch($nom){
        $bdd = bddConnection();
	
        $keyword = "%".$nom."%";

        $query='SELECT COUNT(*) as total FROM `article`  where  article.nom_article LIKE :keyword ;';

        $req = $bdd->prepare($query);
        $req->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $req->execute(  );
        $resulta=$req->fetch(PDO::FETCH_ASSOC);
        return intval($resulta['total']);
    }

    function articleDisplaySearch($resulta_limit_article){
        $currentArticleDisplay="";
    
		while($element = $resulta_limit_article->fetch()) {
            if( intval($element['nombre_exemplaire_article'])>0 ) {
				$style_image_empty='';
				$style_button_empty="<a href='#' class='btn btn-block btn-primary mt-2 ajouter-panier ' data-id='". $element['id_article'] . "'>Ajouter au Panier </a>";
				$style_color_empty="";
			}
			else{
				$style_image_empty="style='-webkit-filter: grayscale(100%); filter: grayscale(100%);'";
				$style_button_empty="<a href='' class='btn btn-block btn-secondary mt-2 ' onclick='return false' style='cursor:default;' >Non Disponible </a>";
				$style_color_empty=" text-secondary ";
				
			}
			//<p class=\"text-capitalize\">date derniere modification : ". $element['date_modif_prix_article'] ."</p>  date modif affichage
			$currentArticleDisplay.="
				<div class='col-lg-3  col-md-4 col-sm-6 col-12'><figure class='card card-product-grid'>
					<div class='img-wrap img-height text-center'>
						<img class='img-height' src=\"/public/images/articles/" . getImageArticle($element['id_article']) . ".jpg\"" 
						.  $style_image_empty . "'>
							<a class='btn-overlay' href=\"" . getUrlArticle($element['id_article']) . "\">
								<i class='fa fa-search-plus'></i> Voir Article
							</a>
					</div> 
					<figcaption class='info-wrap'>
						<div class='text-center' style='min-height: 85px;'>
							<a href='#' class='title h5 text-capitalize" . $style_color_empty .  " '>" . $element['nom_article'] ."</a>
							<div class='price-wrap mt-2 price-product'>
								<span class='price'>" . $element['prix_article'] . " DZD</span>
							</div>
						</div>". $style_button_empty .
						
					"</figcaption></figure>
				</div>"  ;
		}
		return $currentArticleDisplay;
	}
    
    function paginationDisplaySearch($total_pages,$page){

		$id_page;
		$paginationNumber="";
		
		if($page=='1'){
			$paginationNumber.= "<li class=\"page-item disabled\">";
			$id_page=1;
		}
		else{
			$paginationNumber.="<li class=\"page-item\">";
			$id_page=(int)($page)-1;
		}

		$paginationNumber.="<a class=\"page-link previous\" href=\"#\" >Precedant</a></li>";

		for ($i=1; $i<=$total_pages; $i++) { 
			
			if($i==$page)
				$paginationNumber.="<li class=\"page-item active\">";
			else 
				$paginationNumber.="<li class=\"page-item\">";
			
			$paginationNumber.="<a class=\"page-link\" href=\"#\">" . $i . "</a></li>";
		}

		if($page==$total_pages || $total_pages==0 || $total_pages==1 ){
			$paginationNumber.= "<li class=\"page-item disabled\">";
			$id_page=$total_pages;
		}
		else{
			$paginationNumber.= "<li class=\"page-item\">";
			$id_page=(int)($page)+1;
		}

		$paginationNumber.="<a class=\"page-link next\" href=\"#\">Suivant</a></li>";
				
		return $paginationNumber;
    }