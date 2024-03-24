<?php
include ('../include/conexion.php');
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir a index.php
    header("Location: index.php");
    exit();
}

// Obtener el rol del usuario de la base de datos
$usuario_id = $_SESSION['usuario_id'];
$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

if (!$resultadoRolUsuario) {
    // Si hay un error en la consulta, redirigir a una página de error o manejar el error de alguna otra manera
    header("Location: 403.php");
    exit();
}

$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];

// Verificar si el rol del usuario es administrador
if ($rolUsuario !== 'Administrador') {
    // Si el usuario no es administrador, redirigir a una página de acceso denegado
    header("Location: 403.php");
    exit();
}

// Consulta las reservaciones
$consultaReservaciones = "SELECT r.*, h.titulo, h.tipo, h.camas, h.banos, h.mascotas, h.precio
                          FROM reservacion r
                          LEFT JOIN habitaciones h ON r.habitacion_id = h.id";
$resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);

// Preparar los datos para enviar como respuesta JSON
$reservaciones = array();
while ($fila = mysqli_fetch_assoc($resultadoReservaciones)) {
    // Determinar el estado de la habitación
    $estado = '';
    $fecha_actual = date("Y-m-d H:i:s");
    $fecha_reservacion = $fila['fecha_reservacion'];
    $fecha_entrega = $fila['fecha_entrega'];

    if ($fecha_actual >= $fecha_reservacion && $fecha_actual <= $fecha_entrega) {
        $estado = 'Ocupada';
    } elseif ($fecha_actual < $fecha_reservacion) {
        $estado = 'Reservada';
    } else {
        $estado = 'Disponible';
    }

    // Añadir la información de la habitación y su estado al array de reservaciones
    $reservaciones[] = array(
        'id' => $fila['id'],
        'titulo' => $fila['titulo'],
        'tipo' => $fila['tipo'],
        'camas' => $fila['camas'],
        'banos' => $fila['banos'],
        'mascotas' => $fila['mascotas'],
        'estado' => $estado,
        'precio' => $fila['precio']
    );
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoReservaciones);

// Cerrar la conexión
mysqli_close($conexion);

// Enviar la respuesta en formato JSON
echo json_encode($reservaciones);
?>
