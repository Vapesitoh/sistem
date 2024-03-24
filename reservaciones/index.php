<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>Iniciar Sesión</title>
  <!-- Fuentes e íconos -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Iconos Nucleo -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Iconos Font Awesome -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Archivos CSS -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>
<style>
    
.error-message {
    background-color: #ff3333; /* Rojo */
    color: #ffffff; /* Blanco */
    padding: 10px;
    border-radius: 5px;
    text-align: center;
}
</style>
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
      <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message">' . $_GET['error'] . '</p>';
    }
    ?>
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Iniciar Sesión</h4>
                  <p class="mb-0">Ingresa tu correo electrónico y contraseña para iniciar sesión</p>
                </div>
                <div class="card-body">
                  <form role="form" action="include/login.php" method="post">
                    <div class="mb-3">
                      <input type="email" class="form-control form-control-lg" placeholder="Correo Electrónico" aria-label="Email" name="correo">
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Password" name="contrasena">
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Recordarme</label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Iniciar Sesión</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    ¿No tienes una cuenta?
                    <a href="registro.php" class="text-primary text-gradient font-weight-bold">Regístrate</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">"La atención es la nueva moneda"</h4>
                <p class="text-white position-relative">Cuanto más fácil parezca la escritura, más esfuerzo puso el escritor en el proceso.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Archivos JS Core -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Botones de Github -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center para Soft Dashboard: efectos de paralaje, scripts para las páginas de ejemplo, etc. -->
  <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
