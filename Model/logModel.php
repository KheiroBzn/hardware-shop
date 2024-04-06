<?php
	if(!isset($_SESSION)){
		session_start();
	}

	function isExistUsername($username) {
        $bdd= bddConnection();
        $stmt = $bdd->prepare("SELECT id_client FROM client WHERE userlogin_client = ?");
        $stmt->execute(array($username));
        $count = $stmt->rowCount();
        return $count > 0;
    }

    function isValidLogin($username, $pass) {
        $hashedPass = sha1($pass);
        $bdd= bddConnection();
        $stmt = $bdd->prepare("SELECT * FROM client WHERE userlogin_client = ? AND password_client = ? ");
        $stmt->execute(array($username, $hashedPass));
        $count = $stmt->rowCount();
        return $count > 0;
    }

	function getIdByUsername($username) {
        $bdd= bddConnection();
        $stmt = $bdd->prepare("SELECT id_client FROM client WHERE userlogin_client = ?");
        $stmt->execute(array($username));
        return $stmt->fetch()['id_client'];
    }

	function checkUserGroup($id_client) {
        $bdd= bddConnection();
        $stmt = $bdd->prepare("SELECT id_utilisateur FROM client WHERE id_client = ?");
        $stmt->execute(array($id_client));
        $userID = $stmt->fetch()['id_utilisateur'];
        $req = $bdd->prepare("SELECT group_utilisateur FROM utilisateur WHERE id_utilisateur = ?");
        $req->execute(array($userID));
        return $req->fetch()['group_utilisateur'];
    }