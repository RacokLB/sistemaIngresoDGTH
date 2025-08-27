<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INGRESO</title>
    <link rel="stylesheet" href="../Public/style.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

</head>

<body>

    <div class="wrapper">
        <form method="POST">
            <?php
                require_once "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";
                require_once "/xampp/htdocs/sistemaIngresoDGTH/Models/controlador_login.php";
            ?>
            <h1>Inicio de sesion</h1>
            <div class="input-box">
                <input type="text" placeholder="Username" name="user" pattern="[0-9]{6,8}" minlength="6" maxlength="8" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="password" autocomplete="on" minlength="4" maxlength="20" name="password" required>
                <i class='bx bxs-key'></i>
            </div>

            <input type="submit"  value="Ingresar" name="signupbtn" id="signupbtn" class="btn">
            <div class="register-link">
                <p>No tienes cuenta ? <a href="register_login.php">Registrarse</a></p>
            </div>
            <div class="register-link">
                <p>¿Se te olvido la contraseña?<a href="olvidoContraseña.php">¡Click Aqui!</a></p>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </body>
    
</html>



