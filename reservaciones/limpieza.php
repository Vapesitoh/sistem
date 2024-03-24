<?php
include('include/conexion.php');
session_start();

// Verificar si el usuario está autenticado y es administrador
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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
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
                                        <th class="strong-black-text text-center">ID habitacion</th>
                                        <th class="strong-black-text text-center">Acción</th>
                                        <th class="strong-black-text text-center">Finalizar Tarea</th> <!-- Nueva columna para el botón de finalizar -->
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
        $(document).ready(function() {
            $.ajax({
                url: 'controlador/consultas_habitaciones_limpieza.php',
                type: 'GET',
                success: function(data) {
                    var response = JSON.parse(data);
                    var habitaciones = response.habitaciones;

                    habitaciones.forEach(function(habitacion) {
                        var row = '<tr>';
                        row += '<td class="text-center">' + habitacion + '</td>';
                        row += '<td class="text-center"><button class="btn btn-primary btn-agregar" data-habitacion="' + habitacion + '"><i class="bi bi-person-fill-add"></i></button></td>';
                        row += '<td class="text-center"><button class="btn btn-danger btn-finalizar" data-habitacion="' + habitacion + '"><i class="bi bi-stopwatch-fill"></i></button></td>';
                        row += '</tr>';

                        $('#tabla-habitaciones tbody').append(row);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        text: 'Hubo un error al obtener las habitaciones.'
                    });
                }
            });

            $(document).on('click', '.btn-agregar', function() {
                var habitacion = $(this).data('habitacion');

                $.ajax({
                    url: 'controlador/consultas_personal.php',
                    type: 'GET',
                    success: function(data) {
                        var response = JSON.parse(data);
                        var personal = response.personal;

                        Swal.fire({
                            title: 'Seleccione al Personal',
                            input: 'select',
                            inputOptions: personal.reduce(function(acc, curr) {
                                acc[curr.id] = curr.nombres + ' (' + curr.cargo + ')';
                                return acc;
                            }, {}),
                            inputPlaceholder: 'Seleccione...',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            confirmButtonText: 'Agregar',
                            inputValidator: function(value) {
                                if (!value) {
                                    return 'Debe seleccionar al personal para agregar.';
                                }
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                var personalSeleccionado = result.value;
                                $.ajax({
                                    url: 'controlador/botones_personal.php',
                                    type: 'POST',
                                    data: {
                                        action: 'agregarPersonal',
                                        habitacion_id: habitacion,
                                        personal_id: personalSeleccionado
                                    },
                                    success: function(response) {
                                        response = JSON.parse(response);
                                        if (response.status === 'success') {
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
                                            text: 'Hubo un error al agregar personal.'
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            icon: 'error',
                            text: 'Hubo un error al obtener el personal.'
                        });
                    }
                });
            });

            $(document).on('click', '.btn-finalizar', function() {
                var habitacion = $(this).data('habitacion');

                Swal.fire({
                    title: '¿Estás seguro de finalizar la limpieza?',
                    text: 'Esta acción finalizará la limpieza de la habitación seleccionada.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, finalizar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'controlador/botones_personal.php',
                            type: 'POST',
                            data: {
                                action: 'finalizarLimpieza',
                                habitacion_id: habitacion
                            },
                            success: function(response) {
                                response = JSON.parse(response);
                                if (response.status === 'success') {
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
                                    text: 'Hubo un error al finalizar la limpieza.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
