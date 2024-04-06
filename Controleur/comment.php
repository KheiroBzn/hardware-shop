<?php
    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Model/commentModel.php";
    
	// Check if User coming from HTTP Post Request

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        
        if( isset($_POST['comment']) && !empty($_POST['comment']) ) {

            if( !isset($_POST['Password']) || empty($_POST['Password']))
                phpAlert("Mot de passe Vide");
            else{
                phpAlert("Bien");
            }
        }

        $user = $_POST['user'];
        $pass = $_POST['pass'];
		$hashedPass = sha1($pass);

        // Check if User exists in DataBase

        $count = checkClient($user, $hashedPass);
        
        // If count > 0 This means that the Database contain record about this username

        if( $count > 0 ) {

			$_SESSION['userlogin_client'] = $user; // Register Session Name
			$_SESSION['prenom_client'] = $row['prenom_client'];
			$_SESSION['sexe_client'] = $row['sexe_client'];
            $_SESSION['id'] = $row['id_client']; // Register Session ID
            redirect_Accueil();  // Redirect To Home Page
            exit();            
        }
    }	