<?php
	class front_controller_client {
		function categories(){
			$json = array();
			$json = loadModel(DAO_FRONT, "front_client_dao", "categories");
			echo json_encode($json);
		}

		function subcategories(){
			$data = array($_POST["category"]);
			$json = array();
			$json = loadModel(DAO_FRONT, "front_client_dao", "subcategories", $data);
			echo json_encode($json);
		}
	}