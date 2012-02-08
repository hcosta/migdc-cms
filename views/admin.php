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

if (!empty($_SESSION['logged']) && isset($_GET['admin'])) {
    ?>
    <script language="javascript" type="text/javascript" src="assets/js/tiny_mce/tiny_mce.js"></script>
    <script language="javascript" type="text/javascript">
        tinyMCE.init({
            content_css : "assets/css/mycontent.css",
			mode : "textareas",
			theme : "advanced",
            theme_advanced_toolbar_location : "top",
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
				+ "formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
                + "undo,redo,cleanup,code,separator,sub,sup,charmap"
                + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
                + "cite, blockquote, quote, bullist,numlist,outdent,indent",
            theme_advanced_buttons3 : "",
            height:"350px",
            width:"97%",
            plugins : "media, pre",
            theme_advanced_buttons1_add : "media, pre",
            extended_valid_elements : "iframe[src|width|height|name|align], pre",
            file_browser_callback: 'openKCFinder'
        });
            
        function openKCFinder(field_name, url, type, win) {
            tinyMCE.activeEditor.windowManager.open({
                //file: '../../kcfinder/browse.php?lang=es&opener=tinymce&type=' + type,
				file: '../../kcfinder/browse.php?lang=es&opener=tinymce&type=file',
                title: 'KCFinder',
                width: 700,
                height: 500,
                resizable: "yes",
                inline: true,
                close_previous: "no",
                popup_css: false
            }, {
                window: win,
                input: field_name
            });
            return false;
        }
    </script>

    <?php

    //IF EDIT ADMIN OPTION FOUND

    if (isset($_GET['edit'])) {

        $id = cleanStr(addslashes($_GET['edit']));
        $section = new Section();
        $seo = $section->existsSectionId($id);

        if (is_numeric($id) && ($seo != false)) {
            echo "<h3>Admin - Editando [" . $seo . "]</h3>";

            ///////// START EDIT ==> CHECK FORM SENT /////////

            if (isset($_POST['SectionRowid']) && !empty($_POST['SectionTitle']) && !empty($_POST['SectionSeo']) && !empty($_POST['SectionContent'])) {
                if ($section->editSection(cleanStr($_POST['SectionRowid']), cleanStr($_POST['SectionTitle']), friendlyURL(cleanStr($_POST['SectionSeo'])), filterTextArea($_POST['SectionContent']), cleanStr(@$_POST['SectionTags'])))
                    echo 'Sección actualizada! <a href="index.php?' . $seo . '">Haz clic aquí para ver el resultado.</a><br><br>';
                else {
                    echo "Error actualizando... verifica los campos.<br><br>";
                }
            }

            ///////// END EDIT  ==> CHECK FORM SENT /////////

            $result = $db->Result("select rowid, * from Sections where rowid = '" . $id . "'");

            echo '  <form action="" method="POST">
                        Título*<br><input type="text" name="SectionTitle" value="' . $result[0]['Title'] . '"></input><br><br>
                        Seo-url*<br><input type="text" name="SectionSeo" value="' . friendlyURL($result[0]['Seo']) . '"></input><br><br>
                        Palabras clave para buscadores (separadas por comas)<br><input type="text" name="SectionTags" value="' . $result[0]['Tags'] . '"></input><br><br>
                        Contenido*<br><textarea id="SectionContent" name="SectionContent">' . $result[0]['Content'] . '</textarea><br>
                        <input type="hidden" name="SectionRowid" value="' . $result[0]['rowid'] . '"></input>
                        
                        <input type="submit" value="Actualizar"/><br><br>*Campos obligatorios 
                    </form><br>';
        } else {
            echo "<h3>Admin - Editando [...]</h3>";
            echo "Error: La sección no existe";
        }
    }

    //IF DELETE ADMIN OPTION FOUND
    else if (isset($_GET['delete'])) {
        $section = new Section();
        $id = cleanStr(addslashes($_GET['delete']));
        $seo = $section->existsSectionId($id);

        if (isset($_POST['DeleteRowid'])) {
            if ($section->deleteSection(cleanStr($_POST['DeleteRowid'])))
                echo '<h3>Admin - Borrar sección</h3>Sección eliminada! <a href="index.php">Volver</a><br><br>';
            else {
                echo "Error borrando....<br><br>";
            }
        } else {
            if ($seo) {
                echo '  
                <h3>Admin - Borrar sección [' . $seo . ']</h3>
                <form action="" method="POST" style="display: inline;">
                ¿Seguro que quieres borrar [' . $seo . ']?
                    <input type="hidden" name="DeleteRowid" value="' . $id . '"></input>
                    <br><input type="submit" value="Sí" onclick="return confirm(\'¿Seguro seguro seguro?\')"/>
                     
                </form><button onClick="history.back()">Mejor no</button><br><br><br><br><br><br><br><br><br><br>';
            } else {
                echo "<h3>Admin - Borrar sección [...]</h3>";
                echo "Error: La sección no existe";
            }
        }
    }

    //IF NEW ADMIN OPTION FOUND
    else if (isset($_GET['new'])) {

        if (isset($_POST['NewSection'])) {

            $section = new Section();

            if (!$section->existsSection(cleanStr($_POST['SectionSeo']))) {

                if ($section->newSection(cleanStr($_POST['SectionTitle']), friendlyURL(cleanStr($_POST['SectionSeo'])), filterTextArea($_POST['SectionContent']), cleanStr(@$_POST['SectionTags'])))
                    echo '<h3>Admin - Crear sección</h3>Sección creada! <a href="index.php?' . cleanStr($_POST['SectionSeo']) . '">Haz clic aquí para ver el resultado.</a><br><br>';
                else {
                    echo '
                        <h3>Admin - Crear sección</h3>
                        Error creando. Verifica los campos.<br><br>
                        <form action="" method="POST">
                                Título*<br><input type="text" name="SectionTitle" value="' . cleanStr($_POST['SectionTitle']) . '"></input><br><br>
                                Seo-url*<br><input type="text" name="SectionSeo" value="' . friendlyURL(cleanStr($_POST['SectionSeo'])) . '"></input><br><br>
                                Palabras clave para buscadores (separadas por comas)<br><input type="text" name="SectionTags" value="' . cleanStr($_POST['SectionTags']) . '"></input><br><br>
                                Contenido*<br><textarea cols="38" rows="5" name="SectionContent">' . filterTextArea($_POST['SectionContent']) . '</textarea><br>
                                <input type="hidden" name="NewSection"></input>
                                <input type="submit" value="Crear"/><br><br>*Campos obligatorios  
                            </form><br>';
                }
            } else {
                echo '
                        <h3>Admin - Crear sección</h3>
                        El enlace SEO ya existe. Verifica los campos.<br><br>
                        <form action="" method="POST">
                                Título*<br><input type="text" name="SectionTitle" value="' . cleanStr($_POST['SectionTitle']) . '"></input><br><br>
                                Seo-url*<br><input type="text" name="SectionSeo" value="' . friendlyURL(cleanStr($_POST['SectionSeo'])) . '"></input><br><br>
                                Palabras clave para buscadores (separadas por comas)<br><input type="text" name="SectionTags" value="' . cleanStr($_POST['SectionTags']) . '"></input><br><br>
                                Contenido*<br><textarea cols="38" rows="5" name="SectionContent">' . filterTextArea($_POST['SectionContent']) . '</textarea><br>
                                <input type="hidden" name="NewSection"></input>
                                <input type="submit" value="Crear"/><br><br>*Campos obligatorios 
                            </form><br>';
            }
        } else {
            echo '  
                <h3>Admin - Crear sección</h3>
                <form action="" method="POST">
                        Título*<br><input type="text" name="SectionTitle"></input><br><br>
                        Seo-url*<br><input type="text" name="SectionSeo"></input><br><br>
                        Palabras clave para buscadores (separadas por comas)<br><input type="text" name="SectionTags"></input><br><br>
                        Contenido*<br><textarea cols="38" rows="5" name="SectionContent"></textarea><br>
                        <input type="hidden" name="NewSection"></input>
                        <input type="submit" value="Crear"/><br><br>*Campos obligatorios 
                    </form><br>';
        }
    }
} else {
    header("Location: index.php");
}
?>
