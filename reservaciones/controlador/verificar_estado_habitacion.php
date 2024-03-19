<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha recibido el ID de la habitación
if (isset($_GET['habitacion_id'])) {
    // Obtener el ID de la habitación desde la solicitud
    $habitacion_id = $_GET['habitacion_id'];

    // Consultar el estado de la habitación en la tabla estado_habitacion
    $consultaEstadoHabitacion = "SELECT estado FROM estado_habitacion WHERE id_habitacion = $habitacion_id";
    $resultadoEstadoHabitacion = mysqli_query($conexion, $consultaEstadoHabitacion);

    // Verificar si se obtuvo algún resultado de la consulta
    if ($resultadoEstadoHabitacion) {
        // Extraer el estado de la consulta
        $filaEstadoHabitacion = mysqli_fetch_assoc($resultadoEstadoHabitacion);
        $estado = $filaEstadoHabitacion['estado'];

        // Devolver el estado como JSON
        echo json_encode(['estado' => $estado]);
    } else {
        // Si hay algún error en la consulta, devolver un estado predeterminado (por ejemplo, inactivo)
        echo json_encode(['estado' => 0]);
    }
} else {
    // Si no se recibió el ID de la habitación, devolver un estado predeterminado (por ejemplo, inactivo)
    echo json_encode(['estado' => 0]);
}
?>
