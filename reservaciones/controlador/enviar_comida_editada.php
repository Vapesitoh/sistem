<?php
// Aquí debes incluir la lógica de conexión a la base de datos si aún no está incluida
include('../include/conexion.php');

// Verificar si se recibieron todos los datos necesarios del formulario de edición
if(isset($_POST['id'], $_POST['titulo'], $_POST['descripcion'], $_POST['precio'], $_POST['categoria'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    // Preparar la consulta SQL para actualizar la comida
    $consulta = "UPDATE comida SET titulo = ?, descripcion = ?, precio = ?, categoria = ? WHERE id = ?";
    
    // Preparar la declaración
    if($stmt = $mysqli->prepare($consulta)) {
        // Vincular los parámetros
        $stmt->bind_param("ssdsi", $titulo, $descripcion, $precio, $categoria, $id);

        // Ejecutar la consulta
        if($stmt->execute()) {
            // Devolver una respuesta exitosa en formato JSON
            $response = array(
                'success' => true,
                'message' => 'La comida se actualizó correctamente.'
            );
            echo json_encode($response);
        } else {
            // Si la ejecución de la consulta falla, devolver un mensaje de error en formato JSON
            $response = array(
                'success' => false,
                'message' => 'Error al actualizar la comida: ' . $stmt->error
            );
            echo json_encode($response);
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Si la preparación de la consulta falla, devolver un mensaje de error en formato JSON
        $response = array(
            'success' => false,
            'message' => 'Error al preparar la consulta: ' . $mysqli->error
        );
        echo json_encode($response);
    }
} else {
    // Si no se recibieron todos los datos del formulario, devolver un mensaje de error en formato JSON
    $response = array(
        'success' => false,
        'message' => 'No se recibieron todos los datos del formulario.'
    );
    echo json_encode($response);
}

// Cerrar la conexión a la base de datos
$mysqli->close();
?>
