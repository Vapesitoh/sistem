<?php
session_start(); // Iniciar la sesión

include('include/conexion.php');
include('include/procesarformularios.php'); // Incluye tu archivo de procesamiento de formularios

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

// Verificar si el rol del usuario es empleado
if ($rolUsuario != 'Empleado') {
    // Si el usuario no es empleado, redirigir a una página de acceso denegado
    header("Location: 403.php");
    exit();
}
?>
<style>
  .mensaje-exito {
    color: green;
    position: absolute;
    top: 0; /* Puedes ajustar la posición vertical según sea necesario */
    right: 0; /* Coloca el mensaje en el lado derecho */
}
</style>
<body class="g-sidenav-show bg-gray-100">
    <?php include 'include/navbar.php'; // Incluir el navbar.php 
    ?>

<div class="container">
    <div class="card bg-dark text-light mt-4">
        <div class="card-body">
            <h1 class="card-title text-center text-light">Elegir Formulario</h1>
            <select id="tipo_formulario" class="form-control">
                <option value="">Selecciona un formulario</option>
                <option value="comida">Formulario de Comida</option>
                <option value="inicio">Formulario de Inicio</option>
                <option value="lugares">Formulario de Lugares</option>
                <option value="seccion">Formulario de Sección</option>
                <option value="tarjetas">Formulario de Tarjetas</option>
            </select>

           <div id="formulario_comida" style="display: none;">
                <!-- Formulario de Comida -->
                <div class="card bg-dark text-light mt-4">
    <div class="card-body">
        <h1 class="card-title text-center text-light">Formulario de Comida</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo_comida" class="text-sm text-light">Título:</label>
                <input type="text" name="titulo_comida" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagenes_comida" class="text-sm text-light">Imágenes:</label>
                <input type="file" name="imagenes_comida" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion_comida" class="text-sm text-light">Descripción:</label>
                <textarea name="descripcion_comida" class="form-control" required></textarea>
            </div>

            <div class="form-group">
            <label for="precio_comida" class="text-sm text-light">Precio:</label>
            <input type="number" name="precio_comida" class="form-control" required min="0" step="0.01">
            </div>


            <div class="form-group">
            <label for="categoria_comida" class="text-sm text-light">Categoría:</label>
            <select name="categoria_comida" class="form-control" required>
                <option value="Desayunos">Desayunos</option>
                <option value="Almuerzos">Almuerzos</option>
                <option value="Merienda">Merienda</option>
            </select>
        </div>


            <div class="text-center">
                <input type="submit" name="submit_comida" value="Agregar Información" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
</div>

 


            <div id="formulario_inicio" style="display: none;">

        <!-- Formulario para la tabla "inicio" -->
        <div class="card bg-dark text-light mt-4">
    <div class="card-body">
        <h1 class="card-title text-center text-light">Formulario de Inicio</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo_inicio" class="text-sm text-light">Título:</label>
                <input type="text" name="titulo_inicio" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="texto_inicio" class="text-sm text-light">Texto:</label>
                <textarea name="texto_inicio" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="imagen_inicio" class="text-sm text-light">Imagen:</label>
                <input type="file" name="imagen_inicio" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion_inicio" class="text-sm text-light">Descripción:</label>
                <textarea name="descripcion_inicio" class="form-control" required></textarea>
            </div>

            <div class="text-center">
                <input type="submit" name="submit_inicio" value="Agregar Información" class="btn btn-primary">
            </div>
        </form>
        </div>
            </div>
            </div>

  
            <div id="formulario_lugares" style="display: none;">

        <!-- Formulario para la tabla "lugares" -->
        <div class="card bg-dark text-light mt-4">
    <div class="card-body">
        <h1 class="card-title text-center text-light">Formulario de Lugares</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo_lugares" class="text-sm text-light">Título:</label>
                <input type="text" name="titulo_lugares" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagenes_lugares" class="text-sm text-light">Imágenes:</label>
                <input type="file" name="imagenes_lugares" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion_lugares" class="text-sm text-light">Descripción:</label>
                <textarea name="descripcion_lugares" class="form-control" required></textarea>
            </div>

            <div class="text-center">
                <input type="submit" name="submit_lugares" value="Agregar Información" class="btn btn-primary">
            </div>
        </form>
        </div>
            </div>
            </div>


            <div id="formulario_seccion" style="display: none;">
   <!-- Formulario para la tabla "seccion" -->
   <div class="card bg-dark text-light mt-4">
    <div class="card-body">
        <h1 class="card-title text-center text-light">Formulario de Sección</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo_seccion" class="text-sm text-light">Título:</label>
                <input type="text" name="titulo_seccion" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagen_seccion" class="text-sm text-light">Imagen:</label>
                <input type="file" name="imagen_seccion" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion_seccion" class="text-sm text-light">Descripción:</label>
                <textarea name="descripcion_seccion" class="form-control" required></textarea>
            </div>

            <div class="text-center">
                <input type="submit" name="submit_seccion" value="Agregar Información" class="btn btn-primary">
            </div>
        </form>
        </div>
            </div>
            </div>

               <div id="formulario_tarjetas" style="display: none;">
        <!-- Formulario para la tabla "tarjetas" -->
        <div class="card bg-dark text-light mt-4">
    <div class="card-body">
        <h1 class="card-title text-center text-light">Formulario de Tarjetas</h1>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo_tarjetas" class="text-sm text-light">Título:</label>
                <input type="text" name="titulo_tarjetas" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagen_tarjetas" class="text-sm text-light">Imagen:</label>
                <input type="file" name="imagen_tarjetas" class="form-control-file" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="descripcion_tarjetas" class="text-sm text-light">Descripción:</label>
                <textarea name="descripcion_tarjetas" class="form-control" required></textarea>
            </div>

            <div class="text-center">
                <input type="submit" name="submit_tarjetas" value="Agregar Información" class="btn btn-primary">
            </div>
        </form>
        </div>
            </div>
            </div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tipo_formulario').change(function () {
            var selectedForm = $(this).val();
            // Ocultar todos los formularios
            $('#formulario_comida, #formulario_habitaciones, #formulario_informacion, #formulario_inicio, #formulario_lugares, #formulario_seccion, #formulario_tarjetas').hide();

            // Mostrar el formulario seleccionado
            $('#formulario_' + selectedForm).show();
        });
    });
</script>

    <!--   Core JS Files   -->
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/argon-dashboard.min.js?v=2.0.4"></script>
    </body>

</html>