<?php
// Aquí debes incluir la lógica de conexión a la base de datos si aún no está incluida
include('../include/conexion.php');


// Verificar si se recibió el ID de la comida a editar
if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // Preparar la consulta SQL para obtener los datos de la comida
    $consulta = "SELECT * FROM comida WHERE id = $id";

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $consulta);

    if($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos de la comida
        $comida = mysqli_fetch_assoc($resultado);

        // Devolver los datos de la comida como respuesta en formato JSON
        $response = array(
            'success' => true,
            'titulo' => $comida['titulo'],
            'descripcion' => $comida['descripcion'],
            'precio' => $comida['precio'],
            'categoria' => $comida['categoria']
        );
        echo json_encode($response);
    } else {
        // Si no se encontraron datos de la comida, devolver un mensaje de error
        $response = array(
            'success' => false,
            'message' => 'No se encontraron datos de la comida.'
        );
        echo json_encode($response);
    }
} else {
    // Si no se recibió el ID de la comida, devolver un mensaje de error
    $response = array(
        'success' => false,
        'message' => 'No se recibió el ID de la comida.'
    );
    echo json_encode($response);
}
?>
