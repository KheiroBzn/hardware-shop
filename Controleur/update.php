<?php if(!isset($_SESSION)){
    session_start();
}

$numberperpage=NULL;
if(isset($_SESSION['number-per-page']))
    $numberperpage=$_SESSION['number-per-page'];

$orderselect=NULL;
if(isset($_SESSION['order-select']))
    $orderselect=$_SESSION['order-select'];

$filterjson=[];
if(isset($_SESSION['json-filter']))
    $filterjson=$_SESSION['json-filter'];


$price= array();
if(isset($_SESSION['price-range']) and !empty($_SESSION['price-range'])  ){
    $price['min']=$_SESSION['price-range'][0];
    $price['max']=$_SESSION['price-range'][1];
}

$marque= array();
if(isset($_SESSION['marque-filter']))
    $marque= $_SESSION['marque-filter'];

$more_filter= array();
if(isset($_SESSION['more-filter'])){
    $more_filter['disponible']=$_SESSION['more-filter']['disponible'];
    $more_filter['indisponible']=$_SESSION['more-filter']['indisponible'];
}    

header('Content-type: application/json');
echo json_encode(array("moreFilter"=>$more_filter,"marqueFilter"=>$marque,"prix"=>$price,'filterJson'=>$filterjson,'numberPerPage'=>$numberperpage,'orderSelect'=>$orderselect));

