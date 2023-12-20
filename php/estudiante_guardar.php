<?php
    require_once "main.php";

    /**
     ** Almacenando datos
     */
    $id = limpiar_cadena($_POST['id_estudiante']);
    $nombre = limpiar_cadena($_POST['nombre_estudiante']);
    $codigo = limpiar_cadena($_POST['codigo_estudiante']);
    $direccion = limpiar_cadena($_POST['direccion_estudiante']);
    $telefono = limpiar_cadena($_POST['telefono_estudiante']);
    $correo = limpiar_cadena($_POST['correo_estudiante']);
    $genero = limpiar_cadena($_POST['genero_estudiante']);
    $fechanacimiento = limpiar_cadena($_POST['fechanacimiento_estudiante']);
    $semestre = limpiar_cadena($_POST['semestre_estudiante']);
    $estado_civil = limpiar_cadena($_POST['estado_estudiante']);
    $cohorte = limpiar_cadena($_POST['cohorte_estudiante']);
    $programa = limpiar_cadena($_POST['programa_estudiante']);

    
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    // if ($snies == "" || $descripcion == "" || $email =="" || $telefono == "" || $lineatrabajo == "" || $fecharesolucion == "" ||  $coordinador == "" || $resolucion == "") {
    //     alert("No has llenado todos los campos que son obligatorios.", 2);
    //     exit();
    // }

    /**
     * *Verificando integridad de los datos
     */

    if(verificar_datos("[0-9]{1,20}", $id)){
        alert("El número de identificación no coincide con el formato solicitado.",2);
        exit();
    }

    $check_id = conexion();
    $check_id = $check_id->query("SELECT id_estudiante FROM estudiante WHERE id_estudiante='$id'");
    if ($check_id->rowCount() > 0) {
        alert("El número de identificación ingresado ya se encuentra registrado.",2);
        exit();
    }
    
    /**
    * *Directorio de imagenes
    * Donde se almacenaran las imagenes
    */

    $img_dir = "../img/Estudiante/";

    /**
     * *Comprobar si se selecciono una imagen
     */

    if ($_FILES['foto_estudiante']['name'] != "" && $_FILES['foto_estudiante']['size'] > 0) {
        //Creando directorio
        if (!file_exists($img_dir)) {
            if (!mkdir($img_dir, 0777)) {
                alert('Error al crear el directorio.', 2);
                exit();
            }
        }

        //Verificando formato de imagenes
        if (mime_content_type($_FILES['foto_estudiante']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_estudiante']['tmp_name']) != "image/png") {
            alert('La IMAGEN que ha seleccionado es de un formato no permitido.', 2);
            exit();
        }

        //Verificando peso de imagen < 3MB
        if (($_FILES['foto_estudiante']['size'] / 1024) > 3072) {
            alert('La IMAGEN que ha seleccionado supera el peso permitido.', 2);
            exit();
        }

        //Extensión de la imagen

        switch (mime_content_type($_FILES['foto_estudiante']['tmp_name'])) {
            case 'image/jpeg':
                $img_ext = ".jpg";
                break;
            case 'image/png':
                $img_ext = ".png";
                break;
        }

        chmod($img_dir, 0777);
        $img_nombre = renombrar_fotos($id); //Nombre de la imagen en BD
        $foto = $img_nombre . $img_ext; //Nombre final para la BD

        //Moviendo imagen al directorio
        if (!move_uploaded_file($_FILES['foto_estudiante']['tmp_name'], $img_dir . $foto)) {
            alert('No podemos cargar la imagen al sistema en este momento.', 2);
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

    $guardar_estudiante = conexion();
    $guardar_estudiante_maestria = conexion();
    //PREPARE[filtro de seguridad] -> prepara la consulta para después ser ejecutada, lo contrario a QUERY que la ejecuta de una vez la consulta

    //preparando consulta
    $guardar_estudiante = $guardar_estudiante->prepare("INSERT INTO estudiante(id_estudiante, nombre, codigo_estudiantil, foto, direccion, telefono, correo, genero, fecha_nacimiento, semestre, estado_civil, id_cohorte) VALUES(:id, :nombre, :codigo, :foto, :direccion, :telefono, :correo, :genero, :fenac, :semestre, :estado, :cohorte)");

    $guardar_estudiante_maestria = $guardar_estudiante_maestria->prepare("INSERT INTO estudiante_maestria (id_estudiante_maestria, id_estudiante, id_programa, semestre_actual, graduado) VALUES(:id_estudiante_maestria, :id_estudiante, :id_programa, :semestre_actual, :graduado)");


    //ejecutando consulta
    $marcadores = [
        ":id" => $id,
        ":nombre" => $nombre,
        ":codigo" => $codigo,
        ":foto" => $foto,
        ":direccion" => $direccion,
        ":telefono" => $telefono,
        ":correo" => $correo,
        ":genero" => $genero,
        ":fenac" => $fechanacimiento,
        ":semestre" => $semestre,
        ":estado" => $estado_civil,
        ":cohorte" => $cohorte
    ];

    $guardar_estudiante->execute($marcadores);

    $marcadores = [
        ":id_estudiante_maestria" => null,
        ":id_estudiante" => $id,
        ":id_programa" => $programa,
        ":semestre_actual" => $semestre,
        ":graduado" => 0
    ];

    $guardar_estudiante_maestria->execute($marcadores);

    if ($guardar_estudiante->rowCount() == 1 && $guardar_estudiante_maestria->rowCount() == 1) {
        alert('Estudiante registrado con exito.',1);
    } else {
        alert('No se pudo registrar el estudiante, por favor intente nuevamente.',2);
    }

    $guardar_estudiante = null;
    $guardar_estudiante_maestria = null;
    
