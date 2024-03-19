<?php
include('./reservaciones/include/conexion.php');

$categoria_filtrada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$categoria_filtrada = mysqli_real_escape_string($conexion, $categoria_filtrada);

$sql = "SELECT * FROM comida WHERE estado = 1";
if (!empty($categoria_filtrada)) {
    $sql .= " AND categoria = '$categoria_filtrada'";
}

$result = $conexion->query($sql);

$colores = array(
    'Desayunos' => 'green',
    'Almuerzos' => 'orange',
    'Meriendas' => 'blue'
);
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
</head>
<style>
    body {
  background: #150f21;
  font-size: 18px;
}
label {
            color: white;
        }
h2{
    color: #ffff;
}
</style>

<body class="sub_page">
    <?php include 'reservaciones/web/navbarweb.php'; ?>

    <section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Menu</h2>
        </div>

        <div class="container">
            <div class="xd">
                <!-- Formulario de filtrado -->
                <form action="" method="get" class="mb-3">
                    <label for="categoria">Filtrar por categoría:</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Todos</option>
                        <option value="Desayunos">Desayunos</option>
                        <option value="Almuerzos">Almuerzos</option>
                        <option value="Merienda">Merienda</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="filters-content">
                        <div class="row grid">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $categoria_class = strtolower(str_replace(' ', '-', $row['categoria']));
                                    $color = isset($colores[$row['categoria']]) ? $colores[$row['categoria']] : 'black';

                                    echo "<div class='col-sm-6 col-lg-4 all {$categoria_class}'>
                                            <div class='box'>
                                                <div>
                                                    <div class='img-box'>
                                                        <img src='reservaciones/{$row['imagenes']}' alt='{$row['titulo']}' class='img-fluid' />
                                                    </div>
                                                    <div class='detail-box'>
                                                        <h5>{$row['titulo']}</h5>
                                                        <div class='category-box' style='background-color: {$color}'>{$row['categoria']}</div>
                                                        <p>{$row['descripcion']}</p>
                                                        <div class='options'>
                                                            <div class='price-box'>
                                                                <h6>{$row['precio']} $</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                }
                            } else {
                                echo "No hay platos en el menú.";
                            }
                            $conexion->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .price-box {
    background-color: #ffcc00; /* Color de fondo del recuadro */
    padding: 5px 10px; /* Ajuste de relleno para el espacio interior del recuadro */
    border-radius: 5px; /* Bordes redondeados para suavizar la apariencia */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra para destacar el recuadro */
    text-align: center; /* Centrar el texto dentro del recuadro */
}
.price-box h6 {
    color: #ffffff; /* Color del texto */
    font-size: 18px; /* Tamaño de la fuente */
    font-weight: bold; /* Negrita */
    text-align: center; /* Centrar el texto */
    margin: 0; /* Eliminar cualquier margen predeterminado */
}
</style>

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
