<?php if(!isset($_SESSION)){
    session_start();
}
	include $_SERVER['DOCUMENT_ROOT'] . './template.php';
    
    // Affiche la liste de tous les billets du blog
    function accueil(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/accueil.php';
    }

    function dashboard() {
        include  $_SERVER['DOCUMENT_ROOT'] . '/admin/index.php';
    }

    function categorie() {
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/categorie.php';
    }

    function sousCategorie(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/souscategorie.php';
    }

    function connexion(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/log.php';
    }

    function profile(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/profile.php';
    }

    function payment(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/payment.php';
    }

    function inscription(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/sign.php';
    }

    function article(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/article.php';
    }

    function erreur(){
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/erreur.php';
    }

    function panier() {
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/panier.php';
    }

    function recherche() {
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/recherche.php';
    }

    function faq() {
        include  $_SERVER['DOCUMENT_ROOT'] . '/Controleur/faq.php';
    }