<div class="container">
	<?php
	echo "<h1>". $post->getTitulo() ."</h1>";
	$usuario = Usuario::getById($post->getAutor());	
	echo "<h2>Autor: ". $usuario->getNick() ."</h2>";	
	echo '<h2>Fecha: '. date('Y-m-d', $post->getFecha()) .'</h2>';
	echo "<p>". $post->getContenido() ."</p>";
	$categoria = Categoria::getById($post->getCategoria());
	echo "<p>Categoría: ". $categoria->getNombre() ."</p><br><br>";

	if (isset($_SESSION['user']) && ($post->getAutor() == $_SESSION['user']->getId() || 
		$_SESSION['user']->isAdmin())){?>
			<a href="<?php echo URL;?>postcontroller/editar?id=<?php echo $post->getId();?>">Editar</a>
			<a href="<?php echo URL;?>postcontroller/borrar?id=<?php echo $post->getId();?>">Borrar</a>
	<?php }
	
	?>
</div>