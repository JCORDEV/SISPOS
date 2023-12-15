<?php
    /**
     ** Almacenando datos
     */
    $usuario = limpiar_cadena($_POST['login_usuario']);
    $clave = limpiar_cadena($_POST['login_clave']);

    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($usuario == "" || $clave == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /**
     * *Verificando integridad de los datos
     */


    //E-mail usuario
    if($usuario != ""){
        if (!filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El E-MAIL ingresado no es valido
                </div>
            ';
            exit();
        }
    }

    // contraseña
    if(verificar_datos("[a-zA-Z0-9$@-]{7,100}", $clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CONTRASEÑA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    $check_user = conexion();
    $check_user = $check_user->query("SELECT * FROM usuarios WHERE NombreUsuario='$usuario'");

    if ($check_user->rowCount() == 1) {
        $check_user = $check_user->fetch();
        if ($check_user['NombreUsuario'] == $usuario && $clave == $check_user['clave']) {
            //variables de sesion
            $_SESSION['id'] = $check_user['UsuarioID'];
            $_SESSION['usuario'] = $check_user['NombreUsuario'];
            $_SESSION['rol'] = $check_user['Rol'];
            // $_SESSION['usuario'] = $check_user['usuario_usuario'];

            if (headers_sent()) {
                echo "<scripts>window.location.href='index.php?vista=home'</script>";
            } else {
                header("Location: index.php?vista=home");
            }
            
        } else {
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CONTRASEÑA incorrectos
            </div>
        ';
        }
        
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CONTRASEÑA incorrectos
            </div>
        ';
    }

    $check_user = null;
    