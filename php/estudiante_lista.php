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
                    "SELECT m.id_programa, m.semestre_actual, m.graduado, p.Descripcion, e.*, c.fecha_inicio FROM estudiante_maestria m INNER JOIN programa p ON m.id_programa = p.Codigo_SNIES
                    INNER JOIN estudiante e ON m.id_estudiante = e.id_estudiante
                    INNER JOIN cohorte c ON c.id_cohorte = e.id_cohorte
                    ";

                    $consulta_total = "SELECT COUNT(id_estudiante) FROM estudiante";
                break;
            case 'Coordinador':
                $consulta_datos=
                    "SELECT m.id_programa, m.semestre_actual, m.graduado, p.Descripcion, e.*, c.fecha_inicio FROM estudiante_maestria m
                    INNER JOIN programa p ON m.id_programa = p.Codigo_SNIES
                    INNER JOIN estudiante e ON m.id_estudiante = e.id_estudiante
                    INNER JOIN cohorte c ON c.id_cohorte = e.id_cohorte
                    WHERE p.id_coordinador = 
                    ".$_SESSION['id'];
                    $consulta_total = 
                    "SELECT COUNT(*)
                    FROM estudiante_maestria m
                    INNER JOIN programa p ON m.id_programa = p.Codigo_SNIES
                    INNER JOIN estudiante e ON m.id_estudiante = e.id_estudiante
                    INNER JOIN cohorte c ON c.id_cohorte = e.id_cohorte
                    WHERE p.id_coordinador = ".$_SESSION['id'];
                break;
            case 'Asistente':
                $check_coordinador = conexion();
                $check_coordinador = $check_coordinador->query("SELECT id_coordinador FROM asistente WHERE id_asistente = ".$_SESSION['id']);
                $coordinador = (int) $check_coordinador->fetchColumn();

                $consulta_datos=
                    "SELECT m.id_programa, m.semestre_actual, m.graduado, p.Descripcion, e.*, c.fecha_inicio FROM estudiante_maestria m
                    INNER JOIN programa p ON m.id_programa = p.Codigo_SNIES
                    INNER JOIN estudiante e ON m.id_estudiante = e.id_estudiante
                    INNER JOIN cohorte c ON c.id_cohorte = e.id_cohorte
                    WHERE p.id_coordinador = 
                    ".$coordinador;
                    $consulta_total = 
                    "SELECT COUNT(*)
                    FROM estudiante_maestria m
                    INNER JOIN programa p ON m.id_programa = p.Codigo_SNIES
                    INNER JOIN estudiante e ON m.id_estudiante = e.id_estudiante
                    INNER JOIN cohorte c ON c.id_cohorte = e.id_cohorte
                    WHERE p.id_coordinador = ".$coordinador;
                break;
            default:
                # code...
                break;
        }


        
        
        //total general de las categorias
        
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
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">CC</th>
                        <th scope="col">nombre</th>
                        <th scope="col">código estudiantil</th>
                        <th scope="col">foto</th>
                        <th scope="col">direccion</th>
                        <th scope="col">telefono</th>
                        <th scope="col">correo</th>
                        <th scope="col">genero</th>
                        <th scope="col">fecha de nacimiento</th>
                        <th scope="col">semestre</th>
                        <th scope="col">estado civil</th>

                        <th scope="col">cohorte</th>
                        <th scope="col">graduado</th>
                        <th scope="col" colspan=2>Opciones</th>
                    </tr>
                </thead>
                <tbody ">
    ';

    /**
     * *COMPROBACION DE PAGINAS
     */
    if ($total >= 1 && $pagina <= $Npaginas ) {
        //si hay registros y estamos en una página que si existe

        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        
        //mostrando registros
        $campos = "";
        $consulta_datos=
            "SELECT e.id_programa, e.semestre_actual, e.graduado, p.Descripcion FROM estudiante_maestria e INNER JOIN programa p ON e.id_programa = p.Codigo_SNIES INNER JOIN estudiante ON e.id_estudiante = estudiante.id_estudiante";
        foreach ($datos as $rows) {
            $programa = $conexion->query($consulta_datos);
            

            $tabla .= '
                    <tr>
                        <th scope="row">'.$contador.'</th>
                        <td>'.$rows['id_estudiante'].'</td>
                        <td>'.$rows['nombre'].'</td>
                        <td>'.$rows['codigo_estudiantil'].'</td>
                        
            ';
            if(is_file("./img/Estudiante/".$rows['foto'])){
                $tabla .= '
                        <td>
                            <img src="./img/Estudiante/'.$rows['foto'].'" class="img-fluid">
                        </td>';
            }else{
                $tabla .= '
                        <td>
                            <img src="./img/producto.png" class="img-fluid">
                        </td>';
            }
            // style="visibility:collapse; display:none;"
            
            $graduado = $rows['graduado'] == 1 ? "Si":"No";
            $tabla .= '
                        <td>'.$rows['direccion'].'</td>
                        <td>'.$rows['telefono'].'</td>
                        <td>'.$rows['correo'].'</td>
                        <td>'.$rows['genero'].'</td>
                        <td>'.$rows['fecha_nacimiento'].'</td>
                        <td>'.$rows['semestre'].'</td>
                        <td>'.$rows['estado_civil'].'</td>
                        
                        <td>'.$rows['fecha_inicio'].'</td>
                        <td>'.$graduado.'</td>
                        <td class="align-middle">
                            <a href="index.php?vista=actualizar_categoria&cat_id_up='.$rows['id_estudiante'].'" class="btn btn-primary" role="button">
                                Actualizar
                            </a>
                        </td>
                        <td class="align-middle">
                            <a href="'.$url.$pagina.'&cat_id_del='.$rows['id_estudiante'].'" class="btn btn-danger" role="button">
                                Eliminar
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
                    <tr class="has-text-centered">
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
                    <tr class="has-text-centered">
                        <td colspan="6">
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