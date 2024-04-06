<?php

    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Model/logModel.php";

    $passError = '';
    $usernameError = '';
    $formErrors = array();

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        if( isset($_POST['user']) && !empty($_POST['user']) ) {
            if (isExistUsername($_POST['user'])) {
                if( isset($_POST['pass']) && !empty($_POST['pass'])) {
                    if(!isValidLogin($_POST['user'], $_POST['pass'])) {
                        $passError = 'Mot de passe incorrect!';
                        $formErrors[] = $passError;
                    }
                } else {
                    $passError = 'Mot de passe vide!';
                    $formErrors[] = $passError;
                }
            } else {
                $usernameError = 'Nom d\'utilisateur invalide!';
                $formErrors[] = $usernameError;
            }
            if(empty($formErrors)) {
                $_SESSION['userlogin_client'] = $_POST['user'];
                $_SESSION['id_client'] =  getIdByUsername($_POST['user']);
                $_SESSION['group'] = checkUserGroup($_SESSION['id_client']);
                redirect_Profile();
                exit();
                /*
                if($_SESSION['group']  == 'ADMIN') {
                    redirect_Dashboard();
                    exit();
                } else {
                    redirect_Profile();
                    exit();
                }
                */

            } else {
                $username = isset($_POST['user']) ? $_POST['user'] : '';
                $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
            }
        }
    }

    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Vue/logVue.php";