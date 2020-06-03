<?php
    function enviar_email($data,$type) {
        switch ($type) {
            case 'contact':
                $text = 'Hemos recibido correctamente su mensaje, en unos dias recibira una respuesta, Gracias.<br>';
                $ruta = '<a href=' . 'http://localhost/framework-php/'. '>Neteco</a>';
                $body = 'Para visitar nuestra web, pulsa ' . $ruta;
                $subject = 'Gracias por contactar con Neteco.'; 
                break;
            case 'signin':
                $text = 'Gracias por registrarte en NETECO '.$data["nombre"].'.<br>';
                $ruta = '<a href=' . '"http://localhost/framework-php/login/check/'. $data["token"] .'">aqui</a>';
                $body = 'Para verificar su cuenta pulsa ' . $ruta . '.';
                $subject = 'Verifica tu cuenta de Neteco'; 
                break;
            case 'restart':
                $text = 'Restaurar la contraseña, '.$data["nombre"].'.<br>';
                $ruta = '<a href=' . '"http://localhost/framework-php/login/restart/'. $data["token"] .'">aqui</a>';
                $body = 'Para restaurar su contraseña pulsa ' . $ruta . '.';
                $subject = 'Restablece su contraseña de Neteco'; 
                break;
        }

        $html = "<html>";
        $html .= "<body>";
        $html .= "Asunto:";
        $html .= "<br><br>";
        $html .= "<h4>". $text ."</h4>";
        $html .= "<br><br>";
        $html .= "Mensaje:";
        $html .= "<br><br>";
        $html .= $data['mensaje'];
        $html .= "<br><br>";
        $html .= $body;
        $html .= "<br><br>";
        $html .= "<p>Un saludo, Neteco.</p>";
        $html .= "</body>";
        $html .= "</html>";

        try{
            $result = send_mailgun('tonomollag6@gmail.com', $data['correo'], $subject, $html);    
        } catch (Exception $e){
            $return = 0;
        }

        return $result;
    }

    function send_mailgun($from, $email, $subject, $html){
        $api = parse_ini_file(UTILS."mail.ini");
        $config = array();
        $config['api_key'] = $api['key'];
        $config['api_url'] = $api['url'];

        $message = array();
        $message['from'] = $from;
        $message['to'] = $email;
        $message['h:Reply-To'] = $from;
        $message['subject'] = $subject;
        $message['html'] = $html;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['api_url']);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
