
<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" data-bs-theme="dark">
  <div class="container-fluid">
  <a class="navbar-brand fw-bold" href="index.php?vista=home">SISPOS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
       
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Registrar</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php?vista=nuevo_programa">Programa academico</a></li>
            <li><a class="dropdown-item" href="index.php?vista=nuevo_docente">Docente</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="index.php?vista=nuevo_estudiante">Estudiante</a></li>
          </ul>
        </li>
      </ul>
      <div class="d-flex" >
        <div class="container overflow-hidden">
          <div class="row gx-5">
            <div class="col">
              <div class="fw-bold"><?=$_SESSION['id'] == 1 ? "Luis Obeymar Estrada": $_SESSION['usuario']?></div>
              <div><?=$_SESSION['usuario']?></div>
            </div>
          </div>
        </div>
        <button class="btn btn-danger" onclick="window.location.href='index.php?vista=cerrar_sesion'">Salir</button>
</div>
    </div>
  </div>
</nav>