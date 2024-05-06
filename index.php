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
    <title>Centro turístico San Mateo</title>
    <link rel="stylesheet" type="text/css" href="reservaciones/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ==" crossorigin="anonymous" />
    <link href="reservaciones/css/font-awesome.min.css" rel="stylesheet" />
    <link href="reservaciones/css/style.css" rel="stylesheet" />


</head>
<body class="sub_page">
    <?php include 'reservaciones/web/navbarweb.php'; ?>
   
     
<style>
     /* Agrega estilos CSS personalizados aquí 
   body {
    background: #150f21;
    font-size: 18px;
  }*/
.b1-slider {
    /* Estilos para el slider */
    .b1 .owl-item .b1-lanza-video {
        opacity: 0;
        transition: opacity 900ms all 700ms;
    }

    .b1 .owl-item .b1-text h2 {
        opacity: 0;
        transition: opacity 900ms all 800ms;
    }

    .b1 .owl-item .b1-text strong {
        opacity: 0;
        transition: opacity 900ms all 900ms;
    }

    .b1 .owl-item .g-button {
        opacity: 0;
        transition: opacity 900ms all 1000ms;
    }

    .b1 .owl-item.active .b1-lanza-video {
        opacity: 1;
    }

    .b1 .owl-item.active .g-button {
        opacity: 1;
    }

    .b1 .owl-item.active .b1-text h2 {
        opacity: 1;
    }

    .b1 .owl-item.active .b1-text strong {
        opacity: 1;
    }

    .owl-nav {
        display: none;
    }

    .owl-dots {
        position: absolute;
        width: 100%;
        max-width: 1180px;
        left: 0px;
        right: 0px;
        bottom: 35px;
        margin: auto;
        z-index: 100;
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
        box-sizing: border-box;
    }

    .owl-dots .owl-dot {
        width: 72px;
        height: 4px;
        background-color: #fff;
        margin-left: 10px;
        cursor: pointer;
        position: relative;
    }

    .owl-dots .owl-dot span {
        position: absolute;
        bottom: 100%;
        color: #fff;
        width: 100%;
        display: block;
        text-align: center;
        opacity: 0;
        font-family: t-1;
        font-size: 16px;
    }

    .owl-dots .owl-dot.active {
        height: 8px;
    }

    .owl-dots .owl-dot.active span {
        opacity: 1;
    }

    .owl-dots .owl-dot:first-child {
        margin-left: 0;
    }

    .b1-slide {
        min-height: 450px;
        height: calc(100vh - 120px);
        position: relative;
    }

    .b1-slide.active_video .b1-inner-video {
        opacity: 1;
        visibility: visible;
    }

    .b1-bg {
        position: absolute;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 95%;
        background-size: cover;
        background-position: center center;
    }

    .b1-bg:before, .b1-bg:after {
        content: '';
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0px;
        top: 0px;
        display: block;
    }

    .b1-bg:before {
        background: linear-gradient(to right, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 100%);
    }

    .b1-cnt {
        position: relative;
        z-index: 2;
        display: flex;
        height: 100%;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        max-width: 1100px;
        width: 100%;
        margin: auto;
    }

    .b1-center {
        max-width: 400px;
        width: 100%;
        margin: 0 auto 0 0;
    }

    .b1-text {
        margin-bottom: 50px;
    }

    .b1-text h2 {
        font-size: 22px;
        color: #fff;
        margin: 0;
        font-family: 'Arial';
        line-height: 1.2;
    }

    .b1-text strong {
        font-size: 40px;
        font-weight: bold;
        font-family: 'Arial';
        display: block;
    }

    .b1-lanza-video, .b1-bottom {
        margin: 0 auto 0 0;
    }

    .b1-lanza-video {
        font-size: 56px;
        color: #fff;
        cursor: pointer;
    }

    .b1-lanza-video i {
        display: block;
        margin-bottom: 25px;
    }

    .b1-inner-video {
        position: absolute;
        left: 0;
        top: -12.5%;
        width: 100%;
        padding-bottom: 56.3%;
        overflow: hidden;
        transition: all 500ms;
        pointer-events: none;
        opacity: 0;
        z-index: 12;
        visibility: hidden;
    }

    .b1-inner-video iframe {
        position: absolute;
        left: 0;
        height: 100%;
        width: 100%;
    }

    @media screen and (max-width: 1440px) {
        .b1 .owl-dots {
            padding-right: 30px;
        }
        .b1-text h2 {
            font-size: 20px;
        }
        .b1-text strong {
            font-size: 30px;
        }
    }

    @media screen and (max-width: 1024px) {
        .b1-lanza-video i {
            display: none;
        }
    }

    @media screen and (max-width: 768px) {
        .b1-text h2 {
            font-size: 18px;
        }
        .b1-text strong {
            font-size: 25px;
        }
    }

    @media screen and (max-width: 767px) {
        .b1-slide {
            height: 450px;
        }
        .b1-text {
            margin-bottom: 20px;
        }
        .b1 .owl-dots {
            padding-right: 0;
            justify-content: center;
        }
        .b1 .owl-dot {
            width: 50px;
        }
        .b1 .owl-dot span {
            font-size: 12px;
        }
    }
}

</style>
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



    <div class="container">
        <h2 style="font-size: 36px; font-weight: bold; color: #333;">Bienvenido al Centro turístico San Mateo</h2>
        <p style="font-size: 18px; color: #666; ">¡Bienvenido al portal web del Centro turístico San Mateo!</p>
        <p style="font-size: 18px; color: #666; ">Ubicado en un entorno natural impresionante, Las Naves te ofrece una experiencia única llena de aventura, relajación y descubrimiento.</p>
        <p style="font-size: 18px; color: #666; ">Descubre nuestras magníficas cascadas, explora nuestros senderos rodeados de exuberante vegetación y disfruta de la tranquilidad de nuestros rincones especiales.</p>
        <p style="font-size: 18px; color: #666; ">Con una amplia gama de actividades para todos los gustos y edades, Las Naves es el destino perfecto para tus próximas vacaciones inolvidables.</p>
        <div style="text-align: center; margin-top: 20px;">
            <a href="cuartos.php" class="btn btn-primary">Explora nuestros cuartos</a>
        </div>
    </div>
<style>
  * {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f3f3f3;
}

.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 50px 20px;
  text-align: center;
}

.textoxd {
  color: white;
  font-size: 44px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(255, 255, 255);
}

/* Estilos de las tarjetas */
.b1-wrapper {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.b1-custom {
  background-color: white;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  margin: 20px;
  padding: 20px;
  width: calc(50% - 40px); /* Ajusta el ancho según tu diseño */
}

.b1-custom h1 {
  font-size: 24px;
  margin-top: 10px;
  margin-bottom: 10px;
}

.b1-custom p {
  font-size: 16px;
  color: #666;
}

.b1-custom img {
  max-width: 100%;
  border-radius: 5px;
  margin-bottom: 10px;
}

/* Colores alternativos para las tarjetas */
.b1-color-0 {
  background-color: #ff7675; /* Coral */
}

.b1-color-1 {
  background-color: #74b9ff; /* Sky Blue */
}

.b1-color-2 {
  background-color: #55efc4; /* Aqua */
}

.b1-color-3 {
  background-color: #ffeaa7; /* Yellow */
}
</style>
    <div class="container">
        <h2 style="padding: 50px;color: black; font-size: 44px; font-weight: bold; text-shadow: 2px 2px 4px rgba(255, 255, 255)" class="textoxd">Las cascadas</h2>
        <div class="b1-wrapper">
            <?php 
            $i = 0; // Variable para alternar el color de la tarjeta
            foreach ($datosSeccion as $seccion) : 
            ?>
            <div class="b1-custom b1-color-<?php echo $i; ?>">
                <div class="b1-border"></div>
                <h1 style="font-size: 35px;"><?php echo $seccion["titulo"]; ?></h1>
                <img src="<?php echo $seccion["imagen"]; ?>" />
                <p style="color: black;"><?php echo $seccion["descripcion"]; ?></p>
                </div>
            <?php 
            // Alternar el color de la tarjeta
            $i = ($i + 1) % 4; 
            ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container">
    <h2 style="font-size: 48px; font-weight: bold; color: black; text-align: center;">¡Explora nuestro paraíso oculto!</h2>
    <p style="font-size: 24px; color: #666; text-align: center;">Descubre la magia de este lugar único. Sumérgete en la belleza natural y la tranquilidad que ofrecemos.</p>
    <div style="text-align: center; margin-top: 40px;">
        <a href="./reservaciones/index.php" class="btn btn-primary" style="font-size: 24px; ">Reserva tu experiencia</a>
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
