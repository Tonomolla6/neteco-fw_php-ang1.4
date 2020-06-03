<?php
	class cart_bll {
	    private $dao;
	    static $_instance;

	    private function __construct() {
	        $this->dao = cart_dao::getInstance();
	    }

	    public static function getInstance() {
	        if (!(self::$_instance instanceof self)){
	            self::$_instance = new self();
	        }
	        return self::$_instance;
	    }

	    public function money_checking($db,$data) {
			$salary = $this->dao->get_salary($db,$data);
			$total = $this->dao->total_cart($db,$data);
			$array = array(
				"salary" => $salary[0]["salary"],
				"total" => $total[0]["total"]
			);
			return $array;
		}

		public function execute_order($db,$data) {
			$salary = array(
				$data["email"],
				$data["salary"]
			);
			$this->dao->update_salary($db,$salary);

			
			$cart = $this->dao->select_cart_user($db,$data["email"]);
			foreach ($cart as $e) {
				$stock = array(
					intval($e["units"]),
					intval($e["product"])
				);
				$this->dao->update_stock($db,$stock);

				$order = array(
					$data["email"],
					intval($e["units"]),
					intval($e["product"])
				);

				$this->dao->insert_order($db,$order);
				$this->dao->delete_cart_php_user($db,$data["email"]);
				
			}
		}
	}