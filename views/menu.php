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
            <div id="menu" style="text-align: center;">
                <h3>Secciones</h3>
                    <?php
                    $db = new SQLite('db/config.sqlite');
                    $results = $db->Result("select * from Sections");
                    while ($page = $results->fetchArray()){
                        echo '<button style="width: 85%;" onclick="window.location.href=\'index.php?' . $page['Seo'] . '\'">' . $page['Title'] . '</button><br>';
                    }

                    if ($GLOBALS['site_contact'] == "enabled") echo '<button style="width: 85%;" onclick="window.location.href=\'index.php?contacto\'">Contacto</button><br>';
                    
                    //ADMIN OPTIONS
                    echo '<h3>Admin</h3>';
                    if (!empty($_SESSION['logged'])) {
                        echo '<button style="width: 85%;" onclick="window.location.href=\'index.php?admin&new\'">Crear</button><br>';
                        echo '<button style="width: 85%;" onclick="window.location.href=\'index.php?config\'">Panel</button><br>';
                        echo '<br><button style="width: 85%;" onclick="window.location.href=\'index.php?logout\'">Salir</button><br><br>';
                    } else echo '<button style="width: 85%;" onclick="window.location.href=\'index.php?login\'">Login</button><br><br>';
                    ?>
                </ul>
            </div>
