<?php
include('../include/conexion.php');

// Consultar el listado de habitaciones desde la base de datos
$query_habitaciones = "SELECT id FROM habitaciones ";
$result_habitaciones = mysqli_query($conexion, $query_habitaciones);

if (!$result_habitaciones) {
    echo json_encode(array('error' => 'Hubo un error al obtener las habitaciones.'));
} else {
    // Inicializar array para almacenar los datos de habitaciones
    $habitaciones = array();

    // Recorrer el resultado de la consulta de habitaciones y almacenar los datos en el array
    while ($row_habitacion = mysqli_fetch_assoc($result_habitaciones)) {
        $habitaciones[] = $row_habitacion['id'];
    }

    // Devolver los datos de habitaciones en formato JSON
    echo json_encode(array('habitaciones' => $habitaciones));
}
?>
