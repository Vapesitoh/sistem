<?php
session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Verificar el rol del usuario
$usuario_id = $_SESSION['usuario_id'];
include 'include/conexion.php';

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
    <title>Calendario Dinámico</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
</head>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Habitación más reservada</p>
                                    <h5 class="font-weight-bolder" id="habitacion-mas-reservada">Cargando...</h5>
                                    <p class="mb-0">
                                        Veces reservadas: <span id="total-reservas">Cargando...</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Dinero ingresado</p>
                                    <h5 class="font-weight-bolder" id="total-pagos">Cargando...</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-1 bg-transparent">
                        <h6 class="text-capitalize">Reservaciones por día de la semana</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-lg-7 mb-lg-0 mb-4">
        <div id="calendar-container" style="background-color: white; width: 95%; max-width: 800px; margin: auto; margin-top: 10px;">
            <div id='calendar'></div>
        </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='./fullcalendar/dist/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <script>
     document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        events: {
            url: 'controlador/fetch_events.php',
            method: 'POST' 
        },
        eventClick: function(info) {
            var habitacion_id = info.event.extendedProps.habitacion_id;
            var fecha_reservacion = info.event.start.toLocaleDateString();
            var fecha_entrega = info.event.end ? info.event.end.toLocaleDateString() : "No entregada"; // Si no hay fecha de entrega, muestra "No entregada"

            Swal.fire({
                title: 'Detalles de la habitación',
                html: '<p>Habitación: ' + habitacion_id + '</p><p>Fecha de reservación: ' + fecha_reservacion + '</p><p>Fecha de entrega: ' + fecha_entrega + '</p>',
                icon: 'info',
                confirmButtonText: 'Aceptar'
            });
        }
    });
    calendar.render();
});

    </script>

<script>
    $(document).ready(function() {
        $.ajax({
            url: 'controlador/tarjetas.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#habitacion-mas-reservada').text(response.habitacion_mas_reservada);
                $('#total-reservas').text(response.total_reservas);
                
                // Verificar si total_pagos es NaN o null y mostrar 0 en su lugar
                var totalPagos = response.total_pagos;
                if (totalPagos === null || isNaN(totalPagos)) {
                    totalPagos = 0;
                }
                $('#total-pagos').text('$' + parseFloat(totalPagos).toFixed(2));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });
    });
</script>


    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'controlador/grafico.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('chart-line').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Reservaciones por día',
                                data: response.datos,
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
                }
            });
        });
    </script>
</body>
</html>
