<?php
	if(!isset($_SESSION)){
		session_start();
    }

    function isValideEmail($email) {
        return true;
    }

    function isExistEmail($email) {
	    $count = checkItem('email_client', 'client', $email);
	    if($count > 0) return true;
	    else return false;
    }

    function isValideUsername($username) {
        preg_match("/([^A-Za-z0-9\s])/", $username, $result);
        if (empty($result) && IntlChar::isalpha((String)$username[0])) return true;
        return false;
    }

    function isExistUsername($username) {
        $count = checkItem('userlogin_client', 'client', $username);
        if($count > 0) return true;
        else return false;
    }

	function isAlpha($string) {
        preg_match("/([^A-Za-z\s])/", $string, $result);
        return !empty($result) ? false : true;
    }

    function isExistPhone($telephone) {
        $count = checkItem('numero_tel_client', 'client', $telephone);
        if($count > 0) return true;
        else return false;
    }
    
    function checkItem($select, $from, $value, $query = '', $queryValue = null) {        
        $bdd= bddConnection();
        $statement = $bdd->prepare("SELECT $select FROM $from WHERE $select = ? $query");
        if($queryValue == null && $query == '') {
            $statement->execute(array($value));
        } else {
            $statement->execute(array($value, $queryValue));
        }
        $count = $statement->rowCount();
        return $count;
    }
	
    function addUser($email, $pass, $username, $prenom, $nom, $adresse, $telephone, $dateN, $genre) {
        $group = 'CLIENT';
        $hachPass = sha1($pass);
        $bdd= bddConnection();
        $stmt = $bdd->prepare("INSERT INTO utilisateur(group_utilisateur)
                                        VALUE(:zgroup)");
        $stmt->execute(array('zgroup' => $group));
        $userid = $bdd->lastInsertId();
        $date_inscription = date("Y-m-d H:i:s");
        $req = $bdd->prepare("INSERT INTO  client(nom_client, 
                                                    prenom_client,
                                                    email_client, 
                                                    userlogin_client, 
                                                    password_client, 
                                                    adresse_client, 
                                                    numero_tel_client,
                                                    date_naissance_client, 
                                                    sexe_client, 
                                                    date_inscription, 
                                                    approuvation, 
                                                    id_utilisateur)
                                        VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array( $nom, $prenom, $email, $username, $hachPass, $adresse, $telephone, $dateN, $genre, $date_inscription, 'APPROUVE', $userid ));
    }
    