<?php
  function loadModel($model_path, $model_name, $function, $data = ""){
        $model = $model_path . $model_name . '.class.singleton.php';
        $db = db::getInstance();

        if (file_exists($model)) {
            include_once($model);
            $modelClass = $model_name;

            if (!method_exists($modelClass, $function)){
                throw new Exception();
            } else {
                $obj = $modelClass::getInstance();
                if (empty($data))
                    return call_user_func(array($obj, $function),$db);
                else
                    return call_user_func(array($obj, $function),$db,$data);
            }
        } else {
            throw new Exception();
        }
    }

    function loadView($rutaVista = '', $templateName = '') {
        require_once VIEW_PATH_INC . "head.php";
        require_once VIEW_PATH_INC . "menu.php";
        $count = 0;

        for ($t=0; $t < count($templateName); $t++) { 
            $view_path = SITE_ROOT . $rutaVista . $templateName[$t];
            if (file_exists($view_path))
                $count++;
        }
        
        if ($count == count($templateName)) {
            for ($t=0; $t < count($templateName); $t++)
                include_once SITE_ROOT . $rutaVista . $templateName[$t];
        } else
            errorView();

        require_once VIEW_PATH_INC . "footer.html";
    }

    function errorView() {
        require_once VIEW_PATH_INC . "head.php";
        require_once VIEW_PATH_INC . "menu.php";
        require_once VIEW_PATH_INC . "404.php";
        require_once VIEW_PATH_INC . "footer.html";
    }
 
    function encode_token_jwt($email) {
        // Data
        $header = '{"typ":"JWT", "alg":"HS256"}';
        $secret = 'hoyendialostenedoresoncucharas';
        $payload_array = array(
            'iat' => time(),
            'exp' => time() + (5 * 60),
            'name' => $email
           );

        $payload = json_encode($payload_array);

        // Program
        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);

        // Token
        return $token;
    }

    function decode_token_jwt($token_in) {
        $secret = 'hoyendialostenedoresoncucharas';
        $JWT = new JWT;
        $token = $JWT->decode($token_in, $secret);

        return $token;
    }
