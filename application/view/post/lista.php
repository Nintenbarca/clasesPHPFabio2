<div class="container">
	<h1>Posts</h1><br>
	<?php
	foreach ($posts as $post) {
		session_start();		
		echo "<h2>Titulo: ". $post->getTitulo() ."</h2>";
		$usuario = Usuario::getById($post->getAutor());	
		echo "<h3>Autor: ". $usuario->getNick() ."</h3>";	
		echo '<h3>Fecha: '. date('Y-m-d', $post->getFecha()) .'</h3>';		
		$categoria = Categoria::getById($post->getCategoria());
		echo "<p>Categoría: ". $categoria->getNombre() ."</p><br><br>";
		echo "<a href=\"".URL."postcontroller/detail/".$post->getId()."\">Ver Post</a>
			<br><br>";			
	} ?>	
</div>