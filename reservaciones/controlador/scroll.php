<?php
// Incluir la conexión a la base de datos
include('../include/conexion.php');

// Verificar si se reciben los datos del usuario y el nuevo estado
if (isset($_POST['idUsuario']) && isset($_POST['estado'])) {
    // Obtener los datos del usuario y el nuevo estado
    $idUsuario = $_POST['idUsuario'];
    $nuevoEstado = $_POST['estado'];

    // Actualizar el estado del usuario en la base de datos
    $consultaActualizarEstado = "UPDATE usuarios SET estado = '$nuevoEstado' WHERE id = '$idUsuario'";
    $resultadoActualizarEstado = mysqli_query($conexion, $consultaActualizarEstado);

    if ($resultadoActualizarEstado) {
        $response = [
            'success' => true,
            'message' => 'Estado del usuario actualizado correctamente.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error al actualizar el estado del usuario.'
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'No se recibieron los datos del usuario o el estado.'
    ];
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($response);
?>
