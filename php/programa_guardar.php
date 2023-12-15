<?php
    require_once "main.php";

    /**
     ** Almacenando datos
     */
    $snies = limpiar_cadena($_POST['codigo_snies']);
    $descripcion = limpiar_cadena($_POST['descripcion_programa']);
    $email = limpiar_cadena($_POST['email_programa']);
    $telefono = limpiar_cadena($_POST['telefono_programa']);
    $lineatrabajo = limpiar_cadena($_POST['lineatrabajo_programa']);
    $fecharesolucion = limpiar_cadena($_POST['fecharesolucion_programa']);
    $coordinador = limpiar_cadena($_POST['coordinador_programa']);
    $resolucion = limpiar_cadena($_POST['resolucion_programa']);
    
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($snies == "" || $descripcion == "" || $email =="" || $telefono == "" || $lineatrabajo == "" || $fecharesolucion == "" ||  $coordinador == "" || $resolucion == "") {
        echo '
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    No has llenado todos los campos que son obligatorios.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        ';
        exit();
    }

    /**
     * *Verificando integridad de los datos
     */

    if(verificar_datos("[0-9]{1,70}", $snies)){
        echo '
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    El código SNIES no coincide con el formato solicitado.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        ';
        exit();
    }

    $check_snies = conexion();
    $check_snies = $check_snies->query("SELECT CodigoSNIES FROM programaposgrado WHERE CodigoSNIES='$snies'");
    if ($check_snies->rowCount() > 0) {
        echo '
                    El código SNIES ingresado ya se encuentra registrado, por favor elija otro
        ';
        exit();
    }

    /**
    * *Directorio de imagenes
    * Donde se almacenaran las imagenes
    */

    $img_dir = "../img/ProgramaAcademico/logo/";

    /**
     * *Comprobar si se selecciono una imagen
     */

    if ($_FILES['logo_programa']['name'] != "" && $_FILES['logo_programa']['size'] > 0) {
        //Creando directorio
        if (!file_exists($img_dir)) {
            if (!mkdir($img_dir, 0777)) {
                echo '
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                            Error al crear el directorio.
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        </div>
                    </div>
                ';
                exit();
            }
        }

        //Verificando formato de imagenes
        if (mime_content_type($_FILES['logo_programa']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['logo_programa']['tmp_name']) != "image/png") {
            echo '
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                        La IMAGEN que ha seleccionado es de un formato no permitido.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    </div>
                </div>
            ';
            exit();
        }

        //Verificando peso de imagen < 3MB
        if (($_FILES['logo_programa']['size'] / 1024) > 3072) {
            echo '
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                        La IMAGEN que ha seleccionado supera el peso permitido.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    </div>
                </div>
            ';
            exit();
        }

        //Extensión de la imagen

        switch (mime_content_type($_FILES['logo_programa']['tmp_name'])) {
            case 'image/jpeg':
                $img_ext = ".jpg";
                break;
            case 'image/png':
                $img_ext = ".png";
                break;
        }

        chmod($img_dir, 0777);
        $img_nombre = renombrar_fotos($descripcion); //Nombre de la imagen en BD
        $foto = $img_nombre . $img_ext; //Nombre final para la BD

        //Moviendo imagen al directorio
        if (!move_uploaded_file($_FILES['logo_programa']['tmp_name'], $img_dir . $foto)) {
            echo '
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                        No podemos cargar la imagen al sistema en este momento.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    </div>
                </div>
            ';
            exit();
        }
    } else {
        $foto = "";
    }


    // //Nombre usuario
    // if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)){
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             El NOMBRE no coincide con el formato solicitado
    //         </div>
    //     ';
    //     exit();
    // }

    // $check_usuario = conexion();
    // $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuario WHERE usuario_usuario='$usuario'");
    // if ($check_usuario->rowCount() > 0) {
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             El USUARIO ingresado ya se encuentra registrado, por favor elija otro
    //         </div>
    //     ';
    //     exit();
    // }

    // $check_usuario = null;//cerramos conexión

    // //Apellido usuario
    // if(verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)){
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             El APELLIDO no coincide con el formato solicitado
    //         </div>
    //     ';
    //     exit();
    // }

    // //Nickname usuario
    // if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             El USUARIO no coincide con el formato solicitado
    //         </div>
    //     ';
    //     exit();
    // }

    // //E-mail usuario
    // if($email != ""){
    //     if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $check_email = conexion();
    //         $check_email = $check_email->query("SELECT usuario_email FROM usuario WHERE usuario_email='$email'");
    //         if ($check_email->rowCount() > 0) {
    //             echo '
    //                 <div class="notification is-danger is-light">
    //                     <strong>¡Ocurrio un error inesperado!</strong><br>
    //                     El E-MAIL ingresado ya se encuentra registrado, por favor elija otro
    //                 </div>
    //             ';
    //             exit();
    //         }

    //         $check_email = null;//cerramos conexión
    //     } else {
    //         echo '
    //             <div class="notification is-danger is-light">
    //                 <strong>¡Ocurrio un error inesperado!</strong><br>
    //                 El E-MAIL ingresado no es valido
    //             </div>
    //         ';
    //         exit();
    //     }
        
    // }

    // //Contraseña usuario
    // if(verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)){
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             Las CONTRASEÑAS no coincide con el formato solicitado
    //         </div>
    //     ';
    //     exit();
    // }

    // if ($clave_1 != $clave_2) {
    //     echo '
    //         <div class="notification is-danger is-light">
    //             <strong>¡Ocurrio un error inesperado!</strong><br>
    //             Las CONTRASEÑAS que ha ingresado no coinciden
    //         </div>
    //     ';
    //     exit();
    // } else {
    //     $clave = password_hash($clave_1, PASSWORD_BCRYPT, ["cost"=>10]);
    // }

    /**
     * *Guardando datos
     */

    $guardar_programa = conexion();
    //PREPARE[filtro de seguridad] -> prepara la consulta para después ser ejecutada, lo contrario a QUERY que la ejecuta de una vez la consulta

    //preparando consulta
    $guardar_programa = $guardar_programa->prepare("INSERT INTO programaposgrado(CodigoSNIES, Descripcion, Logo, Correo, TelefonoContacto, resolucion, fecha, lineatrabajoID, CoordinadorID) VALUES(:snies, :descripcion, :logo, :email, :telefono, :resolucion, :fecha, :lineatrabajo, :coordinador)");//:nombre_marcador -> los marcadores nos sirven para identificar las variables donde iran los valores reales

    //ejecutando consulta
    $marcadores = [
        ":snies" => $snies,
        ":descripcion" => $descripcion,
        ":logo" => $foto,
        ":email" => $email,
        ":telefono" => $telefono,
        ":resolucion" => $resolucion,
        ":fecha" => $fecharesolucion,
        ":lineatrabajo" => $lineatrabajo,
        ":coordinador" => $coordinador
    ];

    $guardar_programa->execute($marcadores);

    if ($guardar_programa->rowCount() == 1) {
        echo '
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    El usuario se registro con exito.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        ';
    } else {
        echo '
            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    No se pudo registrar el usuario, por favor intente nuevamente.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                </div>
            </div>
        ';
    }

    $guardar_programa = null;
    
