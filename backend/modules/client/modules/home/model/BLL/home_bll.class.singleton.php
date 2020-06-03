<?php
	class home_dao{
	    private $dao;
	    static $_instance;

	    private function __construct() {
	        $this->dao = front_client_dao::getInstance();
	    }

	    public static function getInstance() {
	        if (!(self::$_instance instanceof self)){
	            self::$_instance = new self();
	        }
	        return self::$_instance;
	    }

	    // public function obtain_data_list_BLL($db,$arrArgument){
	    //   return $this->dao->select_data_list($this->db,$arrArgument);
	    // }
	}