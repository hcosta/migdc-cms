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
<div><br><h3 style="padding: 0;margin: 0;">Configurar Migdc</h3><br>
    <?php
    @$name = cleanStr($_POST['configName']);
    @$descr = cleanStr($_POST['configDesc']);
    @$theme = cleanStr($_POST['configTheme']);
    @$oldpass = cleanStr($_POST['configOldPass']);
    @$newpass = cleanStr($_POST['configNewPass']);
    @$email = cleanStr($_POST['configEmail']);
    @$contact = cleanStr($_POST['configContact']);
    
    if ($contact == "true") $contact = true;
    else if ($contact == "false") $contact = false;
    else $contact = true;

    if (isset($_POST['updateConfig'])) {
        if (!empty($name) && !empty($descr) && !empty($email)) {
            if ($db->UpdateConfig($name, $descr, $email, $oldpass, $newpass, $theme, $contact)) {
                echo "Configuración actualizada correctamente. <a href='index.php'>Haz clic aquí para ver el resultado.</a><br><br>";
            } else {
                echo "<u>Se ha encontrado algún fallo, inténtalo de nuevo.</u><br><br>";
            }
        }
    }
    ?>
    <form action="" method="POST">
        Título del site *<br><input type="text" size="50" name="configName" value="<?= $GLOBALS['site_name'] ?>" /><br><br>
        Breve descripción *<br><textarea style="width: 95%;" rows="5" name="configDesc"><?= $GLOBALS['site_desc'] ?></textarea><br><br>
        Usuario administrador<br><input type="text" size="50" name="configAdmin"  readonly="readonly" value="<?= $GLOBALS['site_admin'] ?>"/><br><br>
        Tema *<br>
        <select name="configTheme">
            <?php
            
            foreach (getThemes() as $theme) {
                if ($GLOBALS['site_theme'] == $theme)
                    echo '<option value="' . $theme . '" selected>' . $theme . '</option>';
                else
                    echo '<option value="' . $theme . '">' . $theme . '</option>';
            }
            ?>
        </select><br><br>
        Formulario de contacto *<br>
        <input type="radio" name="configContact" value="true" <?php if ($GLOBALS['site_contact'] == "enabled") echo 'CHECKED'?>/> Activado<br />
        <input type="radio" name="configContact" value="false" <?php if ($GLOBALS['site_contact'] == "disabled") echo 'CHECKED'?>/> Desactivado<br><br>
        Contraseña actual<br><input type="password" size="50" name="configOldPass"/><br><br>
        Nueva contraseña<br><input type="password" size="50" name="configNewPass"/><br><br>
        Email de contacto del administrador *<br><input type="text" size="50" name="configEmail" value="<?= $GLOBALS['site_email'] ?>"/><br><br>* Campos obligatorios
        <input type="hidden" name="updateConfig"/>
        <br><br><div align="center"><input type="submit" value="Cambiar"/></div><br>
    </form>
</div>