<?php
	class controller_contact {
		function __construct(){
			$_SESSION['module'] = "contact";
		}
		
		function view() {
			$paths = array("head.php","contact_page.html");
        	loadView('modules/contact/view/', $paths);
		}
		
		function send_mail(){
			$data_mail = $_POST['data'];
			$data = array(
				'nombre' => $data_mail['nombre'],
				'apellidos' => $data_mail['apellidos'],
				'correo' => $data_mail['correo'],
				'cliente' => $data_mail['cliente'],
				'sexo' => $data_mail['sexo'],
				'asunto' => $data_mail['asunto'],
				'mensaje' => $data_mail['mensaje']
			);

			$total = json_decode(enviar_email($data,"contact"),true);
			if (!empty($total['id'])) {
				echo "<div class='alert alert-success'><i class='fas fa-times'></i> El correo se ha enviado correctamente, en unos dias recibirá una respuesta</div>";
				header("Refresh:0");
			} else
				echo "<div class='alert alert-error'><i class='fas fa-times'></i> Server error. Intentalo mas tarde...</div>";
		}
	}