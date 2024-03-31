<?php
include ('../include/conexion.php');

// Verificar si se ha recibido el ID de la habitación
if(isset($_POST['habitacion_id'])) {
    $habitacion_id = $_POST['habitacion_id'];

    // Consultar la habitación en la base de datos
    $consultaHabitacion = "SELECT * FROM habitaciones WHERE id = $habitacion_id";
    $resultadoHabitacion = mysqli_query($conexion, $consultaHabitacion);

    if(mysqli_num_rows($resultadoHabitacion) > 0) {
        // Si la habitación existe en la base de datos
        $habitacion = mysqli_fetch_assoc($resultadoHabitacion);
        
        // Obtener la fecha y hora actual
        $fecha_actual = date('Y-m-d H:i:s');

        // Consultar todas las reservaciones de la habitación
        $consultaReservaciones = "SELECT * FROM reservacion WHERE habitacion_id = $habitacion_id";
        $resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);

        // Verificar si hay reservaciones para la habitación
        if(mysqli_num_rows($resultadoReservaciones) > 0) {
            $estado_reservacion = null;
            while($reservacion = mysqli_fetch_assoc($resultadoReservaciones)) {
                if($reservacion['estado'] == 3 && $fecha_actual < $reservacion['fecha_reservacion']) {
                    // Si hay una reservación futura con estado 3, la habitación está reservada
                    $estado_reservacion = 'reservada';
                    break;
                } elseif ($reservacion['estado'] == 3 && $fecha_actual >= $reservacion['fecha_reservacion'] && $fecha_actual <= $reservacion['fecha_entrega']) {
                    // Si hay una reservación activa con estado 3, la habitación está ocupada
                    $estado_reservacion = 'ocupada';
                    break;
                }
            }

            if($estado_reservacion === 'reservada') {
                echo 'La habitación está reservada.';
            } elseif($estado_reservacion === 'ocupada') {
                echo 'La habitación está ocupada.';
            } else {
                echo 'La habitación está disponible.';
            }
        } else {
            // Si no hay reservaciones para la habitación
            echo 'La habitación está disponible.';
        }
    } else {
        // Si la habitación no existe en la base de datos
        echo 'La habitación no existe.';
    }

    // Liberar los resultados de las consultas
    mysqli_free_result($resultadoReservaciones);
    mysqli_free_result($resultadoHabitacion);
} else {
    // Si no se ha recibido el ID de la habitación
    echo 'No se ha proporcionado el ID de la habitación.';
}

// Cerrar la conexión
mysqli_close($conexion);
?>
