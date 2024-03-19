<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Consulta SQL para obtener todas las filas de la tabla comida
$sql = "SELECT * FROM comida";

// Ejecutar la consulta
$resultado = $conexion->query($sql);

// Verificar si la consulta tuvo éxito
if ($resultado) {
    // Crear un array para almacenar los resultados
    $comidas = array();

    // Iterar sobre cada fila del resultado
    while ($fila = $resultado->fetch_assoc()) {
        // Agregar cada fila al array de resultados
        $comidas[] = $fila;
    }

    // Liberar el resultado de la memoria
    $resultado->free();

    // Devolver los resultados como JSON
    echo json_encode($comidas);
} else {
    // Si la consulta falla, devolver un mensaje de error
    echo json_encode(array('error' => 'Error al ejecutar la consulta'));
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
