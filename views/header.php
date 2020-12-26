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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title><?= $site_name ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="title" content="<?= $site_name ?>" />
        <meta name="DESCRIPTION" content="<?=$GLOBALS['site_desc']?>" />
        <meta content="index, follow" name="robots"/> 
        <?php
        foreach ($_GET as $key => $elem)
            $keys[] = $key;
        $db = new SQLite('db/config.sqlite');
        $result = $db->Result("select rowid, * from Sections");
        foreach ($result as $page) {
            $seo = $page['Seo'];
            if ($keys[0] == $seo) {
                echo '<meta name="Keywords" content="' . $page['Tags'] . '" />
        ';
                break;
            }
        }
        echo '<meta name="Lang" content="es" />
';
        ?>
        <link href="themes/<?=$GLOBALS['site_theme']?>/css/<?=$GLOBALS['site_theme']?>.css" rel="stylesheet" type="text/css" />
		<link href="assets/js/fancybox/css/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" /> 
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'></script>
		<script type="text/javascript" src="assets/js/fancybox/js/jquery.fancybox-1.3.4.pack.js"></script> 
		<script type="text/javascript" src="assets/js/fancybox/js/jquery.mousewheel-3.0.4.pack.js"></script> 
		<script type="text/javascript" src="assets/js/fancybox/js/jquery.easing-1.3.pack.js"></script> 
		<script type="text/javascript">
			$(function() {
				$('a[href$=jpg], a[href$=JPG], a[href$=jpeg], a[href$=JPEG], a[href$=png], a[href$=PNG], a[href$=gif], a[href$=GIF], a[href$=bmp], a[href$=BMP]:has(img)').fancybox({
					  'titleShow'     : true,
					  'transitionIn'	: 'fade',
					  'transitionOut'	: 'fade',
					  'easingIn'      : 'easeOutBack',
					  'easingOut'     : 'easeInBack'  
				  });
			});
		</script>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1><a href="index.php"><?= $site_name ?></a></h1>
                <h3><?= $site_desc ?></h3>
            </div>
