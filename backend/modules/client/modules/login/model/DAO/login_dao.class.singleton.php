<?php
class login_dao {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function login($db,$data) {
        $sql = "SELECT * FROM login WHERE email = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }
    
    public function slider_img_change($db,$data) {
        $sql = "SELECT * FROM background_img WHERE id = ".$data[0];
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function slider_subcategoria($db) {
        $sql = "SELECT * FROM subcategories ORDER BY clicks DESC LIMIT 5";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function slider_products($db) {
        $sql = "SELECT * FROM products ORDER BY clicks DESC LIMIT 5";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function update_clicks($db,$data) {
        $sql = "UPDATE " . $data[1] . "SET clicks = (clicks + 1) WHERE id = " .$data[1];
        return $db->ejecutar($sql);
    }

    public function insert_user($db, $data) {
        $token = generate_Token_secure(20);
        $sql = "INSERT INTO login (name, email, password, avatar, salary, type, active, token) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."', 1000, 'client', 0, '$token')";
        $db->ejecutar($sql);
        return $token;
    }

    public function check($db, $data) {
        $sql = "UPDATE login SET active = 1 WHERE token = '" . $data . "'";
        return $db->ejecutar($sql);
    }

    public function update_token($db, $data) {
        $sql = "UPDATE login SET token = '" . $data[1] . "' WHERE email = '". $data[0] ."'";
        return $db->ejecutar($sql);
    }

    public function check_token($db, $data) {
        $sql = "SELECT * FROM login WHERE token = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function change_password($db,$data) {
        $sql = "UPDATE login SET password = '" . $data[0] . "' WHERE token = '". $data[1] ."'";
        return $db->ejecutar($sql);
    }

    public function delete_token($db,$data) {
        $sql = "UPDATE login SET token = '' WHERE token = '". $data ."'";
        return $db->ejecutar($sql);
    }

    public function check_social($db,$data) {
        $sql = "SELECT email FROM login WHERE social_id = '".$data[0]."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function insert_social_user($db,$data) {
        $sql = "INSERT INTO login (social_id, name, email, avatar, salary) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."',1000)";
        return $db->ejecutar($sql);
    }   
}
