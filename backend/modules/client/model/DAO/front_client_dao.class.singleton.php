<?php
class front_client_dao {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function categories($db) {
        $sql = "SELECT * FROM categories";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function subcategories($db,$data) {
        $sql = "SELECT * FROM subcategories WHERE category = ".$data[0];
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
    
}
