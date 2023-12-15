<div class="main-container">
<section>
    <div class="row g-0">
      
      <div class="col-lg-4 bg-dark d-flex flex-column align-items-end min-vh-100">
        <div class="px-lg-5 pt-lg-5 pb-lg-3 p-4 w-100">
          <h1 class="fw-bold">SISPOS</h1>
          <h6>Sistema de Información para la Gestión de Posgrados</h6>
        </div>
        <div class="align-self-center w-100 px-lg-5 ">
          
          <form class="mb-5 login" action="" method="POST" autocomplete="off">
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label font-weight-bold">Email</label>
              <input type="email" class="form-control text-white bg-dark-x border-0" placeholder="Ingresa tu email" aria-describedby="emailHelp"  name="login_usuario" required>
            </div>
            <div class="mb-4">
              <label for="exampleInputPassword1" class="form-label font-weight-bold">Contraseña</label>
              <input type="password" class="form-control text-white bg-dark-x border-0 mb-2" placeholder="Ingresa tu contraseña" pattern="[a-zA-Z0-9$@-]{7,100}" maxlength="100" name="login_clave" required>
              <a href="" id="emailHelp" class="form-text text-white text-decoration-none">¿Has olvidado tu contraseña?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>

            <?php
              if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
              }
            ?>
          </form>
        </div>
        <div class="text-center px-lg-5 pt-lg-3 pb-lg-4 p-4 w-100">
          <p class="d-inline-block mb-0">Copyright &COPY 2023 Universidad de Nariño Centro de Informática</p>
        </div>
      </div>

      <div class="col-lg-8 d-none d-lg-block">
        <div id="carouselExampleCaptions" class="carousel slide ">
          <div class="carousel-inner">
            <div class="carousel-item active min-vh-100">
              <img src="img/img-1.jpg" class="d-block w-100 h-100 img-fluid" alt="...">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>