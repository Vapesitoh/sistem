<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include 'include/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir a index.php
    header("Location: index.php");
    exit();
}

// Obtener el rol del usuario de la base de datos
$usuario_id = $_SESSION['usuario_id'];
$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

if (!$resultadoRolUsuario) {
    // Si hay un error en la consulta, redirigir a una página de error o manejar el error de alguna otra manera
    header("Location: 403.php");
    exit();
}

$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];

// Verificar si el rol del usuario es administrador
if ($rolUsuario !== 'Administrador') {
    // Si el usuario no es administrador, redirigir a una página de acceso denegado
    header("Location: 403.php");
    exit();
}
?>
<style>
    .strong-black-text {
        color: #000;
        font-weight: bold;
    }

    /* Reducir el espacio entre las filas */
    .table tbody tr {
        margin-bottom: -5px; /* Ajusta este valor según sea necesario */
    }

    /* Compactar el contenido verticalmente */
    .table tbody tr td {
        padding-top: 5px; /* Ajusta este valor según sea necesario */
        padding-bottom: 5px; /* Ajusta este valor según sea necesario */
    }
</style>
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Habitaciones</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tabla-habitaciones" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center">Habitaciones</th>
                                        <th class="strong-black-text text-center">Imágenes</th>
                                        <th class="strong-black-text text-center">Tipo</th>
                                        <th class="strong-black-text text-center">Mascotas</th>
                                        <th class="strong-black-text text-center">Baños</th>
                                        <th class="strong-black-text text-center">Camas</th>
                                        <th class="strong-black-text text-center">Precio</th>
                                        <th class="strong-black-text text-center">Estado</th>
                                        <th class="text-secondary opacity-7"></th> <!-- Nueva columna para el botón Editar -->
                                        <th class="text-secondary opacity-7"></th> <!-- Nueva columna para el botón Borrar -->
                                        <th class="text-secondary opacity-7"></th> <!-- Nueva columna para el botón Deshabilitar/Habilitar -->
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
            function cargarHabitaciones() {
                $.ajax({
                    url: 'controlador/consulta_habitaciones.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#tabla-habitaciones tbody').empty();
                        data.forEach(function(habitacion) {
                            var fila = `
                                <tr>
                                    <td hidden class="strong-black-text text-center align-middle">${habitacion.id}</td>
                                    <td  class="strong-black-text text-center align-middle">${habitacion.titulo}</td>
                                    <td class="strong-black-text text-center text-xs font-weight-bold mb-0">
                                        <img src="${habitacion.foto1}" alt="Imágenes Habitación" style="max-width: 150px; max-height: 150px;">
                                    </td>
                                    <td class="strong-black-text text-center text-center align-middle">${habitacion.tipo}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${habitacion.mascotas}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${habitacion.banos}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${habitacion.camas}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${habitacion.precio}</td>
                                    <td class="strong-black-text align-middle text-center">${habitacion.estado == 1 ? 'Activo' : 'Desactivado'}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-borrar" data-id="${habitacion.id}">
                                            <i class="bi bi-trash"></i> <!-- Ícono de trash -->
                                        </button>
                                    </td>

                                    <td class="strong-black-text align-middle text-center">
                                        <button class="btn btn-primary btn-editar" data-id="${habitacion.id}">
                                            <i class="bi bi-pencil-square"></i> <!-- Ícono de lápiz -->
                                        </button>
                                    </td>

                                    <td class="strong-black-text align-middle text-center">
                                            <div class="form-check form-switch">
                                            <input class="form-check-input toggle-habitacion" type="checkbox" id="toggle-${habitacion.id}" data-id="${habitacion.id}" ${habitacion.estado == 1 ? 'checked' : ''}>
                                            <label class="form-check-label" for="toggle-${habitacion.id}">
                                                ${habitacion.estado == 1 ? 'Activo' : 'Desactivado'}
                                            </label>
                                        </div>
                                    </td>

                            `;
                            $('#tabla-habitaciones tbody').append(fila);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            cargarHabitaciones();
            $(document).on('click', '.btn-borrar', function() {
                var habitacionId = $(this).data('id');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'controlador/borrar_habitaciones.php',
                            type: 'POST',
                            dataType: 'json',
                            data: { id: habitacionId },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Eliminado',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        cargarHabitaciones();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'Aceptar'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });


    $(document).ready(function() {
        function cargarFormularioEdicion(idHabitacion) {
            $.ajax({
                url: 'controlador/cargar_formulario_edicion.php',
                type: 'POST',
                dataType: 'html',
                data: { id: idHabitacion },
                success: function(response) {
                    Swal.fire({
                        title: 'Editar Habitación',
                        html: response,
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        showConfirmButton: false
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        $(document).on('click', '.btn-editar', function() {
            var habitacionId = $(this).data('id');
            cargarFormularioEdicion(habitacionId);
        });

        $(document).on('submit', '#formulario-edicion', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'controlador/actualizar_habitacion.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Actualizado',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            Swal.close();
                            cargarHabitaciones();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

$(document).on('change', '.toggle-habitacion', function() {
    var habitacionId = $(this).data('id');
    var estado = this.checked ? 1 : 0; // Obtener el nuevo estado

    $.ajax({
        url: 'controlador/cambiar_estado_habitacion.php',
        type: 'POST',
        dataType: 'json',
        data: { id: habitacionId, estado: estado },
        success: function(response) {
            if (response.success) {
                cargarHabitaciones();
            } else {
                console.error(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
        });
    </script>

</body>
