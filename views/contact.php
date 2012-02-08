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

    if ($GLOBALS['site_contact'] == "disabled")
        header('Location: index.php');
?>
<div>
    <br>
    <h3 style="padding: 0;margin: 0;">Formulario de contacto</h3>
    <?php
    @$name = cleanStr($_POST['contactName']);
    @$email = cleanStr($_POST['contactEmail']);
    @$reason = cleanStr($_POST['contactReason']);
    @$message = cleanStr($_POST['contactMessage']);
    $error = true;

    if (isset($_POST['contactCaptcha'])) {
        if ($_POST['contactCaptcha'] == $_SESSION['captcha']) {
            if (!empty($name) && !empty($email) && !empty($reason) && !empty($message) && isEmail($email) && (strlen($message) >= 30)) {
                $cr = new ContactRequest();
                if ($cr->SendEmail($name, $email, $reason, $message)) {
                    $error = false;
                    echo "<br>Mensaje enviado correctamente. El administrador se pondrá en contacto contigo próximamente.<br><br><br><br><br><br><br><br><br><br><br><br><br>";
                } else {
                    echo "<br><u>El servidor ha sufrido un error enviando el mensaje, inténtelo de nuevo más tarde. Disculpe las molestias.</u><br>";
                }
            } else {
                echo "<br>";
                    if (empty($name))
                        echo "<u style='color: red;'>El nombre es necesario</u><br>";
                    if (empty($reason))
                        echo "<u style='color: red;'>La razón es necesaria</u><br>";
                    if (!isEmail($email))
                        echo "<u style='color: red;'>Email incorrecto</u><br>";
                    if (strlen($message) < 30)
                        echo "<u style='color: red;'>El mensaje es demasiado corto</u><br>";
                    if ($error)
                        echo "<u style='color: red;'>No se ha podido enviar tu mensaje, revisa los campos</u><br>";
                }
        } else {
            echo "<br>";
            if (empty($name))
                echo "<u style='color: red;'>El nombre es necesario</u><br>";
            if (empty($reason))
                echo "<u style='color: red;'>La razón es necesaria</u><br>";
            if (!isEmail($email))
                echo "<u style='color: red;'>Email incorrecto</u><br>";
            if (strlen($message) < 30)
                echo "<u style='color: red;'>El mensaje es demasiado corto</u><br>";
            echo "<u style='color: red;'>Antispam incorrecto</u><br>";
            if ($error)
                echo "<u style='color: red;'>No se ha podido enviar tu mensaje, revisa los campos</u><br>";
        }
    }

    /* ANTISPAM */
    $numeros = array(
        array("valor" => "cero"),
        array("valor" => "uno"),
        array("valor" => "dos"),
        array("valor" => "tres"),
        array("valor" => "cuatro")
    );

    $rand1 = rand(0, 4);
    $rand2 = rand(0, 4);

    $suma = $rand1 + $rand2;

    $_SESSION['captcha'] = $suma;

    if ($error == true) {
        ?>
        <p>Puedes ponerte en contacto con el administrador rellenando el siguiente formulario:</p>
        <form action="" method="POST">
            Nombre completo *<br><input type="text" size="50" name="contactName" value="<?= @$name ?>" /><br><br>
            Razón *<br><input type="text" size="50" name="contactReason" value="<?= @$reason ?>" /><br><br>
            Email * <b>(para responderte)</b><br><input type="text" size="50" name="contactEmail" value="<?= @$email ?>" /><br><br>
            Mensaje * <b>(30 carácteres mínimo)</b><br><textarea style="width: 95%;" rows="5" name="contactMessage"><?= @$message ?></textarea><br><br>
            Antispam: contesta en número <b>¿<?= $numeros[$rand1]['valor'] . ' + ' . $numeros[$rand2]['valor'] ?>?</b> * <br><input type="text" size="50" name="contactCaptcha" value="" /><br><br>* Campos obligatorios
            <br><br><div align="center"><input type="submit" value="Enviar mensaje"/></div><br>
        </form>
        <?php
    }
    ?>
</div>