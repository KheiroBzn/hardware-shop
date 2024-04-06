<?php

    function getTitle() {

        global $pageTitle;

        if(isset($pageTitle)) {

            return $pageTitle;

        } else {

            return 'Default';

        }

    }

    // redirect function

    function redirect($Msg, $url = null, $seconds = 3) {

        if($url == null) {

            $url = 'index.php';
            $link = 'Acceuil';

        } elseif($url == 'back') {

            if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {

                $url = $_SERVER['HTTP_REFERER'];
                $link = 'Page précédente';

            } else {

                $url = 'index.php';
                $link = 'Acceuil';
            }
        }

        $link = $url;

        echo $Msg;

        echo "<div class='container alert alert-info'>";
            echo "Vous serez redirigé vers la page '". getTitle() ."' dans $seconds seconde(s).";
        echo "</div>";

        header("refresh:$seconds; url=$url");

        exit();

    }

    // Check If Item Exists
    /**
     ** $select : item to select
     ** $from : table to select from
     ** $value : the value of select
     ** 
     **/

    function checkItem($select, $from, $value, $query = '', $queryValue = null) {
        
        global $connect;

        $statement = $connect->prepare("SELECT $select FROM $from WHERE $select = ? $query");

        if($queryValue == null && $query == '') {

            $statement->execute(array($value));
        } else {

            $statement->execute(array($value, $queryValue));
        }

        $count = $statement->rowCount();

        return $count;
    }

    // Count Number Of Items

    function countItem($item, $table, $query = '', $value = null) {

        global $connect;

        $statement = $connect->prepare("SELECT COUNT($item) FROM $table $query");

        if($value != null && $query != '') {

            $statement->execute(array($value));
        } else {

            $statement->execute();
        }
            

        return $statement->fetchColumn();
    }

    // Get Latest Items

    function getLatest($select, $table, $query = '', $order, $limit = 5) {

        global $connect;

        $getStmt = $connect->prepare("SELECT $select FROM $table $query ORDER BY $order DESC LIMIT $limit");

        $getStmt->execute();

        $rows = $getStmt->fetchAll();

        return $rows;

    }

    function checkUserGroup($id_client) {
        global $connect;
        $stmt = $connect->prepare("SELECT id_utilisateur FROM client WHERE id_client = ?");
        $stmt->execute(array($id_client));
        $userID = $stmt->fetch()['id_utilisateur'];
        $req = $connect->prepare("SELECT group_utilisateur FROM utilisateur WHERE id_utilisateur = ?");
        $req->execute(array($userID));
        return $req->fetch()['group_utilisateur'];
    }

