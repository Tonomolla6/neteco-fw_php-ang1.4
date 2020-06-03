<?php
	class controller_home {
	    function __construct() {
	        $_SESSION['module'] = "home";
		}
		
		function view() {
			$paths = array("head.php","home_page.html");
        	loadView('modules/home/view/', $paths);
		}
		
		function slider_img_count() {
			$json = array();
			$json = loadModel(DAO_HOME, "home_dao", "slider_img_count");
			echo json_encode($json);
		}

		function slider_img_change() {
			$data = array($_POST["id"]);
			$json = array();
			$json = loadModel(DAO_HOME, "home_dao", "slider_img_change", $data);
			echo json_encode($json);
		}

		function slider_subcategoria() {
			$json = array();
			$json = loadModel(DAO_HOME, "home_dao", "slider_subcategoria");
			echo json_encode($json);
		}
		
		function slider_products() {
			$json = array();
			$json = loadModel(DAO_HOME, "home_dao", "slider_products");
			echo json_encode($json);
		}

		function update_clicks() {
			$data = array($_POST['table'],$_POST['id']);
			$json = array();
			$json = loadModel(DAO_HOME, "home_dao", "update_clicks", $data);
			echo json_encode($json);
		}
	}