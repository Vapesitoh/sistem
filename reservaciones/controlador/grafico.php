<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Consulta para obtener el recuento de reservaciones por día de la semana
$consultaReservacionesPorDia = "SELECT DAYOFWEEK(fecha_reservacion) AS dia, COUNT(*) AS total_reservas FROM reservacion GROUP BY DAYOFWEEK(fecha_reservacion)";
$resultadoReservacionesPorDia = mysqli_query($conexion, $consultaReservacionesPorDia);

// Array para almacenar los datos del gráfico
$datos = [];

// Procesar los resultados de la consulta
while ($fila = mysqli_fetch_assoc($resultadoReservacionesPorDia)) {
    $datos[$fila['dia']] = $fila['total_reservas'];
}

// Nombre de los días de la semana
$diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

// Preparar los datos para el gráfico
$labels = [];
$datosGrafico = [];

foreach ($diasSemana as $dia => $nombreDia) {
    $labels[] = $nombreDia;
    $datosGrafico[] = isset($datos[$dia]) ? $datos[$dia] : 0;
}

// Devolver los datos como un array JSON
$resultados = [
    'labels' => $labels,
    'datos' => $datosGrafico
];

echo json_encode($resultados);
?>
