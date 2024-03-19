<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha proporcionado un ID y un estado válido
if (isset($_POST['id']) && isset($_POST['estado']) && !empty($_POST['id']) && ($_POST['estado'] == 0 || $_POST['estado'] == 1)) {
    // Obtener el ID de la tarjeta y el nuevo estado
    $tarjetaId = $_POST['id'];
    $estado = $_POST['estado'];

    // Query para actualizar el estado de la tarjeta con el ID proporcionado
    $query = "UPDATE tarjetas SET estado = $estado WHERE id = $tarjetaId";

    // Ejecutar la consulta
    if ($conexion->query($query) === TRUE) {
        // Devolver una respuesta de éxito
        echo json_encode(array('success' => true, 'message' => 'Estado de la tarjeta actualizado exitosamente.'));
    } else {
        // Devolver un mensaje de error si la consulta falla
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar el estado de la tarjeta: ' . $conexion->error));
    }
} else {
    // Devolver un mensaje de error si no se proporcionó un ID o estado válido
    echo json_encode(array('success' => false, 'message' => 'ID de tarjeta o estado no válido.'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
