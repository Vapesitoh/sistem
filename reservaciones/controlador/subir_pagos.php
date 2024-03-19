<?php
session_start();

include ('../include/conexion.php');

$response = array(); // Array para almacenar la respuesta

if (!isset($_SESSION['usuario_id'])) {
    $response['error'] = "No se ha iniciado sesión.";
} else {
    $usuario_id = $_SESSION['usuario_id'];
    $consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
    $resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

    if (!$resultadoRolUsuario) {
        $response['error'] = "Error al obtener el rol del usuario.";
    } else {
        $filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
        $rolUsuario = $filaRolUsuario['rol'];

        if ($rolUsuario !== 'Cliente') {
            $response['error'] = "No tienes permisos para subir archivos de pago.";
        } else {
            // Verificar si se proporcionó un ID de reservación
            if (isset($_GET['id'])) {
                $reservacion_id = $_GET['id'];

                // Verificar si se subió un archivo
                if (isset($_FILES['archivo'])) {
                    $archivo_nombre = $_FILES['archivo']['name'];
                    $archivo_temp = $_FILES['archivo']['tmp_name'];

                    // Directorio donde se almacenarán los depósitos
                    $directorio_depositos = "../depositos/";

                    // Obtener la extensión del archivo
                    $extension = pathinfo($archivo_nombre, PATHINFO_EXTENSION);

                    // Generar un nombre único para el archivo
                    $nombre_deposito = uniqid() . '.' . $extension;

                    // Ruta completa del archivo en el servidor
                    $ruta_deposito = $directorio_depositos . $nombre_deposito;

                    // Mover el archivo al directorio de depósitos
                    if (move_uploaded_file($archivo_temp, $ruta_deposito)) {
                        // Actualizar el campo de pago correspondiente en la base de datos
                        $ruta_relativa = "depositos/" . $nombre_deposito;
                        $campo_pago = '';

                        // Verificar qué columna de pago está disponible
                        $consulta = "SELECT pago2, pago3, pago4 FROM reservacion WHERE id = $reservacion_id";
                        $resultado = mysqli_query($conexion, $consulta);
                        $fila = mysqli_fetch_assoc($resultado);

                        if (empty($fila['pago2'])) {
                            $campo_pago = 'pago2';
                        } elseif (empty($fila['pago3'])) {
                            $campo_pago = 'pago3';
                        } elseif (empty($fila['pago4'])) {
                            $campo_pago = 'pago4';
                        } else {
                            $response['error'] = "No se pueden agregar más archivos de pago para esta reservación.";
                        }

                        if (!isset($response['error'])) {
                            // Actualizar el campo de pago correspondiente en la base de datos
                            $actualizar_pago = "UPDATE reservacion SET $campo_pago = '$ruta_relativa' WHERE id = $reservacion_id";
                            if (mysqli_query($conexion, $actualizar_pago)) {
                                $response['success'] = "¡El pago se ha subido exitosamente!";
                                $response['url'] = $ruta_relativa; // Devolver la URL relativa del archivo subido
                            } else {
                                $response['error'] = "Error al actualizar la base de datos.";
                            }
                        }
                    } else {
                        $response['error'] = "Error al subir el archivo.";
                    }
                } else {
                    // Si no se proporcionó un archivo, mostrar un mensaje de error
                    $response['error'] = "No se ha seleccionado ningún archivo.";
                }
            } else {
                // Si no se proporcionó un ID de reservación, mostrar un mensaje de error
                $response['error'] = "No se ha proporcionado una ID de reservación.";
            }
        }
    }
}

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
