<?php
    if(session_status() == PHP_SESSION_NONE){
        if(session_start()){
            if(!isset($_SESSION['rol'])){
                header("location: login.php");
            }else{
                if($_SESSION['rol'] != 1){ // Es buena práctica usar '!=' en lugar de '!='
                    header("location: login.php");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dirección General de Talento Humano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link rel="stylesheet" href="../Public/stylepage.css">
    <link rel="stylesheet" href="../Public/slider.css">
    <style>
        :root {
            --color-primario-neutro: #f8f9fa; /* Gris muy claro / Blanco */
            --color-secundario-neutro: #e9ecef; /* Gris claro */
            --color-texto: #343a40; /* Gris oscuro para texto */
            --color-acento-1: #007bff; /* Azul brillante, formal pero llamativo */
            --color-acento-2: #28a745; /* Verde, para éxito/acción, también llamativo */
            --color-hover: #0056b3; /* Azul más oscuro para hover */
        }

        body {
            font-family: "Poppins";
            background-color: var(--color-primario-neutro);
            color: var(--color-texto);
        }

        
        .btn-primary {
            background-color: var(--color-acento-1);
            border-color: var(--color-acento-1);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--color-hover);
            border-color: var(--color-hover);
        }

        .btn-success {
            background-color: var(--color-acento-2);
            border-color: var(--color-acento-2);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838; /* Verde más oscuro para hover */
            border-color: #218838;
        }

        .jumbotron {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('../Public/images/hero-background.jpg') no-repeat center center/cover; /* Asegúrate de tener una imagen en esta ruta */
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 0;
        }

        .section-padding {
            padding: 60px 0;
        }

        .section-light-bg {
            background-color: var(--color-primario-neutro);
        }

        .section-dark-bg {
            background-color: var(--color-secundario-neutro);
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: var(--color-acento-1);
            color: white;
            font-weight: bold;
        }

        footer {
            background-color: var(--color-texto);
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        
        .list-unstyled li {
            padding: 5px 0;
            color: var(--color-texto);
        }

        .list-unstyled li::before {
            content: "✔"; /* Icono de check */
            color: var(--color-acento-2);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .jumbotron h1 {
                font-size: 2.5rem;
            }
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#"> <img src="../Public/images/logo-del-cne.jpg" class="d-inline-block align-text-center" width="50" height="40" > PODER ELECTORAL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">DGTH</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#nuestros-sistemas">Sistemas</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#beneficios">Mejoras</a>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true">Otras Opciones</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <section id="hero" class="jumbotron">
        <div class="container">
            
            <p class="lead">Gestión eficiente y transparente para el desarrollo de nuestro capital humano.</p>
            <a href="#nuestros-sistemas" class="btn btn-dark text-white btn-lg mt-3">Explorar Sistemas <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>

    <section id="direccion-general-de-talento-humano" class="section-padding section-light-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="../Public/images/dgth.jpg" class="img-fluid rounded shadow-sm" alt="Imagen de Gestión de Talento Humano">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-3">Dirección General de <span class="text-primary">Talento Humano</span></h2>
                    <p class="lead">La Dirección General de Talento Humano es un pilar fundamental en nuestra organización. Nos encargamos de la gestión integral del personal, desde la selección de profesionales altamente capacitados que comparten los valores institucionales, hasta la supervisión de su formación continua y el mantenimiento de un clima laboral óptimo que garantice su satisfacción y el cumplimiento de las metas.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="nuestros-sistemas" class="section-padding section-dark-bg bg-dark">
        <div class="container">
            <h2 class="text-center text-white mb-5">Nuestros <span class="text-success">Sistemas</span></h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header text-center bg-dark">
                            <i class="fas fa-user-plus fa-3x mb-3"></i>
                            <h4>Registro de Funcionarios</h4>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">Este aplicativo permite el registro, modificación y consulta de funcionarios activos y en proceso de ingreso al Consejo Nacional Electoral. Nace de la necesidad de alimentar nuestra base de datos con información veraz y completa sobre el funcionario y su núcleo familiar.</p>
                            <div class="mt-auto text-center">
                                <form action="crearFuncionario.php" method="GET">
                                    <input type="hidden" name="api" value="crearTrabajador">
                                    <button type="submit" class="btn btn-success mt-3 w-75">Ir al Aplicativo <i class="fas fa-external-link-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header text-center bg-dark">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <h4>Consulta y Modificación de Datos</h4>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">Accede y actualiza la información de los funcionarios de manera rápida y segura. Este sistema garantiza la integridad y disponibilidad de los datos esenciales para la gestión del talento humano.</p>
                            <div class="mt-auto text-center">
                                <form action="listarTrabajadores.php" method="GET">
                                    <input type="hidden" name="api" value="trabajador">
                                    <button type="submit" class="btn btn-warning mt-3 w-75">Ingresar <i class="fas fa-info-circle"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header text-center bg-dark">
                            <i class="fas fa-calendar-check fa-3x mb-3"></i>
                            <h4>Sistema para la Fe De Vida</h4>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-text">Facilita el proceso de verificación de la Fe de Vida de nuestros jubilados y pensionados, asegurando la continuidad de sus beneficios de manera eficiente y sin contratiempos.</p>
                            <div class="mt-auto text-center">
                                <button class="btn btn-primary mt-3 w-75">Información <i class="fas fa-info-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="beneficios" class="section-padding section-light-bg">
        <div class="container">
            <h2 class="text-center mb-5">Beneficios de Nuestros <span class="text-primary">Sistemas</span></h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ul class="list-unstyled fa-ul lead">
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Recaudación de información veraz y certera de los funcionarios.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Formularios estructurados para el almacenamiento eficiente de la información solicitada.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Rapidez y agilidad en la consulta de datos.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Creación de bases de datos interrelacionadas para nutrir a los distintos departamentos de la DGTH.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Facilidad en el manejo y actualización de la información.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Acceso oportuno y seguro a la información relevante.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Mejora significativa en los tiempos de respuesta.</li>
                        <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span> Resguardo confiable de la información en bases de datos robustas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="slider py-4 bg-light">
        <div class="slide-track">
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 1">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 2">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 3">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 4">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 5">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 6">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 7">
            </div>
            <div class="slide">
                <img src="../Public/images/logo del cne.png" alt="Marquesina CNE 8">
            </div>
        </div>
    </section>

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Dirección General de Talento Humano. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</body>
</html>