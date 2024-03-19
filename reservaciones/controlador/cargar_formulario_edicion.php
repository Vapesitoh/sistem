<?php
// Incluir el archivo de conexión a la base de datos
include('../include/conexion.php');

// Verificar si se recibió el ID de la habitación
if(isset($_POST['id'])) {
    // Obtener el ID de la habitación
    $idHabitacion = $_POST['id'];

    // Consulta SQL para obtener los datos de la habitación
    $consulta = "SELECT * FROM habitaciones WHERE id = $idHabitacion";
    $resultado = mysqli_query($conexion, $consulta);

    // Verificar si se obtuvieron resultados
    if($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos de la habitación
        $habitacion = mysqli_fetch_assoc($resultado);

        // Generar el formulario de edición
        $formulario = '
            <form id="formulario-edicion">
                <input type="hidden" name="id" value="' . $habitacion['id'] . '">
                <div class="form-group">
                    <label for="tipo">Tipo de Habitación:</label>
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="Soltero" ' . ($habitacion['tipo'] == 'Soltero' ? 'selected' : '') . '>Soltero</option>
                        <option value="Familiar" ' . ($habitacion['tipo'] == 'Familiar' ? 'selected' : '') . '>Familiar</option>
                        <option value="Matrimonial" ' . ($habitacion['tipo'] == 'Matrimonial' ? 'selected' : '') . '>Matrimonial</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mascotas">Mascotas:</label>
                    <select class="form-control" id="mascotas" name="mascotas">
                        <option value="0" ' . ($habitacion['mascotas'] == '0' ? 'selected' : '') . '>Ninguna</option>
                        <option value="1" ' . ($habitacion['mascotas'] == '1' ? 'selected' : '') . '>1</option>
                        <option value="2" ' . ($habitacion['mascotas'] == '2' ? 'selected' : '') . '>2</option>
                        <option value="3" ' . ($habitacion['mascotas'] == '3' ? 'selected' : '') . '>3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="banos">Baños:</label>
                    <select class="form-control" id="banos" name="banos">
                        <option value="1" ' . ($habitacion['banos'] == '1' ? 'selected' : '') . '>1</option>
                        <option value="2" ' . ($habitacion['banos'] == '2' ? 'selected' : '') . '>2</option>
                        <option value="3" ' . ($habitacion['banos'] == '3' ? 'selected' : '') . '>3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="camas">Camas:</label>
                    <select class="form-control" id="camas" name="camas">
                        <option value="1" ' . ($habitacion['camas'] == '1' ? 'selected' : '') . '>1</option>
                        <option value="2" ' . ($habitacion['camas'] == '2' ? 'selected' : '') . '>2</option>
                        <option value="3" ' . ($habitacion['camas'] == '3' ? 'selected' : '') . '>3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (USD):</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="' . $habitacion['precio'] . '">
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        ';

        // Imprimir el formulario
        echo $formulario;
    } else {
        echo "No se encontró la habitación";
    }
} else {
    echo "No se recibió el ID de la habitación";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
