<?php

class PostController extends Controller{

	public function loadModel(){
		Post::$db = $this->db;
	}

	public function index()	{
		$posts = Post::getAll();
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();

        require APP . 'view/_templates/header.php';
        require APP . 'view/post/lista.php';
        $this->formularioAnadir();
        require APP . 'view/_templates/footer.php';
	}

	public function formularioAnadir(){
		session_start();
		include_once 'categoriacontroller.php';
		new CategoriaController();
		$categorias = Categoria::getAll();
		if(isset($_SESSION['user'])){			
			require APP . 'view/post/form.php';
			
		}else{			
			echo "Debes estar logueado para poder crear un post (Accede <a href=\"".URL."usuariocontroller/login\">aqui</a>)";
		}
	}

	public function detail($id){		
		$post = Post::get($id);
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();

		require APP . 'view/_templates/header.php';
        require APP . 'view/post/detalle.php';        
        require APP . 'view/_templates/footer.php';

	}

	public function results(){
		$query = $_POST['query'];
		$posts = Post::getByFilter($query);
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();
		
		require APP . 'view/_templates/header.php';
        require APP . 'view/post/lista.php';
        require APP . 'view/_templates/footer.php';
	}
	
	public function anadir(){
		session_start();
		if(!isset($_SESSION["errores"])){
			$_SESSION["errores"] = array();
		}

		$titulo = $_POST['titulo'];
		$autor = $_POST['autor'];
		$contenido = $_POST['contenido'];
		$categoria = $_POST['categoria'];
		$fecha = time()+3600;		

		if (empty($titulo)) {
			array_push($_SESSION["errores"], "Introduzca el titulo");
		}elseif (strlen($titulo) < 3) {
			array_push($_SESSION["errores"], "El titulo debe tener al menos 3 
				caracteres");
		}elseif (strlen($titulo) > 20) {
			array_push($_SESSION["errores"], "El titulo no puede tener mas de 20 
				caracteres");
		}

		if (empty($contenido)) {
			array_push($_SESSION["errores"], "Introduzca el contenido");
		}elseif (strlen($contenido) > 200) {
			array_push($_SESSION["errores"], "El contenido no puede tener mas de 200 caracteres");
		}

		if (empty($_SESSION["errores"])) {
			$post = new Post($titulo, $fecha, $autor, $contenido, $categoria);
			$post->insert();			
			header('location: ' . URL . 'postcontroller');								
		}else{			
			header('location: ' . URL . 'postcontroller');					
		}
		
	}

	public function tryEditar(){
		session_start();
		if(!isset($_SESSION["errores"])){
			$_SESSION["errores"] = array();
		}		

		$id = $_POST['id'];
		$titulo = $_POST['titulo'];		
		$contenido = $_POST['contenido'];
		$categoria = $_POST['categoria'];
		$post = Post::get($id);

		if (empty($titulo)) {
			array_push($_SESSION['errores'], 'No he recibido el titulo');
		}elseif (strlen($titulo) < 3) {
			array_push($_SESSION['errores'], 'El titulo debe tener al menos 3 caracteres');
		}

		if (empty($contenido)) {
			array_push($_SESSION['errores'], 'No he recibido el contenido');
		}elseif (strlen($contenido) > 200) {
			array_push($_SESSION['errores'], 'El contenido no puede superar los 200 
				caracteres');
		}

		if (empty($categoria)) {
			array_push($_SESSION['errores'], 'No he recibido la categoria');
		}

		if (($_SESSION['user']->getId() == $post->getAutor()) || $_SESSION['user']->isAdmin()) {
			if (empty($_SESSION['errores'])) {
				$post->setTitulo($titulo);
				$post->setContenido($contenido);
				$post->setCategoria($categoria);
				$post->update();
				$this->detail($id);
			}else{
				$this->editar($id);
			}			
		}
	}

	public function editar($id = NULL){
		include_once 'categoriacontroller.php';
		new CategoriaController();
		$categorias = Categoria::getAll();
		if($id == NULL) $id = $_GET['id'];
		$post = Post::get($id);
		require APP . 'view/_templates/header.php';
        require APP . 'view/post/editar.php';
        require APP . 'view/_templates/footer.php';
	}

	public function borrar(){
		$id = $_GET['id'];
		$post = Post::get($id);		
		$post->delete();
		header('location: ' . URL . 'postcontroller');
	}
}