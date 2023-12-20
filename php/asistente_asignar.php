<?php
    require_once "main.php";

    /**
     ** Almacenando datos
    */
    $id = limpiar_cadena($_POST['id_asistente']);
    $nombre = limpiar_cadena($_POST['nombre_asistente']);
    $correo = limpiar_cadena($_POST['correo_asistente']);
    $clave = limpiar_cadena($_POST['clave_asistente']);
    $coordinador = limpiar_cadena($_POST['coordinador_asistente']);
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($id == "" || $nombre == "" || $correo == "" || $clave == "") {
        alert("No has llenado todos los campos.", 2);
        exit();
    }

    /**
     * *Verificación de asistente asignado a un coordinador
     */
    $check_id = conexion();
    $check_id = $check_id->query("SELECT id FROM identificacion i WHERE i.id = '$id'");
    if ($check_id->rowCount() > 0) {
        alert("El asistente ya se encuentra asignado.",2);
        exit();
    }

    /**
     * *Verificación de correo ya existente
     */

    $check_correo = conexion();
    $check_correo = $check_correo->query("SELECT usuario FROM usuario u WHERE u.usuario = '$correo'");
    if ($check_correo->rowCount() > 0) {
        alert("El correo ya se encuentra en uso.",2);
        exit();
    }


    $check_asistente = conexion();
    $check_asistente = $check_asistente->query("SELECT id_asistente FROM asistente a WHERE a.id_asistente = '$id'");
    if ($check_asistente->rowCount() > 0) {
        alert("El asistente ya se encuentra asignado.",2);
        exit();
    }
    $check_coordinador = conexion();
    $check_coordinador = $check_coordinador->query("SELECT id_coordinador FROM asistente a WHERE a.id_coordinador = '$coordinador'");
    if ($check_coordinador->rowCount() > 0) {
        alert("Ya tienes asignado un asistente.",2);
        exit();
    }
    /**
     * *Guardando datos
     */

    $guardar_identificacion = conexion();
    $guardar_asistente = conexion();
    $guardar_usuario = conexion();
    //PREPARE[filtro de seguridad] -> prepara la consulta para después ser ejecutada, lo contrario a QUERY que la ejecuta de una vez la consulta
 
    //preparando consulta
    $guardar_identificacion = $guardar_identificacion->prepare("INSERT INTO identificacion(id,nombre) VALUES(:id_asistente, :nombre)");
    $guardar_asistente = $guardar_asistente->prepare("INSERT INTO asistente(id_asistente,id_coordinador) VALUES(:asistente, :coordinador)");//:nombre_marcador -> los marcadores nos sirven para identificar las variables donde iran los valores reales
    $guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario(id,usuario, clave, rol) VALUES(:id_asistente, :correo, :clave, :rol)");
 
    //ejecutando consulta
    $marcadores = [
        ":asistente" => $id,
        ":coordinador" => $coordinador
    ];

    $guardar_identificacion->execute([":id_asistente" => $id, ":nombre" => $nombre]);
    $guardar_asistente->execute($marcadores);
    $guardar_usuario->execute([":id_asistente" => $id, ":correo" => $correo, ":clave" => $clave, ":rol" => "Asistente"]);

    if ($guardar_identificacion->rowCount() == 1 and $guardar_asistente->rowCount() == 1 and $guardar_usuario->rowCount() == 1) {
        alert('Asistente asignado con exito.',1);
    } else {
        alert('No se pudo asignar el asistente, por favor intente nuevamente.',2);
    }
 
    $guardar_identificacion = null;
    $guardar_asistente = null;
    $guardar_usuario = null;