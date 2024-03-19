<?php
include('../include/conexion.php');

// Realizar la consulta para obtener las habitaciones con estado 1
$sql = "SELECT * FROM habitaciones";
$result = mysqli_query($conexion, $sql);

// Inicializar un array para almacenar los resultados
$habitaciones = array();

// Iterar sobre los resultados y almacenarlos en el array
while ($row = mysqli_fetch_assoc($result)) {
    $habitaciones[] = $row;
}

// Devolver los resultados en formato JSON
echo json_encode($habitaciones);
?>
