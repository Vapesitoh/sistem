<?php
session_start();
include 'include/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$consultaRolUsuario = "SELECT rol FROM usuarios WHERE id = $usuario_id";
$resultadoRolUsuario = mysqli_query($conexion, $consultaRolUsuario);

if (!$resultadoRolUsuario) {
    header("Location: 403.php");
    exit();
}

$filaRolUsuario = mysqli_fetch_assoc($resultadoRolUsuario);
$rolUsuario = $filaRolUsuario['rol'];

if ($rolUsuario !== 'Cliente') {
    header("Location: 403.php");
    exit();
}
?>
<link rel="icon" type="image/png" href="./assets/img/favicon.png">
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; ?>
    <div class="container-fluid py-4">
        <div class="row justify-content-center" id="reservaciones-container">
            <!-- Contenido generado dinámicamente -->
        </div>
    </div>

    <style>
        .card {
            border: 1px solid #e1e5eb;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f7fafc;
            border-bottom: 1px solid #e1e5eb;
            padding: 0.75rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-border-bottom {
            border-bottom: 10px solid;
        }

        .saldo-pendiente {
            background-color: #ffa500;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .cancelado {
            background-color: #90ee90;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            function cargarReservaciones() {
                $.ajax({
                    url: 'controlador/consultar_reservaciones.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#reservaciones-container').empty();

                        data.forEach(function (reservacion) {
                            var borderColor = '';
                            var estadoTexto = '';
                            if (reservacion.estado === '1') {
                                borderColor = 'red'; // Cancelado
                                estadoTexto = 'Cancelado';
                            } else if (reservacion.estado === '2') {
                                borderColor = 'yellow'; // En espera
                                estadoTexto = 'En espera';
                            } else if (reservacion.estado === '3') {
                                borderColor = 'green'; // Aprobado
                                estadoTexto = 'Aprobado';
                            }

                            var saldoPendiente = reservacion.valor_total - (reservacion.primer_pago ? reservacion.primer_pago : 0) - (reservacion.segundo_pago ? reservacion.segundo_pago : 0) - (reservacion.tercer_pago ? reservacion.tercer_pago : 0);

                            var botonEnviarDeposito = '';
                            var mensajePago = '';
                            if (saldoPendiente !== 0) {
                                botonEnviarDeposito = `<button class="enviar-deposito" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Enviar depósito</button>`;
                                mensajePago = `<p class="mensaje-pago" style="font-size: 20px; color: #ff4500; font-weight: bold; text-align: center;">¡Atención! Por favor, diríjase a recepción para abonar al saldo pendiente de su habitación o suba la imagen del deposito en boton enviar deposito la verificacion de su transferencia o deposito demora entre 5 a 15 minutos .</p>`;
                            } else {
                                saldoPendiente = 0;
                                borderColor = '#90ee90'; // Verde (Cancelado)
                                estadoTexto = 'Aprobado';
                            }

                            var $tarjeta = $(`
                            <div class="col-md-6">
                                <div class="col-md-9 mb-4">
                                    <div class="card card-border-bottom" style="border-color: ${borderColor};" data-reservacion-id="${reservacion.id}">
                                        <div class="card-header">
                                            <h5 class="card-title">Reservación ${reservacion.id}</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Nombre de Usuario:</strong> ${reservacion.nombre_usuario}</p>
                                            <p><strong>Número de Teléfono:</strong> ${reservacion.numero_telefono}</p>
                                            <p><strong>Tipo de Habitación:</strong> ${reservacion.tipo_habitacion}</p>
                                            <p><strong>Fecha de Reservación:</strong> ${reservacion.fecha_reservacion}</p>
                                            <p><strong>Fecha de Entrega:</strong> ${reservacion.fecha_entrega}</p>
                                            <p><strong>Precio:</strong> ${reservacion.valor_total}</p>
                                            <p><strong>Estado:</strong> ${estadoTexto}</p>
                                            <p><strong>Saldo Pendiente:</strong> <span class="${saldoPendiente !== 0 ? 'saldo-pendiente' : 'cancelado'}"> ${saldoPendiente} $</span></p>
                                            ${mensajePago}
                                            ${botonEnviarDeposito}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `);

                            if (reservacion.estado !== '3') {
                                $tarjeta.find('.enviar-deposito').hide();
                                $tarjeta.find('.mensaje-pago').hide();
                            }

                            $('#reservaciones-container').append($tarjeta);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al cargar las reservaciones:', error);
                        alert('Error al cargar las reservaciones. Por favor, inténtelo de nuevo más tarde.');
                    }
                });
            }

            cargarReservaciones();

            $(document).on('click', '.enviar-deposito', function () {
                const reservacionId = $(this).closest('.card').data('reservacion-id');

                Swal.fire({
                    icon: 'info',
                    title: 'Por favor, suba la imagen de su depósito',
                    html: '<input type="file" id="imagenDeposito" accept="image/*" class="swal2-file">',
                    showCancelButton: true,
                    confirmButtonText: 'Subir',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const fileInput = document.getElementById('imagenDeposito');
                        const file = fileInput.files[0];
                        if (file) {
                            const formData = new FormData();
                            formData.append('archivo', file);

                            $.ajax({
                                url: 'controlador/subir_pagos.php?id=' + reservacionId,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    try {
                                        response = JSON.parse(response);
                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: response.success
                                            }).then(() => {
                                                if (response.url) {
                                                    const imagenUrl = response.url;
                                                    const $tarjeta = $(this).closest('.card');
                                                    $tarjeta.find('.card-body').append(`<img src="${imagenUrl}" alt="Imagen de depósito">`);
                                                }
                                            });
                                        } else if (response.error) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: response.error
                                            });
                                        }
                                    } catch (error) {
                                        console.error('Error al analizar la respuesta JSON:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error al procesar la respuesta del servidor'
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error(xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error al subir la imagen'
                                    });
                                }
                            });
                        } else {
                            Swal.showValidationMessage('Debe seleccionar una imagen');
                        }
                    }
                });
            });
        });
    </script>
</body>
