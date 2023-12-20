<?php
    $cat_id_del = limpiar_cadena($_GET['cat_id_del']);

    /**
     * *Verificando categoria
     */

    $check_categoria = conexion();
    $check_categoria = $check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id = '$cat_id_del'");

    if ($check_categoria->rowCount() == 1) {
        /**
        * *Verificando categoria + registro de productos
        */
        $check_producto = conexion();
        $check_producto = $check_producto->query("SELECT categoria_id FROM producto WHERE categoria_id = '$cat_id_del' LIMIT 1");

        if ($check_producto->rowCount() <= 0) {
            //eliminando categoria
            $eliminar_categoria = conexion();
            $eliminar_categoria = $eliminar_categoria->prepare("DELETE FROM categoria WHERE categoria_id = :id");

            //ejecucion de la consulta anteriormente preparada
            $eliminar_categoria->execute([":id" => $cat_id_del]);

            if ($eliminar_categoria->rowCount() == 1) {
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡CATEGORIA ELIMINADA!</strong><br>
                        Los datos de la CATEGORIA se eliminaron con exito
                    </div>
                ';
            } else {
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>
                        No se pudo eliminar la CATEGORIA, por favor intente nuevamente
                    </div>
                ';
            }
            $eliminar_categoria = null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se puede eliminar la CATEGORIA ya que tiene productos registrados
                </div>
            ';
        }
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CATEGORIA que intenta eliminar no existe
            </div>
        ';
    }

    $check_categoria = null;
    