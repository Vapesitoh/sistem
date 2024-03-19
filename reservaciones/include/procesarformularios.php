<?php
include('conexion.php');

function procesarFormulario($tabla)
{
    global $conexion;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_$tabla"])) {
        switch ($tabla) {
            case 'comida':
                $titulo_comida = $_POST['titulo_comida'];
                $descripcion_comida = $_POST['descripcion_comida'];
                $precio_comida = $_POST['precio_comida'];
                $categoria_comida = $_POST['categoria_comida'];

                $target_dir = "uploads/";
                $original_filename = basename($_FILES["imagenes_comida"]["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($_FILES["imagenes_comida"]["tmp_name"], $target_file);

                $sql = "INSERT INTO comida (titulo, imagenes, descripcion, precio, categoria) VALUES ('$titulo_comida', '$target_file', '$descripcion_comida', '$precio_comida', '$categoria_comida')";
                $conexion->query($sql);
                echo "Registro insertado correctamente.";
                break;

   

            case 'inicio':
                $titulo_inicio = $_POST['titulo_inicio'];
                $texto_inicio = $_POST['texto_inicio'];
                $descripcion_inicio = $_POST['descripcion_inicio'];

                $target_dir = "uploads/";
                $original_filename = basename($_FILES["imagen_inicio"]["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($_FILES["imagen_inicio"]["tmp_name"], $target_file);

                $sql = "INSERT INTO inicio (titulo, texto, imagen, descripcion) VALUES ('$titulo_inicio', '$texto_inicio', '$target_file', '$descripcion_inicio')";
                $conexion->query($sql);
                echo "Registro insertado correctamente.";
                break;

            case 'lugares':
                $titulo_lugares = $_POST['titulo_lugares'];
                $descripcion_lugares = $_POST['descripcion_lugares'];

                $target_dir = "uploads/";
                $original_filename = basename($_FILES["imagenes_lugares"]["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($_FILES["imagenes_lugares"]["tmp_name"], $target_file);

                $sql = "INSERT INTO lugares (titulo, imagenes, descripcion) VALUES ('$titulo_lugares', '$target_file', '$descripcion_lugares')";
                $conexion->query($sql);
                echo "Registro insertado correctamente.";
                break;

            case 'seccion':
                $titulo_seccion = $_POST['titulo_seccion'];
                $descripcion_seccion = $_POST['descripcion_seccion'];

                $target_dir = "uploads/";
                $original_filename = basename($_FILES["imagen_seccion"]["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($_FILES["imagen_seccion"]["tmp_name"], $target_file);

                $sql = "INSERT INTO seccion (titulo, imagen, descripcion) VALUES ('$titulo_seccion', '$target_file', '$descripcion_seccion')";
                $conexion->query($sql);
                echo "Registro insertado correctamente.";
                break;

            case 'tarjetas':
                $titulo_tarjetas = $_POST['titulo_tarjetas'];
                $descripcion_tarjetas = $_POST['descripcion_tarjetas'];

                $target_dir = "uploads/";
                $original_filename = basename($_FILES["imagen_tarjetas"]["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($_FILES["imagen_tarjetas"]["tmp_name"], $target_file);

                $sql = "INSERT INTO tarjetas (titulo, imagen, descripcion) VALUES ('$titulo_tarjetas', '$target_file', '$descripcion_tarjetas')";
                $conexion->query($sql);
                echo "Registro insertado correctamente.";
                break;

            default:
                echo "Tabla no reconocida.";
                break;
        }
    }
}

procesarFormulario('comida');
procesarFormulario('inicio');
procesarFormulario('lugares');
procesarFormulario('seccion');
procesarFormulario('tarjetas');
?>
