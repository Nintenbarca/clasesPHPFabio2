<?php

class CategoriaController extends Controller{

	public function loadModel(){
		Categoria::$db = $this->db;
	}

}