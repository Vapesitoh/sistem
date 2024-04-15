<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el usuario_id y otros datos del formulario
    $usuario_id = $_POST['usuario_id'];

    // Obtener los datos del usuario
    $sql_usuario = "SELECT nombres, numero_telefono, cedula FROM usuarios WHERE id = $usuario_id";
    $result_usuario = mysqli_query($conexion, $sql_usuario);
    $datos_usuario = mysqli_fetch_assoc($result_usuario);
    
    // Verificar si se encontraron datos del usuario
    if ($datos_usuario) {
        // Obtener los datos necesarios del formulario
        $nombre_usuario = $datos_usuario['nombres'];
        $numero_telefono = $datos_usuario['numero_telefono'];
        $cedula = $datos_usuario['cedula'];

        // Obtener otros datos del formulario
        $habitacion_id = $_POST['numero'];
        $tipo_habitacion = $_POST['tipo'];
        $precio = $_POST['precio'];
        $fecha_reservacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_reservacion']));
        $fecha_entrega = date('Y-m-d H:i:s', strtotime($_POST['fecha_entrega']));
        $metodo_pago = $_POST['metodo_pago'];

        // Calcular el precio total
        $precio_total = $_POST['precio_total'];

        // Obtener la cantidad de adultos y niños
        $adultos = $_POST['adultos'];
        $niños = $_POST['niños'];

        // Valor del estado para la reserva
        $estado_reserva = 2;

        // Verificar si se subió un archivo y si el método de pago es Depósito
        if ($_FILES['foto_deposito']['name'] && $metodo_pago === 'Depósito') {
            // Carpeta donde se guardarán los archivos subidos
            $carpeta_destino = '../depositos/';
            // Generar un nombre único para el archivo
            $nombre_archivo = uniqid('archivo_', true) . '.' . pathinfo($_FILES['foto_deposito']['name'], PATHINFO_EXTENSION);
            // Ruta completa donde se guardará el archivo
            $ruta_archivo = $carpeta_destino . $nombre_archivo;

            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($_FILES['foto_deposito']['tmp_name'], $ruta_archivo)) {
                // Guardar la ruta del archivo en la base de datos
                // Remover el prefijo '../' de la ruta antes de guardarla en la base de datos
                $ruta_deposito = str_replace('../', '', $ruta_archivo);

                // Insertar los datos de la reserva en la tabla 'reservacion'
                $sql_insert_reservacion = "INSERT INTO reservacion (habitacion_id, usuario_id, nombre_usuario, numero_telefono, cedula, precio, tipo_habitacion, fecha_reservacion, fecha_entrega, pago, deposito, estado, valor_total, adultos, niños) VALUES ('$habitacion_id', '$usuario_id', '$nombre_usuario', '$numero_telefono', '$cedula', '$precio', '$tipo_habitacion', '$fecha_reservacion', '$fecha_entrega', '$metodo_pago', '$ruta_deposito', '$estado_reserva', '$precio_total', '$adultos', '$niños')";

                // Ejecutar la consulta de inserción de la reserva
                if (mysqli_query($conexion, $sql_insert_reservacion)) {
                    // Si la inserción fue exitosa, redirigir a alguna página de éxito
                    header("Location: ../reserva.php");
                    exit();
                } else {
                    // Si hubo un error en la inserción de la reserva, mostrar un mensaje de error
                    echo "Error al insertar la reserva: " . mysqli_error($conexion);
                    exit();
                }
            } else {
                // Error al mover el archivo, mostrar un mensaje de error
                echo "Error al subir el archivo.";
                exit();
            }
        } else {
            // Insertar los datos de la reserva en la tabla 'reservacion' sin procesar la carga de la imagen
            $sql_insert_reservacion = "INSERT INTO reservacion (habitacion_id, usuario_id, nombre_usuario, numero_telefono, cedula, precio, tipo_habitacion, fecha_reservacion, fecha_entrega, pago, estado, valor_total, adultos, niños) VALUES ('$habitacion_id', '$usuario_id', '$nombre_usuario', '$numero_telefono', '$cedula', '$precio', '$tipo_habitacion', '$fecha_reservacion', '$fecha_entrega', '$metodo_pago', '$estado_reserva', '$precio_total', '$adultos', '$niños')";

            // Ejecutar la consulta de inserción de la reserva
            if (mysqli_query($conexion, $sql_insert_reservacion)) {
                // Si la inserción fue exitosa, redirigir a alguna página de éxito
                header("Location: ../reserva.php");
                exit();
            } else {
                // Si hubo un error en la inserción de la reserva, mostrar un mensaje de error
                echo "Error al insertar la reserva: " . mysqli_error($conexion);
                exit();
            }
        }
    } else {
        // No se encontraron datos del usuario, mostrar un mensaje de error
        echo "No se encontraron datos del usuario.";
        exit();
    }
} else {
    // Si se intenta acceder directamente a este archivo sin enviar el formulario, redirigir a alguna página apropiada
    header("Location: index.php");
    exit();
}
?>