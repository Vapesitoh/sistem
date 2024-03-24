<?php
session_start();

include 'include/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
</head>
<style>
    .card {
        max-width: 400px;
        margin: 0 auto;
        margin-top: 50px;
        padding: 20px;
    }
    .card img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto;
        display: block;
        margin-bottom: 20px;
    }
    .password-container {
    position: relative;
}

#togglePassword {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%);
    cursor: pointer;
}

</style>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="card">
            <img id="imagenUsuario" src="" alt="Imagen de Usuario">
            <h5 class="card-title" id="nombreUsuario"></h5>
            <p class="card-text" id="telefonoUsuario"></p>
            <p class="card-text" id="cedulaUsuario"></p>
            <p class="card-text" id="correoUsuario"></p>
            <button type="button" class="btn btn-primary" onclick="mostrarAlerta()">Cambiar Foto de Perfil</button>
            <button type="button" class="btn btn-danger" onclick="cambiarContraseña()">Cambiar Contraseña</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script>
        $(document).ready(function(){
            // Cargar información del usuario al cargar la página
            cargarInformacionUsuario();
        });

        function cargarInformacionUsuario() {
            // Obtener el ID de usuario de la sesión
            var usuario_id = <?php echo isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'null'; ?>;
            
            if(usuario_id !== null) {
                // Enviar solicitud AJAX para obtener los datos del usuario
                $.ajax({
                    url: 'controlador/consultar_usuario.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {usuario_id: usuario_id},
                    success: function(response){
                        if(response.status === 'success'){
                            // Mostrar los datos del usuario en la card
                            $('#imagenUsuario').attr('src', response.data.imagen);
                            $('#nombreUsuario').text('Nombres: ' + response.data.nombres);
                            $('#telefonoUsuario').text('Teléfono: ' + response.data.numero_telefono);
                            $('#cedulaUsuario').text('Cédula: ' + response.data.cedula);
                            $('#correoUsuario').text('Correo: ' + response.data.correo);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }
        }


        function mostrarAlerta() {
            Swal.fire({
                title: 'Seleccione la imagen que desea colocar',
                input: 'file',
                inputAttributes: {
                    accept: 'image/*',
                    'aria-label': 'Upload your profile picture'
                },
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (file) => {
                    if (file) {
                        var formData = new FormData();
                        formData.append('foto_perfil', file);

                        return $.ajax({
                            url: 'controlador/cargar_foto.php',
                            method: 'POST',
                            data: formData,
                            dataType: 'json',
                            contentType: false,
                            processData: false
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed && result.value.status === 'success') {
                    cargarInformacionUsuario();
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: result.value.message
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Operación cancelada',
                        text: 'No se ha realizado ningún cambio en la foto de perfil'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la foto de perfil'
                    });
                }
            });
        }

        function cambiarContraseña() {
    Swal.fire({
        title: 'Ingrese la nueva contraseña:',
        html: '<div class="password-container">' +
              '<input type="password" id="nuevaContrasena" class="swal2-input" placeholder="Nueva contraseña" minlength="8">' +
              '<input type="password" id="confirmarContrasena" class="swal2-input" placeholder="Confirmar contraseña">' +
              '<i class="fas fa-eye-slash" id="togglePassword" onclick="togglePassword()"></i>' +
              '</div>',
        showCancelButton: true,
        confirmButtonText: 'Cambiar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            var nuevaContrasena = document.getElementById('nuevaContrasena').value;
            var confirmarContrasena = document.getElementById('confirmarContrasena').value;

            if (nuevaContrasena.length < 8) {
                Swal.showValidationMessage('La contraseña debe tener al menos 8 caracteres');
                return false;
            }

            if (nuevaContrasena !== confirmarContrasena) {
                Swal.showValidationMessage('Las contraseñas no coinciden');
                return false;
            }

            return nuevaContrasena;
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar la nueva contraseña al servidor
            $.ajax({
                url: 'controlador/pas.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    nueva_contrasena: result.value
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Contraseña actualizada',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }
    });
}

function togglePassword() {
    var passwordInput = document.getElementById('nuevaContrasena');
    var toggleIcon = document.getElementById('togglePassword');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}


    </script>

    <!-- Incluir otros scripts JavaScript aquí -->

</body>
</html>
