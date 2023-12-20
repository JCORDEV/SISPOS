<?php
    require_once "main.php";

    /**
     ** Almacenando datos
     */
    $nombre = limpiar_cadena($_POST['nombre_docente']);
    $id = limpiar_cadena($_POST['id_docente']);
    $direccion = limpiar_cadena($_POST['direccion_docente']);
    $telefono = limpiar_cadena($_POST['telefono_docente']);
    $correo = limpiar_cadena($_POST['correo_docente']);
    $genero = limpiar_cadena($_POST['genero_docente']);
    $fechanacimiento = limpiar_cadena($_POST['fechanacimiento_docente']);
    $formacion = limpiar_cadena($_POST['formacion_docente']);
    $programa = limpiar_cadena($_POST['programa_docente']);
    
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($nombre == "" || $id == "" || $direccion =="" || $telefono == "" || $correo == "" || $genero == "" ||  $fechanacimiento == "" || $formacion == "" || !isset($_POST['areas_docente'])) {
        alert("No has llenado todos los campos que son obligatorios.", 2);
        exit();
    }$areas = $_POST['areas_docente'];

    /**
     * *Verificando integridad de los datos
     */

    if(verificar_datos("[0-9]{1,20}", $id)){
        alert("El número de identificación no coincide con el formato solicitado.",2);
        exit();
    }

    $check_id = conexion();
    $check_id = $check_id->query("SELECT id_profesor FROM profesor WHERE id_profesor='$id'");
    if ($check_id->rowCount() > 0) {
        alert("El número de identificación ingresado ya se encuentra registrado.",2);
        exit();
    }
    
    /**
    * *Directorio de imagenes
    * Donde se almacenaran las imagenes
    */

    $img_dir = "../img/Docente/";

    /**
     * *Comprobar si se selecciono una imagen
     */

    if ($_FILES['foto_docente']['name'] != "" && $_FILES['foto_docente']['size'] > 0) {
        //Creando directorio
        if (!file_exists($img_dir)) {
            if (!mkdir($img_dir, 0777)) {
                alert('Error al crear el directorio.', 2);
                exit();
            }
        }

        //Verificando formato de imagenes
        if (mime_content_type($_FILES['foto_docente']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['foto_docente']['tmp_name']) != "image/png") {
            alert('La IMAGEN que ha seleccionado es de un formato no permitido.', 2);
            exit();
        }

        //Verificando peso de imagen < 3MB
        if (($_FILES['foto_docente']['size'] / 1024) > 3072) {
            alert('La IMAGEN que ha seleccionado supera el peso permitido.', 2);
            exit();
        }

        //Extensión de la imagen

        switch (mime_content_type($_FILES['foto_docente']['tmp_name'])) {
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
        if (!move_uploaded_file($_FILES['foto_docente']['tmp_name'], $img_dir . $foto)) {
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

    $guardar_docente = conexion();
    //PREPARE[filtro de seguridad] -> prepara la consulta para después ser ejecutada, lo contrario a QUERY que la ejecuta de una vez la consulta

    //preparando consulta
    $guardar_docente = $guardar_docente->prepare("INSERT INTO profesor(id_profesor, nombre, direccion, telefono, correo, genero, fenac, foto, formacion) VALUES(:id, :nombre, :direccion, :telefono, :correo, :genero, :fenac, :foto, :formacion)");//:nombre_marcador -> los marcadores nos sirven para identificar las variables donde iran los valores reales

    //ejecutando consulta
    $marcadores = [
        ":id" => (int) $id,
        ":nombre" => $nombre,
        ":direccion" => $direccion,
        ":telefono" => $telefono,
        ":correo" => $correo,
        ":genero" => $genero,
        ":fenac" => $fechanacimiento,
        ":foto" => $foto,
        ":formacion" => $formacion
    ];
    
    $guardar_docente->execute($marcadores);

    $guardar_docente2 = conexion();
    $guardar_docente2 = $guardar_docente2->prepare("INSERT INTO profesor_areas_conocimiento(id_profesor, id_area) VALUES(:profesor, :area)");

    

    foreach ($areas as $row) {
        $guardar_docente2->execute([":profesor" => $id,
        ":area" => $row]);
    }

    $guardar_programa = conexion();
    $guardar_programa = $guardar_programa->prepare("INSERT INTO programa_profesor(id_programa,id_profesor) VALUES(:programa, :profesor)");

    $guardar_programa->execute([":programa" => $programa, ":profesor" => $id]);

    if ($guardar_docente->rowCount() == 1) {
        alert('Docente registrado con exito.',1);
    } else {
        alert('No se pudo registrar el docente, por favor intente nuevamente.',2);
    }

    $guardar_docente = null;
    
