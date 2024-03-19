<?php
// Iniciar la sesión y verificar la autenticación del usuario
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Verificar el rol del usuario
$usuario_id = $_SESSION['usuario_id'];
include ('include/conexion.php');

$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

if (!$resultadoRolUsuario) {
    header("Location: 403.php");
    exit();
}

$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];

if ($rolUsuario !== 'Administrador') {
    header("Location: 403.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Usuarios</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tabla-usuarios" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center">ID</th>
                                        <th class="strong-black-text text-center">Nombres</th>
                                        <th class="strong-black-text text-center">Teléfono</th>
                                        <th class="strong-black-text text-center">Cédula</th>
                                        <th class="strong-black-text text-center">Correo</th>
                                        <th class="strong-black-text text-center">Rol</th>
                                        <th class="strong-black-text text-center">Imagen</th>
                                        <th class="strong-black-text text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .strong-black-text {
            color: #000;
            font-weight: bold;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script>
        $(document).ready(function() {
            function cargarUsuarios() {
                $.ajax({
                    url: 'controlador/usuarios.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#tabla-usuarios tbody').empty();
                        data.forEach(function(usuario) {
                            var fila = `
                                <tr>
                                    <td class="strong-black-text text-center align-middle">${usuario.id}</td>
                                    <td class="strong-black-text text-center align-middle">${usuario.nombres}</td>
                                    <td class="strong-black-text text-center align-middle">${usuario.numero_telefono}</td>
                                    <td class="strong-black-text text-center align-middle">${usuario.cedula}</td>
                                    <td class="strong-black-text text-center align-middle">${usuario.correo}</td>
                                    <td class="strong-black-text text-center align-middle">${usuario.rol}</td>
                                    <td class="text-center align-middle"><img src="${usuario.imagen}" alt="Imagen de perfil" style="max-width: 50px;"></td>
                                    <td class="strong-black-text align-middle text-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-usuario" type="checkbox" id="toggle-${usuario.id}" data-id="${usuario.id}" ${usuario.estado == 1 ? 'checked' : ''}>
                                            <label class="form-check-label" for="toggle-${usuario.id}">
                                                ${usuario.estado == 1 ? 'Activo' : 'Inactivo'}
                                            </label>
                                        </div>
                                    </td>
                                </tr>`;
                            $('#tabla-usuarios tbody').append(fila);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Hubo un error al obtener los usuarios.'
                        });
                    }
                });
            }

            // Llamar a la función para cargar los usuarios al cargar la página
            cargarUsuarios();

            // Manejar el cambio de estado del toggle switch de usuario
            $(document).on('change', '.toggle-usuario', function() {
                var idUsuario = $(this).data('id');
                var nuevoEstado = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: 'controlador/scroll.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { idUsuario: idUsuario, estado: nuevoEstado },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Éxito',
                                icon: 'success',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                icon: 'error',
                                text: response.message
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Hubo un error al cambiar el estado del usuario.'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
