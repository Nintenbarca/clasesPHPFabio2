<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>MINI</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->
    <!-- See more here: http://stackoverflow.com/q/2105327/1114320 -->

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
    <!-- logo -->
    <div class="logo">
        MINI
    </div>

    <!-- navigation -->
    <div class="navigation">
        <a href="<?php echo URL; ?>">home</a> 
        <?php  
        //error_reporting(0);
        session_start();
        if (isset($_SESSION['user'])) {?>
            <a href="<?php echo URL; ?>postcontroller">posts</a>
            <a href="<?php echo URL; ?>usuariocontroller/logout">cerrar sesión</a>
        <?php
            if ($_SESSION['user']->isAdmin()) {?>
                <a href="<?php echo URL; ?>usuariocontroller">usuarios</a>
            <?php }
        }else{?>
            <a href="<?php echo URL; ?>usuariocontroller/login">login</a>
            <a href="<?php echo URL; ?>usuariocontroller/signup">registrar</a>
            <a href="<?php echo URL; ?>postcontroller">posts</a>
        <?php
        }
        ?>     
        <br><br>

        <form action="<?php echo URL; ?>postcontroller/results" method = "POST">
            <input type="search" name="query">
            <input type="submit" value="Buscar">
        </form>   

    </div>
