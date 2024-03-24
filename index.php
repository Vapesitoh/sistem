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
    <link rel="shortcut icon" href="reservaciones/images/favicon.png" type="image/x-icon">
    <title>Centro turístico San Mateo</title>
    <link rel="stylesheet" type="text/css" href="reservaciones/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
    <link href="reservaciones/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./reservaciones/css/style.css" rel="stylesheet" />
    <link href="./reservaciones/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="reservaciones/css/slider.css">
    <link rel="stylesheet" href="reservaciones/css/index.css">
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
    </section>
    <div class="container">
        <h2 style="font-size: 36px; font-weight: bold; color: #333; text-align: center;">Bienvenido a Las Naves</h2>
        <p style="font-size: 18px; color: #666; text-align: center;">¡Bienvenido al portal web del hermoso centro turístico Las Naves!</p>
        <p style="font-size: 18px; color: #666; text-align: center;">Ubicado en un entorno natural impresionante, Las Naves te ofrece una experiencia única llena de aventura, relajación y descubrimiento.</p>
        <p style="font-size: 18px; color: #666; text-align: center;">Descubre nuestras magníficas cascadas, explora nuestros senderos rodeados de exuberante vegetación y disfruta de la tranquilidad de nuestros rincones especiales.</p>
        <p style="font-size: 18px; color: #666; text-align: center;">Con una amplia gama de actividades para todos los gustos y edades, Las Naves es el destino perfecto para tus próximas vacaciones inolvidables.</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="cuartos.php" class="btn btn-primary">Explora nuestros cuartos</a>
        </div>
    </div>
    <div class="container">
        <h2 style="padding: 50px;color: white; font-size: 44px; font-weight: bold; text-shadow: 2px 2px 4px rgba(255, 255, 255)" class="textoxd">Las cascadas</h2>
        <div class="b1-wrapper">
            <?php 
            $i = 0; // Variable para alternar el color de la tarjeta
            foreach ($datosSeccion as $seccion) : 
            ?>
            <div class="b1-custom b1-color-<?php echo $i; ?>">
                <div class="b1-border"></div>
                <h1><?php echo $seccion["titulo"]; ?></h1>
                <img src="<?php echo $seccion["imagen"]; ?>" />
                <p><?php echo $seccion["descripcion"]; ?></p>
                </div>
            <?php 
            // Alternar el color de la tarjeta
            $i = ($i + 1) % 4; 
            ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
        <h2 style="font-size: 36px; font-weight: bold; color: #333; text-align: center;">Otra sección estática</h2>
        <p style="font-size: 18px; color: #666; text-align: center;">Descripción de esta otra sección estática. Puedes agregar aquí cualquier información adicional sobre el lugar.</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="cuartos.php" class="btn btn-primary">Reservar ahora</a>
        </div>
    </div>
    <?php include 'reservaciones/web/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="reservaciones/js/slider.js"></script>
</body>
</html>
