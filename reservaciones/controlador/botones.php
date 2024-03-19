<?php
include('../include/conexion.php');

session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, retornar un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

// Obtener el rol del usuario de la base de datos
$usuario_id = $_SESSION['usuario_id'];
$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);
if (!$resultadoRolUsuario) {
    // Si hay un error en la consulta, retornar un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Error al obtener el rol del usuario']);
    exit();
}
$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];

// Verificar si el rol del usuario es administrador
if ($rolUsuario !== 'Administrador') {
    // Si el usuario no es administrador, retornar un mensaje de error
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit();
}

// Verificar si se recibió un ID válido
if (!isset($_POST['id'])) {
    // Si no se recibió un ID válido, retornar un mensaje de error
    echo json_encode(['success' => false, 'message' => 'ID de reservación no válido']);
    exit();
}

$reservacionId = $_POST['id'];

// Verificar la acción a realizar
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'cancelar') {
        // Consulta para obtener el ID de habitación asociado a la reservación
        $consultaHabitacionId = "SELECT habitacion_id FROM reservacion WHERE id = $reservacionId";
        $resultadoHabitacionId = mysqli_query($conexion, $consultaHabitacionId);
        if (!$resultadoHabitacionId) {
            // Si hay un error en la consulta, retornar un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al obtener el ID de la habitación']);
            exit();
        }
        $filaHabitacionId = mysqli_fetch_assoc($resultadoHabitacionId);
        $habitacionId = $filaHabitacionId['habitacion_id'];

        // Actualizar la columna de estado en la tabla de habitaciones
        $actualizarEstadoHabitacion = "UPDATE habitaciones SET estado = 1 WHERE id = $habitacionId";
        $resultadoActualizarEstado = mysqli_query($conexion, $actualizarEstadoHabitacion);
        if (!$resultadoActualizarEstado) {
            // Si hay un error al actualizar el estado de la habitación, retornar un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al cancelar la reservación']);
            exit();
        }

        // Actualizar el estado de la reservación en la tabla de reservaciones
        $actualizarEstadoReservacion = "UPDATE reservacion SET estado = 1 WHERE id = $reservacionId";
        $resultadoActualizarReservacion = mysqli_query($conexion, $actualizarEstadoReservacion);
        if (!$resultadoActualizarReservacion) {
            // Si hay un error al actualizar el estado de la reservación, retornar un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al cancelar la reservación']);
            exit();
        }

        // Si se completaron todas las operaciones con éxito, retornar un mensaje de éxito
        echo json_encode(['success' => true, 'message' => 'Reservación cancelada con éxito']);
    } elseif ($_POST['action'] === 'aprobar') {
        // Verificar si se recibió el monto del primer pago
        if (!isset($_POST['monto_primer_pago']) || !is_numeric($_POST['monto_primer_pago'])) {
            echo json_encode(['success' => false, 'message' => 'Monto del primer pago no válido']);
            exit();
        }

        $montoPrimerPago = $_POST['monto_primer_pago'];

        // Obtener el valor total y el 50% del valor total de la reserva
        $consultaValores = "SELECT valor_total, habitacion_id FROM reservacion WHERE id = $reservacionId";
        $resultadoValores = mysqli_query($conexion, $consultaValores);
        if (!$resultadoValores) {
            echo json_encode(['success' => false, 'message' => 'Error al obtener el valor total de la reserva']);
            exit();
        }
        $filaValores = mysqli_fetch_assoc($resultadoValores);
        $valorTotal = $filaValores['valor_total'];
        $habitacionId = $filaValores['habitacion_id'];
        $cincuentaPorCiento = $valorTotal * 0.5;

        // Verificar si el monto del primer pago está dentro del rango permitido
        if ($montoPrimerPago < $cincuentaPorCiento || $montoPrimerPago > $valorTotal) {
            echo json_encode(['success' => false, 'message' => 'El monto del primer pago debe ser al menos el 50% del valor total de la reserva y no mayor que el valor total']);
            exit();
        }

        // Actualizar el estado de la reservación y el monto del primer pago en la tabla de reservaciones
        $actualizarReservacion = "UPDATE reservacion SET estado = 3, primer_pago = $montoPrimerPago WHERE id = $reservacionId";
        $resultadoActualizarReservacion = mysqli_query($conexion, $actualizarReservacion);
        if (!$resultadoActualizarReservacion) {
            echo json_encode(['success' => false, 'message' => 'Error al aprobar la reservación']);
            exit();
        }

        // Actualizar el estado de la habitación a 0 en la tabla de habitaciones
        $actualizarEstadoHabitacion = "UPDATE habitaciones SET estado = 0 WHERE id = $habitacionId";
        $resultadoActualizarEstadoHabitacion = mysqli_query($conexion, $actualizarEstadoHabitacion);
        if (!$resultadoActualizarEstadoHabitacion) {
            // Si hay un error al actualizar el estado de la habitación, retornar un mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado de la habitación']);
            exit();
        }

        echo json_encode(['success' => true, 'message' => 'Reservación aprobada con éxito']);
    } else {
        // Si no se recibió una acción válida, retornar un mensaje de error
        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        exit();
    }
} else { echo json_encode(['success' => false, 'message' => 'Acción no especificada']);
    exit();
    }
    ?>
