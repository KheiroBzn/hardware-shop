<?php

    $dsn = 'mysql:host=localhost;dbname=hwshop';
    $user = 'root';
    $pass = '';
    $options = array (
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {

        $connect = new PDO($dsn, $user, $pass, $options);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch ( PDOExcetion $e ) {
        echo 'failed to connect' . $e->getMessage();
    }

?>