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
function print_login() {
    echo '
    <form action="" method="POST">
        Usuario <br><input type="text" name="loginuser"></input><br>
        Contraseña <br><input type="password" name="loginpass"></input><br>
        <input style="margin-top:10px; width: 80px;"type="submit" value="Login"></input><br>
    </form>';
}

function print_logout() {
    echo '
    <form action="" method="GET">
        <input type="hidden" name="logout"></input>
        <input style="width: 80px;" type="submit" value="Logout"></input><br>
    </form>
';
}

function cleanStr($string) {
    return htmlspecialchars($string);
}

function filterTextArea($string) {
    $find = array("<?php", "?>", "'");
    $replace = array("&lt;?php", "?&gt;", "''");
    return str_replace($find, $replace, $string);
}

function getThemes() {
    $dirs = getFileList("themes");
    foreach ($dirs as $theme) {
        $themes[] = substr(substr($theme['name'], 7), 0, strlen(substr($theme['name'], 7)) - 1);
    }
    return $themes;
}

function getFileList($dir) {
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if (substr($dir, -1) != "/")
        $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while (false !== ($entry = $d->read())) {
        // skip hidden files
        if ($entry[0] == ".")
            continue;
        if (is_dir("$dir$entry")) {
            $retval[] = array(
                "name" => "$dir$entry/",
                "type" => filetype("$dir$entry"),
                "size" => 0,
                "lastmod" => filemtime("$dir$entry")
            );
        } elseif (is_readable("$dir$entry")) {
            $retval[] = array(
                "name" => "$dir$entry",
                "type" => mime_content_type("$dir$entry"),
                "size" => filesize("$dir$entry"),
                "lastmod" => filemtime("$dir$entry")
            );
        }
    }
    $d->close();

    return $retval;
}

function friendlyURL($string){
	$string = preg_replace("`\[.*\]`U","",$string);
	$string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
	$string = htmlentities($string, ENT_COMPAT, 'utf-8');
	$string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
	$string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
	return strtolower(trim($string, '-'));
}

function isEmail($email) {
    $pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
    return preg_match($pattern, $email);
}

?>