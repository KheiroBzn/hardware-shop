<?php if(!isset($_SESSION)){
    session_start();
}
  //  include_once  $_SERVER['DOCUMENT_ROOT'] . './template.php';
    include_once  $_SERVER['DOCUMENT_ROOT'] .  "/Model/profileModel.php";
    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Model/signModel.php";

    $oldUsername = $_SESSION['userlogin_client'];
    $userInfos = getInformationByUserName($oldUsername);
    $oldPass = isset($userInfos['password_client']) ? $userInfos['password_client'] : '';

    $email     = isset($_POST['email']) ? $_POST['email'] : $userInfos['email_client'];
    $pass      = (isset($_POST['nvPasss']) and !empty($_POST['nvPasss'])) ? sha1($_POST['nvPasss']) : $userInfos['password_client'];
    $username  = isset($_POST['username']) ? $_POST['username'] : $userInfos['userlogin_client'];
    $prenom    = isset($_POST['prenom']) ? $_POST['prenom'] : $userInfos['prenom_client'];
    $nom       = isset($_POST['nom']) ? $_POST['nom'] : $userInfos['nom_client'];
    $adresse   = (isset($_POST['adresse']) and isset($_POST['ville'])) ? $_POST['ville'].' - '.$_POST['adresse'] : $userInfos['adresse_client'];
    $telephone = isset($_POST['phone']) ? $_POST['phone'] : $userInfos['numero_tel_client'];
    $dateN     = isset($_POST['dateNaissance']) ? $_POST['dateNaissance'] : $userInfos['date_naissance_client'];
    $genre     = isset($_POST['genre']) ? $_POST['genre'] : $userInfos['sexe_client'];
    $adresseLivraison = isset($_POST['adresseLivraison']) ? $_POST['adresseLivraison'] : $userInfos['adresse_livraison'];

    //For Errors
    $emailError = '';
    $passError = '';
    $nvPassError = '';
    $confirmNvPassError = '';
    $usernameError = '';
    $prenomError = '';
    $nomError = '';
    $telephoneError = '';
    $adresseError = '';

    $displayForm = '';
    $disabled = 'disabled';

    $current_order_display = false;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(!isset($_POST['adresseLivraison']) and !isset($_POST['orderID'])) {
            $formErrors = array();

            if( isset($_POST['email']) && !empty($_POST['email']) ) {
                if(!isValideEmail($_POST['email'])) {
                    $emailError = 'Email non valide';
                    $formErrors[] = $emailError;
                } elseif ($_POST['email'] !== $email AND isExistEmail($_POST['email'])) {
                    $emailError = 'Email existe déja';
                    $formErrors[] = $emailError;
                } else {
                    $email = $_POST['email'];
                }
            } else {
                $emailError = 'Champ obligatoire!';
                $formErrors[] = $emailError;
            }

            if( isset($_POST['oldPasss']) && !empty($_POST['oldPasss']) ) {
                if (sha1($_POST['oldPasss']) !== $oldPass) {
                    $passError = 'Mot de passe incorrect!';
                    $formErrors[] = $passError;
                } else {
                    if (isset($_POST['nvPasss']) && !empty($_POST['nvPasss'])) {
                        if (strlen($_POST['nvPasss']) < 8 && strlen($_POST['nvPasss']) > 0) {
                            $nvPassError = 'Mot de passe trop court! (8 caractère au minimum)';
                            $formErrors[] = $nvPassError;
                        } else {
                            if (isset($_POST['confirmNvPasss']) && !empty($_POST['confirmNvPasss'])) {
                                if ($_POST['confirmNvPasss'] !== $_POST['nvPasss']) {
                                    $confirmNvPassError = 'Mots de passe non identiques!';
                                    $formErrors[] = $confirmNvPassError;
                                } else {
                                    $pass = sha1($_POST['nvPasss']);
                                }
                            } else {
                                $confirmNvPassError = 'Champ obligatoire!';
                                $formErrors[] = $confirmNvPassError;
                            }
                        }
                    } else {
                        $nvPassError = 'Champ obligatoire!';
                        $formErrors[] = $nvPassError;
                    }
                }
            }

            if( isset($_POST['username']) && !empty($_POST['username']) ) {
                if(strlen($_POST['username']) < 4 && strlen($_POST['username']) > 0) {
                    $usernameError = 'Nom d\'utilisateur ne peut pas avoir moins de 4 caractères';
                    $formErrors[] = $usernameError;
                } elseif(!isValideUsername($_POST['username'])) {
                    $usernameError = 'Nom d\'utilisateur non valide (doit commencer par un alphabet et contenir que des caractéres alphanumérique)';
                    $formErrors[] = $usernameError;
                } elseif ($_POST['username'] !== $oldUsername AND isExistUsername($_POST['username'])) {
                    $usernameError = 'Nom d\'utilisateur existe déja';
                    $formErrors[] = $usernameError;
                } else {
                    $username = $_POST['username'];
                }
            } else {
                $usernameError = 'Champ obligatoire!';
                $formErrors[] = $usernameError;
            }

            if( isset($_POST['prenom']) && !empty($_POST['prenom']) ) {
                if(!isAlpha($_POST['prenom'])) {
                    $prenomError = 'Uniquement des lettres alphabetiques seront acceptés pour ce champ!';
                    $formErrors[] = $prenomError;
                } else {
                    $prenom = $_POST['prenom'];
                }
            } else {
                $prenomError = 'Champ obligatoire!';
                $formErrors[] = $prenomError;
            }

            if( isset($_POST['nom']) && !empty($_POST['nom']) ) {
                if(!isAlpha($_POST['nom'])) {
                    $nomError = 'Uniquement des lettres alphabetiques seront acceptés pour ce champ!';
                    $formErrors[] = $nomError;
                } else {
                    $nom = $_POST['nom'];
                }
            } else {
                $nomError = 'Champ obligatoire!';
                $formErrors[] = $nomError;
            }

            if( isset($_POST['adresse']) && !empty($_POST['adresse']) ) {
                if( isset($_POST['ville']) && !empty($_POST['ville'])) {
                    $adresse = '';
                    $adresse = $_POST['ville'].' - '.$_POST['adresse'];
                }
            } else {
                $adresseError = 'Champ obligatoire!';
                $formErrors[] = $adresseError;
            }

            if( isset($_POST['phone']) && !empty($_POST['phone']) ) {
                if($_POST['phone'] !== $telephone AND isExistPhone($_POST['phone'])) {
                    $telephoneError = 'Numéro de téléphone existe déja';
                    $formErrors[] = $telephoneError;
                } else {
                    $telephone = $_POST['phone'];
                }
            } else {
                $telephoneError = 'Champ obligatoire!';
                $formErrors[] = $telephoneError;
            }

            if( isset($_POST['dateNaissance']) && !empty($_POST['dateNaissance']) ) {
                $dateN = $_POST['dateNaissance'];
            }

            if( isset($_POST['genre']) && !empty($_POST['genre']) ) {
                $genre = $_POST['genre'];
            } else $formErrors[] = 'Champ obligatoire!';

            if(empty($formErrors)) {
                updateUser( $email, $pass, $username, $prenom, $nom, $adresse, $telephone, $dateN, $genre, $oldUsername );
                $_SESSION['userlogin_client'] = $username;
                $userInfos = getInformationByUserName($username);
                $email     = $userInfos['email_client'];
                $pass      = $userInfos['password_client'];
                $username  = $userInfos['userlogin_client'];
                $prenom    = $userInfos['prenom_client'];
                $nom       = $userInfos['nom_client'];
                $adresse   = $userInfos['adresse_client'];
                $telephone = $userInfos['numero_tel_client'];
                $dateN     = $userInfos['date_naissance_client'];
                $genre     = $userInfos['sexe_client'];
            } else {
                $displayForm = 'ok';
                $disabled = '';
            }
        } elseif( isset($_POST['orderID']) && !empty($_POST['orderID']) ) {
            $current_order_display = true;
        } elseif( isset($_POST['adresseLivraison']) && !empty($_POST['adresseLivraison']) ) {
            modifAdresseLivraison($oldUsername, $adresseLivraison);
        }
    }

    include_once  $_SERVER['DOCUMENT_ROOT'] . "/Vue/profileVue.php";