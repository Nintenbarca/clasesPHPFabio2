<?php


class UsuarioController extends Controller{

	public function loadModel(){
		Usuario::$db = $this->db;
	}

	public function index(){
		session_start();
		if (isset($_SESSION['user']) && $_SESSION['user']->isAdmin()) {
			$usuarios = Usuario::getAll();
			require APP . 'view/_templates/header.php';
        	require APP . 'view/usuarios/lista.php';        
        	require APP . 'view/_templates/footer.php';
		}		
	}

	public function trySignUp(){
		session_start();
		if(!isset($_SESSION["errores"])){
			$_SESSION["errores"] = array();
		}

		if (! $_POST) {
			$this->signUp();
		}else{
			$nombre = $_POST['nombre'];
			$apellidos = $_POST['apellidos'];
			$email = $_POST['email'];
			$nick = $_POST['nick'];
			$pass = md5($_POST['pass']);
			$pass2 = md5($_POST['pass2']);
			$usuario = Usuario::getByEmail($email);

			if (empty($nombre)){
				array_push($_SESSION["errores"], "Introduzca el nombre");
			}elseif (strlen($nombre) < 3) {
				array_push($_SESSION["errores"], "El nombre debe tener al menos 3 caracteres");		
			}

			if(empty($apellidos)){
				array_push($_SESSION["errores"], "Introduzca los apellidos");
			}elseif (strlen($apellidos) < 5) {
				array_push($_SESSION["errores"], "Los apellidos deben tener al menos 5 caracteres");		
			}

			if(empty($email)){
				array_push($_SESSION["errores"], "Introduzca el email");
			}elseif (strlen($email) < 5) {
				array_push($_SESSION["errores"], "El email debe tener al menos 5 caracteres");		
			}	

			if(empty($nick)){
				array_push($_SESSION["errores"], "Introduzca el nick");
			}elseif (strlen($nick) < 3) {
				array_push($_SESSION["errores"], "El nick debe tener al menos 3 caracteres");		
			}

			if(empty($pass) || empty($pass2)){
				array_push($_SESSION["errores"], "Introduzca las contraseñas");
			}elseif (strlen($pass) < 5) {
				array_push($_SESSION["errores"], "La contraseña deben tener al menos 5 caracteres");		
			}
	
			if ($pass != $pass2) {
				array_push($_SESSION["errores"], "Las contraseñas necesitan ser iguales");		
			}

			if ($usuario != false) {
				array_push($_SESSION["errores"], "Ya existe un usuario con este email");
			}

			if (empty($_SESSION["errores"])) {
				$usuario = new Usuario($nombre, $apellidos, $email, $nick, $pass);
				$usuario->insert();
				$this->login();
			}else{
				$this->signUp();
			}
		}		
	}

	public function tryLogin(){
		session_start();
		if(!isset($_SESSION["errores"])){
			$_SESSION["errores"] = array();
		}

		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$usuario = Usuario::getByEmail($email);

		if (empty($email) || empty($pass)) {
			array_push($_SESSION["errores"], "No he recibido todos los campos");
		}

		if($usuario != false){
			if ($usuario->auth($pass)) {
				session_start();
				$_SESSION['user'] = $usuario;

				header('location: ' . URL );
			}else{
				array_push($_SESSION["errores"], "Email/contraseña incorrectos");
				$this->login();
			}
		}else{
			array_push($_SESSION["errores"], "Email/contraseña incorrectos");
			$this->login();
		}
	}

	public function tryEditar(){
		session_start();
		if(!isset($_SESSION["errores"])){
			$_SESSION["errores"] = array();
		}		

		$id = $_POST['id'];
		$nombre = $_POST['nombre'];		
		$apellidos = $_POST['apellidos'];
		$email = $_POST['email'];
		$nick = $_POST['nick'];
		$pass = md5($_POST['pass']);
		$pass2 = md5($_POST['pass2']);
		$usuarioAEditar = Usuario::getById($id);
		$usuarioRepetido = Usuario::getByEmail($email);

		if (empty($nombre)){
				array_push($_SESSION["errores"], "Introduzca el nombre");
			}elseif (strlen($nombre) < 3) {
				array_push($_SESSION["errores"], "El nombre debe tener al menos 3 caracteres");		
			}

		if(empty($apellidos)){
			array_push($_SESSION["errores"], "Introduzca los apellidos");
		}elseif (strlen($apellidos) < 5) {
			array_push($_SESSION["errores"], "Los apellidos deben tener al menos 5 caracteres");		
		}

		if(empty($email)){
			array_push($_SESSION["errores"], "Introduzca el email");
		}elseif (strlen($email) < 5) {
			array_push($_SESSION["errores"], "El email debe tener al menos 5 caracteres");		
		}	

		if(empty($nick)){
			array_push($_SESSION["errores"], "Introduzca el nick");
		}elseif (strlen($nick) < 3) {
			array_push($_SESSION["errores"], "El nick debe tener al menos 3 caracteres");
		}

		if(empty($pass) || empty($pass2)){
			array_push($_SESSION["errores"], "Introduzca las contraseñas");
		}elseif (strlen($pass) < 5) {
			array_push($_SESSION["errores"], "La contraseña deben tener al menos 5 caracteres");		
		}
	
		if ($pass != $pass2) {
			array_push($_SESSION["errores"], "Las contraseñas necesitan ser iguales");		
		}

		if ($usuarioAEditar->getEmail() != $email && $usuarioRepetido != false) {
			array_push($_SESSION["errores"], "Ya existe un usuario con este email");
		}

		if (isset($_SESSION['user']) && $_SESSION['user']->isAdmin()) {
			if (empty($_SESSION['errores'])) {
				$usuarioRepetido->setNombre($nombre);
				$usuarioRepetido->setApellidos($apellidos);
				$usuarioRepetido->setEmail($email);
				$usuarioRepetido->setNick($nick);
				$usuarioRepetido->setPass($pass);
				$usuarioRepetido->update();
				$this->index();
			}else{
				$this->editar($id);
			}
		}
	}

	public function editar($id){
		session_start();
		$usuario = Usuario::getById($id);
		if ($usuario != NULL && (isset($_SESSION['user']) && $_SESSION['user']->isAdmin())) {
			require APP . 'view/_templates/header.php';
        	require APP . 'view/usuarios/editar.php';
        	require APP . 'view/_templates/footer.php';
		}else{
			$this->index();
		}

	}

	public function logout(){
		session_start();
		session_destroy();
		$this->login();
	}

	public function borrar($id){
		session_start();
		if (isset($_SESSION['user']) && $_SESSION['user']->isAdmin()) {
			$usuario = Usuario::getById($id);
			$usuario->delete();
		}
		$this->index();
	}


	public function login(){
		require APP . 'view/_templates/header.php';
        require APP . 'view/usuarios/login.php';
        require APP . 'view/_templates/footer.php';		
	}
	
	public function signUp(){
		require APP . 'view/_templates/header.php';
        require APP . 'view/usuarios/registrar.php';
        require APP . 'view/_templates/footer.php';		
	}
}