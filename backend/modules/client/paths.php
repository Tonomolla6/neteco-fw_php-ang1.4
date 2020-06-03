<?php
    define('ROOT', '/framework-php/');

    //MODULE
    define('PROJECT', ROOT . 'modules/'.$_SESSION["type"].'/');

    //SITE_ROOT
    define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . PROJECT);
    
    //SITE_PATH
    define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

    //TRANSLATE
    define('TRANSLATE', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

    //CSS
    define('CSS_PATH', SITE_PATH . 'view/css/');
    
    //JS
    define('JS_PATH', SITE_PATH . 'view/js/');
    
    //LIBRARIES
    define('LIBRARIES_PATH', SITE_PATH . 'view/libraries/');
    
    //IMG
    define('IMG_PATH', SITE_PATH . 'view/img/');
    
    //PRODUCTION
    define('PRODUCTION', true);
    
    //MODEL
    define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . ROOT . 'model/');

    //MODEL
    define('CONTROLLER', SITE_ROOT . 'controller/');
    
    //MODULES
    define('MODULES_PATH', SITE_ROOT . 'modules/');
    
    // Module
    define('MODULE', 'modules/'.$_SESSION["type"].'/');

    //VIEW
    define('VIEW_PATH_INC', SITE_ROOT . 'view/inc/');
    
    //RESOURCES
    define('RESOURCES', SITE_ROOT . 'resources/');
    
    //MEDIA
    define('MEDIA_PATH',SITE_ROOT . '/media/');
    
    //UTILS
    define('UTILS', SITE_ROOT . 'utils/');

    //MODULES
    $modules = simplexml_load_file(RESOURCES.'modules.xml');
    $define_name = array('MODEL_PATH_','DAO_','BLL_','MODEL_','JS_VIEW_');
    $define_path = array('model/','model/DAO/','model/BLL/','model/model/','view/js/');

    foreach ($modules->module as $module) {
        $module = $module->name;
        for ($d=0; $d < count($define_name); $d++)
            define($define_name[$d].strtoupper($module), SITE_ROOT . 'modules/'.strtolower($module)."/".$define_path[$d]);
            // echo $define_name[$d].strtoupper($module).",". SITE_ROOT . 'modules/'.strtolower($module)."/".$define_path[$d]."\n";
    }

    //MODULE_FONT
    define('MODEL_PATH_FRONT', SITE_ROOT . 'model/');
    define('DAO_FRONT', SITE_ROOT . 'model/DAO/');
    define('BLL_FRONT', SITE_ROOT . 'model/BLL/');
    define('MODEL_FRONT', SITE_ROOT . 'model/model/');
    define('JS_VIEW_FRONT', SITE_PATH . 'view/js/');


    //FRIENDLY
    define('URL_AMIGABLES', TRUE);
