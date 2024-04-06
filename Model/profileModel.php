<?php

    function getInformationByUserName($username) {
        $bdd = bddConnection();
		$req = $bdd->prepare('SELECT * FROM `client` where userlogin_client = :userlogin;');
		$req->execute( array('userlogin' => $username ) );
		return $req->fetch();
    }

    function getAllOrdersById($userId) {
        $bdd = bddConnection();
        $req = $bdd->prepare("SELECT * FROM `commande`
             where id_client = :id_client ORDER BY id_commande DESC;");
        $req->execute( array('id_client' => $userId) );
        return $req->fetchAll();
    }

    function getHistoAchatById($userId) {
        $bdd = bddConnection();
        $req = $bdd->prepare("SELECT * FROM `commande`
                 where etat_commande = `VALIDE` and id_client = :id_client ORDER BY id_commande DESC;");
        $req->execute( array('id_client' => $userId) );
        return $req->fetchAll();
    }

    function getLastOrdersById($userId, $limit=3) {
        $bdd = bddConnection();
		$req = $bdd->prepare("SELECT * FROM `commande`
         where id_client = :id_client ORDER BY id_commande DESC LIMIT $limit;");
		$req->execute( array('id_client' => $userId) );
		return $req->fetchAll();
    }

    function getLastCommentsByUsername($username, $limit=3) {
        $bdd = bddConnection();
        $userID = getInformationByUserName($username)['id_utilisateur'];
        $req = $bdd->prepare("SELECT * FROM `commentaire`
             where id_utilisateur = :id_utilisateur ORDER BY id_commentaire DESC LIMIT $limit;");
        $req->execute( array('id_utilisateur' => $userID) );
        return $req->fetchAll();
    }

    function getArticlesLastOrdersById($orderId) {
        $bdd = bddConnection();
		$req = $bdd->prepare("SELECT quantite_commande.*, article.* FROM quantite_commande
                                INNER JOIN article ON article.id_article = quantite_commande.id_article
                                WHERE quantite_commande.id_commande = :id_commande");
		$req->execute( array('id_commande' => $orderId) );
		return $req->fetchAll();
    }

    function getNomArticle($id_article){
        $bdd = bddConnection();
        $req = $bdd->prepare('SELECT nom_article FROM `article` where id_article=:id_article;');
        $req->execute( array( 'id_article' => $id_article ) );
        return $req->fetch(PDO::FETCH_ASSOC)['nom_article'];
    }

    function getLivraison($id_clent){
        $bdd = bddConnection();
        $req = $bdd->prepare('SELECT * FROM `livraicon` where id_client=:id_client;');
        $req->execute( array( 'id_client' => $id_clent ) );
        return $req->fetchAll();
    }

    function modifAdresseLivraison($oldUsername, $nvAdresseLivraison) {
        $bdd = bddConnection();
        $req = $bdd->prepare('UPDATE client SET adresse_livraison = ? where userlogin_client = ?;');
        $req->execute( array( $nvAdresseLivraison, $oldUsername ) );
    }

    function updateUser($email, $nvPass, $newUsername, $prenom, $nom, $adresse, $telephone, $dateN, $genre, $oldUsername) {
        $bdd = bddConnection();
        $req = $bdd->prepare("UPDATE client SET nom_client = ?, 
                                                        prenom_client = ?,
                                                        email_client = ?, 
                                                        userlogin_client = ?, 
                                                        password_client = ?, 
                                                        adresse_client = ?, 
                                                        numero_tel_client = ?,
                                                        date_naissance_client = ?, 
                                                        sexe_client = ?
                                        WHERE userlogin_client = ?");
        $req->execute(array( $nom, $prenom, $email, $newUsername, $nvPass, $adresse, $telephone, $dateN, $genre, $oldUsername));
    }

    function getModePayment($id_payment) {
        $bdd = bddConnection();
        $req = $bdd->prepare("SELECT type_payment FROM payment WHERE id_payment = ?");
        $req->execute( array( $id_payment ) );
        return $req->fetch()['type_payment'];
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