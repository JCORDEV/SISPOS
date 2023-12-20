<?php
    /**
     * *Conexión a la base de datos*
     * PDO('motor_base_datos:host[servidor]=servidor local/remoto', 'usuario_base_datos', 'contraseña_base_datos)
    */

    function conexion(){
        $pdo = new PDO('mysql:host=localhost;dbname=sispos_test', 'root', '');
        return $pdo;
    }

    /**
     * *Verificar datos*
     * validamos los formularios con cierta expresion regular(filtros)
     */

    function verificar_datos($filtro, $cadena){
        if (preg_match("/^".$filtro."$/",$cadena)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * *Limpiar cadenas de texto*
     * funcion para envitar inyección SQL(filtro de seguridad)
     */

    function limpiar_cadena($cadena){
        //quitar espacios en blanco
        $cadena = trim($cadena);
        //quita las barras de un string con comillas escapadas --> \'
        $cadena = stripcslashes($cadena);
        //reemplaza una palabra o caracter de acuerdo a su termino de busqueda(es insensible a Mayusculas y Minusculas) --> str_ireplace('termino de busqueda', 'termino por el cual reemplazara el termino de busqueda', 'STRING')
        $cadena = str_ireplace('<script>','',$cadena);
        $cadena = str_ireplace('</script>','',$cadena);
        $cadena = str_ireplace('<script src>','',$cadena);
        $cadena = str_ireplace('<script type=>','',$cadena);
        $cadena = str_ireplace('SELECT * FROM','',$cadena);
        $cadena = str_ireplace('DELETE FROM','',$cadena);
        $cadena = str_ireplace('INSERT INTO','',$cadena);
        $cadena = str_ireplace('DROP TABLE','',$cadena);
        $cadena = str_ireplace('DROP DATABASE','',$cadena);
        $cadena = str_ireplace('TRUNCATE TABLE','',$cadena);
        $cadena = str_ireplace('SHOW TABLES;','',$cadena);
        $cadena = str_ireplace('SHOW DATABASES;','',$cadena);
        $cadena = str_ireplace('<?php','',$cadena);
        $cadena = str_ireplace('?>','',$cadena);
        $cadena = str_ireplace('--','',$cadena);
        $cadena = str_ireplace('^','',$cadena);
        $cadena = str_ireplace('<','',$cadena);
        $cadena = str_ireplace('[','',$cadena);
        $cadena = str_ireplace(']','',$cadena);
        $cadena = str_ireplace('==','',$cadena);
        $cadena = str_ireplace(';','',$cadena);
        $cadena = str_ireplace('::','',$cadena);
        $cadena = trim($cadena);
        $cadena = stripcslashes($cadena);

        return $cadena;
    }

    /**
     * *Función renombrar fotos
     */

    function renombrar_fotos($nombre){
        $nombre = str_ireplace(' ','_',$nombre);
        $nombre = str_ireplace('/','_',$nombre);
        $nombre = str_ireplace('#','_',$nombre);
        $nombre = str_ireplace('-','_',$nombre);
        $nombre = str_ireplace('$','_',$nombre);
        $nombre = str_ireplace('.','_',$nombre);
        $nombre = str_ireplace(',','_',$nombre);
        $nombre = $nombre.'_'.rand(0,100);

        return $nombre;
    }
    
    /**
     * *Función paginador de tablas
     */

    function paginador_tablas($pagina, $Npaginas, $url, $botones){
        $tabla = '<ul class="pagination justify-content-end">';

        //*página anterior
        if($pagina<=1){
            $tabla.='
            <li class="page-item"><a class="page-link disabled">Anterior</a></li>
            ';
        }else{
            $tabla.='
            <li class="page-item"><a class="page-link disabled" href="'.$url.($pagina-1).'">Anterior</a></li>
                <li class="page-item"><a class="page-link" href="'.$url.'">1</a></li>
            ';
        }

        
        $ci = 0;
        for ($i=$pagina;$i <= $Npaginas ; $i++) {
            //*número de páginas
            if ($ci >= $botones) {
                break;
            }

            //*apuntador de página
            if ($pagina==$i) {
                $tabla .= '
                <li class="page-item active"><a class="page-link" href="'.$url.$i.'">'.$i.'</a></li>
                ';
            } else {
                $tabla .= '
                <li class="page-item"><a class="page-link" href="'.$url.$i.'">'.$i.'</a></li>
                ';
            }
            
            $ci++;
        }

        //*página siguiente
        if($pagina==$Npaginas){
            $tabla.='
                <li class="page-item"><a class="page-link disabled">Siguiente</a></li>
            
            ';
        }else{
            $tabla.='
            <li class="page-item"><a class="page-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
            
            <li class="page-item"><a class="page-link" href="'.$url.($pagina+1).'">Siguiente</a></li>
            ';
        }

        $tabla.='</ul>';

        return $tabla;
    }

    function alert($mensaje, $color){
        switch ($color) {
            case 1:
                $color = 'text-bg-success';
                break;
            case 2:
                $color = 'text-bg-danger';
                    break;
            default:
                # code...
                break;
        }
        
        echo '
        <div class="d-flex '.$color.' rounded">
            <div class="toast-body">
                '.$mensaje.'
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>'
        ;
    }

    function alertsesion($text){
        echo'
            <div class="alert alert-danger alert-dismissible fade show text-bg-danger" role="alert" style="text-align: justify;">
                <strong class="">'.$text.'</strong>
            </div>';
    }
