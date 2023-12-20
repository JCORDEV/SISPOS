<section>
  <div class="row g-0 vh-100">

    <div class="col-lg-4 bg-dark d-flex flex-column align-items-end">
      <div class="px-4 pt-5 pb-3 p-4 w-100">
        <h1 class="fw-bold text-success">SISPOS</h1>
        <h6>Sistema de Información para la Gestión de Posgrados</h6>
      </div>
      <div class="align-self-center w-100 px-4 pt-3">

        <form class="mb-5 login" action="" method="POST" autocomplete="off">
          <?php
          if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
            require_once "./php/main.php";
            require_once "./php/iniciar_sesion.php";
          }
          ?>
          <div class="mb-4">
            <label for="exampleInputEmail1" class="form-label font-weight-bold">Email</label>
            <input type="email" class="form-control text-white bg-dark-x border-0" placeholder="Ingresa tu email"
              aria-describedby="emailHelp" name="login_usuario" required>
          </div>
          <div class="mb-4">
            <label for="exampleInputPassword1" class="form-label font-weight-bold">Contraseña</label>
            <input type="password" class="form-control text-white bg-dark-x border-0 mb-2"
              placeholder="Ingresa tu contraseña" pattern="[a-zA-Z0-9$@-]{7,100}" maxlength="100" name="login_clave"
              required>
            <a href="" id="emailHelp" class="form-text text-white text-decoration-none">¿Has olvidado tu contraseña?</a>
          </div>
          <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
          
        </form>
      </div>
      <div class="text-center px-5 pt-3 pb-2  w-100">
        <p class="d-inline-block mb-0">Copyright &COPY 2023 Universidad de Nariño Centro de Informática</p>
      </div>
    </div>

    <div class="col-lg-8 d-none d-lg-block bg-dark">
    <img src="img/PortadaPrincipal.jpg" class="img-fluid w-100 vh-100 object-fit-cover" style="object-position: top left;" alt="...">
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const alerta = document.querySelector(".alert");
    setTimeout(function () {
      alerta.style.display = "none";
    }, 4000);
  });
</script>