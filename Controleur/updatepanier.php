<?php if(!isset($_SESSION)){
    session_start();
}


$qte_total=0;
if(isset($_SESSION['panier']['qte_total']) and !empty($_SESSION['panier']['qte_total']) )
    $qte_total=$_SESSION['panier']['qte_total'];

header('Content-type: application/json');
echo json_encode(array("qteTotal"=>$qte_total));

