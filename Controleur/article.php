<?php if(!isset($_SESSION)){
    session_start();
}
	include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';
	include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/articleModel.php";

	$LIMIT_ARTICLE_MOST_VIEW=10;
	$current_article=getNomArticle($_GET['id_article']);

	if($_SERVER['REQUEST_METHOD'] == 'POST') {	
		if( isset($_POST['commentContent']) && !empty($_POST['commentContent']) ) {
      		addComment($_GET['id_article'], $_SESSION['userlogin_client'], $_POST['commentContent']);
      		unset($_POST['commentContent']);
		} elseif( isset($_POST['commentID']) && !empty($_POST['commentID']) ) {
      		deleteComment($_POST['commentID']);
		}
	}
	
	if($current_article){
		$bdd_nom_article=getNomArticle($_GET['id_article']) ;
		if($_GET['url_article']!=str_replace(' ', '-',$bdd_nom_article)  ){
			header("Location: /" . $_GET['id_article'] ."-" . str_replace(' ', '-',$bdd_nom_article['nom_article']) );
		} else {
			include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/articleVue.php";
		}
	}
	else header("Location: /accueil");

	// Comment section

	/*
	switch($comment) {
	case 'Add': redirect_Accueil(); break;
	case 'Delete': var_dump($action); break;
	default : redirect_Accueil(); break;
	}
	*/	
    

