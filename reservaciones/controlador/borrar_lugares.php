<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibió un ID válido por POST
if (isset($_POST['id'])) {
    // Sanitizar el ID del lugar
    $lugarID = mysqli_real_escape_string($conexion, $_POST['id']);

    // Query para eliminar el lugar
    $query = "DELETE FROM lugares WHERE id = $lugarID";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $query)) {
        // Si se elimina correctamente, responder con éxito
        echo json_encode(array("success" => true, "message" => "El lugar se ha borrado correctamente."));
    } else {
        // Si hay un error, responder con un mensaje de error
        echo json_encode(array("success" => false, "message" => "Error al borrar el lugar."));
    }
} else {
    // Si no se recibió un ID válido, responder con un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se recibió un ID válido."));
}
?>
