<?php
    require_once "main.php";

    /**
     ** Almacenando datos
    */
    $programa = limpiar_cadena($_POST['id_programa']);
    $id = limpiar_cadena($_POST['id_docente']);
    /**
     * *FILTROS
     * 
     * *Verificación de campos obligatorios
     */
    if ($programa == "" || $id == "") {
        alert("No has seleccionado todos los campos.", 2);
        exit();
    }

    $check_id = conexion();
    $check_id = $check_id->query("SELECT id_profesor FROM programa_profesor pp WHERE pp.id_programa = '$programa' AND pp.id_profesor ='$id'");
    if ($check_id->rowCount() > 0) {
        alert("El docente ya se encuentra asignado en la maestria seleccionada.",2);
        exit();
    }

    /**
     * *Guardando datos
     */

    $guardar_docente = conexion();
    //PREPARE[filtro de seguridad] -> prepara la consulta para después ser ejecutada, lo contrario a QUERY que la ejecuta de una vez la consulta
 
    //preparando consulta
    $guardar_docente = $guardar_docente->prepare("INSERT INTO programa_profesor(id_programa,id_profesor) VALUES(:programa, :profesor)");//:nombre_marcador -> los marcadores nos sirven para identificar las variables donde iran los valores reales
 
    //ejecutando consulta
    $marcadores = [
        ":programa" => $programa,
        ":profesor" => $id
    ];
 
    $guardar_docente->execute($marcadores);
 
    if ($guardar_docente->rowCount() == 1) {
        alert('Docente asignado con exito.',1);
    } else {
        alert('No se pudo asignar el docente, por favor intente nuevamente.',2);
    }
 
    $guardar_docente = null; 