<?php

    session_start();     // Start the session
    session_unset();     // Unset Data
    session_destroy();   // Destroy the session

    header('Location: index.php');
    exit();

