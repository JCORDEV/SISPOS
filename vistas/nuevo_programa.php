<?php
    require_once "./php/main.php";
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body form-rest">
            Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<div class="main-container">
    <section>
        <div class="row g-0">

            <div class="col-lg-5 bg-dark d-flex flex-column align-items-end min-vh-100" data-bs-theme="dark">
                <div class="px-5 pt-5 pb-3 w-100">
                    <h3 class="fw-bold">Registrar programa</h3>
                </div>
                <div class="align-self-center w-100 px-5 ">
                    <form  action="./php/programa_guardar.php" method="POST" autocomplete="off" class="FormularioAjax mb-5 login" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Código  SNIES</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingresa nombre del programa" pattern="[0-9]{4,6}" maxlength="6" name="codigo_snies" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Descripción</label>
                           <textarea class="form-control text-white bg-dark-x" id="exampleFormControlTextarea1" rows="5" name="descripcion_programa" required></textarea>
                        </div>

                        <div class="mb-4">

                            <label for="formFile" class="form-label">Logotipo</label>
                            <input class="form-control text-white bg-dark-x" type="file" id="formFile" accept=".jpg, .png, .jpeg" name="logo_programa" required>
                            <span class="file-name">JPG, JPEG, PNG. (MAX 3MB)</span>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Email</label>
                            <input type="email" class="form-control text-white bg-dark-x" placeholder="Ingresa tu email" aria-describedby="emailHelp" name="email_programa" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Telefono</label>
                            <input type="number" class="form-control text-white bg-dark-x" placeholder="Ingresa nombre del programa" pattern="[0-9]" name="telefono_programa" required>
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Linea de trabajo</label>
                            <select class="form-select text-white bg-dark-x" name="lineatrabajo_programa">
                                <option value="" seleted="">Seleccione una opción</option>
                                <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $lineatrabajo = conexion();
                                $lineatrabajo = $lineatrabajo->query("SELECT * FROM lineatrabajo");

                                if ($lineatrabajo->rowCount() > 0) {
                                    $lineatrabajo = $lineatrabajo->fetchAll();

                                    foreach ($lineatrabajo as $row) {
                                        echo '<option value="' . $row['lineatrabajoID'] . '">' . $row['nombre'] . '</option>';
                                    }

                                }
                                $categorias = null;
                                ?>
                            </select>
                        </div>

                        <div class="mb-4">
                            <legend>Información de Registro Calificado</legend>
                            <label for="startDate">Fecha de Resolución</label>
                            <input type="date" class="form-control text-white bg-dark-x" id="startDate" name="fecharesolucion_programa" />
                        </div>

                        <div class="mb-4">

                            <div class="mb-4">
                                <label for="exampleInputEmail1" class="form-label font-weight-bold">Resolución de registro calificado</label>
                            <textarea class="form-control text-white bg-dark-x" id="exampleFormControlTextarea1" rows="3" name="resolucion_programa" required></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Coordinador</label>
                            <select class="form-select text-white bg-dark-x" name="coordinador_programa">
                                <option value="" seleted="">Seleccione una opción</option>
                                <?php
                                /**
                                 * *Carga de categorias en SELECT
                                 */
                                $coordinador = conexion();
                                $coordinador = $coordinador->query("SELECT * FROM coordinador");

                                if ($coordinador->rowCount() > 0) {
                                    $coordinador = $coordinador->fetchAll();

                                    foreach ($coordinador as $row) {
                                        echo '<option value="' . $row['CoordinadorID'] . '">' . $row['Nombre'] . '</option>';
                                    }

                                }
                                $coordinador = null;
                                ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="toast-button">Guardar</button>
                    </form>
                </div>
            </div>
    </section>
</div>