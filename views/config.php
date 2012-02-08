<?php

/**
 * Este código se encuentra bajo una licencia GPLv3
 * Usted es libre de utilitzar, modificar, compartir o mejorar el código.
 * Al hacerlo deberá citar la licencia y el autor del código.
 * Usted no puede apropiarse del código para usos comerciales.
 * Una copia de la licencia se adjunta en el directorio principal.
 * 
 * Copyright 2012 Héctor Costa Guzmán
 */

if (file_exists('../db/config.sqlite'))
    header('Location: ../index.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Configura tu sitio web - MyCMS</title>
        <link href="themes/default/css/config.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div id="content">
            <div align="center"><br><h3 style="padding: 0;margin: 0;">Configurar MyCMS</h3></div><br>
            <?php
            
                @$titulo = cleanStr($_POST['configname']);
                @$descr = cleanStr($_POST['configdesc']);
                @$usuario = cleanStr($_POST['configadmin']);
                @$email = cleanStr($_POST['configemail']);
            
                if (@$error) echo "<u>No se admiten campos vacíos.</u><br><br>";
                
            ?>
            <form action="config.php" method="POST">
                Título del site *<br><input type="text" size="50" name="configname" value="<?=$titulo?>" /><br><br>
                Breve descripción *<br><textarea cols="38" rows="5" name="configdesc"><?=$descr?></textarea><br><br>
                Usuario administrador *<br><input type="text" size="50" name="configadmin" value="<?=$usuario?>"/><br><br>
                Contraseña del administrador *<br><input type="password" size="50" name="configpass"/><br><br>
                Email de contacto del administrador *<br><input type="text" size="50" name="configemail" value="<?=$email?>"/><br><br>* Campos obligatorios
                <br><br><div align="center"><input type="submit" value="Siguiente"/></div>
            </form>
        </div>
    </body>
</html>