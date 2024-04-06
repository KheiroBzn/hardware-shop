<?php

    function ajouterCommande($id_client, $etat_commande, $type_payment ) {
        $bdd = bddConnection();
        $stmt = $bdd->prepare("SELECT id_payment from payment WHERE type_payment = ?");
        $stmt->execute(array($type_payment));
        $id_payment = $stmt->fetch()['id_payment'];

        $req = $bdd->prepare("INSERT INTO commande(date_commande, etat_commande, id_client, id_payment) VALUES(NOW(), ?, ?, ?)");
        $req->execute(array($etat_commande, $id_client, $id_payment ));
        return $bdd->lastInsertId();
    }

    function ajouterQteCommande($id_commande, $id_article, $qte_commande) {
        $bdd= bddConnection();
        $req = $bdd->prepare("INSERT INTO  quantite_commande(id_commande, id_article, quantite_article_commande) 
                                            VALUES(?, ?, ?)");
        $req->execute(array( $id_commande, $id_article, $qte_commande ));
    }

    function creerLivraison($id_commande, $id_client){
        $bdd= bddConnection();
        $stmt = $bdd->prepare("SELECT adresse_livraison, adresse_client from client WHERE id_client = ?");
        $stmt->execute(array($id_client));
        $row = $stmt->fetch();
        $adresse_livraison = !empty($row['adresse_livraison']) ? $row['adresse_livraison'] : $row['adresse_client'];
        $frais_livraison = fraisLivraison($id_commande);
        var_dump($adresse_livraison);
        var_dump($frais_livraison);
        $req = $bdd->prepare("INSERT INTO livraison(adresse_livraison , frais_livraison, id_commande, id_client ) 
                                            VALUES(?, ?, ?, ?)");
        $req->execute(array( $adresse_livraison, $frais_livraison, $id_commande, $id_client ));
    }

    function creerFacture($prix_total, $nombre_article_facture, $id_commande, $id_client) {
        $bdd= bddConnection();
        $req = $bdd->prepare("INSERT INTO facture(prix_total_facture , nombre_article_facture, date_facture, id_client, id_commande ) 
                                            VALUES(?, ?, NOW(), ?, ?)");
        $req->execute(array( $prix_total, $nombre_article_facture, $id_client, $id_commande ));
    }

    function fraisLivraison($id_commande) {
    $bdd = bddConnection();
    $req = $bdd->prepare("SELECT id_client FROM commande WHERE id_commande = ?");
    $req->execute( array( $id_commande ) );
    $id_client = $req->fetch()['id_client'];

    $req1 = $bdd->prepare("SELECT adresse_client FROM client WHERE id_client = ?");
    $req1->execute( array( $id_client ) );
    $adresse = $req1->fetch()['adresse_client'];
    $ville = explode(' - ', $adresse, 2)[0];
    switch ($ville) {
        case 'Adrar':
            redirect_Accueil();
            break;

        case 'Adrar': return 10000;

        case 'Laghouat': return 6000;

        case 'Oum el Bouaghi': return 5000;

        case 'Batna': return 5000;

        case 'Béjaia': return 6000;

        case 'Biskra': return 7000;

        case 'Bechar': return 6000;

        case 'Blida': return 5000;

        case 'Bouira': return 5000;

        case 'Tamanghasset': return 10000;

        case 'Tébessa'; return 7000;

        case 'Tlemcen': return 0;

        case 'Tiaret': return 3000;

        case 'Tizi Ouzou': return 6000;

        case 'Alger': return 5000;

        case 'Djelfa': return 5000;

        case 'Jijel': return 6000;

        case 'Setif': return 5000;

        case 'Saida': return 5000;

        case 'Skikda': return 7000;

        case 'Sidi Bel Abbes': return 1000;

        case 'Annaba': return 7000;

        case 'Guelma': return 7000;

        case 'Constantine': return 7000;

        case 'Médéa': return 4000;

        case 'Mostaganem': return 2000;

        case 'Msila': return 5000;

        case 'Mascara': return 2000;

        case 'Ouargla': return 7000;

        case 'Oran': return 1200;

        case 'El Bayadh': return 5000;

        case 'Illizi': return 12000;

        case 'Bordj Bou Arreridj': return 5000;

        case 'Boumerdès': return 5000;

        case 'El Tarf': return 7500;

        case 'Tindouf': return 7000;

        case 'Tissemsilt': return 5000;

        case 'El Oued': return 7000;

        case 'Khenchela': return 7000;

        case 'Souk Ahras': return 7000;

        case 'Tipaza': return 5000;

        case 'Mila': return 6000;

        case 'Ain Defla': return 4000;

        case 'Naama': return 1500;

        case 'Ain Temouchent': return 1000;

        case 'Ghardaia': return 5000;

        case 'Relizane': return 2000;

        default: return 0;
    }
}