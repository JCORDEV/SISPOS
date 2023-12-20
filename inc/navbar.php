<?php
    require_once "./php/main.php";
    require_once "./inc/session_start.php";
?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center form-rest border-0" role="alert" aria-live="assertive" aria-atomic="true"
        id="liveToast"></div>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" data-bs-theme="dark">
  <div class="container-fluid">
  <a class="navbar-brand fw-bold text-success" href="index.php?vista=home">SISPOS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
        <?php
          switch ($_SESSION['rol']) {
            case 'Presidente':
              echo '
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Registrar</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="index.php?vista=nuevo_programa">Programa academico</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="index.php?vista=nuevo_docente">Docente</a></li>
                    </ul>
                  </li>

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Información</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="index.php?vista=listar_programas">Programas academicos</a></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_docentes">Docentes</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_estudiantes">Estudiantes</a></li>
                    </ul>
                  </li>

                  <div class="dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle me-lg-5" data-bs-toggle="dropdown" aria-expanded="true" data-bs-auto-close="outside">
                      Asignar docente
                    </button>
                    <form class="dropdown-menu p-4 FormularioAjax" id="FormularioAjax" method="POST" action="./php/docente_asignar.php">
                      <div class="mb-3">
                        <label for="exampleDropdownFormEmail2" class="form-label">Programa</label>
                        <select class="form-select text-white text-wrap bg-dark-x" name="id_programa" required>
                                <option value="" seleted="">Seleccione una opción</option>
                        ';
                                $programa = conexion();
                                $programa = $programa->query("SELECT * FROM programa");

                                if ($programa->rowCount() > 0) {
                                    $programa = $programa->fetchAll();

                                    foreach ($programa as $row) {
                                        echo '<option value="' . $row['Codigo_SNIES'] . '">'.$row['Descripcion'] . '</option>';
                                    }

                                }
                                $programa = null;
                            
              echo '    </select>
                      </div>
                      <div class="mb-3">
                        <label for="exampleDropdownFormPassword2" class="form-label">Docente</label>
                        <select class="form-select text-white text-wrap bg-dark-x" name="id_docente" required>
                                <option value="" seleted="">Seleccione una opción</option>
                        ';
                                $docente = conexion();
                                $docente = $docente->query("SELECT * FROM profesor");

                                if ($docente->rowCount() > 0) {
                                    $docente = $docente->fetchAll();

                                    foreach ($docente as $row) {
                                        echo '<option value="' . $row['id_profesor'] . '">'.$row['nombre'] . '</option>';
                                    }

                                }
                                $docente = null;
              echo '    </select>
                      </div>
                      <button type="submit" class="btn btn-primary w-100" id="liveToast">Asignar</button>
                    </form>
                  </div>
                ';
              break;
            case 'Coordinador':
                echo '
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Registrar</a>
                      <ul class="dropdown-menu">
                        ';

                $check_coordinador_programa = conexion();
                $check_coordinador_programa = $check_coordinador_programa->query("SELECT * FROM programa p WHERE p.id_coordinador = ".$_SESSION['id']);
                if ($check_coordinador_programa->rowCount() <= 0) {
                  echo '<li><a class="dropdown-item disabled" disabled href="index.php?vista=nuevo_estudiante">Estudiante</a></li>';
                }else{
                  echo '<li><a class="dropdown-item" href="index.php?vista=nuevo_estudiante">Estudiante</a></li>';
                }
                        
                echo '
                      </ul>
                    </li>
                    

                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Información</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="index.php?vista=listar_programas">Programa academico</a></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_docentes">Docentes</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_estudiantes">Estudiantes</a></li>
                    </ul>
                  </li>
                  
                  <div class="dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle me-lg-5" data-bs-toggle="dropdown" aria-expanded="true" data-bs-auto-close="outside">
                      Añadir asistente
                    </button>
                    <form class="dropdown-menu p-4 FormularioAjax" id="FormularioAjax" method="POST" action="./php/asistente_asignar.php">
                    <input type="text" class="form-control text-white bg-dark-x visually-hidden" value="' . $_SESSION['id'] . '" name="coordinador_asistente" required>

                      <div class="mb-3">
                        <label for="exampleDropdownFormEmail2" class="form-label">Identificación</label>
                        <input type="number" min="0"onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="10" oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" id="exampleDropdownFormEmail2" placeholder="Ingrese la cédula" name="id_asistente" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleDropdownFormEmail2" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="exampleDropdownFormEmail2" placeholder="Ingrese el nombre" name="nombre_asistente" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleDropdownFormEmail2" class="form-label">Correo eléctronico</label>
                        <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="Ingrese el correo" name="correo_asistente" required>
                      </div>
                      <div class="mb-3">
                        <label for="exampleDropdownFormEmail3" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" id="exampleDropdownFormEmail3" placeholder="Ingrese la contraseña" name="clave_asistente" required>
                      </div>
                      <button type="submit" class="btn btn-primary w-100" id="liveToast">Guardar</button>
                    </form>
                  </div>
                    ';
              break;
            case 'Asistente':
                echo '
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Información</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="index.php?vista=listar_programas">Programa academico</a></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_docentes">Docentes</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="index.php?vista=listar_estudiantes">Estudiantes</a></li>
                    </ul>
                  </li>';
                break;
            default:
              # code...
              break;
          }

        ?>
      </ul>
      <div class="d-flex me-3">
          <div class="row gx-5">
            <div class="col">
              <div class="fw-bold text-wrap"><?=$_SESSION['nombre']?></div>
              <div><?=$_SESSION['usuario']?></div>
            </div>
          </div>
      </div>
      <div class="d-flex">
        <button class="btn btn-danger" onclick="window.location.href='index.php?vista=cerrar_sesion'">Salir</button>
      </div>
    </div>
  </div>
</nav>