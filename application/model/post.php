<?php

class Post {

	private $id;
	private $titulo;
	private $fecha;
	private $autor;
	private $contenido;
	private $categoria;

	public static $db;

	function __construct($titulo, $fecha, $autor, $contenido, $categoria){		
		$this->titulo = $titulo;
		$this->fecha = $fecha;		
		$this->autor = $autor;
		$this->contenido = $contenido;
		$this->categoria = $categoria;
	}

	public static function getAll(){ 
		$sql = "SELECT * FROM post"; 
        $query = Post::$db->prepare($sql);
        $query->execute();

        $posts = array();

        foreach ($query->fetchAll() as $row) {
        	$row  = (array)$row;
        	$nuevoPost = new Post($row['titulo'], $row['fecha'], $row['autor'], 
        		$row['contenido'], $row['categoria']); 
        	$nuevoPost->id = $row['id'];
        	array_push($posts, $nuevoPost);
        }
        return $posts;
	}

	public static function get($id){
		$sql = "SELECT * FROM post WHERE id = :id";
        $query = Post::$db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);

        $row = (array)$query->fetch();

        $nuevoPost = new Post($row['titulo'], $row['fecha'], $row['autor'], 
        	$row['contenido'], $row['categoria']); 
        $nuevoPost->id = $row['id'];         
        
        return $nuevoPost;
	}

	public static function getByFilter($query){
		$allPosts = Post::getAll();
		$posts = array();
		foreach ($allPosts as $post) {
			if($post->matches($query)){
				array_push($posts, $post);
			}
		}
		return $posts;
	}

	public function insert(){		
        $sql = "INSERT INTO post (titulo, fecha, autor, contenido, categoria) VALUES (:titulo, :fecha, :autor, :contenido, :categoria)";
        $query = Post::$db->prepare($sql);
        $parameters = array(':titulo' => $this->titulo, ':fecha' => $this->fecha,
           	':autor' => $this->autor, ':contenido' => $this->contenido, 
        	':categoria' => $this->categoria);

        $query->execute($parameters);        
	}

	public function update(){		
        $sql = "UPDATE post SET titulo = :titulo, fecha = :fecha, autor = :autor, 
        	contenido = :contenido, categoria = :categoria WHERE id = :id";
        $query = Post::$db->prepare($sql);
        $parameters = array(':titulo' => $this->titulo, ':fecha' => $this->fecha,
        	':autor' => $this->autor, ':contenido' => $this->contenido, 
        	':categoria' => $this->categoria, ':id' => $this->id);

        $query->execute($parameters);        
	}

	public function delete(){
		$sql = "DELETE FROM post WHERE id = :id";
        $query = Post::$db->prepare($sql);
        $parameters = array(':id' => $this->id);
        $query->execute($parameters);        
	}

	public function getId(){
		return $this->id;
	}
	public function getTitulo(){
		return $this->titulo;
	}
	public function getSlug(){
		return str_replace(" ", "_", $this->titulo);
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function getAutor(){
		return $this->autor;
	}
	public function getContenido(){
		return $this->contenido;
	}
	public function getCategoria(){
		return $this->categoria;
	}

	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}
	public function setContenido($contenido){
		$this->contenido = $contenido;
	}
	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}

	public function matches($query){
		$query = strtolower($query);

		$titulo = $this->getTitulo();
		$titulo = strtolower($titulo);
		if(strpos($titulo, $query) !== false){
			return true;
		}

		$contenido = $this->getContenido();
		$contenido = strtolower($contenido);
		if(strpos($contenido, $query) !== false){
			return true;
		}

		include_once APP . "controller/usuariocontroller.php";
		new UsuarioController();
		$usuario = Usuario::getById($this->getAutor());
		$autor = $usuario->getNick();
		$autor = strtolower($autor);
		if (strpos($autor, $query) !== false) {
			return true;
		}

		include_once APP . "controller/categoriacontroller.php";
		new CategoriaController();
		$categoria = Categoria::getById($this->getCategoria());
		$nombre = $categoria->getNombre();
		$nombre = strtolower($nombre);
		if (strpos($nombre, $query) !== false) {
			return true;
		}

		return false;
	}

}