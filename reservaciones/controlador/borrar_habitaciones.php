<?php
include('../include/conexion.php');

$response = array();

// Verificar si se recibió un ID válido por POST
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Obtener las rutas de las fotos asociadas a la habitación
    $consultaRutas = "SELECT foto1, foto2, foto3 FROM habitaciones WHERE id = $id";
    $resultadoRutas = mysqli_query($conexion, $consultaRutas);

    if ($resultadoRutas && mysqli_num_rows($resultadoRutas) > 0) {
        $fila = mysqli_fetch_assoc($resultadoRutas);
        $foto1 = '../' . $fila['foto1']; // Ruta completa de la foto1
        $foto2 = '../' . $fila['foto2']; // Ruta completa de la foto2
        $foto3 = '../' . $fila['foto3']; // Ruta completa de la foto3

        // Eliminar la habitación de la base de datos
        $consultaEliminar = "DELETE FROM habitaciones WHERE id = $id";
        $resultadoEliminar = mysqli_query($conexion, $consultaEliminar);

        if ($resultadoEliminar) {
            // Eliminar los archivos de las fotos asociadas
            if (file_exists($foto1)) {
                unlink($foto1);
            }
            if (file_exists($foto2)) {
                unlink($foto2);
            }
            if (file_exists($foto3)) {
                unlink($foto3);
            }

            $response['success'] = true;
            $response['message'] = "Habitación eliminada exitosamente";
        } else {
            $response['success'] = false;
            $response['message'] = "Error al eliminar la habitación de la base de datos";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "No se encontró una habitación con el ID proporcionado";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Parámetros incorrectos en la solicitud";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($response);
?>
