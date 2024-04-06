<?php if(!isset($_SESSION)){
    session_start();
}
	function verifier(){
        $bdd= bddConnection();
        $req = $bdd->prepare('SELECT userlogin_client, password_client  FROM `client` ');
		$req->execute();
		while( $donnee = $req->fetch(PDO::FETCH_ASSOC) ) {
			$tab[$donnee['nom_categorie'] ] =  $donnee['id_categorie'];
		}
		return $tab;
	}

	function checkClient($user, $hashedPass) {
		$bdd= bddConnection();
		$stmt = $bdd->prepare("SELECT
									*
								FROM 
									client 
								WHERE 
									userlogin_client = ?
								AND 
									password_client = ? ");
        $stmt->execute(array($user, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        return $count;
	}	 