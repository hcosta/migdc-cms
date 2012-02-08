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

require_once ('includes/sqlite.php');
require_once ('includes/functions.php');

if (!file_exists('db/config.sqlite')) {

    if (isset($_POST['configname']) && isset($_POST['configdesc']) && isset($_POST['configadmin']) && isset($_POST['configpass']) && isset($_POST['configemail'])) {

        if (!empty($_POST['configname']) && !empty($_POST['configdesc']) && !empty($_POST['configadmin']) && !empty($_POST['configpass']) && !empty($_POST['configemail'])) {

            $db = new SQLite('db/config.sqlite');

            if ($db->AutoSetup(cleanStr($_POST['configname']), cleanStr($_POST['configdesc']), cleanStr($_POST['configadmin']), cleanStr($_POST['configpass']), cleanStr($_POST['configemail']))) {

                $result = $db->Result('SELECT * FROM Config');

                // Dump db config to CMS
                foreach ($result as $entry) {
                    switch ($entry['Key']) {
                        case 'site_name':
                            $GLOBALS['site_name'] = $entry['Value'];
                            break;
                        case 'site_desc':
                            $GLOBALS['site_desc'] = $entry['Value'];
                            break;
                        case 'site_admin':
                            $GLOBALS['site_admin'] = $entry['Value'];
                            break;
                        case 'site_pass':
                            $GLOBALS['site_pass'] = $entry['Value'];
                            break;
                        case 'site_email':
                            $GLOBALS['site_email'] = $entry['Value'];
                            break;
                        case 'site_contact':
                            $GLOBALS['site_contact'] = $entry['Value'];
                            break;
                        case 'site_theme':
                            $GLOBALS['site_theme'] = $entry['Value'];
                            break;
                    }
                }

                include ('views/ready.php');
            }
        } else {
            $error = true;
            include ('views/config.php');
        }
    } else
        include ('views/config.php');
} else {
    try {

        $db = new SQLite('db/config.sqlite');
        //$db->ReadConfig();
        $result = $db->Result('SELECT * FROM Config');

        // Dump db config to CMS
        foreach ($result as $entry) {
            switch ($entry['Key']) {
                case 'site_name':
                    $GLOBALS['site_name'] = $entry['Value'];
                    break;
                case 'site_desc':
                    $GLOBALS['site_desc'] = $entry['Value'];
                    break;
                case 'site_admin':
                    $GLOBALS['site_admin'] = $entry['Value'];
                    break;
                case 'site_pass':
                    $GLOBALS['site_pass'] = $entry['Value'];
                    break;
                case 'site_email':
                    $GLOBALS['site_email'] = $entry['Value'];
                    break;                        
                case 'site_contact':
                    $GLOBALS['site_contact'] = $entry['Value'];
                    break;
                case 'site_theme':
                    $GLOBALS['site_theme'] = $entry['Value'];
                    break;
            }
        }
    } catch (Exception $e) {
        //
    }
}
?>
