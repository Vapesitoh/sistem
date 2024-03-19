<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$usuario = 'root';
$contrasena = ''; // No hay contraseña
$base_datos = 'hotel_prueba2'; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a utf8
$conexion->set_charset("utf8");
?>
