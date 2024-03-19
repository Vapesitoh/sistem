<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (isset($_SESSION['usuario_id'])) {
    // Obtener el ID del usuario
    $usuario_id = $_SESSION['usuario_id'];

    // Actualizar la sesión activa del usuario en la base de datos para indicar que no está activa
    $query_desactivar_sesion = "UPDATE usuarios SET sesion_activa = 0 WHERE id = $usuario_id";
    $conexion->query($query_desactivar_sesion);
}

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al usuario a la página de inicio o a donde prefieras después de cerrar sesión
header("Location: ../index.php");
exit();
?>
