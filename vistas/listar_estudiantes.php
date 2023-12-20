<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center form-rest border-0" role="alert" aria-live="assertive" aria-atomic="true" id="liveToast"></div>
</div>
<div class="main-container">
    <section>
        <div class="row g-0">

            <div class="col-lg-12 bg-dark d-flex flex-column align-items-end min-vh-100" data-bs-theme="dark">
                <div class="px-5 pt-5 pb-3 w-100">
                    <h3 class="fw-bold">Información de los estudiantes</h3>
                </div>
                <div class="align-self-center w-100 px-5 ">
                    <?php
                        require_once "./php/main.php";

                        //Eliminar usuario
                        // if (isset($_GET['user_id_del'])) {
                        //     require_once "./php/usuario_eliminar.php";
                        // }



                        if (!isset($_GET['page'])) {
                            $pagina = 1;
                        } else {
                            $pagina = (int) $_GET['page'];
                            if ($pagina <= 1) {
                                $pagina = 1;
                            }
                        }

                        $pagina = limpiar_cadena($pagina);
                        $url = "index.php?vista=listar_estudiantes&page=";
                        $registros = 15; //# de registros por página
                        $busqueda = ""; //término de búsqueda
                        
                        /**
                         * *incluimos esta página para que se envien todas las variables anteriormente creadas para utilizarlas posteriormente
                         */
                        require_once "./php/estudiante_lista.php";
                    ?>
                </div>
            </div>
    </section>
</div>