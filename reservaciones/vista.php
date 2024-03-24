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
        <!-- Aquí se cargarán dinámicamente las tarjetas de habitaciones -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    function cargarHabitaciones() {
        $.ajax({
            url: 'controlador/vista_general.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.length > 0) {
                    $("#habitaciones-container").empty();
                    response.forEach(function(habitacion) {
                        var cardHtml = '<div class="col-md-4 mb-4">';
                        cardHtml += '<div class="card">';
                        cardHtml += '<div class="card-body">';
                        cardHtml += '<h5 class="card-title">' + habitacion.titulo + '</h5>';
                        cardHtml += '<p class="card-text">Tipo: ' + habitacion.tipo + '</p>';
                        cardHtml += '<p class="card-text">Camas: ' + habitacion.camas + '</p>';
                        cardHtml += '<p class="card-text">Baños: ' + habitacion.banos + '</p>';
                        cardHtml += '<p class="card-text">Mascotas: ' + habitacion.mascotas + '</p>';
                        cardHtml += '<p class="card-text">Estado: ' + habitacion.estado + '</p>';
                        cardHtml += '<p class="card-text">Precio: ' + habitacion.precio + '</p>';
                        cardHtml += '</div>';
                        cardHtml += '</div>';
                        cardHtml += '</div>';
                        $("#habitaciones-container").append(cardHtml);

                        // Agregar evento de clic a la tarjeta de habitación
                        $(".card").click(function() {
                            mostrarAlerta(habitacion.estado);
                        });
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function mostrarAlerta(estado) {
        // Mostrar la alerta de SweetAlert2 según el estado de la habitación
        if (estado === 'Ocupada') {
            Swal.fire({
                icon: 'error',
                title: 'Habitación Ocupada',
                text: 'Lo siento, la habitación está ocupada en este momento.'
            });
        } else if (estado === 'Reservada') {
            Swal.fire({
                icon: 'info',
                title: 'Habitación Reservada',
                text: 'La habitación está reservada para este período.'
            });
        } else {
            Swal.fire({
                icon: 'success',
                title: 'Habitación Disponible',
                text: 'La habitación está disponible.'
            });
        }
    }

    cargarHabitaciones();
});

</script>

</body>
</html>
