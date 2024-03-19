<?php
session_start();

// Establecer la zona horaria a la de Ecuador o Bogotá
date_default_timezone_set('America/Guayaquil');

// Incluir el archivo de conexión a la base de datos
include '../include/conexion.php';

// Verificar si se reciben los datos del formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se reciben los datos necesarios para asignar personal
    if (isset($_POST["personal"]) && isset($_POST["habitacion"])) {
        // Obtener los datos del formulario
        $id_personal = $_POST["personal"];
        $id_habitacion = $_POST["habitacion"];

        // Consultar si hay una actividad activa para esa habitación
        $consultaActividad = "SELECT * FROM estado_habitacion WHERE id_habitacion = $id_habitacion AND estado = 1";
        $resultadoActividad = mysqli_query($conexion, $consultaActividad);

        if ($resultadoActividad && mysqli_num_rows($resultadoActividad) > 0) {
            // Si ya existe una actividad activa, no permitir crear una nueva
            echo json_encode(array("status" => "error", "message" => "Ya existe una actividad activa para esta habitación"));
        } else {
            // No hay actividad activa, proceder con la asignación de personal
            // Consultar el cargo del personal
            $consultaCargo = "SELECT cargo FROM personal WHERE id = $id_personal";
            $resultadoCargo = mysqli_query($conexion, $consultaCargo);

            if ($resultadoCargo) {
                $filaCargo = mysqli_fetch_assoc($resultadoCargo);
                $cargo_personal = $filaCargo['cargo'];

                // Verificar si el cargo del personal es Limpieza o Mantenimiento
                if ($cargo_personal === 'Limpieza' || $cargo_personal === 'Mantenimiento') {
                    // Obtener la fecha y hora actual
                    $fechaInicio = date('Y-m-d H:i:s');

                    // Insertar los datos en la tabla estado_habitacion
                    $consultaInsertar = "INSERT INTO estado_habitacion (id_habitacion, id_personal, cargo_personal, estado, fecha_inicio) VALUES ($id_habitacion, $id_personal, '$cargo_personal', 1, '$fechaInicio')";
                    $resultadoInsertar = mysqli_query($conexion, $consultaInsertar);

                    if ($resultadoInsertar) {
                        // Éxito
                        echo json_encode(array("status" => "success"));
                    } else {
                        // Error al insertar en la tabla
                        echo json_encode(array("status" => "error", "message" => "Error al insertar en la tabla estado_habitacion: " . mysqli_error($conexion)));
                    }
                } else {
                    // El cargo del personal no es válido
                    echo json_encode(array("status" => "error", "message" => "El cargo del personal no es válido"));
                }
            } else {
                // Error en la consulta del cargo
                echo json_encode(array("status" => "error", "message" => "Error al consultar el cargo del personal: " . mysqli_error($conexion)));
            }
        }
    } 
    // Verificar si se recibió el botón "terminar"
    else if (isset($_POST["terminar"])) {
        $id_habitacion = $_POST["habitacion"];
        
        // Verificar si la habitación está en proceso de limpieza y si el estado es 1
        $consultaEstado = "SELECT * FROM estado_habitacion WHERE id_habitacion = $id_habitacion AND estado = 1";
        $resultadoEstado = mysqli_query($conexion, $consultaEstado);

        if ($resultadoEstado && mysqli_num_rows($resultadoEstado) > 0) {
            // Obtener la fecha y hora actual
            $fechaFin = date('Y-m-d H:i:s');
            
            // Actualizar la fila correspondiente en la tabla estado_habitacion cambiando el estado a 0 y estableciendo la fecha de finalización
            $consultaActualizar = "UPDATE estado_habitacion SET fecha_fin = '$fechaFin', estado = 0 WHERE id_habitacion = $id_habitacion AND estado = 1";
            $resultadoActualizar = mysqli_query($conexion, $consultaActualizar);

            if ($resultadoActualizar) {
                // Éxito
                echo json_encode(array("status" => "success"));
            } else {
                // Error al actualizar la tabla
                echo json_encode(array("status" => "error", "message" => "Error al actualizar la tabla estado_habitacion: " . mysqli_error($conexion)));
            }
        } else {
            // La habitación no está en proceso de limpieza o el estado no es 1
            echo json_encode(array("status" => "error", "message" => "La habitación no se encuentra en proceso de limpieza"));
        }
    } else {
        // Datos incompletos
        echo json_encode(array("status" => "error", "message" => "Datos incompletos"));
    }
} else {
    // Método de solicitud incorrecto
    echo json_encode(array("status" => "error", "message" => "Método de solicitud incorrecto"));
}

// Consultar el listado de personal desde la base de datos
$query = "SELECT id, nombre, tipo FROM personal";
$result = mysqli_query($conexion, $query);

if (!$result) {
    // Si hay un error en la consulta, devolver un mensaje de error
    echo json_encode(array('error' => 'Hubo un error al obtener el listado de personal: ' . mysqli_error($conexion)));
} else {
    // Inicializar un array para almacenar los datos del personal
    $personal = array();

    // Recorrer el resultado de la consulta y almacenar los datos en el array
    while ($row = mysqli_fetch_assoc($result)) {
        $personal[] = $row;
    }

    // Devolver los datos del personal en formato JSON
    echo json_encode(array('personal' => $personal));
}
?>
