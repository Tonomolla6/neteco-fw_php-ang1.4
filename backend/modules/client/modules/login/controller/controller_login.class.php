<?php
	class controller_login {
	    function __construct() {
			$_SESSION['module'] = "login";
		}
		
		function view() {
			$paths = array("head_login.php","login_page.html");
        	loadView('modules/login/view/', $paths);
		}

		function view_signin() {
			$paths = array("head_signin.php","signin_page.html");
        	loadView('modules/login/view/', $paths);
		}

		function view_checking() {
			$paths = array("head_login.php","checking_page.html");
        	loadView('modules/login/view/', $paths);
		}

		function login() {
			if ($_POST) {
                $var = $_POST['password'];
				$result = loadModel(DAO_LOGIN, "login_dao", "login", strtolower($_POST['email']));
				$result = $result[0];

				if (password_verify($var, $result['password'])) {
					if ($result['active'] == 0)
						$array = array(false,"La cuenta no está activada, verifique el correo.");
					else {
						$token = encode_token_jwt($result['email']);
						$array = array(true,$token);
						// if ($result["cart"] == true) {
						// 	echo false;
						// } else
						// 	echo true;
					}
				} else
					$array = array(false,"La direccion de correo o contraseña no son correctos");
			} else {
				$array = array(false,"No hay post");
			}
			echo json_encode($array);
		}

		function checking() {
			if ($_POST["token"]) {
				$json = decode_token_jwt($_POST["token"]);
				$email = json_decode($json)->name;
				$result = loadModel(DAO_LOGIN, "login_dao", "login", strtolower($email));
				$array = array(
					"stat" => true,
					"name" => $result[0]["name"],
					"avatar" => $result[0]["avatar"]
				);
				
			} else
				$array = array(
					"stat" => false
				);
			echo json_encode($array);
		}

		function logout() {
			session_destroy();
			session_unset();
			echo "true";
		}

		function time() {
			if (!isset($_SESSION["time"])){
				echo "true";
			}
			else {  
				if((time() - $_SESSION["time"]) >= 900) {
					session_destroy();
					session_unset();
	    	  		echo "false"; 
				} else {
					session_regenerate_id();
					echo "true";
				}
			}
		}

		function signin() {
			if ($_POST) {
				$result = loadModel(DAO_LOGIN, "login_dao", "login", strtolower($_POST['email']));
				$result = $result[0];

				if (!$result) {
					$data = array(
						$_POST['name'],
						strtolower($_POST['email']),
						password_hash($_POST['password'], PASSWORD_DEFAULT),
						"http://i.pravatar.cc/300?u=".$_POST['hash']
					);
					$token = loadModel(DAO_LOGIN, "login_dao", "insert_user", $data);
					$data = $_POST;
					$data = array(
						"token" => $token,
						"correo" => $_POST["email"],
						"nombre" => $_POST["name"]
					);
					json_decode(enviar_email($data,"signin"),true);
                    echo "true";
				} else
					echo "Este email ya esta registrado";
				
            } else
				echo "error";
		}

		function check() {
			loadModel(DAO_LOGIN, "login_dao", "check", $_GET["param"]);
			loadModel(DAO_LOGIN, "login_dao", "delete_token", $_GET["param"]);
			$paths = array("head_login.php","login_page.html");
        	loadView('modules/login/view/', $paths);
		}

		function restart() {
			if ($_GET["param"]) {
				$user = loadModel(DAO_LOGIN, "login_dao", "check_token", $_GET["param"]);
				if ($user) {
					$_SESSION["token"] = $_GET["param"];
				 	$paths = array("head_signin.php","restart_page.html");
        		 	loadView('modules/login/view/', $paths);
				} else {
					$paths = array("head_login.php","login_page.html");
        		 	loadView('modules/login/view/', $paths);
				}
			} else {
				if ($_POST) {
					$result = loadModel(DAO_LOGIN, "login_dao", "login", strtolower($_POST['email']));
					$result = $result[0];

					if ($result) {
						$token = generate_Token_secure(20);
						$data = array(strtolower($_POST['email']),$token);
						loadModel(DAO_LOGIN, "login_dao", "update_token", $data);

						$data = array(
							"nombre" => $result["name"],
							"token" => $token,
							"correo" => strtolower($_POST['email'])
						);

						json_decode(enviar_email($data,"restart"),true);
						echo "true";

					} else
						echo "false";
				}
			}
		}

		function change() {
			$data = array(password_hash($_POST['password'], PASSWORD_DEFAULT),$_SESSION["token"]);
			loadModel(DAO_LOGIN, "login_dao", "change_password", $data);
			loadModel(DAO_LOGIN, "login_dao", "delete_token", $_SESSION["token"]);
			$_SESSION["token"] = "";
			echo "true";
		}

		function social_login() {
			$data = array($_POST["id"],$_POST["name"],$_POST["email"],$_POST["avatar"]);
			$result = loadModel(DAO_LOGIN, "login_dao", "check_social", $data);
			$result = $result[0];

			if (!$result){
				loadModel(DAO_LOGIN, "login_dao", "insert_social_user", $data);
				$token = encode_token_jwt($data[2]);
			} else
				$token = encode_token_jwt($result["email"]);
			echo json_encode($token);
		}
	}