<?php
include 'conexion.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST["nombres"];
    $numero_telefono = $_POST["numero_telefono"];
    $cedula = $_POST["cedula"];
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $contrasena_encriptada = md5($contrasena);
    
    // Validar si el usuario o correo ya existen en la base de datos
    $sql_verificar = "SELECT id FROM usuarios WHERE nombres = ? OR correo = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("ss", $nombres, $correo);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();
    if ($stmt_verificar->num_rows > 0) {
        $response['success'] = false;
        $response['message'] = "El usuario o correo ya existen.";
    } else {
        $sql = "INSERT INTO usuarios (nombres, numero_telefono, cedula, correo, contrasena) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $nombres, $numero_telefono, $cedula, $correo, $contrasena_encriptada);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Cuenta creada correctamente";
        } else {
            $response['success'] = false;
            $response['message'] = "Error al registrar: " . $stmt->error;
        }
    }

    echo json_encode($response);
    $stmt_verificar->close();
    $stmt->close();
    $conexion->close();
}
?>