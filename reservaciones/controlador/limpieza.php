<?php
include('../include/conexion.php');

// Consultar las habitaciones
$query = "SELECT id, camas, banos, mascotas, estado, tipo, precio FROM habitaciones";
$result = mysqli_query($conexion, $query);

if (!$result) {
    // Si hay un error en la consulta, devolver un mensaje de error
    $response = array('error' => 'Error al consultar las habitaciones');
} else {
    // Inicializar un array para almacenar los datos de las habitaciones
    $habitaciones = array();

    // Recorrer el resultado de la consulta y almacenar los datos en el array
    while ($row = mysqli_fetch_assoc($result)) {
        $habitaciones[] = $row;
    }

    // Devolver los datos de las habitaciones en formato JSON
    $response = array('habitaciones' => $habitaciones);
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
