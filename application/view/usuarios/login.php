<div class="container">
	<h1>Login</h1>

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
	
	<form action="<?php echo URL; ?>usuariocontroller/trylogin" method = "post">
		<p><label for="email">Email: </label>
		<input type="email" name="email"></p>		

		<p><label for="pass">Contraseña: </label>
		<input type="password" name="pass"></p>

		<p><input type="submit" value="Login"></p>
	</form>
</div>