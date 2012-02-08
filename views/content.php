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
            <div id="content">
                <?php
                //CHECK ADMIN OPTIONS
                $db = new SQLite('db/config.sqlite');
                $found = false;

                foreach ($_GET as $key => $elem) {
                    $keys[] = $key;
                }

                if (!isset($_GET['admin']) && !isset($_GET['edit']) && !isset($_GET['delete'])) {

                    $others = array("config", "contacto");

                    $result = $db->Result("select rowid, * from Sections");
                    foreach ($result as $page) {
                        $seo = $page['Seo'];
                        if (isset($_GET["$seo"])) {

echo "                              
<!-- START POST CONTENT -->
                            
";
                            echo "<h3>" . $page['Title'] . "</h3>";

                            //ADMIN OPTIONS
                            if (!empty($_SESSION['logged'])) {
                                echo '<button style="width: 80px;" onclick="window.location.href=\'index.php?admin&edit=' . $page['rowid'] . '\'">Editar</button>';
                                echo '<button style="width: 80px;margin-left:5px;" onclick="window.location.href=\'index.php?admin&delete=' . $page['rowid'] . '\'">Borrar</button>';
                            }
                            echo $page['Content'];
                            
echo "
                            
<!-- END POST CONTENT -->
        
";

                            $found = true;
                            break;
                        }
                    }
                    if (!$found && (count($result) < 1)) {
                        echo "<h3>No hay páginas para mostrar.</h3><br><br><br><br><br><br>";
                    } else if (!$found && in_array($keys[0], $others)) {
                        if ($keys[0] == "config")
                            include 'panel.php';
                        else if ($keys[0] == "contacto")
                            include 'contact.php';
                    } else if (!$found && (count($result) > 0)) {
                        header('Location: index.php?' . $result[0]['Seo'] . '');
                    }
                } else {
                    include_once 'views/admin.php';
                }
                ?>
            </div> 
