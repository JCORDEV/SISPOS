<?php
require_once "./php/main.php";
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center form-rest border-0" role="alert" aria-live="assertive" aria-atomic="true"
        id="liveToast"></div>
</div>

<div class="main-container">
    <section>
        <div class="row g-0">

            <div class="col-lg-5 bg-dark d-flex flex-column align-items-end min-vh-100" data-bs-theme="dark">
                <div class="px-5 pt-5 pb-3 w-100">
                    <h3 class="fw-bold">Registrar docente</h3>
                </div>
                <div class="align-self-center w-100 px-5 ">
                    <div class="form-rest"></div>
                    <form action="./php/docente_guardar.php" method="POST" autocomplete="off"
                        class="FormularioAjax mb-5 login" id="FormularioAjax" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Nombre</label>
                            <input type="text" class="form-control text-white bg-dark-x"
                                placeholder="Ingresa nombre del docente" name="nombre_docente" required>
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Identificación</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese su Identificación" name="id_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Dirección</label>
                            <input type="text" class="form-control text-white bg-dark-x" placeholder="Ingresa dirección"
                                name="direccion_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Teléfono</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese número de teléfono" name="telefono_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">E-mail</label>
                            <input type="email" class="form-control text-white bg-dark-x" placeholder="Ingrese correo"
                                name="correo_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Género</label>
                            <select class="form-select text-white bg-dark-x" name="genero_docente">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="startDate">Fecha de nacimiento</label>
                            <input type="date" class="form-control text-white bg-dark-x" id="startDate"
                                name="fechanacimiento_docente" />
                        </div>

                        <div class="mb-4">

                            <label for="formFile" class="form-label">Fotografia</label>
                            <input class="form-control text-white bg-dark-x" type="file" id="formFile"
                                accept=".jpg, .png, .jpeg" name="foto_docente" required>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Formación
                                academica</label>
                            <select class="form-select text-white bg-dark-x" name="formacion_docente">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="pregrado">Pregrado</option>
                                <option value="posgrado">Posgrado</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Áreas de conocimiento</label><br />


                            <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $areaconocimiento = conexion();
                                $areaconocimiento = $areaconocimiento->query("SELECT * FROM areas_conocimiento");

                                if ($areaconocimiento->rowCount() > 0) {
                                    $areaconocimiento = $areaconocimiento->fetchAll();

                                    foreach ($areaconocimiento as $row) {
                                        echo '
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="'.$row['id_area'].'" id="flexCheckDefault'.$row['id_area'].'" name="areas_docente[]">
                                            <label class="form-check-label" for="flexCheckDefault'.$row['id_area'].'">
                                            '.$row['nombre'].'
                                            </label>
                                        </div>
                                        ';
                                    }

                                }
                                $areaconocimiento = null;
                                ?>
                            
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Programa</label>
                            <select class="form-select text-white bg-dark-x" name="programa_docente" required>
                                <option value="" seleted="">Seleccione una opción</option>
                                <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $programa = conexion();
                                $programa = $programa->query("SELECT * FROM programa");

                                if ($programa->rowCount() > 0) {
                                    $programa = $programa->fetchAll();

                                    foreach ($programa as $row) {
                                        echo '<option value="' . $row['id_coordinador'] . '">'.$row['Descripcion'] . '</option>';
                                    }

                                }
                                $programa = null;
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="toast-button">Guardar</button>
                    </form>
                </div>
            </div>
    </section>
</div>