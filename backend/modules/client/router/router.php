<?php
    ob_start();
    session_start();

    function handlerRouter() {
       // Comprobamos header del cliente por post.
        if ($_GET['module'] == "client")
            handlerFront($_GET['module'],$_GET['function']);
        else {
            // Comprobamos el modulo por get.
            if (!empty($_GET['module']))
                $URI_module = $_GET['module'];
            else
                $URI_module = 'home';

            // Comprobamos la funcion por get.
            if (!empty($_GET['function']))
                $URI_function = $_GET['function'];
            else
                $URI_function = false;
            
            handlerModule($URI_module, $URI_function);
        }
    }

    function handlerModule($URI_module, $URI_function) {
        // Importamos los modulos.
        $modules = simplexml_load_file(RESOURCES.'modules.xml');
        $exist = false;
        
        // Comprobamos que existen.
        foreach ($modules->module as $module) {
            if ($URI_module == $module->uri) {
                $exist = true;
                $NAME_module = $module->name;
                
                $path = MODULES_PATH . $NAME_module . "/controller/controller_" . $NAME_module . ".class.php";
                if (file_exists($path)) {
                    require_once $path;
                    $controllerClass = "controller_" . $NAME_module;
                    $obj = new $controllerClass;
                } else
                    errorView();

                handlerFunction($NAME_module, $obj, $URI_function);
                break;
            }
        }
        if (!$exist)
            errorView();
    }

    function handlerFunction($NAME_module, $obj, $URI_function) {

        // Comprobamos que tiene funcion o no.
        if (!empty($URI_function)) {
            // Importamos las funciones del modulo.
            $functions = simplexml_load_file(MODULES_PATH . $NAME_module . "/resources/function.xml");
            $exist = false;

            foreach ($functions->function as $function) {
                if (($URI_function === (String) $function->uri)) {
                    $exist = true;
                    $event = (String) $function->name;
                    break;
                }
            }

            if (!$exist)
                errorView();
            else
                call_user_func(array($obj, $event));
        } else
            call_user_func(array($obj, "view"));
    }

    function handlerFront($NAME_module,$NAME_function) {
        // Importamos las funciones.
        $functions = simplexml_load_file(RESOURCES.'functions.xml');
        $exist = false;

        foreach ($functions->function as $function) {
            if (($NAME_function === (String) $function->name)) {
                $exist = true;
                $event = (String) $function->name;
                break;
            }
        }

        if (!$exist)
            errorView();
        else {
            require_once CONTROLLER . "front_controller_" . $NAME_module . ".class.php";
            $controllerClass = "front_controller_" . $NAME_module;
            $obj = new $controllerClass;
            call_user_func(array($obj,$event));
        }
    }
    handlerRouter();