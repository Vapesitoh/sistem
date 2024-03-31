<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Consulta para obtener el recuento de reservaciones por día del mes
$consultaReservacionesPorDia = "SELECT DAY(fecha_reservacion) AS dia, COUNT(*) AS total_reservas FROM reservacion GROUP BY DAY(fecha_reservacion)";
$resultadoReservacionesPorDia = mysqli_query($conexion, $consultaReservacionesPorDia);

// Array para almacenar los datos del gráfico
$datos = [];

// Procesar los resultados de la consulta
while ($fila = mysqli_fetch_assoc($resultadoReservacionesPorDia)) {
    $datos[$fila['dia']] = $fila['total_reservas'];
}

// Preparar los datos para el gráfico
$labels = range(1, 31); // Crear un array con los días del mes
$datosGrafico = [];

foreach ($labels as $dia) {
    $datosGrafico[] = isset($datos[$dia]) ? $datos[$dia] : 0;
}

// Devolver los datos como un array JSON
$resultados = [
    'labels' => $labels,
    'datos' => $datosGrafico
];

echo json_encode($resultados);
?>
