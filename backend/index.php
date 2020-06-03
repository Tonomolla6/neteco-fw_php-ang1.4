<?php
    //Iniciamos la session
    session_start();

    //Comprobamos la session
    $default = "client";

    if (isset($_SESSION["type"]))
        require "modules/".$_SESSION["type"]."/index.php";
    else {
        $_SESSION["type"] = $default;
        require "modules/".$default."/index.php";
    }
?>