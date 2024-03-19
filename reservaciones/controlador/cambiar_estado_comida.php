<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibió un ID y un estado válido por POST
if (isset($_POST['id']) && isset($_POST['estado'])) {
    // Sanitizar el ID y el estado de la comida
    $comidaId = mysqli_real_escape_string($conexion, $_POST['id']);
    $estado = mysqli_real_escape_string($conexion, $_POST['estado']);

    // Query para actualizar el estado de la comida
    $query = "UPDATE comida SET estado = $estado WHERE id = $comidaId";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $query)) {
        // Si se actualiza correctamente, responder con éxito
        echo json_encode(array("success" => true, "message" => "Estado de la comida actualizado correctamente."));
    } else {
        // Si hay un error, responder con un mensaje de error
        echo json_encode(array("success" => false, "message" => "Error al actualizar el estado de la comida."));
    }
} else {
    // Si no se recibió un ID o un estado válido, responder con un mensaje de error
    echo json_encode(array("success" => false, "message" => "No se recibió un ID o un estado válido."));
}
?>
