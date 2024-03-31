<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Inicializar la variable de consulta
$consultaUsuarios = "SELECT * FROM usuarios";

// Verificar si se proporcionó un número de cédula para filtrar
if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
    // Escapar el número de cédula para evitar inyección SQL
    $cedula = mysqli_real_escape_string($conexion, $_GET['cedula']);
    
    // Agregar el filtro a la consulta SQL utilizando LIKE para buscar coincidencias parciales
    $consultaUsuarios .= " WHERE cedula LIKE '%$cedula%'";
}

// Ejecutar la consulta
$resultadoUsuarios = mysqli_query($conexion, $consultaUsuarios);

// Verificar si la consulta fue exitosa
if (!$resultadoUsuarios) {
    // Si hay un error en la consulta, enviar una respuesta de error en formato JSON
    echo json_encode(array("error" => "Hubo un error al obtener los usuarios desde la base de datos."));
    exit();
}

// Preparar un array para almacenar los datos de los usuarios
$usuarios = array();

// Iterar sobre los resultados de la consulta y almacenar los datos en el array de usuarios
while ($filaUsuario = mysqli_fetch_assoc($resultadoUsuarios)) {
    $usuarios[] = $filaUsuario;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoUsuarios);

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

// Devolver los datos de los usuarios en formato JSON
echo json_encode($usuarios);
?>
