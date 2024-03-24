<?php
include('../include/conexion.php');

// Verificar si se ha recibido el ID de la reservación y el valor del pago
if (isset($_GET['id']) && isset($_POST['valor'])) {
    // Obtener el ID de la reservación y el valor del pago
    $reservacionId = $_GET['id'];
    $valorPago = $_POST['valor'];

    // Verificar si el valor del pago es válido (mayor que cero)
    if ($valorPago > 0) {
        // Realizar la consulta para actualizar los pagos en la reservación
        $consulta = "UPDATE reservacion 
                     SET tercer_pago = $valorPago
                     WHERE id = $reservacionId AND tercer_pago IS NULL";

        // Ejecutar la consulta
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            // Si la consulta se ejecutó correctamente, devolver una respuesta JSON con éxito
            echo json_encode(array('success' => true));
            exit();
        } else {
            // Si hubo un error en la consulta, devolver una respuesta JSON con el error
            echo json_encode(array('success' => false, 'error' => 'Hubo un error al realizar el pago. Por favor, inténtalo de nuevo.'));
            exit();
        }
    } else {
        // Si el valor del pago no es válido, devolver una respuesta JSON con el error
        echo json_encode(array('success' => false, 'error' => 'El valor del pago debe ser mayor que cero.'));
        exit();
    }
} else {
    // Si no se recibieron los parámetros esperados, devolver una respuesta JSON con el error
    echo json_encode(array('success' => false, 'error' => 'Parámetros incorrectos.'));
    exit();
}
?>
