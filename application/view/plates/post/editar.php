<?php $this->layout('layout'); ?>

<div class="container">
	<h2>Editar Post</h2>

	<?php
    session_start();
    if (!empty($_SESSION["errores"])) {
        echo "<ul>";
        while (!empty($_SESSION["errores"])) {
            echo "<li style='color: red'>".array_pop($_SESSION["errores"])."</li>";
        }
        echo "</ul>";
    }?>

    <form action="<?php echo URL; ?>postcontroller/tryEditar" method="post">

    	<input type="hidden" name="id" value="<?php echo $post->getId();?>">

    	<p><label for="titulo">Titulo: </label>
    	<input type="text" name="titulo" value="<?php echo $post->getTitulo();?>" 
    	required></p>

    	<p><label for="contenido">Contenido: </label>
        <textarea name="contenido" 
        required><?php echo $post->getContenido();?></textarea></p>

        <p><label for="categoria">Categoria: </label>
		<select name="categoria">
		<?php
		foreach ($categorias as $categoria) {
					
		echo '<option value="'.$categoria->getId().'"';
			if($categoria->getId() == $post->getCategoria()){
				echo ' selected';
			}
		echo '>';
		echo $categoria->getNombre();
		echo '</option>';
		}
		?>
		</select></p>

		<p><input type="submit" value="Guardar"></p>
    </form>
</div>