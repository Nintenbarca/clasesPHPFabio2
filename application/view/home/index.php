<div class="container">
	<?php

	if (isset($_SESSION['user'])) {
		echo "<h1>Bienvenido ". $_SESSION['user']->getNick() ."</h1>";
	}else{
		echo "<h1>Bienvenido</h1>";

	}	
	?>    
</div>