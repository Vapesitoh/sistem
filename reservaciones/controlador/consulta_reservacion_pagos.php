<?php
include('../include/conexion.php');

// Consulta para obtener todas las reservaciones y calcular el saldo restante
$consultaReservaciones = "SELECT *,
                            (valor_total - COALESCE(primer_pago, 0) - COALESCE(segundo_pago, 0) - COALESCE(tercer_pago, 0) - COALESCE(cuarto_pago, 0)) AS saldo_restante
                        FROM reservacion
                        WHERE estado = 3";

$resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);

// Verificar si hubo errores en la consulta
if (!$resultadoReservaciones) {
    // Manejar el error, redirigir o mostrar un mensaje de error
    echo "Error al obtener las reservaciones: " . mysqli_error($conexion);
    exit();
}

// Crear un array para almacenar las reservaciones
$reservaciones = array();

// Iterar sobre los resultados y almacenarlos en el array
while ($fila = mysqli_fetch_assoc($resultadoReservaciones)) {
    $reservaciones[] = $fila;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoReservaciones);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Devolver el array de reservaciones como respuesta
echo json_encode($reservaciones);
?>
