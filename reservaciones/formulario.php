<?php
include 'controlador/procesarformulario.php'; // Incluye tu archivo de procesamiento de formularios
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Si el usuario no está autenticado, redirigir a index.php
    header("Location: index.php");
    exit();
}
?>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; // Incluir el navbar.php ?>
<div class="container">
    <div class="card bg-dark text-light mt-4">
        <div class="card-body">
            <h1 class="card-title text-center text-light">Elegir Formulario</h1>
            <select id="tipo_formulario" class="form-control">
                <option value="">Selecciona un formulario</option>
                <option value="habitaciones">Formulario de Habitaciones</option>
            </select>

           <div id="formulario_habitaciones" style="display: none;">
                <!-- Formulario de Habitaciones -->
                <div class="card bg-dark text-light mt-4">
                    <div class="card-body">
                        <h1 class="card-title text-center text-light">Formulario de Habitaciones</h1>
                        <form method="post" action="formulario.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="imagen1" class="text-sm text-light">Imagen 1:</label>
                                <input type="file" name="imagen1" class="form-control-file" accept="image/*" required>
                            </div>
                          
                            <div class="form-group">
                                <label for="imagen2" class="text-sm text-light">Imagen 2:</label>
                                <input type="file" name="imagen2" class="form-control-file" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="imagen3" class="text-sm text-light">Imagen 3:</label>
                                <input type="file" name="imagen3" class="form-control-file" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="titulo_habitacion" class="text-sm text-light">Título:</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion_habitaciones" class="text-sm text-light">Descripción:</label>
                                <textarea name="descripcion" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="precio" class="text-sm text-light">Precio:</label>
                                <input type="number" name="precio" class="form-control" required min="0" step="0.01">
                            </div>

                            <div class="form-group">
                                <label for="tipo" class="text-sm text-light">Tipo de habitación:</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="">Selecciona un tipo</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Familiar">Familiar</option>
                                    <option value="Matrimonial">Matrimonial</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="mascotas" class="text-sm text-light">Cantidad de mascotas permitidas (máximo 3):</label>
                                <select name="mascotas" class="form-control">
                                    <option value="0">Ninguna</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="banos" class="text-sm text-light">Cantidad de baños (máximo 3):</label>
                                <select name="banos" class="form-control">
                                    <option value="0">Ninguno</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="camas" class="text-sm text-light">Cantidad de camas:</label>
                                <select name="camas" class="form-control" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="text-center">
                                <input type="submit" name="submit_habitaciones" value="Agregar Información" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tipo_formulario').change(function () {
            var selectedForm = $(this).val();
            // Ocultar todos los formularios
            $('#formulario_habitaciones').hide();

            // Mostrar el formulario seleccionado
            $('#formulario_' + selectedForm).show();
        });
    });
</script>
</body>
</html>
