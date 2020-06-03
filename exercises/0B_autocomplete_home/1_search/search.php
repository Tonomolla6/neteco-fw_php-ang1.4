<?php
    $data = file_get_contents("php://input");
    $objData = json_decode($data, true);

    $values = array('php', 'web', 'angularjs', 'js');

    if(in_array($objData['data'], $values)) {
    	echo 'I have found what you\'re looking for!';
    } else {
    	echo 'Sorry, no match!';
    }
