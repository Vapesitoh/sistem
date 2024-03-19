<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha proporcionado un ID válido para borrar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Obtener el ID de la seccion a borrar
    $seccionId = $_POST['id'];

    // Query para borrar la seccion con el ID proporcionado
    $query = "DELETE FROM seccion WHERE id = $seccionId";

    // Ejecutar la consulta
    if ($conexion->query($query) === TRUE) {
        // Devolver una respuesta de éxito
        echo json_encode(array('success' => true, 'message' => 'Sección eliminada exitosamente.'));
    } else {
        // Devolver un mensaje de error si la consulta falla
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar la sección: ' . $conexion->error));
    }
} else {
    // Devolver un mensaje de error si no se proporcionó un ID válido
    echo json_encode(array('success' => false, 'message' => 'ID de sección no válido.'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
