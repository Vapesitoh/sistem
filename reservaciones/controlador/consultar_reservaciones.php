<?php
session_start();

include('../include/conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, devuelve un mensaje de error
    echo json_encode(array('error' => 'Usuario no autenticado'));
    exit();
}

// Obtener el ID del usuario autenticado
$usuario_id = $_SESSION['usuario_id'];

// Consultar las reservaciones del usuario actual con estado 2 o 3
$consultaReservaciones = "SELECT * FROM reservacion WHERE usuario_id = $usuario_id AND estado IN (2, 3)";
$resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);

// Preparar los datos para enviar como respuesta JSON
$reservaciones = array();
while ($fila = mysqli_fetch_assoc($resultadoReservaciones)) {
    $reservaciones[] = $fila;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoReservaciones);

// Cerrar la conexión
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($reservaciones);
?>
