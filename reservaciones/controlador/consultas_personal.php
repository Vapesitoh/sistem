<?php
include('../include/conexion.php');

// Consultar el listado de personal activo desde la base de datos
$query_personal = "SELECT id, nombres, cargo FROM personal WHERE Estado = '1'";
$result_personal = mysqli_query($conexion, $query_personal);

if (!$result_personal) {
    // Si hay un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Hubo un error al obtener el personal.'));
} else {
    // Inicializar array para almacenar los datos de personal
    $personal = array();

    // Recorrer el resultado de la consulta de personal y almacenar los datos en el array
    while ($row_personal = mysqli_fetch_assoc($result_personal)) {
        $personal[] = $row_personal;
    }

    // Devolver los datos de personal en formato JSON
    echo json_encode(array('personal' => $personal));
}
?>
