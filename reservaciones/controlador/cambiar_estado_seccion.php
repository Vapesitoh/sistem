<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha proporcionado un ID y un estado válido
if (isset($_POST['id']) && isset($_POST['estado']) && !empty($_POST['id']) && ($_POST['estado'] == 0 || $_POST['estado'] == 1)) {
    // Obtener el ID de la sección y el nuevo estado
    $seccionId = $_POST['id'];
    $estado = $_POST['estado'];

    // Query para actualizar el estado de la sección con el ID proporcionado
    $query = "UPDATE seccion SET estado = $estado WHERE id = $seccionId";

    // Ejecutar la consulta
    if ($conexion->query($query) === TRUE) {
        // Devolver una respuesta de éxito
        echo json_encode(array('success' => true, 'message' => 'Estado de la sección actualizado exitosamente.'));
    } else {
        // Devolver un mensaje de error si la consulta falla
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar el estado de la sección: ' . $conexion->error));
    }
} else {
    // Devolver un mensaje de error si no se proporcionó un ID o estado válido
    echo json_encode(array('success' => false, 'message' => 'ID de sección o estado no válido.'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
