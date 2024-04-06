<?php if(!isset($_SESSION)){
    session_start();
}
    include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/erreurVue.php" ;