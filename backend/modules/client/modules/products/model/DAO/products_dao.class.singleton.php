<?php
class products_dao {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function list_products_add($db,$data) {
        $add = "";
        if(!empty($data[1]))
            $add = 'WHERE subcategory = '.$data[1].' LIMIT 20 OFFSET '.$data[2];
        else if (!empty($data[0]))
            $add = 'WHERE category = '.$data[0].' LIMIT 20 OFFSET '.$data[2];
        $sql = "SELECT * FROM products ".$add;
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function list_categories($db) {
        $sql = "SELECT * FROM categories";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function list_subcategories($db) {
        $sql = "SELECT * FROM subcategories";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function list_products($db, $data){
        $add = "";
        if(!empty($data[1]))
            $add = 'WHERE subcategory = '.$data[1].' LIMIT 20';
        else if (!empty($data[0]))
            $add = 'WHERE category = '.$data[0].' LIMIT 20';
        $sql = "SELECT * FROM products ".$add;
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function count_products($db, $data) {
        $add = "";
        if(!empty($data[1]))
            $add = 'WHERE subcategory = '.$data[1];
        else if (!empty($data[0]))
            $add = 'WHERE category = '.$data[0];
        $sql = "SELECT * FROM products ".$add;
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function list_likes($db,$data) {
        $sql = "SELECT product FROM favorites WHERE user = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function add_like($db,$data) {
        $sql = "INSERT INTO favorites (user,product) VALUES ('".$data[1]."','".$data[0]."')";
        return $db->ejecutar($sql);
    }

    public function remove_like($db,$data) {
        $sql = "DELETE FROM favorites WHERE user = '".$data[1]."' and product = '".$data[0]."'";
        return $db->ejecutar($sql);
    }

    public function details($db,$data) {
        $sql = "SELECT * FROM products WHERE id = ".$data;
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function products_categories($db, $data) {
        $add = "";
        if(!empty($data[1]))
            $add = 'WHERE id != '.$data[2].' and category = '.$data[0].' and subcategory = '.$data[1].' LIMIT 5';
        else if (!empty($data[0]))
            $add = 'WHERE id != '.$data[2].' and category = '.$data[0].' LIMIT 5';
        $sql = "SELECT * FROM products ".$add;
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
}