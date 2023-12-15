<?php require "./inc/session_start.php"?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include "./inc/head.php"?>
</head>
<body data-bs-theme="dark">
<?php
        //si la variable de session 'vista' no esta definida o esta vacia nos la crea con el valor=login
        if(!isset($_GET['vista']) || $_GET['vista'] == ""){
            $_GET['vista']="login";
        }

        /**VERIFICACION DE ARCHIVOS
         * condicion #1 -> si el archivo existe en el sistema, además que la variable de session se diferente a 'login' y '404', creara la vista
         * 
         * condicion #2 -> sino creara una vista por defecto 'login' o en su defecto si no existe la página solicitada se mostrara la vista '404'
         */
        if(is_file("./vistas/".$_GET['vista'].".php") && $_GET['vista'] != "login" && $_GET['vista'] != "404"){

            /**
             * *CIERRE DE SESION FORZADO
             * evitaremos que usuarios al manipular la URL puedan entrar al sistema*/

            if ((!isset($_SESSION['id']) || $_SESSION['id']=="") || (!isset($_SESSION['usuario']) || $_SESSION['usuario']=="")) {
                include "./vistas/cerrar_sesion.php";
                exit();
            }

            /**
             * *________________________________________
             */

            include "./inc/navbar.php";
            include "./vistas/".$_GET['vista'].".php";
            include "./inc/scripts.php";
        }else{
            if($_GET['vista'] == "login"){
                include "./vistas/login.php";
            }else{
                include "./vistas/404.php";
            }
        }
    ?>
</body>
</html>