<?php
// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo o la cédula y la contraseña del formulario
    $usuario = $_POST['correo'];
    $contrasena = md5($_POST['contrasena']); // Encriptar la contraseña

    // Consulta para verificar las credenciales del usuario
    $query = "SELECT * FROM usuarios WHERE (correo = '$usuario' OR cedula = '$usuario') AND contrasena = '$contrasena'";
    $result = $conexion->query($query);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();
        $usuario_id = $row['id'];
        $estado = $row['estado']; // Obtener el estado del usuario

        // Verificar si el estado del usuario es 0 (inactivo)
        if ($estado == 0) {
            // Redirigir con un mensaje de error indicando que el usuario está inactivo
            header("Location: ../index.php?error=El usuario está inactivo. Por favor, contacte al administrador.");
            exit();
        }

        // Continuar con el proceso de inicio de sesión si el usuario está activo
        $rol = $row['rol'];

        // Iniciar sesión
        session_start();

        // Almacenar el ID de usuario en la sesión
        $_SESSION['usuario_id'] = $usuario_id;

        // Redirigir al usuario según su rol
        if ($rol == 'Cliente') {
            // Redirigir al usuario con rol de cliente a la página habitacion.php
            header("Location: ../habitacion.php");
            exit();
        } else if ($rol == 'Empleado') {
            // Redirigir al usuario con rol de empleado a la página formularios_web.php
            header("Location: ../formularios_web.php");
            exit();
        }

        // Actualizar la sesión activa del usuario en la base de datos
        $query_actualizar_sesion = "UPDATE usuarios SET sesion_activa = '1' WHERE id = $usuario_id";
        $conexion->query($query_actualizar_sesion);

        // Redirigir al usuario a la página de inicio
        header("Location: ../inicio.php");
        exit();
    } else {
        // Si las credenciales son incorrectas, redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
        header("Location: ../index.php?error=Credenciales incorrectas. Por favor, inténtelo de nuevo.");
        exit();
    }
} else {
    // Si no se enviaron datos por POST, redirigir al formulario de inicio de sesión
    header("Location: ../index.php");
    exit();
}
