<?php
include('include/conexion.php');

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; 
$sql = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$result = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($result);

if (!$usuario || $usuario['rol'] !== 'Cliente') {
    header("Location: 403.php");
    exit();
}

$sql_reserva_activa = "SELECT COUNT(*) as count FROM reservacion WHERE usuario_id = $usuario_id AND estado = 3";
$result_reserva_activa = mysqli_query($conexion, $sql_reserva_activa);
$reserva_activa = mysqli_fetch_assoc($result_reserva_activa);

$reserva_activa_count = $reserva_activa['count'];
$sql_reserva_activa = "SELECT * FROM reservacion WHERE usuario_id = $usuario_id AND estado = 3";
$result_reserva_activa = mysqli_query($conexion, $sql_reserva_activa);
$reserva_activa = mysqli_fetch_assoc($result_reserva_activa);

?>

<?php include 'include/navbar.php';  ?>


<style>
   .card-img-top {
        max-width: 100%; 
        height: auto; 
        object-fit: cover; 
    }
</style>
<?php if ($reserva_activa) : ?>
    <div class="alert alert-info" style="background-color: #007bff; color: #ffffff; font-size: 20px; font-weight: bold; text-align: center;">
        ¡Hola <?php echo $nombres; ?>! Tienes una reserva activa aprobada que aún no ha concluido.
    </div>
<?php endif; ?>


<div class="container-fluid py-4">
    <div class="row" id="habitaciones-container">
    </div>    
    
</div>    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="./assets/js/core/popper.min.js"></script>
<script src="./assets/js/core/bootstrap.min.js"></script>
<script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="./assets/js/plugins/chartjs.min.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: 'controlador/consulta_habitaciones_reservar.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var habitacionesContainer = $('#habitaciones-container');
                habitacionesContainer.empty(); 

                $.each(data, function(index, habitacion) {
                    var card = '<div class="col-md-4">' +
                                '<div class="card">' +
                                '<img src="' + habitacion.foto1 + '" class="card-img-top" alt="...">' +
                                '<div class="card-body">' +
                                '<h5 class="card-title">' + habitacion.tipo + '</h5>' +
                                '<h5 class="card-title">Numero de Habitación' + habitacion.id + '</h5>' +
                                '<p class="card-text">Camas: ' + habitacion.camas + '</p>' +
                                '<p class="card-text">Baños: ' + habitacion.banos + '</p>' +
                                '<p class="card-text">Mascotas: ' + habitacion.mascotas + '</p>' +
                                '<p class="card-text">Precio: ' + habitacion.precio + '</p>';

                    if(<?php echo $reserva_activa_count; ?> > 0) {
                        card += '<button class="btn btn-primary" disabled>Reservar</button>';
                    } else {
                        card += '<a href="./reservar.php?id=' + habitacion.id + '" class="btn btn-primary">Reservar</a>';
                    }

                    card += '</div>' +
                            '</div>' +
                            '</div>';

                    habitacionesContainer.append(card);
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>
</body>
</body>
</html>
