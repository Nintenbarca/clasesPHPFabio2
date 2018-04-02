<?php $this->layout('layout'); ?>

<div class="container">
	<h2>Editar Usuario</h2>

	<?php
    error_reporting(0);
    session_start();
    if (!empty($_SESSION["errores"])) {
        echo "<ul>";
        while (!empty($_SESSION["errores"])) {
            echo "<li style='color: red'>".array_pop($_SESSION["errores"])."</li>";
        }
        echo "</ul>";
    }?>

    <form action="<?php echo URL; ?>usuariocontroller/tryEditar" method="post">

    	<input type="hidden" name="id" value="<?php echo $usuario->getId();?>">

    	<p><label for="nombre">Nombre: </label>
    	<input type="text" name="nombre" value="<?php echo $usuario->getNombre();?>" 
    	required></p>

        <p><label for="apellidos">Apellidos: </label>
        <input type="text" name="apellidos" value="<?php echo $usuario->getApellidos();?>"
        required></p>

        <p><label for="email">Email: </label>
        <input type="email" name="email" value="<?php echo $usuario->getEmail();?>" 
        required></p>

        <p><label for="nick">Nick: </label>
        <input type="text" name="nick" value="<?php echo $usuario->getNick();?>"
        required></p>

        <p><label for="pass">Contraseña: </label>
        <input type="password" name="pass" required></p> 

        <p><label for="pass2">Repetir Contraseña: </label>
        <input type="password" name="pass2" required></p>  	        

		<p><input type="submit" value="Guardar"></p>
    </form>
</div>