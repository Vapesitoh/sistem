<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <title>Iniciar Sesión</title>
 
</head>
<body>
<div class="login-box">
    <h2>Iniciar Sesión</h2>
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error-message">' . $_GET['error'] . '</p>';
    }
    ?>
    <form action="include/login.php" method="post">
        <div class="user-box">
            <input type="text" name="correo" required="">
            <label>Correo Electrónico</label>
        </div>
        <div class="user-box">
            <input type="password" name="contrasena" required="">
            <label>Contraseña</label>
        </div>
        <div class="btn-box">
            <input type="submit" value="Iniciar Sesión">
        </div>
    </form>
    <div class="btn-box">
        <a href="registro.php">¿No tiene cuenta? Regístrate</a>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
