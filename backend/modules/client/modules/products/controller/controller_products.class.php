<?php
	class controller_products {
	    function __construct() {
	        $_SESSION["module"] = "products";
		}
		
		function view() {
			$paths = array("head.php","products_page.html");
        	loadView("modules/products/view/", $paths);
		}

		function list_products_add() {
			$json = array();
			$data = array($_POST["category"],$_POST["subcategory"],$_POST["mostrados"]);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "list_products_add", $data);
			echo json_encode($json);
		}

		function list_categories() {
			$json = array();
			$json = loadModel(DAO_PRODUCTS, "products_dao", "list_categories");
			echo json_encode($json);
		}

		function list_subcategories() {
			$json = array();
			$json = loadModel(DAO_PRODUCTS, "products_dao", "list_subcategories");
			echo json_encode($json);
		}

		function list_products(){
			$json = array();
			$data = array($_POST["category"],$_POST["subcategory"]);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "list_products", $data);
			echo json_encode($json);
		}

		function count_products() {
			$json = array();
			$data = array($_POST["category"],$_POST["subcategory"]);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "count_products", $data);
			echo json_encode($json);
		} 
		
		function list_likes() {
			$json = array();
			$array = decode_token_jwt($_POST["token"]);
			$email = json_decode($array)->name;
			$json = loadModel(DAO_PRODUCTS, "products_dao", "list_likes", $email);
			echo json_encode($json);
		}

		function add_like() {
			$json = array();
			$array = decode_token_jwt($_POST["token"]);
			$email = json_decode($array)->name;
			$data = array($_POST["id_product"],$email);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "add_like", $data);
			echo json_encode($json);
		}

		function remove_like() {
			$json = array();
			$array = decode_token_jwt($_POST["token"]);
			$email = json_decode($array)->name;
			$data = array($_POST["id_product"],$email);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "remove_like", $data);
			echo json_encode($json);
		}

		function details() {
			$json = array();
			$json = loadModel(DAO_PRODUCTS, "products_dao", "details", $_POST["id"]);
			echo json_encode($json);
		}

		function products_categories() {
			$json = array();
			$data = array($_POST["cat"],$_POST["sub"],$_POST["id"]);
			$json = loadModel(DAO_PRODUCTS, "products_dao", "products_categories", $data);
			echo json_encode($json);
		}
	}