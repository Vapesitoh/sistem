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

// Consultar el historial de reservaciones del usuario actual con estado 1 y 0
$consultaHistorial = "SELECT * FROM reservacion WHERE usuario_id = $usuario_id AND (estado = 0 OR estado = 1)";
$resultadoHistorial = mysqli_query($conexion, $consultaHistorial);

// Preparar los datos para enviar como respuesta JSON
$historial = array();
while ($fila = mysqli_fetch_assoc($resultadoHistorial)) {
    // Crear un array asociativo con los datos relevantes de la reservación
    $reservacion = array(
        'id' => $fila['id'],
        'habitacion_id' => $fila['habitacion_id'],
        'nombre_usuario' => $fila['nombre_usuario'],
        'numero_telefono' => $fila['numero_telefono'],
        'tipo_habitacion' => $fila['tipo_habitacion'],
        'fecha_reservacion' => $fila['fecha_reservacion'],
        'fecha_entrega' => $fila['fecha_entrega'],
        'precio' => $fila['precio'],
        'estado' => $fila['estado'],
        'valor_total' => $fila['valor_total']
    );
    // Agregar la reservación al historial
    $historial[] = $reservacion;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoHistorial);

// Cerrar la conexión
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($historial);
?>
