<?php
include('../include/conexion.php');
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, retornar un mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'Acceso no autorizado'
    );
    echo json_encode($response);
    exit();
}

// Obtener los datos del empleado del formulario AJAX
$nombres = $_POST['nombres'];
$cedula = $_POST['cedula'];
$cel = $_POST['cel'];
$cargo = $_POST['cargo'];

// Validar que el cargo sea "Limpieza" o "Mantenimiento"
if ($cargo !== "Limpieza" && $cargo !== "Mantenimiento") {
    // Si el cargo no es válido, retornar un mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'El cargo especificado no es válido'
    );
    echo json_encode($response);
    exit();
}

// Insertar los datos del empleado en la base de datos
$insertQuery = "INSERT INTO `personal` (`nombres`, `cedula`, `cel`, `cargo`, `Estado`) VALUES ('$nombres', '$cedula', '$cel', '$cargo', '1')";
$result = mysqli_query($conexion, $insertQuery);

if ($result) {
    // Si la inserción es exitosa, retornar un mensaje de éxito
    $response = array(
        'status' => 'success',
        'message' => 'Empleado agregado exitosamente'
    );
    echo json_encode($response);
} else {
    // Si hay un error en la inserción, retornar un mensaje de error
    $response = array(
        'status' => 'error',
        'message' => 'Hubo un error al agregar el empleado'
    );
    echo json_encode($response);
}

// Cerrar la conexión a la base de datos si es necesario
mysqli_close($conexion);
?>
