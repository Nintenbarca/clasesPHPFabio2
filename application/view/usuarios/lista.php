<div class="container">
	<h1>Usuarios</h1>
	<?php
	foreach ($usuarios as $usuario) {
		echo "<h2>Nick: ". $usuario->getNick() ."</h2>";
		echo "<h2>Email: ". $usuario->getEmail() ."</h2>";

		if (isset($_SESSION['user']) && $_SESSION['user']->isAdmin()) {?>
			<a href="<?php echo URL;?>usuariocontroller/editar/<?php echo $usuario->getId();?>">Editar</a>
			<a href="<?php echo URL;?>usuariocontroller/borrar/<?php echo $usuario->getId();?>">Borrar</a>
		<?php }
	}
	?>
</div>