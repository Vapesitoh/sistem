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
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Inicio</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="strong-black-text text-center">Título</th>
                          
                                        <th class="strong-black-text text-center">Imagen</th>
                                        <th class="strong-black-text text-center">Descripción</th>
                                        <th class="strong-black-text text-center">Estado</th>
                                        <th class="text-secondary opacity-7 text-center"></th>
                                        <th class="text-secondary opacity-7 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-inicio"></tbody>
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
        }.hidden {
    display: none;
    }

    </style>

    <!-- Importar Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
        $(document).ready(function () {
            function cargarInicio() {
                $.ajax({
                    url: 'controlador/consultar_inicio.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#tabla-inicio').empty();
                        data.forEach(function (inicio) {
                            var texto = dividirEnSegmentos(inicio.texto, 10);
                            var descripcion = dividirEnSegmentos(inicio.descripcion, 10);

                            var fila = `
                                <tr>
                                    <td class="strong-black-text text-center align-middle">${inicio.titulo}</td>
                                    <td class="strong-black-text text-center align-middle hidden">${texto}</td>
                                    <td class="strong-black-text text-center align-middle"><img src="${inicio.imagen}" alt="Imagen Inicio" style="max-width: 150px; max-height: 150px;"></td>
                                    <td class="strong-black-text text-center align-middle">${descripcion}</td>
                                    <td class="strong-black-text align-middle text-center">${inicio.estado == 1 ? 'Activo' : 'Desactivado'}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-danger btn-borrar" data-id="${inicio.id}">
                                            <i class="bi bi-trash"></i> <!-- Ícono de trash -->
                                        </button>
                                    </td>
                                    <td class="strong-black-text align-middle text-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-inicio" type="checkbox" id="toggle-${inicio.id}" data-id="${inicio.id}" ${inicio.estado == 1 ? 'checked' : ''}>
                                            <label class="form-check-label" for="toggle-${inicio.id}">
                                                ${inicio.estado == 1 ? 'Activo' : 'Desactivado'}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            $('#tabla-inicio').append(fila);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            cargarInicio();

            $(document).on('click', '.btn-borrar', function () {
                var inicioId = $(this).data('id');

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
                            url: 'controlador/borrar_inicio.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: inicioId
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Eliminado',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'Aceptar'
                                    }).then(() => {
                                        cargarInicio();
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
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });

            $(document).on('change', '.toggle-inicio', function () {
                var inicioId = $(this).data('id');
                var estado = this.checked ? 1 : 0; // Obtener el nuevo estado

                $.ajax({
                    url: 'controlador/cambiar_estado_inicio.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: inicioId,
                        estado: estado
                    },
                    success: function (response) {
                        if (response.success) {
                            cargarInicio();
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Función para dividir texto en segmentos cada 15 palabras
            function dividirEnSegmentos(texto, palabrasPorSegmento) {
                var palabras = texto.split(' ');
                var segmentos = [];
                var segmentoActual = '';

                palabras.forEach(function (palabra, indice) {
                    segmentoActual += palabra + ' ';
                    if ((indice + 1) % palabrasPorSegmento === 0 || indice === palabras.length - 1) {
                        segmentos.push(segmentoActual.trim());
                        segmentoActual = '';
                    }
                });

                return segmentos.join('<br>');
            }
        });
    </script>
</body>
