<?php
// Incluir el archivo de conexión a la base de datos
include '../include/conexion.php';

// Consulta para obtener la habitación más reservada
$consultaHabitacionMasReservada = "SELECT habitacion_id, COUNT(habitacion_id) AS total_reservas FROM reservacion GROUP BY habitacion_id ORDER BY total_reservas DESC LIMIT 1";
$resultadoHabitacionMasReservada = mysqli_query($conexion, $consultaHabitacionMasReservada);

// Obtener el ID de la habitación más reservada y el número de reservas
if ($resultadoHabitacionMasReservada && mysqli_num_rows($resultadoHabitacionMasReservada) > 0) {
    $filaHabitacionMasReservada = mysqli_fetch_assoc($resultadoHabitacionMasReservada);
    $id_habitacion_mas_reservada = $filaHabitacionMasReservada['habitacion_id'];
    $total_reservas = $filaHabitacionMasReservada['total_reservas'];
} else {
    $id_habitacion_mas_reservada = "No hay datos";
    $total_reservas = 0;
}

// Consulta para obtener la suma total de los pagos de todas las reservas
$consultaTotalPagos = "SELECT SUM(COALESCE(primer_pago, 0) + COALESCE(segundo_pago, 0) + COALESCE(tercer_pago, 0)) AS total_pagos FROM reservacion";
$resultadoTotalPagos = mysqli_query($conexion, $consultaTotalPagos);

// Obtener el total de pagos
if ($resultadoTotalPagos && mysqli_num_rows($resultadoTotalPagos) > 0) {
    $filaTotalPagos = mysqli_fetch_assoc($resultadoTotalPagos);
    $total_pagos = $filaTotalPagos['total_pagos'];
} else {
    $total_pagos = 0;
}

// Devolver los resultados como un array JSON
$resultados = [
    'habitacion_mas_reservada' => $id_habitacion_mas_reservada,
    'total_reservas' => $total_reservas,
    'total_pagos' => $total_pagos
];

echo json_encode($resultados);
?>
