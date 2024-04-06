<?php

    include 'connect.php';

    // Routes

    $tpl    = 'includes/templates/'; // Templates Directory
    $func   = 'includes/functions/'; // Functions Directory
    $css    = 'layout/css/'; // CSS Directory
    $js     = 'layout/js/'; // JavaScript Directory
    $img    = 'layout/images/'; // JavaScript Directory

    // include the important files

    include $func . 'functions.php';
    include $tpl . 'header.php';

    // include Navbar on all pages expect the one with noNavvar variable

    if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }

?>