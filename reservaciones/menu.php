<?php
session_start(); // Iniciar la sesión

include('include/conexion.php');
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

// Verificar si el rol del usuario es empleado
if ($rolUsuario != 'Empleado') {
    // Si el usuario no es empleado, redirigir a una página de acceso denegado
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
</head>

<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Comida</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tabla-comida" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center">Título</th>
                                        <th class="strong-black-text text-center">Imagen</th>
                                        <th class="strong-black-text text-center">Descripción</th>
                                        <th class="strong-black-text text-center">Precio</th>
                                        <th class="strong-black-text text-center">Categoría</th>
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
            // Función para dividir una cadena en segmentos de n palabras
            function dividirEnSegmentos(cadena, n) {
                var palabras = cadena.split(' ');
                var segmentos = [];
                for (var i = 0; i < palabras.length; i += n) {
                    segmentos.push(palabras.slice(i, i + n).join(' '));
                }
                return segmentos.join('<br>');
            }

            function cargarComida() {
                $.ajax({
                    url: 'controlador/consulta_comida.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#tabla-comida tbody').empty();
                        data.forEach(function(comida) {
                            // Dividir la descripción en segmentos de 11 palabras
                            var descripcionSegmentada = dividirEnSegmentos(comida.descripcion, 11);
                            var fila = `
                                <tr>
                                    <td class="strong-black-text text-center align-middle">${comida.titulo}</td>
                                    <td class="strong-black-text text-center text-xs font-weight-bold mb-0">
                                        <img src="${comida.imagenes}" alt="Imágenes Comida" style="max-width: 150px; max-height: 150px;">
                                    </td>
                                    <td class="strong-black-text text-center text-center align-middle">${descripcionSegmentada}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${comida.precio}</td>
                                    <td class="strong-black-text text-center text-center align-middle">${comida.categoria}</td>
                                    <td class="strong-black-text align-middle text-center">${comida.estado == 1 ? 'Activo' : 'Desactivado'}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-borrar" data-id="${comida.id}">
                                            <i class="bi bi-trash"></i> <!-- Ícono de trash -->
                                        </button>
                                    </td>
                                    <td class="strong-black-text align-middle text-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-comida" type="checkbox" id="toggle-${comida.id}" data-id="${comida.id}" ${comida.estado == 1 ? 'checked' : ''}>
                                            <label class="form-check-label" for="toggle-${comida.id}">
                                                ${comida.estado == 1 ? 'Activo' : 'Desactivado'}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            $('#tabla-comida tbody').append(fila);
                        });
                    },
                    error: function(xhr, status, error, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            cargarComida();
            // Evento click para el botón de borrar
            $(document).on('click', '.btn-borrar', function() {
                var comidaId = $(this).data('id');

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
                        // Llamada AJAX para borrar la comida
                        $.ajax({
                            url: 'controlador/borrar_comida.php',
                            type: 'POST',
                            dataType: 'json',
                            data: { id: comidaId },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Eliminado',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        cargarComida();
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

            $(document).on('change', '.toggle-comida', function() {
                var comidaId = $(this).data('id');
                var estado = this.checked ? 1 : 0; // Obtener el nuevo estado

                $.ajax({
                    url: 'controlador/cambiar_estado_comida.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: comidaId, estado: estado },
                    success: function(response) {
                        if (response.success) {
                            cargarComida();
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

</html>

