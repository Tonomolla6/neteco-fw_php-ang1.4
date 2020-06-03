<?php
class front_client_model {
    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = front_client_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // public function obtain_data_list($db,$arrArgument){
    //     return $this->bll->obtain_data_list_BLL($db,$arrArgument);
    // }
}