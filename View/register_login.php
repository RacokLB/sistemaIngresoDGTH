<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRO</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href='../Public/style.css' rel='stylesheet'>

</head>
<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h1>Registro</h1>
            <?php
            require_once "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";       
            include_once "/xampp/htdocs/sistemaIngresoDGTH/Models/controlador_register.php";
            ?>
            <div class="input-box">
                <input type="text" autocomplete="off"  placeholder="cedula de identidad" required name="cedula_identidad" id="cedula_identidad" minlength="7" maxlength="8" pattern="[0-9]{7,8}" title = "Indique numero de cedula . use solo numeros">
                <i class='bx bx-id-card'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Contraseña" name="password" minlength="4" maxlength="20" title="Tiene un minimo de 4 a un maximo de 20 caracteres" required>
                <i class='bx bxs-key'></i>
            </div>
            <input type="submit" value="Registrarse" class="btn" name="registerbtn">
            <div class="login-link">
                <p>Ya tienes una cuenta ? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>