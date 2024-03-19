<?php
session_start();

// Verificar si se recibió la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió la nueva contraseña
    if (isset($_POST["nueva_contrasena"])) {
        // Obtener la nueva contraseña y el ID de usuario de la sesión
        $nueva_contrasena = $_POST["nueva_contrasena"];
        $usuario_id = $_SESSION["usuario_id"];
        
        // Encriptar la nueva contraseña con MD5
        $contrasena_md5 = md5($nueva_contrasena);
        
        // Actualizar la contraseña en la base de datos
        include ('../include/conexion.php');
        $sql = "UPDATE usuarios SET contrasena = '$contrasena_md5' WHERE id = $usuario_id";

        if (mysqli_query($conexion, $sql)) {
            $response = array("status" => "success", "message" => "Contraseña actualizada correctamente");
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Error al actualizar la contraseña en la base de datos");
            echo json_encode($response);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conexion);
    } else {
        $response = array("status" => "error", "message" => "No se recibió la nueva contraseña");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Solicitud no válida");
    echo json_encode($response);
}
?>
