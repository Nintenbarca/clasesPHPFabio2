<?php

class Categoria{

	private $id;
	private $nombre;

	public static $db;

	function __construct($nombre){
		$this->nombre = $nombre;
	}

	public static function getAll(){ 
		$sql = "SELECT * FROM categoria"; 
        $query = Categoria::$db->prepare($sql);
        $query->execute();

        $categorias = array();

        foreach ($query->fetchAll() as $row) {
        	$row  = (array)$row;
        	$nuevaCategoria = new Categoria($row['nombre']); 
        	$nuevaCategoria->id = $row['id'];
        	array_push($categorias, $nuevaCategoria);
        }
        return $categorias;
	}

	public static function getById($id){
		$sql = "SELECT * FROM categoria WHERE id = :id";
        $query = Categoria::$db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);

 		if ($query->rowCount()>0) {
 			$row = (array)$query->fetch();

	        $nuevaCategoria = new Categoria($row['nombre']);         
	        $nuevaCategoria->id = $row['id'];
	        return $nuevaCategoria;
 		}else{
 			return false;
 		}
	}

	public function getId(){
		return $this->id;
	}

	public function getNombre(){
		return $this->nombre;
	}
}