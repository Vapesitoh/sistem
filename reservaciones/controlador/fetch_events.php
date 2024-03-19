<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Consulta para obtener las reservaciones de habitaciones
$consultaReservaciones = "SELECT id, habitacion_id, fecha_reservacion, fecha_entrega, estado FROM reservacion";
$resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);

if (!$resultadoReservaciones) {
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

// Preparar un array para los eventos del calendario
$eventos = [];

// Iterar sobre las reservaciones y agregarlas al array de eventos
while ($filaReservacion = mysqli_fetch_assoc($resultadoReservaciones)) {
    switch ($filaReservacion['estado']) {
        case 0:
            // Estado 0: Reserva concluida (color gris)
            $color = '#808080';
            break;
        case 1:
            // Estado 1: Reserva activa (color naranja)
            $color = '#FF0000';
            break;
        case 2:
            // Estado 2: Habitación a probar a reservación (color amarillo)
            $color = '#FFC300';
            break;
        case 3:
            // Estado 3: Habitación aprobada y en reservación (color verde)
            $color = '#008000';
            break;
        default:
            // Otros estados: Reserva activa por defecto (color naranja)
            $color = '#FFA500';
            break;
    }
    
    $evento = [
        'id' => $filaReservacion['id'],
        'title' => 'Habitación ' . $filaReservacion['habitacion_id'], // Título con el número de habitación
        'start' => $filaReservacion['fecha_reservacion'],
        'end' => $filaReservacion['fecha_entrega'],
        'habitacion_id' => $filaReservacion['habitacion_id'], // Asignar habitacion_id al evento
        'estado' => $filaReservacion['estado'],
        'color' => $color // Color según el estado de la reserva
    ];
    $eventos[] = $evento;
}

// Devolver los eventos como JSON
header('Content-Type: application/json');
echo json_encode($eventos);
?>
