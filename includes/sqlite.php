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

class SQLite {

    var $file;
    var $query;
    var $database;
    var $result;

    function SQLite($file) {

        $this->file = $file;

        try {
            $this->database = new SQLite3($this->file);
        } catch (Exception $e) {
            die($error);
        }
    }

    function AutoSetup($configname, $configdesc, $configadmin, $configpass, $configemail) {

        try {

            if ($this->database->exec('CREATE TABLE "Config" (Key TEXT, Value TEXT, PRIMARY KEY (Key))')) {

                $configpass = md5($configpass . "MyCMS");

                if ($this->database->exec(
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_name", "' . $configname . '"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_desc", "' . $configdesc . '"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_admin", "' . $configadmin . '"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_pass", "' . $configpass . '"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_theme", "default"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_contact", "enabled"); ' .
                        'INSERT INTO Config (Key, Value) ' .
                        'VALUES ("site_email", "' . $configemail . '")')) {
                    try {

                        if (@$this->database->exec('CREATE TABLE "Sections" (Title TEXT, Seo TEXT, Content TEXT, Tags TEXT, UNIQUE (Seo))')) {

                            //Sample section
                            if (!$this->database->exec('INSERT INTO Sections (Title, Seo, Content, Tags) ' .
                                    'VALUES ("Portada", "portada", "<p>Bienvenido a la página de ejemplo de Migdc, la forma más rápida de crear contenido en Internet!</p><br><br><br><br><br><br><br><br><br>", "portada")')) {
                                return true;
                            }
                        }
                    } catch (Exception $e) {
                        return false;
                    }
                }

                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function ReadConfig() {
        //read data from database
        if ($this->result = $this->database->query("SELECT * FROM Config", SQLITE_BOTH, $error)) {
            while ($row = $this->result->fetch()) {
                print("Key: {$row['Key']} <br />" .
                        "Value: {$row['Value']} <br />");
            }
        } else {
            die($error);
        }
    }

    function UpdateConfig($configname, $configdesc, $configemail, $actualpass=null, $newpass=null, $theme="default", $contact) {
        if (!empty($actualpass) && !empty($newpass) && !empty($configname) && !empty($configdesc) && !empty($configemail)) {
            if ($contact == true)
                $contact = "enabled";
            else
                $contact = "disabled";
            if (md5($actualpass . "MyCMS") == $GLOBALS['site_pass']) {

                $this->database->exec('UPDATE Config SET Value="' . $configname . '" WHERE Key=\'site_name\';
                            UPDATE Config SET Value=\'' . $configdesc . '\' WHERE Key=\'site_desc\';
                            UPDATE Config SET Value=\'' . md5($newpass . "MyCMS") . '\' WHERE Key=\'site_pass\';
                            UPDATE Config SET Value=\'' . $theme . '\' WHERE Key=\'site_theme\';
                            UPDATE Config SET Value=\'' . $contact . '\' WHERE Key=\'site_contact\';
                            UPDATE Config SET Value="' . $configemail . '" WHERE Key=\'site_email\'');

                $GLOBALS['site_name'] = $configname;
                $GLOBALS['site_desc'] = $configdesc;
                $GLOBALS['site_theme'] = $theme;
                $GLOBALS['site_pass'] = md5($newpass . "MyCMS");
                $GLOBALS['site_email'] = $configemail;
                $GLOBALS['site_contact'] = $contact; 
                
                return true;
            } else
                return false;
        } else if (!empty($configname) && !empty($configdesc) && !empty($configemail) && !empty($theme)) {
                        if ($contact == true)
                $contact = "enabled";
            else
                $contact = "disabled";
            $this->database->exec('UPDATE Config SET Value="' . $configname . '" WHERE Key=\'site_name\';
                            UPDATE Config SET Value=\'' . $configdesc . '\' WHERE Key=\'site_desc\';
                            UPDATE Config SET Value=\'' . $theme . '\' WHERE Key=\'site_theme\';
                            UPDATE Config SET Value=\'' . $contact . '\' WHERE Key=\'site_contact\';
                            UPDATE Config SET Value="' . $configemail . '" WHERE Key=\'site_email\'');
            $GLOBALS['site_name'] = $configname;
            $GLOBALS['site_desc'] = $configdesc;
            $GLOBALS['site_email'] = $configemail;
            $GLOBALS['site_theme'] = $theme;
            $GLOBALS['site_contact'] = $contact;    

            return true;
        } else
            return false;
    }
	
    function Result($query) {
        return $this->database->query($query);
    }

    function DoQuery($query) {
        return $this->database->exec($query);
    }

}

?>