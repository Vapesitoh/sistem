<?php
include('include/conexion.php');

session_start();

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

// Consulta para obtener todas las reservaciones
$consultaReservaciones = "SELECT * FROM reservacion WHERE estado = 2";
$resultadoReservaciones = mysqli_query($conexion, $consultaReservaciones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Aquí puedes incluir tus hojas de estilo CSS -->
    <link rel="stylesheet" href="estilos.css">
    <style>
        /* CSS personalizado */
        .strong-black-text {
            color: #000;
            font-weight: bold;
        }

    </style>
</head>
<body class="g-sidenav-show bg-gray-100">
<?php include 'include/navbar.php'; // Incluir el navbar.php ?>
<!--   Core JS Files   -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Reservaciones</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="strong-black-text text-center" hidden>ID</th>
                                <th class="strong-black-text text-center">Habitación</th>
                                <th class="strong-black-text text-center">Usuario</th>
                                <th class="strong-black-text text-center">Nombre</th>
                                <th class="strong-black-text text-center">Teléfono</th>
                                <th class="strong-black-text text-center">Cédula</th>
                                <th class="strong-black-text text-center">Valor Total</th>
                                <th class="strong-black-text text-center">Tipo</th>
                                <th class="strong-black-text text-center">Reserva</th>
                                <th class="strong-black-text text-center">Entrega</th>
                                <th class="strong-black-text text-center">Pago</th>
                                <th class="strong-black-text text-center">Comprobante</th>
                                <th class="strong-black-text text-center">Estado</th>
                                <th class="strong-black-text text-center">Aprobar</th>
                                <th class="strong-black-text text-center">Cancelar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Comprobar si hay resultados
                            if (mysqli_num_rows($resultadoReservaciones) > 0) {
                                // Iterar sobre los resultados y mostrar los datos en la tabla
                                while ($fila = mysqli_fetch_assoc($resultadoReservaciones)) {
                                    echo "<tr class='reservacion-row' data-deposito='{$fila['deposito']}'>";
                                    echo "<td class='strong-black-text text-center' hidden>" . $fila['id'] . "</td>"; // Aquí ocultamos el ID
                                    echo "<td class='strong-black-text text-center'>" . $fila['habitacion_id'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['usuario_id'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['nombre_usuario'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['numero_telefono'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['cedula'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['valor_total'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['tipo_habitacion'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['fecha_reservacion'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['fecha_entrega'] . "</td>";
                                    echo "<td class='strong-black-text text-center'>" . $fila['pago'] . "</td>";
                                    // Si el pago es 'Efectivo', mostrar espacio vacío en lugar de botón de depósito
                                    if ($fila['pago'] === 'Efectivo') {
                                        echo "<td class='strong-black-text text-center'></td>";
                                    } else {
                                        // Mostrar un botón para ver la imagen
                                        echo "<td class='strong-black-text text-center'><a href='{$fila['deposito']}' target='_blank' class='btn btn-primary btn-ver-imagen'>Ver imagen</a></td>";
                                    }
                                    // Mostrar el estado en texto según el valor del estado
                                    $estadoTexto = ($fila['estado'] == 1) ? 'Activo' : 'En espera';
                                    echo "<td class='strong-black-text text-center'>" . $estadoTexto . "</td>";
                                    // Agregar botones para aprobar y cancelar
                                    echo "<td class='strong-black-text text-center'>
                                              <button class='btn btn-info btn-sucess' data-id='{$fila['id']}'>Aprobar</button>
                                          </td>";
                                    echo "<td class='strong-black-text text-center'>
                                              <button class='btn btn-danger btn-cancelar' data-id='{$fila['id']}'>Cancelar</button>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                // Si no hay reservaciones, mostrar un mensaje de que no hay datos
                                echo "<tr><td colspan='14' class='text-center'>No hay reservaciones</td></tr>";
                            }

                            // Liberar el conjunto de resultados
                            mysqli_free_result($resultadoReservaciones);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Cerrar la conexión
mysqli_close($conexion);
?>
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
    $(document).ready(function() {
        $('.btn-ver-imagen').click(function() {
            // Eliminar la clase 'selected-row' de todas las filas
            $('.reservacion-row').removeClass('selected-row');
            // Agregar la clase 'selected-row' a la fila actual
            $(this).closest('tr').addClass('selected-row');
        });

// Función para manejar el click en el botón Aprobar
$('.btn-sucess').click(function() {
    var reservacionId = $(this).data('id');
    // Obtener el valor total de la reserva
    var valorTotalReserva = parseFloat($(this).closest('tr').find('td:eq(6)').text()); // Esto asume que la columna del valor total es la séptima (índice 6)

    // Calcular el 50% del valor total
    var cincuentaPorCiento = valorTotalReserva * 0.50;

    // Mostrar modal para ingresar el monto del primer pago
    Swal.fire({
        title: 'Ingrese el monto del primer pago',
        html: 'El valor mínimo a pagar del usuario es del 50% del valor total que es: <strong>' + cincuentaPorCiento.toFixed(2) + '$</strong> para poder reservar la habitación',
        input: 'text',
        inputLabel: 'Monto',
        inputPlaceholder: 'Ingrese el monto del primer pago',
        showCancelButton: true,
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,
        preConfirm: (monto) => {
            // Validar el monto ingresado
            if (!monto || !/^\d+(\.\d{1,2})?$/.test(monto)) {
                Swal.showValidationMessage('Por favor ingrese un monto válido. Solo se permiten números.');
            } else {
                var montoPrimerPago = parseFloat(monto);
                // Verificar que el monto ingresado sea al menos el 50% del valor total
                if (montoPrimerPago < cincuentaPorCiento) {
                    Swal.showValidationMessage('El monto del primer pago debe ser al menos el 50% del valor total de la reserva.');
                } else if (montoPrimerPago > valorTotalReserva) {
                    Swal.showValidationMessage('El monto del primer pago no puede ser mayor que el valor total de la reserva.');
                } else {
                    // Realizar la solicitud AJAX al controlador
                    return $.ajax({
                        url: 'controlador/botones.php',
                        type: 'POST',
                        data: { id: reservacionId, action: 'aprobar', monto_primer_pago: monto },
                    }).then(response => {
                        const data = JSON.parse(response);
                        if (!data.success) {
                            throw new Error(data.message || 'Error al aprobar la reservación.');
                        }
                    }).catch(error => {
                        Swal.showValidationMessage(
                            `Error: ${error}`
                        );
                    });
                }
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Reservación aprobada con éxito'
            }).then(function() {
                // Recargar la página después de cerrar la alerta
                location.reload();
            });
        }
    });
});


        // Función para manejar el click en el botón Cancelar
        $('.btn-cancelar').click(function() {
            var reservacionId = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción cancelará la reservación seleccionada",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, realizar la solicitud AJAX
                    $.ajax({
                        url: 'controlador/botones.php',
                        type: 'POST',
                        data: {id: reservacionId, action: 'cancelar'},
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                // Mostrar alerta de éxito
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.message
                                }).then(function() {
                                    // Recargar la página después de cerrar la alerta
                                    location.reload();
                                });
                            } else {
                                // Mostrar alerta de error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message
                                });
                            }
                        },
                        error: function() {
                            // Mostrar alerta de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al procesar la solicitud'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>
