<?php
include ('../include/conexion.php');

// Verificar si se ha recibido el ID de usuario y el nuevo rol
if(isset($_POST['usuario_id']) && isset($_POST['nuevo_rol'])) {
    $usuario_id = $_POST['usuario_id'];
    $nuevo_rol = $_POST['nuevo_rol'];

    // Validar el nuevo rol
    $roles_validos = array('Administrador', 'Cliente', 'Empleado');
    if(!in_array($nuevo_rol, $roles_validos)) {
        echo json_encode(array('success' => false, 'message' => 'El rol proporcionado no es válido.'));
        exit();
    }

    // Actualizar el rol del usuario en la base de datos
    $actualizarRolUsuario = "UPDATE usuarios SET rol = '$nuevo_rol' WHERE id = $usuario_id";
    if(mysqli_query($conexion, $actualizarRolUsuario)) {
        echo json_encode(array('success' => true, 'message' => 'El rol del usuario ha sido actualizado correctamente.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Hubo un error al actualizar el rol del usuario.'));
    }
} else {
    // Si no se han recibido los datos esperados
    echo json_encode(array('success' => false, 'message' => 'No se han proporcionado todos los datos necesarios.'));
}

// Cerrar la conexión
mysqli_close($conexion);
?>
