<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha proporcionado un ID válido para borrar
if (isset($_POST['id']) && !empty($_POST['id'])) {
    // Obtener el ID del inicio a borrar
    $inicioId = $_POST['id'];

    // Query para borrar el inicio con el ID proporcionado
    $query = "DELETE FROM inicio WHERE id = $inicioId";

    // Ejecutar la consulta
    if ($conexion->query($query) === TRUE) {
        // Devolver una respuesta de éxito
        echo json_encode(array('success' => true, 'message' => 'Inicio eliminado exitosamente.'));
    } else {
        // Devolver un mensaje de error si la consulta falla
        echo json_encode(array('success' => false, 'message' => 'Error al eliminar el inicio: ' . $conexion->error));
    }
} else {
    // Devolver un mensaje de error si no se proporcionó un ID válido
    echo json_encode(array('success' => false, 'message' => 'ID de inicio no válido.'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
