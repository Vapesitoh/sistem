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
    $sql_verificar = "SELECT id FROM Usuarios WHERE nombres = ? OR correo = ?";
    $stmt_verificar = $conexion->prepare($sql_verificar);
    $stmt_verificar->bind_param("ss", $nombres, $correo);
    $stmt_verificar->execute();
    $stmt_verificar->store_result();
    if ($stmt_verificar->num_rows > 0) {
        $response['success'] = false;
        $response['message'] = "El usuario o correo ya existen.";
        echo json_encode($response);
        exit; // Salir del script si ya existe el usuario o correo
    }
    $stmt_verificar->close();

    // Validar el formato de la cédula ecuatoriana
    if (!preg_match('/^[0-9]{10}$/', $cedula)) {
        $response['success'] = false;
        $response['message'] = "El formato de la cédula no es válido. Debe contener 10 dígitos numéricos.";
        echo json_encode($response);
        exit; // Salir del script si el formato de la cédula no es válido
    }

    $sql = "INSERT INTO Usuarios (nombres, numero_telefono, cedula, correo, contrasena) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssss", $nombres, $numero_telefono, $cedula, $correo, $contrasena_encriptada);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Cuenta creada correctamente";
        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = "Error al registrar: " . $stmt->error;
        echo json_encode($response);
    }

    $stmt->close();
    $conexion->close();
}
?>
