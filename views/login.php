<!DOCTYPE html>
<html>
    <head>
        <title>Login panel - MyCMS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="themes/<?=$GLOBALS['site_theme']?>/css/config.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <div align="center">
            <h2><?=$site_name?></h2>
            <div class="loginDiv">

                <?php
                $login = new Login();

                $fail = false;

                if (isset($_POST['loginuser']) && isset($_POST['loginpass'])) {
                    if (!$login->doLogin(cleanStr($_POST['loginuser']), md5($_POST['loginpass'] . "MyCMS")))
                        $fail = true;
                    else
                        header('Location: index.php');
                }

                if (isset($_GET['logout'])) {
                    $login->doLogout();
                    header('Location: index.php');
                }

                if ($login->isLogged()) {
                    echo "  <b>Logout panel</b><br><br>";
                    print_logout();
                } else {
                    echo "  <b>Login panel</b><br><br>";
                    print_login();
                    if ($fail)
                        echo "Login Fail";
                }
                ?> 
            </div><br>
            <a href="index.php">Volver</a>
        </div>
    </body>
</html>
