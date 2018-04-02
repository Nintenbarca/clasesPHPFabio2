<?php

class PostController extends Controller{

	public function loadModel(){
		Post::$db = $this->db;
	}

	public function index()	{
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();
		$this->view->addData(['posts'=>Post::getAll(), 'categorias'=> Categoria::getAll()]);
        echo $this->view->render('post/lista');
	}

	public function detail($id){		
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();

		$this->view->addData(['post'=>Post::get($id)]);
		echo $this->view->render('post/detalle');
	}

	public function results(){
		$query = $_POST['query'];		
		include_once 'categoriacontroller.php';
		new CategoriaController();
		include_once 'usuariocontroller.php';
		new UsuarioController();

		$this->view->addData(['posts'=>Post::getByFilter($query)]);
        echo $this->view->render('post/lista');	
		
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
		if($id == NULL) $id = $_GET['id'];
		$post = Post::get($id);

		$this->view->addData(['post'=>Post::get($id), 
			'categorias'=>Categoria::getAll()]);
		echo $this->view->render('post/editar');		
	}

	public function borrar(){
		$id = $_GET['id'];
		$post = Post::get($id);		
		$post->delete();
		header('location: ' . URL . 'postcontroller');
	}
}