<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Registro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="register-box">
    <h2>Registro</h2>
    <form id="registroForm">
        <div class="user-box">
            <input type="text" name="nombres" required="">
            <label>Nombres</label>
        </div>
        <div class="user-box">
            <input type="text" name="numero_telefono" required="">
            <label>Número de Teléfono</label>
        </div>
        <div class="user-box">
            <input type="text" name="cedula" required="">
            <label>Cédula</label>
        </div>
        <div class="user-box">
            <input type="email" name="correo" required="">
            <label>Correo Electrónico</label>
        </div>
        <div class="user-box">
            <input type="password" name="contrasena" required="">
            <label>Contraseña</label>
        </div>
        <div class="btn-box">
            <input type="submit" value="Registrarse">
        </div>
    </form>
    <div class="btn-box">
        <a href="index.php">¿Ya tiene cuenta? Inicie sesión ahora</a>
    </div>
</div><br>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#registroForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'include/registro.php',
            data: $(this).serialize(),
            success: function(response){
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "registro.php";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        });
    });
});
</script>
</html>
