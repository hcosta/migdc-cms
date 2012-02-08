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
        <title>Tusitio ha sido configurado correctamente! - MyCMS</title>
        <link href="assets/css/config.css" rel="stylesheet" type="text/css"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div align="center">
            <h3><br><br>Felicidades, el sitio ya está listo para empezar a usarlo. <a href="index.php">Siguiente paso</a></h3>
        </div>
    </body>
</html>

