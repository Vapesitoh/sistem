<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibió un ID válido por POST
if (isset($_POST['id'])) {
    // Sanitizar el ID de la comida
    $comidaId = mysqli_real_escape_string($conexion, $_POST['id']);

    // Query para eliminar la comida
    $query = "DELETE FROM comida WHERE id = $comidaId";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $query)) {
        // Si se elimina correctamente, responder con éxito
        echo json_encode(array("success" => true, "message" => "Comida eliminada correctamente."));
    } else {
        // Si hay un error, responder con un mensaje de error
        echo json_encode(array("success" => false, "message" => "Error al eliminar la comida."));
    }
} else {
    // Si no se recibió un ID válido, responder con un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se recibió un ID válido."));
}
?>
