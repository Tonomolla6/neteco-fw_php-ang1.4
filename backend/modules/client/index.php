<?php
    // Module
    define('MODULE', 'modules/'.$_SESSION["type"].'/');

    // Cargamos la informacion del modulo.
    require MODULE."paths.php";
    require MODULE."autoload.php";

    // Utils
    foreach (glob(MODULE. 'utils/*.inc.php') as $name) 
        require $name;

    if (PRODUCTION) { // estamos en producción
        ini_set('display_errors', '1');
        ini_set('error_reporting', E_ERROR | E_WARNING); // error_reporting(E_ALL) ;
    } else {
        ini_set('display_errors', '0');
        ini_set('error_reporting', '0'); // error_reporting(0);
    }

    include MODULE."modules/cart/model/DAO/cart_dao.class.singleton.php";
    require MODULE."router/router.php";
?>