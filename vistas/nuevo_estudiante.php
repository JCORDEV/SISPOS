<?php
    require_once "./php/main.php";
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center form-rest border-0" role="alert" aria-live="assertive" aria-atomic="true" id="liveToast"></div>
</div>
<div class="main-container">
    <section>
        <div class="row g-0">

            <div class="col-lg-5 bg-dark d-flex flex-column align-items-end min-vh-100" data-bs-theme="dark">
                <div class="px-5 pt-5 pb-3 w-100">
                    <h3 class="fw-bold">Registrar estudiante</h3>
                </div>
                <div class="align-self-center w-100 px-5 ">
                    <div class="form-rest"></div>
                    <form  action="./php/estudiante_guardar.php" method="POST" autocomplete="off" class="FormularioAjax mb-5 login" id="FormularioAjax" enctype="multipart/form-data">

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Nombre</label>
                            <input type="text" class="form-control text-white bg-dark-x"
                                placeholder="Ingresa nombre del estudiante" name="nombre_estudiante" required>
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Identificación</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese su Identificación" name="id_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Código estudiantil</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese código estudiantil" name="codigo_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="formFile" class="form-label">Fotografia</label>
                            <input class="form-control text-white bg-dark-x" type="file" id="formFile" accept=".jpg, .png, .jpeg" name="foto_estudiante" required>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Dirección de residencia</label>
                            <input type="text" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese la dirección de residencia" name="direccion_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Teléfono</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese número de teléfono" name="telefono_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">E-mail</label>
                            <input type="email" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese correo" name="correo_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Genero</label>
                            <select class="form-select text-white bg-dark-x" name="genero_estudiante">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="startDate">Fecha de nacimiento</label>
                            <input type="date" class="form-control text-white bg-dark-x" id="startDate" name="fechanacimiento_estudiante" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Semestre</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese semestre" name="semestre_estudiante" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Estado civil</label>
                            <select class="form-select text-white bg-dark-x" name="estado_estudiante">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="S">Soltero(a)</option>
                                <option value="C">Casado(a)</option>
                                <option value="V">Viudo(a)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Cohorte</label>
                            <select class="form-select text-white bg-dark-x" name="cohorte_estudiante">
                                <option value="" seleted="">Seleccione una opción</option>
                                <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $cohorte = conexion();
                                $cohorte = $cohorte->query("SELECT * FROM cohorte");

                                if ($cohorte->rowCount() > 0) {
                                    $cohorte = $cohorte->fetchAll();

                                    foreach ($cohorte as $row) {
                                        echo '
                                        <option value="' . $row['id_cohorte'] . '">' . $row['fecha_inicio'] . '</option>';
                                    }

                                }
                                $cohorte = null;
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Programa acádemico</label>

                                <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $programa = conexion();
                                $programa = $programa->query("SELECT * FROM programa WHERE id_coordinador =".$_SESSION['id']);

                                if ($programa->rowCount() > 0) {
                                    $programa = $programa->fetchAll();

                                    foreach ($programa as $row) {
                                        echo '
                                        <input type="text" class="form-control text-white bg-dark-x visually-hidden" value="' . $row['Codigo_SNIES'] . '" name="programa_estudiante" required>

                                        <span class="input-group-text text-wrap fw-bold">' . $row['Descripcion'] . '</span>';
                                    }

                                }
                                $programa = null;
                                ?>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="toast-button">Guardar</button>
                    </form>
                </div>
            </div>
    </section>
</div>