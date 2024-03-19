<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibieron los datos requeridos
if (isset($_POST['id']) && isset($_POST['estado'])) {
    // Obtener los datos enviados por la solicitud AJAX
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    // Preparar la consulta para actualizar el estado de la habitación
    $consultaActualizarEstado = "UPDATE habitaciones SET estado = $estado WHERE id = $id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consultaActualizarEstado)) {
        // Si la consulta se ejecuta con éxito, enviar una respuesta JSON indicando éxito
        echo json_encode(array('success' => true));
    } else {
        // Si hay un error en la consulta, enviar una respuesta JSON con el mensaje de error
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar el estado de la habitación'));
    }
} else {
    // Si no se reciben los datos requeridos, enviar una respuesta JSON con un mensaje de error
    echo json_encode(array('success' => false, 'message' => 'No se recibieron los datos requeridos'));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>