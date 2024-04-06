<?php if(!isset($_SESSION)){
    session_start();
}

    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Model/paymentModel.php";

    $prix_total = isset($_SESSION['panier']['prix_total']) ? $_SESSION['panier']['prix_total'] : 0;
    $nombre_article_facture  = isset($_SESSION['panier']['nombre_exemplaire_article']) ? $_SESSION['panier']['nombre_exemplaire_article'] : 0;

    include  $_SERVER['DOCUMENT_ROOT'] . "/Vue/paymentVue.php" ;

    if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['payment'])) {
        $type = $_POST['payment'];
        if(isset($_SESSION['id_client']) and !empty($_SESSION['id_client'])) {
            if($type == 'ccp') {
                $id_commande = ajouterCommande($_SESSION['id_client'], 'EN COUR', 'CCP');
                creerLivraison($id_commande, $_SESSION['id_client']);
                creerFacture($prix_total, $nombre_article_facture, $id_commande, $_SESSION['id_client']);
            } elseif ($type == 'livraison') {
                $id_commande = ajouterCommande($_SESSION['id_client'], 'VALIDE', 'A LA LIVRAISON');
            } else {
                echo "Mode de payement indisponible";
            }

            $i = 0;
            while (!empty($_SESSION['panier']['id_article'][$i])) {
                ajouterQteCommande($id_commande, $_SESSION['panier']['id_article'][$i], $_SESSION['panier']['qte_article'][$i]);
                $i++;
            }

            unset($_SESSION['panier']);
            header('Location: /Profile');
        }
    }


