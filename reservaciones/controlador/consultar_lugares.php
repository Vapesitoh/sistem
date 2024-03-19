<?php
// Incluir el archivo de conexión a la base de datos
include '../include/conexion.php';

// Consultar los lugares
$query = "SELECT * FROM lugares";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa
if ($resultado) {
    // Crear un array para almacenar los lugares
    $lugares = array();

    // Iterar sobre los resultados y guardar cada fila en el array de lugares
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $lugares[] = $fila;
    }

    // Responder con los lugares en formato JSON
    echo json_encode($lugares);
} else {
    // Si hay un error en la consulta, responder con un mensaje de error en JSON
    echo json_encode(array("error" => "Error al consultar los lugares."));
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
