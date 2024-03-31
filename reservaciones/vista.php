<?php
include ('include/conexion.php');
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

// Consultar todas las habitaciones
$consultaHabitaciones = "SELECT * FROM habitaciones";
$resultadoHabitaciones = mysqli_query($conexion, $consultaHabitaciones);

// Preparar los datos de las habitaciones para mostrar en tarjetas
$habitaciones = array();
while ($fila = mysqli_fetch_assoc($resultadoHabitaciones)) {
    $habitaciones[] = $fila;
}

// Liberar el conjunto de resultados
mysqli_free_result($resultadoHabitaciones);

// Cerrar la conexión
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vista general de las habitaciones</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
<?php include 'include/navbar.php'; ?>
<div class="container mt-4">
    <div class="row" id="habitaciones-container">
        <?php foreach ($habitaciones as $habitacion): ?>
            <div class="col-md-4 mb-4">
                <div class="card" id="habitacion-<?php echo $habitacion['id']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $habitacion['titulo']; ?></h5>
                        <p class="card-text">Tipo: <?php echo $habitacion['tipo']; ?></p>
                        <p class="card-text">Camas: <?php echo $habitacion['camas']; ?></p>
                        <p class="card-text">Baños: <?php echo $habitacion['banos']; ?></p>
                        <p class="card-text">Mascotas: <?php echo $habitacion['mascotas']; ?></p>
                        <p class="card-text">Precio: <?php echo number_format($habitacion['precio'], 2); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Agregar evento de clic a las tarjetas de habitaciones
    $('[id^="habitacion-"]').click(function() {
        var habitacionId = $(this).attr('id').split('-')[1];

        // Realizar una solicitud AJAX al controlador vista_general.php
        $.ajax({
            url: 'controlador/vista_general.php',
            method: 'POST',
            data: {habitacion_id: habitacionId},
            success: function(response) {
                // Mostrar la respuesta utilizando SweetAlert2
                Swal.fire({
                    title: 'Estado de la habitación',
                    html: response
                });
            }
        });
    });
});
</script>
</body>
</html>
