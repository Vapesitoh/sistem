<?php
include('../include/conexion.php');

// Consulta las habitaciones
$consultaHabitaciones = "SELECT * FROM habitaciones";
$resultadoHabitaciones = mysqli_query($conexion, $consultaHabitaciones);

// Preparar los datos para enviar como respuesta JSON
$habitaciones = array();
while ($fila = mysqli_fetch_assoc($resultadoHabitaciones)) {
    $habitaciones[] = $fila;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoHabitaciones);

// Cerrar la conexión
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($habitaciones);
?>
