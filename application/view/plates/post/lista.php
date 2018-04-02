<?php $this->layout('layout'); ?>

<div class="container">
	<h1>Posts</h1><br>
	<?php session_start();
	foreach ($posts as $post) {
				
		echo "<h2>Titulo: ". $post->getTitulo() ."</h2>";
		$usuario = Usuario::getById($post->getAutor());	
		echo "<h3>Autor: ". $usuario->getNick() ."</h3>";	
		echo '<h3>Fecha: '. date('d-m-Y', $post->getFecha()) .'</h3>';		
		$categoria = Categoria::getById($post->getCategoria());
		echo "<p>Categoría: ". $categoria->getNombre() ."</p><br><br>";
		echo "<a href=\"".URL."postcontroller/detail/".$post->getId()."\">Ver Post</a>
			<br><br>";			
	} if(isset($_SESSION['user'])){?>
		<div class="container">
			<h2>Añadir Post</h2>

		    <?php
		    if (!empty($_SESSION["errores"])) {
		        echo "<ul>";
		        while (!empty($_SESSION["errores"])) {
		            echo "<li style='color: red'>".array_pop($_SESSION["errores"])."</li>";
		        }
		        echo "</ul>";
		    }?>

			<form action="<?php echo URL; ?>postcontroller/anadir" method="POST">   

		       <input type="hidden" name="autor" required value="<?php echo $_SESSION['user']->getId();?>">         
		        
		        <p><label for="titulo">Titulo: </label>
		        <input type="text" name="titulo" required=""></p>

		        <p><label for="contenido">Contenido: </label>
		        <textarea name="contenido" required=""></textarea></p>

		        <p><label for="categoria">Categoria: </label>
		        <select name="categoria">
		        <?php foreach ($categorias as $categoria) {
		            echo "<option value='". $categoria->getId() ."'>". $categoria->getNombre() .
		            "</option>";
		        }

		        ?>            
		        </select></p>

		        <p><input type="submit" value="Añadir"></p>
		    </form>
		</div>
	<?php		
	}else{			
		echo "Debes estar logueado para poder crear un post (Accede <a href=\"".URL."usuariocontroller/login\">aqui</a>)";
	}
	?>	
</div>
