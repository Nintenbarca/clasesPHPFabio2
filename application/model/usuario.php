<?php

class Usuario{

	private $id;
	private $nombre;
	private $apellidos;
	private $email;
	private $nick;
	private $pass;

	private $isAdmin;

	public static $db;

	function __construct($nombre, $apellidos, $email, $nick, $pass, $isAdmin = false){
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->email = $email;
		$this->nick = $nick;
		$this->pass = $pass;
		$this->isAdmin = $isAdmin;
	}

	public static function getAll(){ 
		$sql = "SELECT * FROM usuario"; 
        $query = Usuario::$db->prepare($sql);
        $query->execute();

        $usuarios = array();

        foreach ($query->fetchAll() as $row) {
        	$row  = (array)$row;
        	$nuevoUsuario = new Usuario($row['nombre'], $row['apellidos'], $row['email'], $row['nick'], $row['pass'], $row['isAdmin']); 
        	$nuevoUsuario->id = $row['id'];
        	array_push($usuarios, $nuevoUsuario);
        }
        return $usuarios;
	}

	public static function getByEmail($email){
		$sql = "SELECT * FROM usuario WHERE email = :email";
        $query = Usuario::$db->prepare($sql);
        $parameters = array(':email' => $email);
        $query->execute($parameters);

 		if ($query->rowCount()>0) {
 			$row = (array)$query->fetch();

	        $nuevoUsuario = new Usuario($row['nombre'], $row['apellidos'], $row['email'],
        		$row['nick'], $row['pass'], $row['isAdmin']);         
	        $nuevoUsuario->id = $row['id'];
	        return $nuevoUsuario;
 		}else{
 			return false;
 		}
	}

	public static function getById($id){
		$sql = "SELECT * FROM usuario WHERE id = :id";
        $query = Usuario::$db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);

 		if ($query->rowCount()>0) {
 			$row = (array)$query->fetch();

	        $nuevoUsuario = new Usuario($row['nombre'], $row['apellidos'], $row['email'],
        		$row['nick'], $row['pass'], $row['isAdmin']);         
	        $nuevoUsuario->id = $row['id'];
	        return $nuevoUsuario;
 		}else{
 			return false;
 		}
	}

	public function insert(){		
        $sql = "INSERT INTO usuario (nombre, apellidos, email, nick, pass, isAdmin) 
        	VALUES (:nombre, :apellidos, :email, :nick, :pass, :isAdmin)";
        $query = Usuario::$db->prepare($sql);
        $parameters = array(':nombre' => $this->nombre, ':apellidos' => $this->apellidos, ':email' => $this->email, ':nick' => $this->nick, ':pass' => $this->pass, 
        	':isAdmin' => $this->isAdmin);

        $query->execute($parameters);
        $this->id = Usuario::$db->lastInsertId();
	}

	public function update(){
		$sql = "UPDATE usuario SET nombre = :nombre, apellidos = :apellidos, email = :email, nick = :nick, pass = :pass, isAdmin = :isAdmin WHERE id = :id";
        $query = Usuario::$db->prepare($sql);
        $parameters = array(':nombre' => $this->nombre, ':apellidos' => $this->apellidos, ':email' => $this->email, ':nick' => $this->nick, ':pass' => $this->pass, 
        	':isAdmin' => $this->isAdmin, ':id' => $this->id);

        $query->execute($parameters);

	}

	public function delete(){
		$sql = "DELETE FROM usuario WHERE id = :id";
        $query = Usuario::$db->prepare($sql);
        $parameters = array(':id' => $this->id);
        $query->execute($parameters);        
	}

	public function getId(){
		return $this->id;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getApellidos(){
		return $this->apellidos;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getNick(){
		return $this->nick;
	}

	public function isAdmin(){
		return $this->isAdmin;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setApellidos($apellidos){
		$this->apellidos = $apellidos;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setNick($nick){
		$this->nick = $nick;
	}

	public function setPass($pass){
		$this->pass = $pass;
	}

	public function auth($pass){
		return ($this->pass == md5($pass));
	}
}