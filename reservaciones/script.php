<?php

$host = 'localhost';
$usuario = 'root';
$contrasena = ''; // No hay contraseña
$base_datos = 'hotel_prueba2'; // Nombre de la base de datos
// Crear la conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a utf8
$conexion->set_charset("utf8");

// Obtener la fecha y hora actual
$current_date = date("Y-m-d H:i:s");

// Consulta para actualizar el estado de las reservaciones caducadas en la tabla reservacion
$sql_reservacion = "UPDATE reservacion SET estado = 0 WHERE fecha_entrega < '$current_date' AND estado = 3";
$result_reservacion = $conexion->query($sql_reservacion);

// Consulta para actualizar el estado de las habitaciones correspondientes en la tabla habitaciones
$sql_habitaciones = "UPDATE habitaciones h
                    INNER JOIN reservacion r ON h.id = r.habitacion_id
                    SET h.estado = 1
                    WHERE r.estado = 0";
$result_habitaciones = $conexion->query($sql_habitaciones);

if ($result_reservacion === TRUE && $result_habitaciones === TRUE) {
    echo "Reservaciones caducadas actualizadas correctamente.";
} else {
    echo "Error al actualizar reservaciones caducadas: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>