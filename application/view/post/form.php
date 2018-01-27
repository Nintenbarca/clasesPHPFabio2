<div class="container">
	<h2>Añadir Post</h2>

    <?php
    session_start();
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