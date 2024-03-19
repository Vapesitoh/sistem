<?php
session_start();

include 'include/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

if (!$resultadoRolUsuario) {
    header("Location: 403.php");
    exit();
}
$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];
if ($rolUsuario !== 'Cliente') {
    header("Location: 403.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservaciones</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Historial</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tabla-historial" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th hidden class="text-center">ID</th>
                                        <th hidden class="text-center">Habitación ID</th> <!-- Ocultar la columna Habitación ID -->
                                        <th class="text-center">Número de Habitación</th> <!-- Cambiar el nombre de la columna -->
                                        <th class="text-center">Nombre Usuario</th>
                                        <th class="text-center">Número Teléfono</th>
                                        <th class="text-center">Tipo de Habitación</th>
                                        <th class="text-center">Fecha de Reservación</th>
                                        <th class="text-center">Fecha de Entrega</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Valor total</th>
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
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: 'controlador/consulta_historial.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var tableBody = $('#tabla-historial tbody');
                    $.each(data, function(index, reservacion) {
                        var estadoTexto = reservacion.estado === '1' ? 'Cancelado' : 'Pagado';
                        var row = $('<tr>');
                        row.append($('<td hidden>').text(reservacion.id));
                        row.append($('<td class="text-center">').text(reservacion.habitacion_id));
                        row.append($('<td class="text-center">').text(reservacion.nombre_usuario));
                        row.append($('<td class="text-center">').text(reservacion.numero_telefono));
                        row.append($('<td class="text-center">').text(reservacion.tipo_habitacion));
                        row.append($('<td class="text-center">').text(reservacion.fecha_reservacion));
                        row.append($('<td class="text-center">').text(reservacion.fecha_entrega));
                        row.append($('<td class="text-center">').text(reservacion.precio));
                        row.append($('<td class="text-center">').text(estadoTexto));
                        row.append($('<td class="text-center">').text(reservacion.valor_total));
                        tableBody.append(row);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al obtener el historial de reservaciones:', textStatus, errorThrown);
                }
            });
        });
    </script>
</body>
</html>
