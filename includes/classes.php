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

class ContactRequest {
    
    function SendEmail($name, $email, $reason, $msg) {
        $to = $GLOBALS['site_email'];
        $asunto = "Nuevo correo de " . $GLOBALS['site_name'] . "";
        $message ="\n\nDe: " . $email;
        $message ="\nNombre: " . $name;
        $message .="\nAsunto: " . $reason;
        $message .="\nMissatge: " . $msg;
        if (@mail($to, $asunto, $message)) {
            return true;
        } else
            return false;
    }
    
}

class Login {

    function Login() {
        
    }

    function doLogin($user, $password) {
        if ($user == $GLOBALS['site_admin'] && $password == $GLOBALS['site_pass']) {
            $_SESSION['logged'] = true;
            //Kcfinder
            $_SESSION['KCFINDER'] = array();
            $_SESSION['KCFINDER']['disabled'] = false;
            return true;
        } else
            return false;
    }

    function isLogged() {
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true)
            return true;
        else
            return false;
    }

    function doLogout() {
        session_destroy();
    }

}

include_once 'sqlite.php';

class Section {

    var $db;

    function Section() {
        $this->db = new SQLite('db/config.sqlite');
    }

    function newSection($title, $seo, $content, $tags="") {

        if (empty($title) || empty($seo) || empty($content))
            return false;

        $query = 'INSERT INTO Sections (Title, Seo, Content, Tags) ' .
                'VALUES ("' . $title . '", "' . $seo . '", \'' . $content . '\', \'' . $tags . '\')';

        $this->db->DoQuery($query);
        return true;
    }

    function editSection($id, $title, $seo, $content, $tags="") {

        if (empty($id) || empty($title) || empty($seo) || empty($content))
            return false;

        $query = 'UPDATE Sections SET Title="' . $title . '", Seo="' . $seo . '", Content=\'' . $content . '\', Tags=\'' . $tags . '\' WHERE rowid="' . $id . '"';

        $this->db->DoQuery($query);
        return true;
    }

    function deleteSection($id) {

        if (empty($id))
            return false;

        $query = 'DELETE from Sections WHERE rowid="' . $id . '"';

        $this->db->DoQuery($query);
        return true;
    }

    function existsSection($seo) {

        $query = 'SELECT rowid from Sections WHERE seo="' . $seo . '"';
        $result = $this->db->Result($query);
        if (count($result) > 0)
            return $result[0]['rowid'];
        else
            return false;
    }

    function existsSectionId($id) {

        $query = 'SELECT seo from Sections WHERE rowid="' . $id . '"';
        $result = $this->db->Result($query);
        if (count($result) > 0)
            return $result[0]['seo'];
        else
            return false;
    }

}

//$s = new Section();
//echo $s->existsSection("about-us");
//if($s->editSection(3, "Example2", "example2", "<p>Example content 2</p>")) echo "Edited!";
?>
