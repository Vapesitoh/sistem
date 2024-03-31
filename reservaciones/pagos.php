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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
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
                                <th class="strong-black-text text-center">Habitacion</th>
                                <th hidden class="strong-black-text text-center">Usuario</th>
                                <th class="strong-black-text text-center">Nombre</th>
                                <th class="strong-black-text text-center">Teléfono</th>
                                <th class="strong-black-text text-center">Cédula</th>
                                <th class="strong-black-text text-center">Valor Total</th>
                                <th class="strong-black-text text-center">Entrega</th>
                                <th class="strong-black-text text-center">Pago</th>
                                <th class="strong-black-text text-center">Comprobante</th>
                                <th class="strong-black-text text-center">Pago 2</th>
                                <th class="strong-black-text text-center">Pago 3</th>
                                <th class="strong-black-text text-center">Pago 4</th>
                                <th class="strong-black-text text-center">Saldo Restante</th>
                                <th class="strong-black-text text-center">Acción</th>
                            </tr>
                            </thead>
                            <tbody id="reservaciones-body">
                            </tbody>
                        </table>
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
$(document).ready(function () {
    // Realizar la petición AJAX para obtener las reservaciones
    $.ajax({
        url: 'controlador/consulta_reservacion_pagos.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Iterar sobre los datos y agregarlos a la tabla
            data.forEach(function (reservacion) {
                var row = '<tr>' +
                    '<td class="strong-black-text text-center" hidden>' + reservacion.id + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.habitacion_id + '</td>' +
                    '<td hidden class="strong-black-text text-center">' + reservacion.usuario_id + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.nombre_usuario + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.numero_telefono + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.cedula + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.valor_total + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.fecha_entrega + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.pago + '</td>' +
                    '<td class="strong-black-text text-center">' + (reservacion.pago === 'Efectivo' ? '' : '<a href="' + reservacion.deposito + '" target="_blank" class="btn btn-primary btn-ver-imagen">Ver comprobante</a>') + '</td>' +
                    '<td class="strong-black-text text-center">' + (reservacion.pago2 ? '<a href="' + reservacion.pago2 + '" target="_blank" class="btn btn-primary btn-ver-imagen">Pago 2</a>' : '') + '</td>' +
                    '<td class="strong-black-text text-center">' + (reservacion.pago3 ? '<a href="' + reservacion.pago3 + '" target="_blank" class="btn btn-primary btn-ver-imagen">Pago 3</a>' : '') + '</td>' +
                    '<td class="strong-black-text text-center">' + (reservacion.pago4 ? '<a href="' + reservacion.pago4 + '" target="_blank" class="btn btn-primary btn-ver-imagen">Pago 4</a>' : '') + '</td>' +
                    '<td class="strong-black-text text-center">' + reservacion.saldo_restante + '</td>';

                // Verificar si el saldo restante es 0 y mostrar "Pagado"
                if (parseFloat(reservacion.saldo_restante) === 0) {
                    row += '<td class="strong-black-text text-center">Pagado</td>';
                } else {
                    // Verificar si se debe mostrar el botón de pago 1
                    if (!reservacion.segundo_pago && parseFloat(reservacion.saldo_restante) !== 0) {
                        row += '<td class="strong-black-text text-center"><button class="btn btn-success btn-pago" data-id="' + reservacion.id + '" data-saldo="' + reservacion.saldo_restante + '">Pagar</button></td>';
                    }
                    // Verificar si se debe mostrar el botón de pago 2
                    else if (reservacion.segundo_pago && !reservacion.tercer_pago && parseFloat(reservacion.saldo_restante) !== 0) {
                        row += '<td class="strong-black-text text-center"><button class="btn btn-success btn-pago9" data-id="' + reservacion.id + '" data-saldo="' + reservacion.saldo_restante + '">Pagar</button></td>';
                    }
                    // Verificar si se debe mostrar el botón de pago 3
                    else if (reservacion.tercer_pago && !reservacion.cuarto_pago && parseFloat(reservacion.saldo_restante) !== 0) {
                        row += '<td class="strong-black-text text-center"><button class="btn btn-success btn-pago5" data-id="' + reservacion.id + '" data-saldo="' + reservacion.saldo_restante + '">Pagar</button></td>';
                    }
                    // Si no se cumple ninguna condición, no se muestra ningún botón
                    else {
                        row += '<td class="strong-black-text text-center"></td>';
                    }
                }

                row += '</tr>';

                $('#reservaciones-body').append(row);
            });
        },
        error: function (xhr, status, error) {
            // Manejar el error
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al cargar las reservaciones. Por favor, inténtalo de nuevo más tarde.'
            });
        }
    });

    // Manejar el clic en el botón de pago
    $(document).on('click', '.btn-pago', function () {
        var reservacionId = $(this).data('id');
        var saldoRestante = parseFloat($(this).data('saldo'));

        Swal.fire({
            title: 'Ingrese el valor del pago (Saldo Restante: ' + saldoRestante + ')',
            input: 'number',
            inputAttributes: {
                step: '0.01',
                max: saldoRestante // Establecer el saldo restante como máximo
            },
            showCancelButton: true,
            confirmButtonText: 'Pagar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: (valor) => {
                // Realizar la petición AJAX para realizar el pago
                return $.ajax({
                    url: 'controlador/pagos.php?id=' + reservacionId,
                    type: 'POST',
                    data: { valor: valor },
                    dataType: 'json'
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            // Mostrar el resultado de la operación
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pago realizado',
                        text: 'El pago se ha realizado correctamente.'
                    }).then(() => {
                        // Recargar la página después de cerrar la alerta
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.value.error
                    });
                }
            }
        });
    });

  // Manejar el clic en el botón de pago 2
$(document).on('click', '.btn-pago9', function () {
        var reservacionId = $(this).data('id');
        var saldoRestante = parseFloat($(this).data('saldo'));

        Swal.fire({
            title: 'Ingrese el valor del tercer pago (Saldo Restante: ' + saldoRestante + ')',
            input: 'number',
            inputAttributes: {
                step: '0.01',
                max: saldoRestante // Establecer el saldo restante como máximo
            },
            showCancelButton: true,
            confirmButtonText: 'Pagar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: (valor) => {
                // Realizar la petición AJAX para realizar el pago
                return $.ajax({
                    url: 'controlador/pagos2.php?id=' + reservacionId,
                    type: 'POST',
                    data: { valor: valor },
                    dataType: 'json'
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            // Mostrar el resultado de la operación
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pago realizado',
                        text: 'El pago se ha realizado correctamente.'
                    }).then(() => {
                        // Recargar la página después de cerrar la alerta
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.value.error
                    });
                }
            }
        });
    });
  // Manejar el clic en el botón de pago 2
  $(document).on('click', '.btn-pago5', function () {
        var reservacionId = $(this).data('id');
        var saldoRestante = parseFloat($(this).data('saldo'));

        Swal.fire({
            title: 'Ingrese el valor del cuarto pago (Saldo Restante: ' + saldoRestante + ')',
            input: 'number',
            inputAttributes: {
                step: '0.01',
                max: saldoRestante // Establecer el saldo restante como máximo
            },
            showCancelButton: true,
            confirmButtonText: 'Pagar',
            cancelButtonText: 'Cancelar',
            showLoaderOnConfirm: true,
            preConfirm: (valor) => {
                // Realizar la petición AJAX para realizar el pago
                return $.ajax({
                    url: 'controlador/pagos3.php?id=' + reservacionId,
                    type: 'POST',
                    data: { valor: valor },
                    dataType: 'json'
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            // Mostrar el resultado de la operación
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pago realizado',
                        text: 'El pago se ha realizado correctamente.'
                    }).then(() => {
                        // Recargar la página después de cerrar la alerta
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.value.error
                    });
                }
            }
        });
    });


});
</script>

</body>
</html>
