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
        
        

        //total general de las categorias
        



        switch ($_SESSION['rol']) {
            case 'Presidente':
                $consulta_datos=
                    "SELECT p.*, GROUP_CONCAT('<p>', a.nombre, '</p>' SEPARATOR '<hr>') AS area_conocimiento, pr.Descripcion
                    FROM profesor p
                    INNER JOIN profesor_areas_conocimiento pa ON pa.id_profesor = p.id_profesor
                    INNER JOIN areas_conocimiento a ON a.id_area = pa.id_area
                    INNER JOIN programa_profesor pp ON pp.id_profesor = p.id_profesor
                    INNER JOIN programa pr ON pr.Codigo_SNIES = pp.id_programa
                    GROUP BY p.id_profesor, pr.Descripcion
                    ORDER BY p.id_profesor LIMIT $inicio, $registros";
                    //total general de las categorias
                    $consulta_total = 
                    "SELECT COUNT(id_profesor) FROM profesor";
                break;
            case 'Coordinador':
                $consulta_datos=
                    "SELECT pro.*, GROUP_CONCAT('<p>',a.nombre,'</p>' SEPARATOR '<hr>') AS area_conocimiento FROM coordinador c
                    INNER JOIN programa p ON p.id_coordinador = c.id_coordinador
                    INNER JOIN programa_profesor pp ON pp.id_programa = p.Codigo_SNIES
                    INNER JOIN profesor pro ON pro.id_profesor = pp.id_profesor
                    INNER JOIN profesor_areas_conocimiento pa ON pa.id_profesor = pro.id_profesor
                    INNER JOIN areas_conocimiento a ON a.id_area = pa.id_area
                    WHERE p.id_coordinador = ".$_SESSION['id']."
                    GROUP BY pro.id_profesor
                    ORDER BY pro.id_profesor
                    LIMIT $inicio, $registros";

                $consulta_total = 
                    "SELECT COUNT(pro.id_profesor) AS cantidad_profesores
                    FROM coordinador c
                    INNER JOIN programa p ON p.id_coordinador = c.id_coordinador
                    INNER JOIN programa_profesor pp ON pp.id_programa = p.Codigo_SNIES
                    INNER JOIN profesor pro ON pro.id_profesor = pp.id_profesor
                    WHERE p.id_coordinador = ".$_SESSION['id'];
                break;
            case 'Asistente':
                $check_coordinador = conexion();
                $check_coordinador = $check_coordinador->query("SELECT id_coordinador FROM asistente WHERE id_asistente = ".$_SESSION['id']);
                $coordinador = (int) $check_coordinador->fetchColumn();

                $consulta_datos=
                    "SELECT pro.*, GROUP_CONCAT('<p>',a.nombre,'</p>' SEPARATOR '<hr>') AS area_conocimiento FROM coordinador c
                    INNER JOIN programa p ON p.id_coordinador = c.id_coordinador
                    INNER JOIN programa_profesor pp ON pp.id_programa = p.Codigo_SNIES
                    INNER JOIN profesor pro ON pro.id_profesor = pp.id_profesor
                    INNER JOIN profesor_areas_conocimiento pa ON pa.id_profesor = pro.id_profesor
                    INNER JOIN areas_conocimiento a ON a.id_area = pa.id_area
                    WHERE p.id_coordinador = ".$coordinador."
                    GROUP BY pro.id_profesor
                    ORDER BY pro.id_profesor
                    LIMIT $inicio, $registros";

                $consulta_total = 
                    "SELECT COUNT(pro.id_profesor) AS cantidad_profesores
                    FROM coordinador c
                    INNER JOIN programa p ON p.id_coordinador = c.id_coordinador
                    INNER JOIN programa_profesor pp ON pp.id_programa = p.Codigo_SNIES
                    INNER JOIN profesor pro ON pro.id_profesor = pp.id_profesor
                    WHERE p.id_coordinador = ".$coordinador;
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
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">CC</th>
                        <th scope="col">nombre</th>
                        <th scope="col">direccion</th>
                        <th scope="col">telefono</th>
                        <th scope="col">correo</th>
                        <th scope="col">genero</th>
                        <th scope="col">fecha de nacimiento</th>
                        <th scope="col">foto</th>
                        <th scope="col">formacion</th>
                        <th scope="col">areas de conocimiento</th>';
    if ($_SESSION['rol'] == 'Presidente') {
        $tabla .= '     <th scope="col">programa</th>';
    }                   
    $tabla .= '
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
                        <td>'.$rows['id_profesor'].'</td>
                        <td>'.$rows['nombre'].'</td>
                        <td>'.$rows['direccion'].'</td>
                        <td>'.$rows['telefono'].'</td>
                        <td>'.$rows['correo'].'</td>
                        <td>'.$rows['genero'].'</td>
                        <td>'.$rows['fenac'].'</td>
                        
            ';
            if(is_file("./img/Docente/".$rows['foto'])){
                $tabla .= '
                        <td>
                            <img src="./img/Docente/'.$rows['foto'].'" class="img-fluid">
                        </td>';
            }else{
                $tabla .= '
                        <td>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                <img src="./img/producto.png" class="img-fluid">
                            </button>
                        </td>';
            }
            // style="visibility:collapse; display:none;"
            $tabla .= '
                        <td>'.$rows['formacion'].'</td>
                        <td>'.$rows['area_conocimiento'].'</td>';

            if ($_SESSION['rol'] == 'Presidente') {
                $tabla .= '
                        <td class="bg-primary fw-bold">
                            '.$rows['Descripcion'].'
                        </td>';
            }
            $tabla .= '  
                        
                        <td class="align-middle">
                            <a href="index.php?vista=actualizar_categoria&cat_id_up='.$rows['id_profesor'].'" class="btn btn-primary disabled" disabled role="button">
                                Actualizar
                            </a>
                        </td>
                        <td class="align-middle">
                            <a href="'.$url.$pagina.'&cat_id_del='.$rows['id_profesor'].'" class="btn btn-danger disabled" disabled role="button">
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
                        <td colspan="13">
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