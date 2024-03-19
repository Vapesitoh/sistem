<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibieron los datos del formulario de edición
if(isset($_POST['id'], $_POST['tipo'], $_POST['mascotas'], $_POST['banos'], $_POST['camas'], $_POST['precio'])) {
    // Obtener los datos del formulario
    $idHabitacion = $_POST['id'];
    $tipo = $_POST['tipo'];
    $mascotas = $_POST['mascotas'];
    $banos = $_POST['banos'];
    $camas = $_POST['camas'];
    $precio = $_POST['precio'];

    // Preparar la consulta SQL para actualizar la habitación
    $consulta = "UPDATE habitaciones SET tipo = ?, mascotas = ?, banos = ?, camas = ?, precio = ? WHERE id = ?";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conexion, $consulta);

    // Vincular los parámetros
    mysqli_stmt_bind_param($stmt, "ssssdi", $tipo, $mascotas, $banos, $camas, $precio, $idHabitacion);

    // Ejecutar la sentencia
    if(mysqli_stmt_execute($stmt)) {
        // Si la actualización fue exitosa, enviar una respuesta JSON de éxito
        $response = array(
            'success' => true,
            'message' => 'Habitación actualizada correctamente'
        );
        echo json_encode($response);
    } else {
        // Si hubo un error en la ejecución de la consulta, enviar una respuesta JSON de error
        $response = array(
            'success' => false,
            'message' => 'Error al actualizar la habitación'
        );
        echo json_encode($response);
    }

    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
} else {
    // Si no se recibieron los datos esperados, enviar una respuesta JSON de error
    $response = array(
        'success' => false,
        'message' => 'No se recibieron todos los datos necesarios para actualizar la habitación'
    );
    echo json_encode($response);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
