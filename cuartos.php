<!-- Archivo: cuartos.php -->
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
    <link href="./reservaciones/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./reservaciones/css/style.css" rel="stylesheet" />
    <link href="./reservaciones/css/responsive.css" rel="stylesheet" />
    <link href="./reservaciones/css/habi.css" rel="stylesheet">
    <style>
     
    </style>
</head>

<body class="sub_page">
    <?php include 'reservaciones/web/navbarweb.php'; ?><br>
    <div class="CONTAINER">
        <div class="container">
            <div class="row">
                <?php
                // Incluir el archivo de conexión
                include('./reservaciones/include/conexion.php');

                // Consulta para obtener los datos de la tabla 'habitaciones' con estado 1
                $query = "SELECT titulo, foto1, descripcion, banos, camas, mascotas, precio FROM habitaciones WHERE estado = 1";
                $resultado = $conexion->query($query);

                // Comprobar si hay resultados
                if ($resultado->num_rows > 0) {
                    // Directorio donde se encuentran las imágenes
                    $directorioImagenes = 'reservaciones/';

                    // Mostrar los resultados en el formato deseado
                    while ($fila = $resultado->fetch_assoc()) {
                        // Obtener la ruta almacenada en la base de datos
                        $rutaDesdeBD = $fila['foto1'];

                        // Construir la ruta completa a la imagen
                        $rutaCompleta = $directorioImagenes . $rutaDesdeBD;

                        // Mostrar la información y la imagen
                        echo '<div class="col-md-8 col-lg-8 mx-auto">

                                <div id="container">
                                    <div class="product-details">
                                        <h1> ' . $fila['titulo'] . '</h1>
                                     
                                        <h5 class="information">' . $fila['descripcion'] . '</h5>
                                        <div class="control">
                                            <button class="btn">
                                                <span class="price">$' . $fila['precio'] . '</span>
                                                <span class="shopping-cart"><i class="fa fa-shopping-cart" aria-hidden=""></i></span>
                                                <span class="buy">Valor</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-image">
                                        <img src="' . $rutaCompleta . '" alt="">
                                        <div class="info">
                                            <h2>Informacion</h2>
                                            <ul>
                                                <li><strong>Camas : </strong>' . $fila['camas'] . '</li>
                                                <li><strong>Baños : </strong>' . $fila['banos'] . '</li>
                                                <li><strong>Mascotas: </strong>' . $fila['mascotas'] . '</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                } else {
                    echo '<div class="col-md-12">No se encontraron habitaciones.</div>';
                }

                // Cerrar la conexión a la base de datos
                $conexion->close();
                ?>
            </div>
        </div>
    </div>

    <script src="reservaciones/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="reservaciones/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <script src="reservaciones/js/custom.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
    <?php include 'reservaciones/web/footer.php'; ?>
</body>

</html>
