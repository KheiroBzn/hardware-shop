<?php

	/* fonction consernant la sous categorie */
	/*----------------------------- */
	/* avoir le nom de categorie et de sous categorie */
	function getNomCategorieSousCategorie($id_categorie,$id_sous_categorie){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT nom_sous_categorie , nom_categorie FROM `sous_categorie`, `categorie` 
        where categorie.id_categorie=:id_categorie AND
              sous_categorie.id_categorie = :id_categorie AND
              sous_categorie.id_sous_categorie = :id_sous_categorie ;');
		$req->execute( array( 'id_categorie' => $id_categorie  ,'id_sous_categorie' => $id_sous_categorie ) );
		return $req->fetch(PDO::FETCH_ASSOC);
	}

	/* avoir le fichier xml de sous categorie pour afficher */
	function getFiltreXmlSousCategorie($id_sous_categroie){
		$bdd = bddConnection();
		$req = $bdd->prepare('SELECT  filtre_sous_categorie  FROM `sous_categorie` where id_sous_categorie=:id_sous_categorie ;');
		$req->execute( array( 'id_sous_categorie' => $id_sous_categroie ) );
		$file=$req->fetch(PDO::FETCH_ASSOC)['filtre_sous_categorie'];
		if($file!=NULL){
			if (file_exists( $_SERVER['DOCUMENT_ROOT'] . '/public/filtre/sousCategorie/'.$file .'.xml')) {
				$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] . '/public/filtre/sousCategorie/'.$file .'.xml');
				return $xml;
			} else 
				return NULL;
		}
		else
			return NULL;

	}

	/* marque for sous categorie */
	function getMarqueSousCategorie($id_sous_categorie){
		$bdd = bddConnection();
		
		$req = $bdd->prepare('SELECT `marque_article`, COUNT(`marque_article`) as `total_article` FROM `article` 
		where article.id_sous_categorie=:id_sous_categorie 
		GROUP BY `marque_article`  ;');
		$req->execute( array( 'id_sous_categorie' =>  $id_sous_categorie ) );
		return $req;
	}
	/*----------------------------- */

	/* fonction consernant article */
	/*----------------------------- */

	/* filtre article */
	function FiltreArticle($id_sous_categorie,$order,$start_from,$results_per_page,$price,$marque_filter,$json_tab=NULL,$query_id_filter_article = '',$more_filter){
		$bdd = bddConnection();
		$req;

		if($json_tab==NULL)
			$query_id_filter_article='';
		
		if($json_tab!=NULL and $query_id_filter_article==''){
			$query='NULL' ;

			$req = $bdd->prepare($query);
			$req->execute(  );
			return $req;
		}
		else if( !is_null($results_per_page) and !is_null($start_from) ){
			
			$query='';

			$from='FROM `article`';
			$where=' where  article.id_sous_categorie=:id_sous_categorie ';
			$order_by=' ORDER BY ';

			$query_marque=getQueryMarque($marque_filter);
			$query_price=getQueryPrix($price);
			$query_more_filter=getQueryMoreFilter($more_filter);

			switch ($order) {
				
				case "plus recent":
					$order_by.=' date_modif_prix_article DESC ' ;
				break;

				case "plus ancien":
					$order_by.=' date_modif_prix_article ASC ' ;
				break;

				case "plus vues":
					$order_by.=' vue_article DESC ' ;
				break;

				case "prix decroissant":
					$order_by.=' prix_article DESC ' ;
				break;

				case "prix croissant":
					$order_by.=' prix_article ASC ' ;
				break;

				case "plus vendus":

					$from.=' ,`historique_article` ';
					$where.=' AND article.id_article= historique_article.id_article ';
					$order_by.=' historique_article.nombre_article_vendu DESC ' ;
				
				break;

				default:
					$order_by.=' date_modif_prix_article DESC ' ;
				break;
			}

			$query='SELECT article.nom_article,article.prix_article,article.id_article,article.date_modif_prix_article,article.filtre_article , article.marque_article , article.nombre_exemplaire_article  '
			. $from . $where . $query_more_filter	. $query_marque . $query_price . $query_id_filter_article . $order_by . 
			' LIMIT :start_from , :nbr_resulta_page  ;';

			$req = $bdd->prepare($query);

			$req->bindParam(':start_from', $start_from, PDO::PARAM_INT);
			$req->bindParam(':nbr_resulta_page', $results_per_page, PDO::PARAM_INT);
			$req->bindParam(':id_sous_categorie', $id_sous_categorie, PDO::PARAM_INT);
			$req->execute(  );
			return $req;
		
		
		

		}
	
		
		
	}

	/* avoir nombre article de une sous categorie */
	function getNbrArticle($id_sous_categorie,$json_tab,$query_id_filter_article,$price,$marque_filter,$more_filter){
		if($json_tab!=NULL and $query_id_filter_article==''){/* aucun article trouve */
			return 0;
		}
		else{
			$bdd = bddConnection();

			$query_marque=getQueryMarque($marque_filter);
			$query_price=getQueryPrix($price);
			$query_more_filter=getQueryMoreFilter($more_filter);
			
			$query='SELECT COUNT(*) as total FROM `article` where id_sous_categorie=:id_sous_categorie'. 
			$query_more_filter .$query_marque .$query_price  . $query_id_filter_article . ';';

			$req = $bdd->prepare($query);
			$req->execute( array( 'id_sous_categorie' => $id_sous_categorie  ) );
			$resulta=$req->fetch(PDO::FETCH_ASSOC);
			return $resulta['total'];
		}
	}

	/* nombre page pour afficher article de une sous categorie */
	function nombrePage($article_per_page,$id_sous_categroie,$json_tab=NULL,$query_id_filter_article = '',$price,$marque_filter,$more_filter){
		$bdd = bddConnection();
		if($json_tab!=NULL and $query_id_filter_article==''){
			return 1;
		}
		else{

			$query_marque=getQueryMarque($marque_filter);
			$query_price=getQueryPrix($price);
			$query_more_filter=getQueryMoreFilter($more_filter);

			$query='SELECT COUNT(*) as total FROM `article` where  id_sous_categorie=:id_sous_categorie ' .
			 $query_more_filter . $query_marque . $query_price . $query_id_filter_article .' ;';

			$req = $bdd->prepare($query);
			$req->execute( array( 'id_sous_categorie' => $id_sous_categroie  ) );
			$resulta=$req->fetch(PDO::FETCH_ASSOC);
			$nbr_page= ceil( $resulta['total']/$article_per_page );
			if( intval($nbr_page)==0)
				$nbr_page=1;
			return intval($nbr_page);
		}
	}

	/* get ID Article for filter */
	function getIDFilterArticle($id_sous_categorie,$filter_json){
		if(isset($filter_json) and !empty($filter_json) ){
			$bdd = bddConnection();
			
			$firstIterat=true;
			$filter_select='';

			foreach ($filter_json as $filterName=>$filterTab) {
				//echo "name : " .$filterName . "\n" ;
				if($firstIterat){
					$filter_select .='`filtre_article`->>"$.' . $filterName .'" IN ( ';
					$firstIterat=false;
				}
				else{
					$filter_select .=' AND `filtre_article`->>"$.' . $filterName .'" IN ( ';
				}

				$filter_value='';
				foreach ($filterTab as  $value) {
					//echo $value .",";
					if($filter_value==='')
						$filter_value.='"' . $value . '"' ;
					else
						$filter_value.= ',' . '"' . $value . '"' ;
				}

				$filter_value.=' ) ';
				$filter_select .=$filter_value;
			}

			$query ='SELECT id_article FROM `article` 
			where id_sous_categorie=:id_sous_categorie and `filtre_article` is not NULL and ' . $filter_select .' ;' ;
			$req = $bdd->prepare($query );
		
			$req->bindParam(':id_sous_categorie', $id_sous_categorie, PDO::PARAM_INT);
			$req->execute(  );


			$result=$req->fetchAll(PDO::FETCH_ASSOC);

			return $result;
				
		}
	}
	/*----------------------------- */


	/* get query  */
	/*----------------------------- */
	/* query for id article filter */
	function getQueryIDFilterArticle($tab_id_article){
		$firstIterat=true;
		
		$str='';
		if(isset($tab_id_article) and !empty($tab_id_article)){
			$str=' AND article.id_article IN ( ';
			foreach ($tab_id_article  as $value) {
				if($firstIterat){
					$str.= '"' . $value['id_article']. '"';
					$firstIterat=false;
				}
				else
					$str.= ' , "' . $value['id_article']. '"';
			}
			
			$str.=' ) ';
		}

		return $str;
	}

	function getQueryPrix($price){
		$query_price='';
		if(!empty($price)){
			$query_price=' AND prix_article BETWEEN '. $price['min'] . ' AND ' . $price['max']. ' ' ;
		}
		return $query_price;
	}

	function getQueryMarque($marque_filter){
		$query_marque='';
		if(!empty($marque_filter)){
			$firstIterat=true;
			if(isset($marque_filter) and !empty($marque_filter)){
				$query_marque=' AND article.marque_article IN ( ';
				foreach ($marque_filter  as $key) {
					if($firstIterat){
						$query_marque.= '"' . $key. '"';
						$firstIterat=false;
					}
					else
						$query_marque.= ' , "' . $key. '"';
				}
				
				$query_marque.=' ) ';
			}

		}
		return $query_marque;
	}

	function getQueryMoreFilter($more_filter){
		$query_disponibilite='';
		if( !empty($more_filter) and isset($more_filter['disponible']) and isset($more_filter['indisponible']) ){
			if($more_filter['disponible']!="true" || $more_filter['indisponible']!="true" ){
				if($more_filter['disponible']=="true")
					$query_disponibilite=' AND 	nombre_exemplaire_article > 0 ';

				if($more_filter['indisponible']=="true")
					$query_disponibilite=' AND 	nombre_exemplaire_article = 0 ';

			}
		} 
		return $query_disponibilite;
	}
	/*----------------------------- */

	/* fonction pour afficher element */
	/*----------------------------- */
	/* display article pour AJAX et HTTP */
	function displayArticle($resulta_limit_article){

		$currentArticleDisplay="";
		
		while($element = $resulta_limit_article->fetch()) {

			$filtreArticle=json_decode($element['filtre_article'],true);
			$jsontext="";
			/*if($filtreArticle!=NULL){
				foreach ($filtreArticle as $filterName=>$filterTab) {

					$jsontext.= "<p>" .$filterName. " : " . $filterTab . "</p>" ;
				}
			}*/

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
				<div class='col-lg-4 col-md-6'><figure class='card card-product-grid'>
					<div class='img-wrap img-height text-center'>
						<img class='img-height' src=\"/public/images/articles/" . getImageArticle($element['id_article']) . ".jpg\"" 
						.  $style_image_empty . "'>
							<a class='btn-overlay' href=\"" . getUrlArticle($element['id_article']) . "\">
								<i class='fa fa-search-plus'></i> Voir Article
							</a>
					</div> 
					<figcaption class='info-wrap'>
						<div class='text-center' style='min-height: 104px;'>
							<a href='#' class='title h5 text-capitalize" . $style_color_empty .  " '>" . $element['nom_article'] ."</a>
							
							<p class=\"text-capitalize\">Marque : " .$element['marque_article'] . "</p>". $jsontext .
							"<div class='price-wrap mt-2 price-product'>
								<span class='price'>" . $element['prix_article'] . " DZD</span>
							</div>
						</div>". $style_button_empty .
						
					"</figcaption></figure>
				</div>"  ;
		}
		return $currentArticleDisplay;
	}

	/* display pagination pour AJAX et HTTP */
	function displayPagination($total_pages,$page,$url){

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
		$paginationNumber.="<a class=\"page-link\"href=\"" . preg_replace('/page[0-9]$/s','page' . 
		$id_page ,$url) ."\">Precedant</a>
		</li>";
		for ($i=1; $i<=$total_pages; $i++) {  
			if($i==$page)
				$paginationNumber.="<li class=\"page-item active\">";
			else 
				$paginationNumber.="<li class=\"page-item\">";
			
			$paginationNumber.="<a class=\"page-link\" href=\"" . preg_replace('/page[0-9]$/s','page' . $i ,$url) . "\">" . $i .
			 "</a></li>";
		}; 

		if($page==$total_pages || $total_pages==0){
			$paginationNumber.= "<li class=\"page-item disabled\">";
			$id_page=$total_pages;
		}
		else{
			$paginationNumber.= "<li class=\"page-item\">";
			$id_page=(int)($page)+1;
		}

		$paginationNumber.="<a class=\"page-link\"
		href=\"" .preg_replace('/page[0-9]$/s','page' . $id_page ,$url) ."\">Suivant</a></li>";
				
		return $paginationNumber;
	}
	/*----------------------------- */
