<?php
// Incluir la conexión a la base de datos
include ('../include/conexion.php');

// Verificar si se ha enviado un archivo
if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    // Ruta donde se guardarán las imágenes de perfil
    $ruta_destino = '../perfiles/';

    // Obtener nombre único para el archivo
    $nombre_archivo = uniqid('perfil_') . '_' . basename($_FILES['imagen']['name']);
    $ruta_completa = $ruta_destino . $nombre_archivo;

    // Mover el archivo a la carpeta de destino
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
        // Actualizar la ruta de la imagen en la base de datos
        $usuario_id = $_SESSION['usuario_id'];
        include 'include/conexion.php';

        $query = "UPDATE usuarios SET imagen = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $ruta_completa, $usuario_id);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['imagen'] = $ruta_completa;
        } else {
            $response['success'] = false;
            $response['mensaje'] = "Error al actualizar la ruta de la imagen en la base de datos";
        }

        $stmt->close();
        $conexion->close();
    } else {
        $response['success'] = false;
        $response['mensaje'] = "Error al mover el archivo a la carpeta de destino";
    }
} else {
    $response['success'] = false;
    $response['mensaje'] = "No se ha enviado ninguna imagen";
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
