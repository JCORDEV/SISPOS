<?php
    require_once "main.php";

    /**
     ** Almacenando datos
     */
    $snies = limpiar_cadena($_POST['codigo_snies']);
    $descripcion = limpiar_cadena($_POST['descripcion_programa']);
    $email = limpiar_cadena($_POST['email_programa']);
    $telefono = limpiar_cadena($_POST['telefono_programa']);
    
    $fecharesolucion = limpiar_cadena($_POST['fecharesolucion_programa']);
    $coordinador = limpiar_cadena($_POST['coordinador_programa']);
    // $resolucion = limpiar_cadena($_POST['resolucion_programa']);
    $modalidad = limpiar_cadena($_POST['modalidad_programa']);
    
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($snies == "" || $descripcion == "" || $email =="" || $telefono == "" || !isset($_POST['lineatrabajo_programa']) || $fecharesolucion == "" ||  $coordinador == "") {
        alert('No has llenado todos los campos que son obligatorios.', 2);
        exit();
    }$lineatrabajo = $_POST['lineatrabajo_programa'];

    /**
     * *Verificando integridad de los datos
     */

    if(verificar_datos("[0-9]{1,70}", $snies)){
        alert('El código SNIES no coincide con el formato solicitado.', 2);
        exit();
    }

    $check_snies = conexion();
    $check_snies = $check_snies->query("SELECT Codigo_SNIES FROM programa WHERE Codigo_SNIES='$snies'");
    if ($check_snies->rowCount() > 0) {
        alert("El código SNIES ingresado ya se encuentra registrado, por favor elija otro",2);
        exit();
    }
    
    $check_coordinador = conexion();
    $check_coordinador = $check_coordinador->query("SELECT id_coordinador FROM programa WHERE id_coordinador ='$coordinador'");
    if ($check_coordinador->rowCount() > 0) {
        alert("El coordinador seleccionado ya se encuentra asignado a un programa, por favor elija otro",2);
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
                alert('Error al crear el directorio.', 2);
                exit();
            }
        }

        //Verificando formato de imagenes
        if (mime_content_type($_FILES['logo_programa']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['logo_programa']['tmp_name']) != "image/png") {
            alert('La IMAGEN que ha seleccionado es de un formato no permitido.', 2);
            exit();
        }

        //Verificando peso de imagen < 3MB
        if (($_FILES['logo_programa']['size'] / 1024) > 3072) {
            alert('La IMAGEN que ha seleccionado supera el peso permitido.', 2);
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
            alert('No podemos cargar la imagen al sistema en este momento.', 2);
            exit();
        }
    } else {
        $foto = "";
    }


    /**
    * *Directorio de PDF
    * Donde se almacenaran las imagenes
    */

    $pdf_dir = "../pdf/ProgramaAcademico/resolución/";

    /**
     * *Comprobar si se selecciono un archivo pdf
     */

    if ($_FILES['resolucion_programa']['name'] != "" && $_FILES['resolucion_programa']['size'] > 0) {
        //Creando directorio
        if (!file_exists($pdf_dir)) {
            if (!mkdir($pdf_dir, 0777)) {
                alert('Error al crear el directorio.', 2);
                exit();
            }
        }

        //Verificando formato del pdf
        if (mime_content_type($_FILES['resolucion_programa']['tmp_name']) != "application/pdf") {
            alert('La archivo que ha seleccionado es de un formato no permitido, debe ser pdf.', 2);
            exit();
        }

        //Verificando peso del pdf < 3MB
        if (($_FILES['resolucion_programa']['size'] / 1024) > 3072) {
            alert('El PDF que ha seleccionado supera el peso permitido.', 2);
            exit();
        }

        //Extensión del pdf

        switch (mime_content_type($_FILES['resolucion_programa']['tmp_name'])) {
            case 'application/pdf':
                $pdf_ext = ".pdf";
                break;
        }

        chmod($pdf_dir, 0777);
        $pdf_nombre = renombrar_fotos($descripcion); //Nombre del pdf en BD
        $pdf = $pdf_nombre . $pdf_ext; //Nombre final para la BD

        //Moviendo pdf al directorio
        if (!move_uploaded_file($_FILES['resolucion_programa']['tmp_name'], $pdf_dir . $pdf)) {
            alert('No podemos cargar el pdf al sistema en este momento.', 2);
            exit();
        }
    } else {
        $pdf = "";
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
    $guardar_programa = $guardar_programa->prepare("INSERT INTO programa(Codigo_SNIES, Descripcion, Logo, Correo, modalidad, TelefonoContacto, id_coordinador, resolucion, fecha) VALUES(:snies, :descripcion, :logo, :email, :modalidad, :telefono, :coordinador, :resolucion, :fecha)");//:nombre_marcador -> los marcadores nos sirven para identificar las variables donde iran los valores reales

    //ejecutando consulta
    $marcadores = [
        ":snies" => $snies,
        ":descripcion" => $descripcion,
        ":logo" => $foto,
        ":email" => $email,
        ":modalidad" => $modalidad,
        ":telefono" => $telefono,
        ":coordinador" => $coordinador,
        ":resolucion" => $pdf,
        ":fecha" => $fecharesolucion
    ];

    $guardar_programa2 = conexion();
    $guardar_programa2 = $guardar_programa2->prepare("INSERT INTO programa_linea_trabajo(id_programa, id_linea) VALUES(:programa, :linea)");

    $guardar_programa->execute($marcadores);

    foreach ($lineatrabajo as $row) {
        $guardar_programa2->execute([":programa" => $snies,
        ":linea" => $row]);
    }


    if ($guardar_programa->rowCount() == 1) {
        alert("El programa acádemico se registro con exito.", 1);

    } else {
        alert("No se pudo registrar el programa, por favor intente nuevamente.", 2);
    }

    $guardar_programa = null;
    
