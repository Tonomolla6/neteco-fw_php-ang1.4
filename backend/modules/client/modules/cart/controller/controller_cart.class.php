<?php
	class controller_cart {
	    function __construct() {
	        $_SESSION['module'] = "cart";
		}
		
		function view() {
			$paths = array("head.php","cart_page.html");
        	loadView('modules/cart/view/', $paths);
		}
		
		function money_checking() {
			$array = decode_token_jwt($_POST["token"]);
			$email = json_decode($array)->name;
			$data = loadModel(BLL_CART, "cart_bll", "money_checking", $email);
	
			if (intval($data['salary']) >= intval($data['total'])) {
				$array = array(
					"salary" => intval($data['salary']) - intval($data['total']),
					"email" => $email
				);
				loadModel(BLL_CART, "cart_bll", "execute_order", $array);
				echo json_encode(true);
			} else
				echo json_encode(false);
		}

		function insert_cart_user() {
			$json = decode_token_jwt($_POST["token"]);
			$email = json_decode($json)->name;
			loadModel(DAO_CART, "cart_dao", "delete_cart_php_user", $email);
			foreach ($_POST["data"] as $valor) {
				$array = array($email,$valor["id"],$valor["und"]);
				loadModel(DAO_CART, "cart_dao", "insert_cart_php", $array);
			}
		}

		function list_products() {
			$json = array();
			$json = loadModel(DAO_CART, "cart_dao", "select_products", $_POST["data"]);
			echo json_encode($json);
		}

		function select_cart_user() {
			$json = array();
			$array = decode_token_jwt($_POST["token"]);
			$email = json_decode($array)->name;
			$json = loadModel(DAO_CART, "cart_dao", "select_cart_user", $email);
			echo json_encode($json);
		}

		function stock_checking() {
			$json = array();
			$json = loadModel(DAO_CART, "cart_dao", "stock_checking", $_POST["id"]);
			echo json_encode($json);
		}
	}