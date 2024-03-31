<?php
// Incluir el archivo de conexión a la base de datos
include('include/conexion.php');

session_start();

// Verificar si el usuario está autenticado y tiene el rol de Cliente
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir a index.php o mostrar un mensaje de error
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; // Suponiendo que tienes almacenado el ID del usuario en la sesión

// Obtener los datos del usuario de la sesión
$sql_usuario = "SELECT * FROM usuarios WHERE id = $usuario_id";
$result_usuario = mysqli_query($conexion, $sql_usuario);
$datos_usuario = mysqli_fetch_assoc($result_usuario);

if (!$datos_usuario) {
    // Si el usuario no existe en la base de datos, redirigir a index.php o mostrar un mensaje de error
    header("Location: index.php");
    exit();
}

// Obtener los datos de la habitación
$habitacion_id = $_GET['id']; // Suponiendo que el ID de la habitación se pasa a través de la URL
$sql_habitacion = "SELECT * FROM habitaciones WHERE id = $habitacion_id";
$result_habitacion = mysqli_query($conexion, $sql_habitacion);
$habitacion = mysqli_fetch_assoc($result_habitacion);

if (!$habitacion) {
    // Si la habitación no existe en la base de datos, redirigir a alguna página de error
    header("Location: ..php");
    exit();
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <link rel="stylesheet" href="./css/reservaciones.css">
</head>

<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; // Incluir el navbar.php 
    ?>
    <div class="container py-4">
        <h2 class="mb-4">Reservar Habitación</h2>
        <div class="containerxd">

            <div class="container">
                <div class="row">

                    <div class="col-md-6">
                    <div class="col-md-6">
                        <form id="reservacionForm" action="./controlador/reservar_habitacion.php" method="POST" enctype="multipart/form-data">
                            <?php if ($datos_usuario) : ?>
                                <input type="hidden" name="usuario_id" value="<?php echo $datos_usuario['id']; ?>">
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre de usuario:</label>
                                    <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $datos_usuario['nombres']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="numero_telefono">Número de Teléfono:</label>
                                    <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $datos_usuario['numero_telefono']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cedula">Cédula:</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $datos_usuario['cedula']; ?>" readonly>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="numero">Número de habitación:</label>
                                <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $habitacion['id']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de habitación:</label>
                                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $habitacion['tipo']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio por adulto por día:</label>
                                <input type="text" class="form-control" id="precio_adulto" name="precio_adulto" value="20" readonly>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio por niño por día:</label>
                                <input type="text" class="form-control" id="precio_niño" name="precio_niño" value="15" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fecha_reservacion">Fecha y Hora de Reservación:</label>
                                <input type="datetime-local" class="form-control" id="fecha_reservacion" name="fecha_reservacion" min="<?php echo date('Y-m-d\TH:i'); ?>" onchange="calcularPrecioTotal()" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha y Hora de Entrega:</label>
                                <input type="datetime-local" class="form-control" id="fecha_entrega" name="fecha_entrega" min="<?php echo date('Y-m-d\TH:i'); ?>" onchange="calcularPrecioTotal()" required>
                            </div>
                            <div class="form-group">
                                <label for="adultos">Cantidad de adultos:</label>
                                <input type="number" class="form-control" id="adultos" name="adultos" min="0" max="4" onchange="calcularPrecioTotal()" required>
                            </div>
                            <div class="form-group">
                                <label for="niños">Cantidad de niños:</label>
                                <input type="number" class="form-control" id="niños" name="niños" min="0" max="4" onchange="calcularPrecioTotal()" required>
                            </div>
                            <div class="form-group">
                                <label for="precio_total">Total a pagar:</label>
                                <input type="text" class="form-control" id="precio_total" name="precio_total" readonly>
                            </div>
                            <div class="form-group">
                                <label for="metodo_pago">Método de Pago:</label>
                                <select class="form-control" id="metodo_pago" name="metodo_pago" onchange="mostrarSeccionFotoDeposito(this.value)" required>
                                    <option value="">Seleccionar Método de Pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Depósito">Depósito</option>
                                </select>
                            </div>
                            <!-- Sección para subir foto en caso de Depósito -->
                            <div id="seccion_foto_deposito">
                                <div class="form-group">
                                    <label for="foto_deposito">Foto del Comprobante de Depósito:</label>
                                    <input type="file" class="form-control-file" id="foto_deposito" name="foto_deposito">
                                </div>
                            </div>
                            <button type="button" onclick="validarFormulario()" class="btn btn-primary">Reservar</button>
                            <a href="javascript:history.go(-1)" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
                    </div>
                    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>

    <script>
        function calcularPrecioTotal() {
    var precioAdulto = parseFloat(document.getElementById('precio_adulto').value);
    var precioNiño = parseFloat(document.getElementById('precio_niño').value);
    var adultos = parseInt(document.getElementById('adultos').value);
    var niños = parseInt(document.getElementById('niños').value);
    var fechaReservacion = new Date(document.getElementById('fecha_reservacion').value);
    var fechaEntrega = new Date(document.getElementById('fecha_entrega').value);

    // Calcular el número de días de reserva
    var diferenciaFechas = fechaEntrega.getTime() - fechaReservacion.getTime();
    var diasReserva = Math.ceil(diferenciaFechas / (1000 * 3600 * 24));

    // Calcular el precio total
    var precioTotal = (precioAdulto * adultos + precioNiño * niños) * diasReserva;

    // Mostrar el precio total en el campo correspondiente
    document.getElementById('precio_total').value = precioTotal.toFixed(2);
}


        function mostrarSeccionFotoDeposito(valor) {
            if (valor === 'Depósito') {
                document.getElementById('seccion_foto_deposito').style.display = 'block';
            } else {
                document.getElementById('seccion_foto_deposito').style.display = 'none';
            }
        }

        function validarFormulario() {
            var precioTotal = parseFloat(document.getElementById('precio_total').value);

            // Validar que el precio total sea mayor que 0.00
            if (precioTotal > 0.00) {
                var deposito = precioTotal * 0.5;
                // Mostrar un SweetAlert de confirmación antes de enviar el formulario
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Deseas realizar la reserva? El depósito requerido es de ' + deposito.toFixed(2) + ' dólares',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, reservar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma la reserva, enviar el formulario
                        document.getElementById('reservacionForm').submit();
                    }
                });
            } else {
                // Si el precio total es 0.00, mostrar un SweetAlert de error
                Swal.fire({
                    title: 'Error',
                    text: 'El precio total debe ser mayor que 0.00',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    </script>
</body>

</html>