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
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Tarjetas</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tabla-tarjetas" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center">Título</th>
                                        <th class="strong-black-text text-center">Imagen</th>
                                        <th class="strong-black-text text-center">Descripción</th>
                                        <th class="strong-black-text text-center">Estado</th>
                                        <th class="text-secondary opacity-7"></th>
                                        <th class="text-secondary opacity-7"></th>
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            function cargarTarjetas() {
                $.ajax({
                    url: 'controlador/consultar_tarjetas.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#tabla-tarjetas tbody').empty();
                        data.forEach(function(tarjeta) {
                            var fila = `
                                <tr>
                                    <td class="strong-black-text text-center align-middle">${tarjeta.titulo}</td>
                                    <td class="strong-black-text text-center align-middle">
                                        <img src="${tarjeta.imagen}" alt="Imagen Tarjeta" style="max-width: 150px; max-height: 150px;">
                                    </td>
                                    <td class="strong-black-text text-center align-middle">${dividirEnLineas(tarjeta.descripcion, 10)}</td>
                                    <td class="strong-black-text align-middle text-center">${tarjeta.estado == 1 ? 'Activo' : 'Desactivado'}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-borrar" data-id="${tarjeta.id}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                    <td class="strong-black-text align-middle text-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-tarjeta" type="checkbox" id="toggle-${tarjeta.id}" data-id="${tarjeta.id}" ${tarjeta.estado == 1 ? 'checked' : ''}>
                                            <label class="form-check-label" for="toggle-${tarjeta.id}">
                                                ${tarjeta.estado == 1 ? 'Activo' : 'Desactivado'}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            $('#tabla-tarjetas tbody').append(fila);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            cargarTarjetas();

            $(document).on('click', '.btn-borrar', function() {
                var tarjetaId = $(this).data('id');

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
                            url: 'controlador/borrar_tarjetas.php',
                            type: 'POST',
                            dataType: 'json',
                            data: { id: tarjetaId },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Eliminado',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        cargarTarjetas();
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

            $(document).on('change', '.toggle-tarjeta', function() {
                var tarjetaId = $(this).data('id');
                var estado = this.checked ? 1 : 0;

                $.ajax({
                    url: 'controlador/cambiar_estado_tarjetas.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: tarjetaId, estado: estado },
                    success: function(response) {
                        if (response.success) {
                            cargarTarjetas();
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            function dividirEnLineas(texto, palabrasPorLinea) {
                var palabras = texto.split(' ');
                var lineas = [];
                var lineaActual = '';

                palabras.forEach(function(palabra, indice) {
                    lineaActual += palabra + ' ';
                    if ((indice + 1) % palabrasPorLinea === 0 || indice === palabras.length - 1) {
                        lineas.push(lineaActual.trim());
                        lineaActual = '';
                    }
                });

                return lineas.join('<br>');
            }
        });
    </script>
</body>
