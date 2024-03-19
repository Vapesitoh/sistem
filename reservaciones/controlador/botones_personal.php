<?php
include('../include/conexion.php');

if(isset($_POST['action'])) {
    if($_POST['action'] == 'agregarPersonal') {
        agregarPersonal($conexion, $_POST['habitacion_id'], $_POST['personal_id']);
    } elseif($_POST['action'] == 'finalizarLimpieza') {
        finalizarLimpieza($conexion, $_POST['habitacion_id']);
    }
}

function agregarPersonal($conexion, $habitacion_id, $personal_id) {
    $query_tarea_pendiente = "SELECT id FROM estado_habitacion WHERE id_habitacion = ? AND estado = 1";
    $stmt = mysqli_prepare($conexion, $query_tarea_pendiente);
    mysqli_stmt_bind_param($stmt, "i", $habitacion_id);
    mysqli_stmt_execute($stmt);
    $resultado_tarea_pendiente = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado_tarea_pendiente) > 0) {
        echo json_encode(array("status" => "error", "message" => "No puede crear una nueva tarea si aún no finaliza la que está pendiente."));
        return;
    }

    $cargo_personal = obtenerCargoPersonal($conexion, $personal_id);

    $fecha_inicio = date('Y-m-d H:i:s');
    $query_insert_tarea = "INSERT INTO estado_habitacion (id_habitacion, id_personal, cargo_personal, fecha_inicio, estado) VALUES (?, ?, ?, ?, 1)";
    $stmt = mysqli_prepare($conexion, $query_insert_tarea);
    mysqli_stmt_bind_param($stmt, "iiss", $habitacion_id, $personal_id, $cargo_personal, $fecha_inicio);
    $resultado_insert_tarea = mysqli_stmt_execute($stmt);

    if ($resultado_insert_tarea) {
        echo json_encode(array("status" => "success", "message" => "Personal agregado correctamente a la habitación."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Hubo un error al agregar el personal a la habitación."));
    }
}

function obtenerCargoPersonal($conexion, $personal_id) {
    $query_cargo_personal = "SELECT cargo FROM personal WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $query_cargo_personal);
    mysqli_stmt_bind_param($stmt, "i", $personal_id);
    mysqli_stmt_execute($stmt);
    $resultado_cargo_personal = mysqli_stmt_get_result($stmt);
    $row_cargo_personal = mysqli_fetch_assoc($resultado_cargo_personal);
    return $row_cargo_personal['cargo'];
}

function finalizarLimpieza($conexion, $habitacion_id) {
    $query_tarea_pendiente = "SELECT id FROM estado_habitacion WHERE id_habitacion = ? AND estado = 1";
    $stmt = mysqli_prepare($conexion, $query_tarea_pendiente);
    mysqli_stmt_bind_param($stmt, "i", $habitacion_id);
    mysqli_stmt_execute($stmt);
    $resultado_tarea_pendiente = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado_tarea_pendiente) == 0) {
        echo json_encode(array("status" => "error", "message" => "No se puede finalizar la limpieza porque no existe una tarea pendiente para esta habitación."));
        return;
    }

    date_default_timezone_set('America/Bogota');
    $fecha_fin = date('Y-m-d H:i:s');

    $query_update_tarea = "UPDATE estado_habitacion SET fecha_fin = ?, estado = 0 WHERE id_habitacion = ? AND estado = 1";
    $stmt = mysqli_prepare($conexion, $query_update_tarea);
    mysqli_stmt_bind_param($stmt, "si", $fecha_fin, $habitacion_id);
    $resultado_update_tarea = mysqli_stmt_execute($stmt);

    if ($resultado_update_tarea) {
        echo json_encode(array("status" => "success", "message" => "Limpieza finalizada correctamente."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Hubo un error al finalizar la limpieza de la habitación."));
    }
}
?>
