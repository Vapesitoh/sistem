<?php
include('./reservaciones/include/conexion.php');

$sql = "SELECT * FROM lugares WHERE Estado = 1";
$result = mysqli_query($conexion, $sql);

if ($result) {
    $lugares = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $lugares = array();
}

$num_tarjetas_a_mostrar = count($lugares);
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
    <link href="reservaciones/css/style.css" rel="stylesheet" />
    <link href="reservaciones/css/responsive.css" rel="stylesheet" />
    <link rel="stylesheet" href="reservaciones/css/style1.css">
</head>
<style>
    body {
  background: #150f21;
  font-size: 18px;
}

</style>
<body class="sub_page">
    <?php include 'reservaciones/web/navbarweb.php'; ?><br>

    <div class="container">
    <div class="row">
        <?php foreach ($lugares as $lugar): ?>
            <article class="postcard dark blue">
                <!-- Quitamos el enlace <a> que envuelve la imagen -->
                <img class="postcard__img" src="<?php echo 'reservaciones/' . $lugar['imagenes']; ?>" width="920" height="540" alt="<?php echo $lugar['titulo']; ?>">
                <div class="postcard__text">
                    <h1 class="postcard__title_blue" id="postcard__title_blue"><?php echo $lugar['titulo']; ?></a></h1>
                
                    <div class="postcard__bar"></div>
                    <div class="postcard__preview-txt">
                        <p></p>
                        <p><?php echo $lugar['descripcion']; ?></p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
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
