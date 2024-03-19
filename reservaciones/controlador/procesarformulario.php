<?php
include('include/conexion.php');

function procesarFormulario($accion)
{
    global $conexion;
    
    // Procesar formulario de habitaciones
    if ($accion == 'habitaciones') {
        if(isset($_POST['titulo'],$_POST['descripcion'],$_POST['precio'], $_POST['tipo'], $_POST['camas'], $_POST['mascotas'], $_POST['banos'])) {
            // Obtener los datos del formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $tipo_habitacion = $_POST['tipo'];
            $numero_camas = $_POST['camas'];
            $mascotas = isset($_POST['mascotas']) ? min($_POST['mascotas'], 3) : 0;
            $bano = $_POST['banos'];

            // Procesar la carga de imágenes
            $target_dir = "uploads/";
            $target_files = array();
            foreach ($_FILES as $key => $file) {
                $original_filename = basename($file["name"]);
                $unique_filename = uniqid() . "_" . $original_filename;
                $target_file = $target_dir . $unique_filename;
                move_uploaded_file($file["tmp_name"], $target_file);
                $target_files[] = $target_file;
            }

            // Insertar datos en la base de datos
            $sql = "INSERT INTO habitaciones (titulo, descripcion, foto1, foto2, foto3, precio, tipo, camas, mascotas, banos) 
                    VALUES ('$titulo', '$descripcion', '$target_files[0]', '$target_files[1]', '$target_files[2]', '$precio', '$tipo_habitacion', '$numero_camas', '$mascotas', '$bano')";
            if ($conexion->query($sql) === TRUE) {
                echo "Registro insertado correctamente.";
            } else {
                echo "Error al insertar registro: " . $conexion->error;
            }
        } else {
            echo "Faltan campos requeridos.";
        }
    }
}

// Llamada a la función para procesar el formulario de habitaciones
procesarFormulario('habitaciones');
?>
