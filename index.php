<?php
include('./reservaciones/include/conexion.php');

// Consulta para obtener los datos de la tabla 'inicio'
$query = "SELECT titulo, texto, imagen, descripcion FROM inicio WHERE estado = 1";
$result = mysqli_query($conexion, $query);

if (!$result) {
    // Si hay un error en la consulta, imprime el mensaje de error y termina el script
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Array para almacenar los datos de inicio
$datosInicio = array();

// Obtener los datos de inicio de la consulta y guardarlos en el array
while ($row = mysqli_fetch_assoc($result)) {
    // Concatenar la ruta de la carpeta 'reservaciones/' con el nombre de la imagen
    $row['imagen'] = 'reservaciones/' . $row['imagen'];
    $datosInicio[] = $row;
}

// Consulta para obtener los datos de la tabla 'seccion'
$query_seccion = "SELECT titulo, imagen, descripcion FROM tarjetas WHERE estado = 1";
$result_seccion = mysqli_query($conexion, $query_seccion);

if (!$result_seccion) {
    // Si hay un error en la consulta, imprime el mensaje de error y termina el script
    die('Error en la consulta de seccion: ' . mysqli_error($conexion));
}

// Array para almacenar los datos de seccion
$datosSeccion = array();

// Obtener los datos de seccion de la consulta y guardarlos en el array
while ($row_seccion = mysqli_fetch_assoc($result_seccion)) {
    // Concatenar la ruta de la carpeta 'reservaciones/' con el nombre de la imagen
    $row_seccion['imagen'] = 'reservaciones/' . $row_seccion['imagen'];
    $datosSeccion[] = $row_seccion;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="reservaciones/images/favicon.png" type="">
    <title>Centro turistico las naves</title>
    <link rel="stylesheet" type="text/css" href="reservaciones/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
    <link href="reservaciones/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./reservaciones/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./reservaciones/css/style.css" rel="stylesheet" />
    <link href="./reservaciones/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="reservaciones/css/slider.css">
</head>
<body class="sub_page">
    <?php include 'reservaciones/web/navbarweb.php'; ?>
    <section class="b1">
        <div class="b1-slider">
            <?php foreach ($datosInicio as $inicio) : ?>
                <div class="b1-slide">
                    <div class="b1-bg" style="background-image: url('<?php echo $inicio['imagen']; ?>');"></div>
                    <div class="wancho b1-cnt">
                        <figure class="b1-lanza-video">
                            <i class="icon-SVG-11"></i>
                        </figure>
                        <div class="b1-center">
                            <div class="b1-text">
                                <h2>
                                    <?php echo $inicio['titulo']; ?>
                                    <strong><?php echo $inicio['descripcion']; ?></strong>
                                </h2>
                            </div>
                           
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
<!--
  Please note: this code is in no way ready to be used as is in production on your website. It will need to be adapted to be cross browser compliant & accessible. I just wanted to share how one might go about this effect with CSS & JS and no other dependencies
-->
<style>

</style>
 <!-- Mostrar tarjetas de sección -->
 <div class="container1">
        <?php 
        $i = 0; // Variable para alternar el color de la tarjeta
        foreach ($datosSeccion as $seccion) : 
        ?>
            <div class="card-column">
                <div class="card card-color-<?php echo $i; ?>">
                    <div class="border"></div>
                    <img src="<?php echo $seccion["imagen"]; ?>" />
                    <h1><?php echo $seccion["titulo"]; ?></h1>
                    <p><?php echo $seccion["descripcion"]; ?></p>
                </div>
            </div>
        <?php 
        // Alternar el color de la tarjeta
        $i = ($i + 1) % 4; 
        ?>
        <?php endforeach; ?>
    </div>

    
    <?php include 'reservaciones/web/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="reservaciones/js/slider.js"></script>
</body>

</html>
<script>
  
</script>