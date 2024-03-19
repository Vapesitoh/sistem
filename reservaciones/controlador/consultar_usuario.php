<?php
// Incluir la conexión a la base de datos
include '../include/conexion.php';

// Verificar si se recibió el ID del usuario por POST
if(isset($_POST['usuario_id'])) {
    // Obtener el ID del usuario
    $usuario_id = $_POST['usuario_id'];

    // Consultar los datos del usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE id = $usuario_id";
    $result = mysqli_query($conexion, $query);

    if($result) {
        // Convertir los datos del usuario a un arreglo asociativo
        $usuario = mysqli_fetch_assoc($result);

        // Preparar la respuesta JSON
        $response = array(
            'status' => 'success',
            'data' => $usuario
        );
    } else {
        // Si hay un error en la consulta
        $response = array(
            'status' => 'error',
            'message' => 'Error al consultar los datos del usuario'
        );
    }
} else {
    // Si no se recibió el ID del usuario
    $response = array(
        'status' => 'error',
        'message' => 'No se recibió el ID del usuario'
    );
}

// Devolver la respuesta como JSON
echo json_encode($response);
?>
