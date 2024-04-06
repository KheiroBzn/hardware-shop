<?php

    if(!isset($_SESSION)){
        session_start();
    }

    //For Errors
    $emailError = '';
    $passError = '';
    $usernameError = '';
    $prenomError = '';
    $nomError = '';
    $telephoneError = '';
    $adresseError = '';

    include_once $_SERVER['DOCUMENT_ROOT'] . "/Model/signModel.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();

        if( isset($_POST['email']) && !empty($_POST['email']) ) {
            if(!isValideEmail($_POST['email'])) {
                $emailError = 'Email non valide';
                $formErrors[] = $emailError;
            } elseif(isExistEmail($_POST['email'])) {
                $emailError = 'Email existe déja';
                $formErrors[] = $emailError;
            }
        } else {
            $emailError = 'Champ obligatoire!';
            $formErrors[] = $emailError;
        }

        if( isset($_POST['pass']) && !empty($_POST['pass']) ) {
            if(strlen($_POST['pass']) < 8 && strlen($_POST['pass']) > 0) {
                $passError = 'Mot de passe trop court! (8 caractère au minimum)';
                $formErrors[] = $passError;
            }
        } else {
            $passError = 'Champ obligatoire!';
            $formErrors[] = $passError;
        }

        if( isset($_POST['username']) && !empty($_POST['username']) ) {
            if(strlen($_POST['username']) < 4 && strlen($_POST['username']) > 0) {
                $usernameError = 'Nom d\'utilisateur ne peut pas avoir moins de 4 caractères';
                $formErrors[] = $usernameError;
            } elseif(isExistUsername($_POST['username'])) {
                $usernameError = 'Nom d\'utilisateur existe déja';
                $formErrors[] = $usernameError;
            } elseif(!isValideUsername($_POST['username'])) {
                $usernameError = 'Nom d\'utilisateur non valide (doit commencer par un alphabet et contenir que des caractéres alphanumérique)';
                $formErrors[] = $usernameError;
            }
        } else {
            $usernameError = 'Champ obligatoire!';
            $formErrors[] = $usernameError;
        }

        if( isset($_POST['prenom']) && !empty($_POST['prenom']) ) {
            if(!isAlpha($_POST['prenom'])) {
                $prenomError = 'Uniquement des lettres alphabetiques seront acceptés pour ce champ!';
                $formErrors[] = $prenomError;
            }
        } else {
            $prenomError = 'Champ obligatoire!';
            $formErrors[] = $prenomError;
        }

        if( isset($_POST['nom']) && !empty($_POST['nom']) ) {
            if(!isAlpha($_POST['nom'])) {
                $nomError = 'Uniquement des lettres alphabetiques seront acceptés pour ce champ!';
                $formErrors[] = $nomError;
            }
        } else {
            $nomError = 'Champ obligatoire!';
            $formErrors[] = $nomError;
        }

        if( !isset($_POST['adresse']) || empty($_POST['adresse']) ) {
            $adresseError = 'Champ obligatoire!';
            $formErrors[] = $adresseError;
        }

        if( isset($_POST['phone']) && !empty($_POST['phone']) ) {
            if(isExistPhone($_POST['phone'])) {
                $telephoneError = 'Numéro de téléphone existe déja';
                $formErrors[] = $telephoneError;
            }
        } else {
            $telephoneError = 'Champ obligatoire!';
            $formErrors[] = $telephoneError;
        }

        if( !isset($_POST['dateNaissance']) || empty($_POST['dateNaissance']) ) {
            $_POST['dateNaissance'] = null;
        }

        if( !isset($_POST['genre']) || empty($_POST['genre']) ) {
            $formErrors[] = 'Champ manquant!';
        }

        if(empty($formErrors)) {
            $count = checkItem("userlogin_client", "client", $_POST['username']);
            if($count == 0) {
                addUser($_POST['email'],
                        $_POST['pass'],
                        $_POST['username'],
                        $_POST['prenom'],
                        $_POST['nom'],
                 $_POST['adresse'].' - '.$_POST['ville'],
                        $_POST['phone'],
                        $_POST['dateNaissance'],
                        $_POST['genre']);
                redirect_Connexion();
            }
        } else {
            // For POST Values
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
            $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
            $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
            $telephone = isset($_POST['phone']) ? $_POST['phone'] : '';
            $dateN = isset($_POST['dateNaissance']) ? $_POST['dateNaissance'] : '';
            $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
            $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
        }
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . "/Vue/signVue.php";
