<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
            </div>
        </div>
    </div>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Registro</h4>
                                    <p class="mb-0">Por favor, complete el siguiente formulario para registrarse</p>
                                </div>
                                <div class="card-body">
                                    <form id="registroForm">
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="Nombres" aria-label="Nombres" name="nombres" required="">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="Número de Teléfono" aria-label="Número de Teléfono" name="numero_telefono" required="">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="Cédula" aria-label="Cédula" name="cedula" required="">
                                        </div>
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg" placeholder="Correo Electrónico" aria-label="Correo Electrónico" name="correo" required="">
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Contraseña" name="contrasena" required="">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Registrarse</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        ¿Ya tiene una cuenta?
                                        <a href="index.php" class="text-primary text-gradient font-weight-bold">Inicie sesión ahora</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4  class="mt-5 text-white font-weight-bolder position-relative">"La atención es la nueva moneda"</h4>
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
<!-- Script para manejar el registro -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#registroForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'include/registro.php',
                data: $(this).serialize(),
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro exitoso!',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "registro.php";
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            });
        });
    });
</script>
<!-- Botones de Github -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center para Soft Dashboard: efectos de paralaje, scripts para las páginas de ejemplo, etc. -->
<script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>
