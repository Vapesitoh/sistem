<?php
include ('include/conexion.php');

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
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>
<style>
    .hidden {
    display: none;
}

</style>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Usuarios</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="mb-3">
                            <!-- Campo de entrada para filtrar por número de cédula -->
                            <h7>Filtrar por cedúla</h7>
                            <input type="text" id="filtro-cedula" class="form-control" placeholder="Filtrar por número de cédula">
                        </div>
                        <div class="table-responsive p-0">
                            <table id="tabla-usuarios" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center hidden">ID</th>
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
        // Función para cargar usuarios con posibilidad de filtrar por cédula
        var timer;
        
        function cargarUsuarios(filtroCedula = '') {
            clearTimeout(timer); // Limpiar el temporizador existente
            timer = setTimeout(function() {
                $.ajax({
                    url: 'controlador/usuarios.php',
                    type: 'GET',
                    dataType: 'json',
                    data: { cedula: filtroCedula }, // Pasar el número de cédula como parámetro
                    success: function(data) {
                        $('#tabla-usuarios tbody').empty();
                        if (data.length === 0) {
                            Swal.fire({
                                title: 'No se encontraron usuarios',
                                icon: 'info',
                                text: 'No hay usuarios que coincidan con la cédula especificada.'
                            });
                        } else {
                            data.forEach(function(usuario) {
                                // Agregar las filas a la tabla
                                var fila = `
                                    <tr>
                                        <td class="strong-black-text text-center align-middle hidden">${usuario.id}</td>
                                        <td class="strong-black-text text-center align-middle">${usuario.nombres}</td>
                                        <td class="strong-black-text text-center align-middle">${usuario.numero_telefono}</td>
                                        <td class="strong-black-text text-center align-middle">${usuario.cedula}</td>
                                        <td class="strong-black-text text-center align-middle">${usuario.correo}</td>
                                        <td class="strong-black-text text-center align-middle">${usuario.rol}</td>
                                        <td class="text-center align-middle"><img src="${usuario.imagen}" alt="Imagen de perfil" style="max-width: 50px;"></td>
                                        <td class="strong-black-text align-middle text-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-estado" type="checkbox" id="toggle-estado-${usuario.id}" data-id="${usuario.id}" ${usuario.estado == 1 ? 'checked' : ''}>
                                                <label class="form-check-label" for="toggle-estado-${usuario.id}">
                                                    ${usuario.estado == 1 ? 'Activo' : 'Inactivo'}
                                                </label>
                                            </div>
                                        </td>
                                        <td class="strong-black-text align-middle text-center">
                                            <select class="form-select select-rol" data-usuario-id="${usuario.id}">
                                                <option value="Cliente" ${usuario.rol == 'Cliente' ? 'selected' : ''}>Cliente</option>
                                                <option value="Administrador" ${usuario.rol == 'Administrador' ? 'selected' : ''}>Administrador</option>
                                                <option value="Empleado" ${usuario.rol == 'Empleado' ? 'selected' : ''}>Empleado</option>
                                            </select>
                                        </td>
                                    </tr>`;
                                $('#tabla-usuarios tbody').append(fila);
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Hubo un error al obtener los usuarios.'
                        });
                    }
                });
            }, 500); // Esperar 500 milisegundos después de la última entrada
        }

        // Cargar usuarios al cargar la página
        cargarUsuarios();

        // Manejar evento de entrada en el campo de filtrar por cédula
        $('#filtro-cedula').on('input', function() {
            var filtroCedula = $(this).val();
            cargarUsuarios(filtroCedula);
        });

        // Manejar el evento de cambio en el rol del usuario
        $(document).on('change', '.select-rol', function() {
            var usuario_id = $(this).data('usuario-id');
            var nuevo_rol = $(this).val();

            // Verificar si el usuario intenta cambiar su propio rol
            var usuario_id_sesion = <?php echo $usuario_id; ?>;
            if (usuario_id == usuario_id_sesion) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'No puedes editar tu propio rol.'
                });
                return; // Detener el proceso
            }

            // Enviar la solicitud AJAX para actualizar el rol del usuario
            $.ajax({
                url: 'controlador/rol.php',
                type: 'POST',
                dataType: 'json',
                data: { usuario_id: usuario_id, nuevo_rol: nuevo_rol },
                success: function(response) {
                    if(response.success) {
                        // Si la actualización fue exitosa, mostrar una alerta de éxito
                        Swal.fire({
                            title: 'Éxito',
                            icon: 'success',
                            text: response.message
                        });

                        // Actualizar la tabla de usuarios después de cambiar el rol
                        cargarUsuarios($('#filtro-cedula').val());
                    } else {
                        // Si hubo un error, mostrar una alerta de error
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: response.message
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Si hubo un error en la solicitud AJAX, mostrar una alerta de error
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'Hubo un error al procesar la solicitud.'
                    });
                }
            });
        });
        // Manejar el evento de cambio en el estado del usuario
        $(document).on('change', '.toggle-estado', function() {
            var usuario_id = $(this).data('id');
            var nuevo_estado = $(this).prop('checked') ? 1 : 0;

            // Verificar si el usuario intenta cambiar su propio estado
            var usuario_id_sesion = <?php echo $usuario_id; ?>;
            if (usuario_id == usuario_id_sesion) {
                Swal.fire({
                    title: 'Error',
                    icon: 'error',
                    text: 'No puedes deshabilitar tu propio usuario.'
                });
                return; // Detener el proceso
            }

            // Enviar la solicitud AJAX para actualizar el estado del usuario
            $.ajax({
                url: 'controlador/deshabilitar_usuario.php',
                type: 'POST',
                dataType: 'json',
                data: { usuario_id: usuario_id, nuevo_estado: nuevo_estado },
                success: function(response) {
                    if(response.success) {
                        // Si la actualización fue exitosa, mostrar una alerta de éxito
                        Swal.fire({
                            title: 'Éxito',
                            icon: 'success',
                            text: response.message
                        });

                        // Actualizar la tabla de usuarios después de cambiar el estado
                        cargarUsuarios($('#filtro-cedula').val());
                    } else {
                        // Si hubo un error, mostrar una alerta de error
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: response.message
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Si hubo un error en la solicitud AJAX, mostrar una alerta de error
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'Hubo un error al procesar la solicitud.'
                    });
                }
            });
        });
    });
</script>
</body>
</html>