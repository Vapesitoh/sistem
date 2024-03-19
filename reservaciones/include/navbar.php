<?php
include ('conexion.php'); // Incluye el archivo de conexión a la base de datos

// Ejemplo de obtención del rol desde la base de datos (suponiendo que ya tienes la lógica para obtener el rol del usuario)
$usuario_id = $_SESSION['usuario_id']; // Suponiendo que tienes almacenado el ID del usuario en la sesión
$sql = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $rol = $fila['rol']; // Asigna el rol del usuario
} else {
    // Manejo de error si no se encuentra el rol del usuario
    $rol = 'error'; // Por ejemplo, podrías establecer un valor predeterminado o mostrar un mensaje de error
}
if(isset($_SESSION['usuario_id'])) {
  $usuario_id = $_SESSION['usuario_id']; // Obtén el ID del usuario de la sesión

  // Consulta SQL para obtener el nombre del usuario y la ruta de la imagen de perfil
  $sql = "SELECT nombres, imagen FROM usuarios WHERE id = $usuario_id";
  $resultado = $conexion->query($sql);

  if ($resultado->num_rows > 0) {
      $fila = $resultado->fetch_assoc();
      $nombres = $fila['nombres']; // Obtén el nombre del usuario
      $ruta_imagen = $fila['imagen']; // Obtén la ruta de la imagen de perfil del usuario
  } else {
      // Manejo de error si no se encuentra el nombre del usuario
      $nombres = 'Error'; // Por ejemplo, podrías establecer un valor predeterminado o mostrar un mensaje de error
      $ruta_imagen = ''; // Por ejemplo, podrías establecer una ruta predeterminada para una imagen de perfil por defecto
  }
} else {
  // Manejo de error si no hay una sesión de usuario
  $nombres = 'No hay sesión'; // Por ejemplo, podrías mostrar un mensaje indicando que no hay una sesión activa
  $ruta_imagen = ''; // Por ejemplo, podrías establecer una ruta predeterminada para una imagen de perfil por defecto
}

$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtener el nombre de la página actual
?>
<style>
    /* Estilos para la sección activa del menú de navegación */
.navbar-nav .nav-item.active .nav-link {
    background-color: #007bff; /* Color de fondo */
    color: #fff; /* Color del texto */
    border-radius: 0.375rem; /* Radio de borde */
}

</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <title>Panel</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="#">
                <img src="./assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">Panel administrativo</span>
                
              </a>
            </div>
            <div class="border-radius-md p-3 " style=" display: flex; align-items: center;">  <!-- Contenedor flex para alinear contenido verticalmente -->
                <img src="<?php echo $ruta_imagen; ?>" alt="Imagen de perfil" style="width: 70px; height: 70px; border-radius: 70%; margin-right: 10px;">
                <p class="ms-1 font-weight-normal text-muted mb-0"><?php echo $nombres; ?></p>
            </div>

        <hr class="dark mt-auto">
        <div class="w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
            <ul class="navbar-nav">
    <?php if ($rol === 'Administrador') { ?>
        <li class="nav-item <?php echo ($pagina_actual == 'inicio.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./inicio.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Inicio</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'formulario.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./formulario.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Formularios</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'habitaciones.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./habitaciones.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Habitaciones</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'pagos.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./pagos.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Pagos</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'solicitudes.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./solicitudes.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Solicitudes</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'limpieza.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./limpieza.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Limpieza</span>
            </a>
        </li>
        <li class="nav-item <?php echo ($pagina_actual == 'usuarios.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="./usuarios.php">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Usuarios</span>
            </a>
        </li>
                    <!-- Otras secciones para Administrador -->
                <?php } elseif ($rol === 'Cliente') { ?>
                    <li class="nav-item <?php echo ($pagina_actual == 'habitacion.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="./habitacion.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Habitaciones</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($pagina_actual == 'reserva.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="./reserva.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Reserva</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($pagina_actual == 'historial.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="./historial.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Historial</span>
                        </a>
                    </li>
                    <?php } elseif ($rol === 'Empleado') { ?>
                    <!-- Opciones de menú para Empleado -->
                    <li class="nav-item <?php echo ($pagina_actual == 'prueba.php') ? 'active' : ''; ?>">
                    <li class="nav-item">
                        <a class="nav-link" href="./formularios_web.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Formularios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./home.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./lugares.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Lugares turisticos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./menu.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Comida</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./secciones.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Secciones</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./tarjetas.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-app text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Tarjetas</span>
                        </a>
                    </li>
                <?php } ?>


                <!-- Opciones de menú para ambos roles -->
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Sesion</h6>
                </li>
                <li class="nav-item <?php echo ($pagina_actual == 'perfil.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="./perfil.php">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Perfil</span>
                        </a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="./include/logout.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

 
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Panel Web</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Centro turistico las naves</h6>
        </nav>
       
         <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
      </div>
    </div>
  </div>
    <!-- Core JS Files -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/chartjs.min.js"></script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
