<?php
class cart_dao {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_salary($db,$data) {
        $sql = "SELECT salary FROM login WHERE email = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function delete_cart_php_user($db,$data) {
        $sql = "DELETE FROM cart WHERE user = '".$data."'";
        return $db->ejecutar($sql);
    }

    public function insert_cart_php($db,$data) {
        $sql = "INSERT INTO cart (user,product,units) VALUES ('".$data[0]."',".$data[1].",".$data[2].")";
        return $db->ejecutar($sql);
    }

    public function update_salary($db,$data) {
        $sql = "UPDATE login SET salary = ".$data[1]." WHERE email = '".$data[0]."'";
        return $db->ejecutar($sql);
    }

    public function select_products($db,$data) {
        $sql = "SELECT id,name,sale_price,img,stock FROM products WHERE id in ($data)";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function update_clicks($db,$data) {
        $sql = "UPDATE " . $data[1] . "SET clicks = (clicks + 1) WHERE id = " .$data[1];
        return $db->ejecutar($sql);
    }

    public function select_cart_user($db,$data) {
        $sql = "SELECT product,units FROM cart WHERE user = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function stock_checking($db,$data) {
        $sql = "SELECT stock FROM products WHERE id like ".$data.";";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function total_cart($db,$data) {
        $sql = "SELECT SUM(p.sale_price*c.units) as total FROM cart c INNER JOIN products p ON c.product = p.id WHERE user = '".$data."'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function update_stock($db,$data) {
        $sql = "UPDATE products SET stock = (stock-".$data[0].") WHERE id = ".$data[1];
        return $db->ejecutar($sql);
    }

    public function insert_order($db,$data) {
        $sql = "INSERT INTO orders (user,product,units) VALUES ('".$data[0]."',".$data[2].",".$data[1].")";
        return $db->ejecutar($sql);
    }
}