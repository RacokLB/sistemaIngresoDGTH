<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href='../Public/style.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/f50bfae678.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="wrapper">
        <form method="POST">
            <?php
                require_once "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";
                require_once "/xampp/htdocs/sistemaIngresoDGTH/Models/controlador_cambioContraseña.php";
            ?>
            <h2>Cambio Contraseña</h2>
            <div class="input-box">
                <input type="text" placeholder="Usuario C.I" name="user" pattern="[0-9]{6,8}" minlength="6" maxlength="8" required>
                <i class="fa-solid fa-circle-user"></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Nueva Contraseña" autocomplete="on" minlength="4" maxlength="20" name="password" required>
                <i class="fa-solid fa-pen-nib"></i>
            </div>
            <input type="submit"  value="Cambiar" name="modificacionBtn" id="modificacionBtn" class="btn">
            <div class="register-link">
                <p>No tienes cuenta ? <a href="register_login.php">Registrarse</a></p>
            </div>
        </form>
    </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>