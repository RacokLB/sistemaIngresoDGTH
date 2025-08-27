<?php
/*
        //here we open the session from the user
        session_start();
        //here we verified if the field "id" is empty the user cannot enter into the index page 
        if (!isset($_SESSION['rol'])){
            header(header:'location: login.php');
        }else{
            if($_SESSION['rol'] != 1){
                header(header:'location: login.php');
            }
        }
            */
        // Incluye tus archivos de configuración de la base de datos
        require_once 'Config/abrir_conexion.php'; // Asegúrate de que este archivo exista y configure la conexión PDO

        require_once 'Enrutador/enrutador.php';
        require_once 'Controllers/TrabajadorController.php'; // Asegúrate de que la ruta sea correcta
        require_once 'Models/Repositories/trabajadorRepository.php'; // Asegúrate de que la ruta sea correcta
        require_once 'Models/Entities/Trabajador.php'; // Asegúrate de que la ruta sea correcta


        //Obten la conexion PDO

        $database = new Database();
        $pdo = $database->getPDO();
        $error = $database->getError();

        //Instancia el enrutador, pasando la conexion PDO
        $enrutador = new Enrutador($pdo);
        $enrutador->enrutar();//llama al metodo principal del enrutador
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direccion General de Talento Humano</title>
    <link rel="stylesheet" href="public/stylepage.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="public/slider.css">
</head>
 <body>
    <header>
        <div class="container">
            <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&cad=rja&uact=8&ved=2ahUKEwjrs8bLyYeGAxU2TTABHY_PAgEQFnoECAYQAQ&url=http%3A%2F%2Fwww.cne.gob.ve%2F&usg=AOvVaw0UvMM7uR5qWwVdCBPXIVeX&opi=89978449" target="_blank" rel="noopener noreferrer" class="logo">
            <img src="public/images/logo-del-cne.jpg" alt="logo del CNE">
            </a>
            <h1>PODER ELECTORAL</h1>
            <nav>
                <a href="#Direccion-general-de-talento-humano">Direccion General de Talento Humano</a>
                <a href="#Nuestros-departamentos">Nuestros Proyectos</a>
                <a href="#caracteristicas">Beneficios de nuestros Proyectos</a>
                <a href="controlador/controlador_cerrar_session.php" name="salir" value="5">Salir</a>
                <?php
                echo "ID de inicio de sesion: ".$_SESSION["rol"]."<br>"." ". "cedula del usuario :  ".$_SESSION["user"];
                ?>
            </nav>
        </div>
    </header>
    <section id="hero">
        <h1 class="border"><br></h1>

    </section>
    <section id="Direccion-de-talento-humano">
        <div class="container">
       
          <div class="img-container"></div>
          <h2>Direccion General de <span class="color-acento">Talento Humano</span></h2>
          <p>La Direccion General de Talento Humano es una de las áreas clave de la organizacion ya que se encarga de la gestión del personal. No solo selecciona a los profesionales más capacitados que compartan los valores de la institucion, sino que también supervisa su formación y se asegura de mantener un clima laboral adecuado que garantice su satisfacción y el cumplimiento de las actividades</p>
          </div>
    </section>
<!-----------------nuestros departamentos------------------>
    <section id="Nuestros-departamentos">
        <div class="container">
          <h2>Nuestros Sistemas</h2>
          <div class="programas">
          <div class="carta">
            <h3>Aplicativo para el registro de funcionarios</h3>
            <p>El desarrollo de este aplicativo tiene como fin el registro, modificacion y consulta de los funcionarios que se encuentran laborando dentro del Consejo Nacional Electoral y en proceso de ingreso al organismo, nace de la necesidad de alimentar la data de nuestro departamento con informacion veraz sobre el funcionario y de su nucleo familiar</p>
            <!--para que este boton nos redirija a un link es necesario envolverlo en un form y action agregar el link de la pagina a donde queremos redirigir al usuario-->
            <form action="View/crearFuncionario.php" method="GET">
                <input type="hidden" name="api" value="crearTrabajador">
                <button type="submit" >Ir al Aplicativo</button>
            </form>
          </div>
<!--------------- Direccion de Desarrollo Personal---------------->
          <div class="carta">
            <h3>Sistema de Reestructuracion de Cargos</h3>
            <p>El desarrollo de personal es el proceso de mejorar las aptitudes y competencias que tus empleados ya tienen, y de enseñarles otras nuevas, con el objetivo de que profundicen en sus intereses personales y contribuyan a los objetivos de tu empresa</p>
            <form action="">
                <input type="hidden" name="api" value="trabajador">
                <button type="submit">Informacion</button>
            </form>
            
          </div>
<!------------------Direccion de Remuneraciones----------------------->
          <div class="carta">
            <h3>Sistema para la Fe De Vida</h3>
            <p>El área de remuneraciones es la que prepara las liquidaciones mensuales de los trabajadores, procesando todos los incidentes que pueden hacer variar tu pago mensual.</p>
            <button>Informacion</button>
          </div>
          </div>
        </div>
    </section>
<!------------------------ seccion de ventajas ---------------------->

<!------------- Seccion de ventajas del sistema de jornada ----->
    <section id="caracteristicas">
        <div class="container">  
        <label><h2>Aspectos positivos del Aplicativo para el registro de funcionarios <br> </h2></label>
        <ul>
        <li>✅​Recaudacion de informacion veraz y certera de los funcionarios</li>
        <li>✅​Formulario estructurado para el almacenamiento de la informacion solicitada</li>
        <li>✅​Rapidez en la consulta</li>
        <li>✅Creacion de Bases de datos interrelacionadas para asi nutrir los distintos departamentos de la DGTH</li>
        <li>✅​Facil manejo de la informacion </li>
        <li>✅​Acceso oportuno a la informacion</li>
        <li>✅​Mejora en los tiempos de respuesta</li>
        <li>✅Resguardo de la informacion en bases de datos</li>
        </ul>
        </div>
    </section>
<!---------------------marquesina de la pagina--------------------------->
    <section class="slider">

        <div class="slide-track">
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>

            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
            <div class="slide">
                <img src="public/images/logo del cne.png" alt="marquesina">
            </div>
        </div>
    </section>
<!-------------------- pie de pagina -------------------->
    <footer>
        <div class="container">            
            <p>&copy; Direccion General De Talento Humano</p>
        </div>
    </footer>
 </body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</html>