<?php
    require_once "./php/main.php";
?>

<!-- <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body form-rest">
            Hello, world! This is a toast message.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div> -->
<div class="main-container">
    <section>
        <div class="row g-0">

            <div class="col-lg-5 bg-dark d-flex flex-column align-items-end min-vh-100" data-bs-theme="dark">
                <div class="px-5 pt-5 pb-3 w-100">
                    <h3 class="fw-bold">Registrar docente</h3>
                </div>
                <div class="align-self-center w-100 px-5 ">
                    <div class="form-rest"></div>
                    <form  action="./php/docente_guardar.php" method="POST" autocomplete="off" class="FormularioAjax mb-5 login">

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
                            <input type="text" class="form-control text-white bg-dark-x"
                                placeholder="Ingresa dirección" name="direccion_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Teléfono</label>
                            <input type="number" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese número de teléfono" name="telefono_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">E-mail</label>
                            <input type="email" class="form-control text-white bg-dark-x"
                                placeholder="Ingrese correo" name="correo_docente" required>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Genero</label>
                            <select class="form-select text-white bg-dark-x" name="genero_docente">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="startDate">Fecha de nacimiento</label>
                            <input type="date" class="form-control text-white bg-dark-x" id="startDate" name="fechanacimiento_docente" />
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Formación academica</label>
                            <select class="form-select text-white bg-dark-x" name="formacion_docente">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="pre">Pregrado</option>
                                <option value="pos">Posgrado</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleInputEmail1" class="form-label font-weight-bold">Areas de conocimiento</label>
                            <select class="form-select text-white bg-dark-x" name="areas_docente">
                                <option value="" seleted="">Seleccione una opción</option>
                                <option value="1">area#1</option>
                                <option value="2">area#2</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="toast-button">Guardar</button>
                    </form>
                </div>
            </div>
    </section>
</div>