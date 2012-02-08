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

session_start();

/*Start seconds count*/
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;

if (!file_exists('db/config.sqlite')) {
    header ('Location: config.php');
} else {
    
    require_once ('config.php');
    require_once ('includes/functions.php');
    require_once ('includes/classes.php');
    
    if (isset($_GET['login']) || isset($_GET['logout'])){
        include ('views/login.php');
    } else {
        // Secciones de la página
        include ('views/header.php');
        include ('views/menu.php');
        include ('views/content.php');
        
        /*Seconds stop*/
        list($usec, $sec) = explode(' ', microtime());
        $script_end = (float) $sec + (float) $usec;
        
        /*Calculate total time*/
        $elapsed_time = round($script_end - $script_start, 4);
        
        include ('views/footer.php');
    }
}



?>
