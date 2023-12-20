<?php
    $inicio = ($pagina > 0) ? (($pagina*$registros)-$registros) : 0;
    $tabla = "";

    if (isset($busqueda) && $busqueda != "") {
        /**
         * *BUSCADOR
         */

        //busqueda de acuerdo el campo(nombre, ubicacion) ordenado de forma ascendente
        // $consulta_datos=
        //     "SELECT * FROM categoria 
        //     WHERE categoria_nombre LIKE '%$busqueda%' 
        //     OR categoria_ubicacion LIKE '%$busqueda%' 
        //     ORDER BY categoria_nombre ASC LIMIT $inicio, $registros";
        
        //total de busquedas encontradas(nombre, ubicacion)
        // $consulta_total = 
        //     "SELECT COUNT(categoria_id) FROM categoria
        //     WHERE categoria_nombre LIKE '%$busqueda%' 
        //     OR categoria_ubicacion LIKE '%$busqueda%'";
    } else {
        /**
         * *lISTADO GENERAL
         */

        //listado general de las categorias

        switch ($_SESSION['rol']) {
            case 'Presidente':
                $consulta_datos=
                    "SELECT p.Codigo_SNIES, p.Descripcion, p.Logo, p.Correo,p.modalidad,p.TelefonoContacto,p.resolucion,p.fecha, i.nombre AS Coordinador, GROUP_CONCAT('<p>',l.nombre ,'</p>' SEPARATOR '<hr>') AS LineasDeTrabajo
                    FROM programa p
                    INNER JOIN programa_linea_trabajo t ON t.id_programa = p.Codigo_SNIES
                    INNER JOIN lineas_trabajo l ON l.id_linea = t.id_linea
                    INNER JOIN identificacion i ON i.id = p.id_coordinador
                    GROUP BY p.Codigo_SNIES, i.nombre
                    ORDER BY p.Codigo_SNIES
                    LIMIT $inicio, $registros";
                    //total general de las categorias
                $consulta_total =  "SELECT COUNT(Codigo_SNIES) FROM programa";
                break;
            case 'Coordinador':
                $consulta_datos=
                    "SELECT p.Codigo_SNIES, p.Descripcion, p.Logo, p.Correo, p.modalidad, p.TelefonoContacto, p.resolucion, p.fecha, i.nombre AS Coordinador, GROUP_CONCAT('<p>', l.nombre, '</p>' SEPARATOR '<hr>') AS LineasDeTrabajo
                    FROM programa p
                    INNER JOIN programa_linea_trabajo t ON t.id_programa = p.Codigo_SNIES
                    INNER JOIN lineas_trabajo l ON l.id_linea = t.id_linea
                    INNER JOIN identificacion i ON i.id = p.id_coordinador
                    WHERE p.id_coordinador = ".$_SESSION['id']." 
                    GROUP BY p.Codigo_SNIES, i.nombre
                    ORDER BY p.Codigo_SNIES
                    LIMIT $inicio, $registros;
                    ";
                    //total general de las categorias
                    $consulta_total = "SELECT COUNT(Codigo_SNIES) FROM programa WHERE programa.id_coordinador = ".$_SESSION['id'];
                break;
            case 'Asistente':
                    $check_coordinador = conexion();
                    $check_coordinador = $check_coordinador->query("SELECT id_coordinador FROM asistente WHERE id_asistente = ".$_SESSION['id']);
                    $coordinador = (int) $check_coordinador->fetchColumn();

                    $consulta_datos=
                    "SELECT p.Codigo_SNIES, p.Descripcion, p.Logo, p.Correo, p.modalidad, p.TelefonoContacto, p.resolucion, p.fecha, i.nombre AS Coordinador, GROUP_CONCAT('<p>', l.nombre, '</p>' SEPARATOR '<hr>') AS LineasDeTrabajo
                    FROM programa p
                    INNER JOIN programa_linea_trabajo t ON t.id_programa = p.Codigo_SNIES
                    INNER JOIN lineas_trabajo l ON l.id_linea = t.id_linea
                    INNER JOIN identificacion i ON i.id = p.id_coordinador
                    WHERE p.id_coordinador = ".$coordinador." 
                    GROUP BY p.Codigo_SNIES, i.nombre
                    ORDER BY p.Codigo_SNIES
                    LIMIT $inicio, $registros;
                    ";
                    //total general de las categorias
                    $consulta_total = "SELECT COUNT(Codigo_SNIES) FROM programa WHERE programa.id_coordinador = ".$coordinador;
                break;
            default:
                
                break;
        }
    }
    
    /**
     * *CONSULTAS SQL
     */

    $conexion = conexion();
    
    $datos = $conexion->query($consulta_datos);
    $datos = $datos->fetchAll(); //*fetchAll nos hace un array de datos, en caso de que devuelva la consulta más de un dato

    $total = $conexion->query($consulta_total);
    $total = (int) $total->fetchColumn();//*fetchColumn, devuelve una unica columna de los resultados

    //*redondeamos para evitar números flotantes(2.5 -> 3)
    $Npaginas = ceil($total / $registros);//# de páginas

    /**
     * *VISUALIZACION DE DATOS CONSULTADOS
     */

    
    //TABLA -> encabezado

    $tabla .= '
    </tbody>
        <div class="table-responsive">
            <table class="table table-light table-striped-columns">
                <thead class="table-dark ">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SNIES</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Logo</th>
                        <th scope="col">Correo</th>
                        <th scope="col">modalidad</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">lineas</th>
                        <th scope="col">coordinador</th>
                        <th scope="col">resolución</th>
                        <th scope="col">fecha</th>
                        <th scope="col" colspan=2>Opciones</th>
                    </tr>
                </thead>
                <tbody>
    ';

    /**
     * *COMPROBACION DE PAGINAS
     */
    if ($total >= 1 && $pagina <= $Npaginas ) {
        //si hay registros y estamos en una página que si existe

        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        
        //mostrando registros
        foreach ($datos as $rows) {

            $tabla .= '
                    <tr>
                        <th scope="row">'.$contador.'</th>
                        <td>'.$rows['Codigo_SNIES'].'</td>
                        <td>'.$rows['Descripcion'].'</td>';
            if(is_file("./img/ProgramaAcademico/logo/".$rows['Logo'])){
                $tabla .= '
                        <td>
                            <img src="./img/ProgramaAcademico/logo/'.$rows['Logo'].'" class="img-fluid">
                        </td>';
            }else{
                $tabla .= '
                        <td>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                <img src="./img/producto.png" class="img-fluid">
                            </button>
                        </td>';
            }
            $tabla .= '
                        <td>'.$rows['Correo'].'</td>
                        <td>'.$rows['modalidad'].'</td>
                        <td>'.$rows['TelefonoContacto'].'</td>

            
                        <td>'.$rows['LineasDeTrabajo'].'</td>
                        <td>'.$rows['Coordinador'].'</td>
                        <td>'.$rows['resolucion'].'</td>
                        <td>'.$rows['fecha'].'</td>
                        <td>
                            <a href="index.php?vista=actualizar_categoria&cat_id_up='.$rows['Codigo_SNIES'].'" class="btn btn-primary disabled" disabled role="button">
                                Actualizar
                            </a>
                        </td>
                        <td>
                            <a href="'.$url.$pagina.'&cat_id_del='.$rows['Codigo_SNIES'].'" class="btn btn-danger disabled" disabled role="button">
                                Inactivar
                            </a>
                        </td>
                    </tr>
            ';
            $contador++;
        }
        $pag_final = $contador - 1;//# de registros por cada página
    } else {
        //cuando tengamos registros(datos)
        if ($total >= 1) {
            $tabla .= '
                    <tr class="text-center">
                        <td colspan="6">
                            <a href="'.$url.'1" class="button is-link is-small mt-4 mb-4">
                                Haga clic acá para recargar el listado
                            </a>
                        </td>
                    </tr>
            ';
        } else {
            //cuando no hay registros en el sistema
            $tabla .= '
                    <tr class="text-center">
                        <td colspan="12">
                            No hay registros en el sistema
                        </td>
                    </tr>
            ';
        }
    }
    
    //TABLA -> cierre
    $tabla .= '
                </tbody>
            </table>
        </div>
    ';

    /**
     * *PAGINAS
     * página_inicio, página_final, total_páginas
     */
    if ($total >= 1 && $pagina <= $Npaginas ) {
        $tabla .= '
        <caption class="justify-content-end">
            Mostrando programas
            <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong>
            de un <strong>total de '.$total.'</strong>
        </caption>
        ';
    }
    
    $conexion = null;

    echo $tabla;
    
    /**
     * *PAGINADOR
     */

    if ($total >= 1 && $pagina <= $Npaginas ) {
        echo paginador_tablas($pagina, $Npaginas, $url, 7);
    }