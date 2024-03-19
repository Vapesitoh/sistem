<?php
session_start();

include('../include/conexion.php'); // Incluir archivo de conexión

// Verificar si se ha subido un archivo
if (isset($_FILES['foto_perfil'])) {
    $usuario_id = $_SESSION['usuario_id'];

    // Directorio donde se almacenarán las imágenes de perfil
    $directorio = '../perfiles/';

    // Verificar si la carpeta de perfiles existe, si no, crearla
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true); // Crear la carpeta con permisos de lectura, escritura y ejecución para todos
    }

    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = $_FILES['foto_perfil']['name'];
    $nombre_tmp = $_FILES['foto_perfil']['tmp_name'];

    // Obtener la extensión del archivo
    $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

    // Nueva ruta de la imagen de perfil
    $nueva_ruta = $directorio . 'perfil_' . $usuario_id . '.' . $extension;

    // Obtener la ruta de la imagen de perfil actual en la base de datos
    $query = "SELECT imagen FROM usuarios WHERE id = $usuario_id";
    $resultado = mysqli_query($conexion, $query);
    $fila = mysqli_fetch_assoc($resultado);
    $ruta_anterior = $fila['imagen'];

    // Si la ruta anterior existe y no es default.jpg, eliminar la imagen anterior
    if ($ruta_anterior && !strpos($ruta_anterior, 'default.jpg') && file_exists('../' . $ruta_anterior)) {
        unlink('../' . $ruta_anterior);
    }

    // Mover el archivo subido al directorio de perfiles
    if (move_uploaded_file($nombre_tmp, $nueva_ruta)) {
        // Actualizar la ruta de la imagen de perfil en la base de datos
        $ruta_en_db = 'perfiles/perfil_' . $usuario_id . '.' . $extension;
        $query = "UPDATE usuarios SET imagen = '$ruta_en_db' WHERE id = $usuario_id";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            echo json_encode(array('status' => 'success', 'message' => 'La foto de perfil se ha cargado correctamente'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error al actualizar la ruta de la foto de perfil en la base de datos'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error al cargar la foto de perfil'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'No se ha seleccionado ninguna imagen'));
}
?>
