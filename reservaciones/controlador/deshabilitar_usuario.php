<?php
include ('../include/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario a deshabilitar
    $usuario_id = $_POST['usuario_id'];

    // Consulta para obtener el estado actual del usuario
    $consulta_estado = "SELECT estado FROM usuarios WHERE id = $usuario_id";
    $resultado_estado = mysqli_query($conexion, $consulta_estado);

    if ($resultado_estado && mysqli_num_rows($resultado_estado) > 0) {
        $fila_estado = mysqli_fetch_assoc($resultado_estado);
        $estado_actual = $fila_estado['estado'];

        // Determinar el nuevo estado
        $nuevo_estado = $estado_actual == 1 ? 0 : 1;

        // Actualizar el estado del usuario en la base de datos
        $consulta = "UPDATE usuarios SET estado = $nuevo_estado WHERE id = $usuario_id";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            echo json_encode(array('success' => true, 'message' => 'Estado del usuario actualizado correctamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al actualizar el estado del usuario.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'No se encontró el usuario.'));
    }
} else {
    // Si la solicitud no es de tipo POST, redirigir a una página de error
    header("Location: ../403.php");
    exit();
}
?>