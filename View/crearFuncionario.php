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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="../Public/styleTable.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/f50bfae678.js" crossorigin="anonymous"></script>
    
    
    <style>
        .formulario-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        .form-section {
            display: none;
            /* Ocultar todas las secciones por defecto */
        }

        .form-section.current {
            display: block;
            /* Mostrar la sección actual */
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<?php

include_once "../Config/abrir_conexion.php";

$queryCargo = $pdo->prepare(query: "SELECT cod_cargo, desc_cargo FROM cargos");
$queryCargo->execute();

$queryDirector = $pdo->prepare(query: "SELECT codigo_cargo, nombre_cargoD FROM tabla_cargodirectores");
$queryDirector->execute();

$queryEstado = $pdo->prepare(query: "SELECT ID, state FROM estados");
$queryEstado->execute();

$queryDireccionGeneral = $pdo->prepare(query: "SELECT cod_ubicadmin, desc_ubicadmin FROM ubicadmin");
$queryDireccionGeneral->execute();

$queryDireccionEspecifica = $pdo->prepare(query: "SELECT cod_ubicafisica, desc_ubicafisica FROM ubicafisica");
$queryDireccionEspecifica->execute();

$queryAcademico = $pdo->prepare("SELECT id, grado_academico FROM tabla_instruccion");
$queryAcademico->execute();


$querySede = $pdo->prepare("SELECT codigo_sede, nombre_sede FROM tabla_sede");
$querySede->execute();



?>

<body>
    <div class="wrapper">
        <!--NAV BAR-->
        <aside id="sidebar" class="js-sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="#">CNE</a>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Elementos analista
                    </li>
                    <li class="sidebar-item">
                        <a href="../index.php" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            CNE
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="principalPagina.php" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Pagina de Inicio
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-solid fa-file-lines pe-2"></i>
                            Modulos
                        </a>
                        <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="listarTrabajadores.php" class="sidebar-link">Consulta Funcionarios & Actualizacion</a>
                            </li>
                            <li class="sidebar-item">    
                                <a href="listarParientes.php" class="sidebar-link">Consulta Parientes & Actualizacion</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-target="#auth" data-bs-toggle="collapse"
                            aria-expanded="false"><i class="fa-regular fa-user pe-2"></i>
                            USUARIO
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="login.php" class="sidebar-link">Ingreso</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="registerLogin.php" class="sidebar-link">Registrarse</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="olvidoContraseña.php" class="sidebar-link">Cambiar la contraseña</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <img src="../Public/images/logo-del-cne.jpg" class="avatar img-fluid rounded" alt="Logotipo del CNE">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <ol class="list-group">
                                    <li class="list-group-item"><?php 
                                              echo "C.I -" . $_SESSION['user'] . " " . "Analista"
                                            ?></li>
                                </ol>
                                
                                <a href="../Models/controlador_cerrar_session.php" class="dropdown-item">Salir</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <br>
            <main class="col-12 px-3">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h1 class="fw-bold text-center">Carga de Funcionarios</h1>
                    </div>
                    <div class="row shadow-lg">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration bg-dark shadow-lg border-radius">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-8 col-md-10">
                                            <!-- Button modal de registros -->
                                            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-list"></i>
                                            Registros
                                            </button>
                                            <!---- Button modal de Total por sede --->
                                            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"><i class="fa-solid fa-chart-simple"></i>
                                            Estadisticas por sede
                                            </button>
                                            <!--- Button modal de total trabajadores & parientes--->
                                            <button type="button" class="btn btn-dark btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdrop3"><i class="fa-solid fa-magnifying-glass-chart"></i>
                                            Personal & Parientes
                                            </button>
                                            <!-- Modal de registros -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h1 class="modal-title fs-4"  id="staticBackdropLabel">Ultimos registros realizados</h1>
                                                    <button type="button" class="btn-close bg-white border border-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body fs-5" id="reporte">
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss ="modal" >Revisado</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <!-- Modal de estadisticas -->
                                            <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h1 class="modal-title fs-4"  id="staticBackdropLabel">Personal por Sede</h1>
                                                    <button type="button" class="btn-close bg-white border border-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body fs-6" id="totales">
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss ="modal">Revisado</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <!-- Modal de total personas -->
                                            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h1 class="modal-title fs-4"  id="staticBackdropLabel">Trabajadores & Parientes</h1>
                                                    <button type="button" class="btn-close bg-white border border-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body fs-6" id="totalPersonas">
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss ="modal">Revisado</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col align-self-end text-end" >
                                            <div class="card shadow-lg">
                                                <div class="card-header ">
                                                    <div class="card-body fs-6" id="reporte">
                                                        <canvas id="myChart" class="bg-light"></canvas>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container formulario-container">
                            <h1>Registro de Funcionario</h1>
                            <div class="progress-container">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                <br>
                                </div>
                            </div>
                            <form id="personaForm" action="/sistemaIngresoDGTH/index.php?Controllers=trabajadorController&api=crearTrabajador" method="POST">
                                <!--- FIELD DATOS Identificación--->
                                <div id="step1" class="form-section current">
                                    <input type="hidden" id="parientesArray" name="parientesArray">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Datos de Identificación</h2>
                                    <!--FIELD NACIONALIDAD & CEDULA--->
                                    <div class="form-group mb-4 col-md-6">
                                        <label for="cedula" class="form-label fs-6">Nacionalidad & Cedula <i class="fa-solid fa-address-card"></i></label>
                                        <div class="input-group mb-3">
                                                <select id="nacionalidad" class="form-select bg-dark text-white" aria-describedby="nacionalidadHelpInline" name="nacionalidad" required>
                                                    
                                                    <option value="V" selected>Venezolano</option>
                                                    <option value="E">Extranjero</option>
                                                </select>
                                            
                                            <input type="text" id="cedula" class="form-control" aria-describedby="cedulaHelpInline" name="cedula" placeholder="Cedula" minlength="7" maxlength="8" required autocomplete="off">
                                            
                                        </div>
                                        <div id="cedulaError" class="alert"></div>
                                    </div>

                                    <!--- FIELD NOMBRES & APELLIDOS--->
                                    <div class="form-group">
                                        <div class="input-group row-md-3 mb-3">
                                            <span class="input-group-text bg-dark text-white">Nombres & Apellidos</span>
                                            <input type="text" aria-label="First name" class="form-control" name="nombre" id="nombre" placeholder="Nombres..." required >
                                            <input type="text" aria-label="Last name" class="form-control" name="apellido" id="apellido" placeholder="Apellidos..." required >
                                        </div>
                                    </div>
                                    <!--- FIELD RIF--->
                                    <div class="form-group col-md-3">
                                        <label for="rif" class="form-label fs-6">Rif <i class="fa-solid fa-address-card"></i></label>
                                        <input type="text" id="rif" class="form-control mb-3" aria-describedby="rifHelpInline" name="rif" minlength="7" maxlength="9" placeholder="J-xxx-xxx-xxx-x" autocomplete="off" >
                                    </div>

                                    <!---- FIELD BUTTON---->
                                    <button type="button" class="btn btn-primary next-step">Siguiente</button>
                                </div>
                                <!---- FIELD DATOS LABORALES--->
                                <div id="step2" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Datos Personales del funcionario</h2>
                                    <!--- FIELD FECHA DE NACIMIENTO--->
                                    <div class="form-group col-md-3">
                                        <label for="fechaNacimiento" class="form-label fs-6">Fecha de Nacimiento <i class="fa-solid fa-calendar-days"></i></label>
                                        <input type="date" class="form-control mb-3" id="fechaNacimiento" name="fechaNacimiento" required>
                                    </div>
                                    <!--- FIELD SEXO--->
                                    <div class="form-group mb-3 col-md-4">
                                        <label for="genero" class="form-label fs-6">Genero <i class="fa-solid fa-venus-mars"></i></label>
                                        <select class="form-control mb-3" id="genero" name="genero" required>
                                            <option selected>Seleccionar</option>
                                            <option value="M">Masculino </option>
                                            <option value="F">Femenino </option>
                                        </select>
                                    </div>
                                    <!--- FIELD Discapacidad--->
                                    <div class="form-group mb-4 col-md-5">
                                        <label for="discapacidad" class="form-label fs-6">Discapacidad: <i class="fa-solid fa-wheelchair"></i></label>
                                        <select class="form-control" id="discapacidad" name="discapacidad" required>
                                            <option value="">Seleccione una opción</option>
                                            <option value="ninguna">Ninguna</option>
                                            <option value="fisica">Física</option>
                                            <option value="visual">Visual</option>
                                            <option value="auditiva">Auditiva</option>
                                            <option value="intelectual">Intelectual</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                    </div>
                                    <!--- FIELD ESTADO CIVIL--->
                                    <div class="form-group mb-4 col-md-5">
                                        <label for="estadoCivil"class="form-label fs-6">Estado Civil: <i class="fa-solid fa-user-group"></i></label>
                                        <select class="form-control" id="estadoCivil" name="estadoCivil" required>
                                            <option selected>Seleccione una opción</option>
                                            <option value="soltero">Soltero(a)</option>
                                            <option value="casado">Casado(a)</option>
                                            <option value="divorciado">Divorciado(a)</option>
                                            <option value="viudo">Viudo(a)</option>
                                            <option value="union_estable_de_hechos">Unión Estable de Hechos</option>
                                        </select>
                                    </div>
                                    <!--- FIELD BUTTONS--->
                                    <button type="button" class="btn btn-secondary prev-step mb-3">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step mb-3">Siguiente</button>
                                </div>
                                <div id="step3" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Datos Laborales</h2>    
                                    <!--- FIELD TIPO TRABAJADOR--->
                                    <div class="form-group col-md-4">
                                        <label for="tipoTrabajador" class="form-label fs-6" >Tipo de Trabajador <i class="fa-solid fa-arrows-down-to-people"></i></label>
                                        <select class="form-control col-md-9 mb-3" id="tipoTrabajador" name="tipoTrabajador" required>
                                            <option selected>Abre este menu</option>
                                            <option value="AN">Alto Nivel</option>
                                            <option value="CON">Contratado</option>
                                            <option value="CS">Comision de Servicio</option>
                                            <option value="EMP">Empleado</option>
                                        </select>
                                    </div>
                                    <!---- FIELD ESTATUS TRABAJADOR--->
                                    <div class="form-group col-md-4">
                                        <label for="estatus"class="form-label fs-6">Estatus del Trabajador <i class="fa-solid fa-clipboard-user"></i></label>
                                        <select class="form-control col-md-9 mb-3" id="estatus" name="estatus" >   
                                            <option selected>Abre este menu</option>
                                            <option value="A">Activo</option</option>            
                                            <option value="J">Jubilado</option>
                                            <option value="S">Suspendido</option>
                                        </select>
                                    </div>
                                    <!---- FIELD COMPANIA ---->
                                    <div class="form-group col-md-4">
                                        <label for="compania"class="form-label fs-6">Compañia <i class="fa-solid fa-landmark"></i></label>
                                        <select class="form-control col-md-9 mb-3" id="compania" name="compania">
                                            <option selected>Abre este menu</option>
                                            <option value="1">activos</option>
                                            <option value="2">jubilados</option>
                                            <option value="4">suspendidos</option>
                                            <option value="5">obreros</option>
                                        </select>
                                    </div>
                                    <!---- N° DE CONTACTO--->
                                    <div class="form-group col-md-3">
                                        <label for="numeroContacto" class="form-label fs-6">Número de Contacto <i class="fa-solid fa-tty"></i></label>
                                        <input type="tel" class="form-control col-md-8 mb-3" id="numeroContacto" name="numeroContacto" placeholder="xxxx-xxxxxxx" autocomplete="off">
                                    </div>
                                    <!--- FIELD BUTTONS--->
                                    <button type="button" class="btn btn-secondary prev-step mb-3">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step mb-3">Siguiente</button>
                                </div>
                                <!--- FIELD INFORMACION RELEVANTE--->
                                <div id="step4" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Información Laboral</h2>
                                    <!--- FIELD TIPO DE CARGO--->
                                    <div class="form-group col-md-7 mb-3">
                                        <label for="codCargo" class="form-label fs-6">Cargo del Funcionario <i class="fa-solid fa-people-group"></i></label>
                                        <select class="form-control" style="width: 50%" aria-describedby="cod_cargoHelpInline" id="codCargo" name="codCargo" required>
                                            <option selected>Abre este menu</option>
                                            <?php
                                            while ($row = $queryCargo->fetch(mode: PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $row['cod_cargo']; ?>"><?php echo $row['desc_cargo']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!---- FIELD CodCargoDirector --->
                                    <div class="form-group col-md-7 mb-3">
                                        <label for="cargoDirector" class="form-label fs-6">Cargo Director <i class="fa-solid fa-user-plus"></i></label>
                                        <select name="cargoDirector" style="width: 50%" class="form-control mb-3" id="cargoDirector" >
                                            <option selected value="0">Abre este menu</option>
                                            <?php
                                            while($row = $queryDirector->fetch(mode: PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $row['codigo_cargo'];?>"><?php echo $row['nombre_cargoD'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--- FIELD FECHA DE INGRESO--->
                                    <div class="form-group col-md-3">
                                        <label for="fechaIngreso" class="form-label fs-6">Fecha de Ingreso <i class="fa-solid fa-calendar-day"></i></label>
                                        <input type="date" class="form-control mb-3" id="fechaIngreso" name="fechaIngreso" >
                                    </div>
                                    
                                    <!--- FIELD BUTTONS--->
                                    <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step">Siguiente</button>
                                </div>
                                <!--- FIELD PARIENTES--->
                                <div id="family-info" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Información Familiar</h2>
                                
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPariente">Agregar Pariente</button>
                                    <!--- FIELD PARIENTES REGISTRADOS-->
                                    <div id="parientes-container">
                                        
                                        <h4>Parientes Registrados: <i class="fa-solid fa-users-rays"></i></h4>
                                        <ul id="lista-parientes">
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step">Siguiente</button>
                                </div>
                                <!--- FIELD UBICACION--->
                                <div id="step5" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Ubicación Geográfica</h2>
                                    <!--- FIELD ESTADO--->
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="estado" class="form-label fs-6">Estado <i class="fa-solid fa-map"></i></label>
                                        <select class="form-control" id="estado" name="estado" required>
                                            <option selected>Abra este menu</option>
                                            <?php
                                            while ($row = $queryEstado->fetch(mode: PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $row['ID']; ?>"><?php echo $row['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--- FIELD CIUDAD--->
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="ciudad" class="form-label fs-6">Ciudad <i class="fa-solid fa-city"></i></label>
                                        <select class="form-control" id="ciudad" name="ciudad">
                                            <option></option>
                                        </select>
                                    </div>
                                    <!--- FIELD MUNICIPIO--->
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="municipio" class="form-label fs-6">Municipio <i class="fa-solid fa-landmark"></i></label>
                                        <select class="form-control" id="municipio" name="municipio">
                                            <option></option>
                                        </select>
                                    </div>
                                    <!--- FIELD PARROQUIA--->
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="parroquia" class="form-label fs-6">Parroquia <i class="fa-solid fa-archway"></i></label>
                                        <select class="form-control" id="parroquia" name="parroquia">
                                            <option></option>
                                        </select>
                                    </div>
                                    <!--- FIELD DIRECCION PARTICULAR --->
                                    <div class="form-group mb-3">
                                        <label for="direccion">Dirección de la residencia <i class="fa-solid fa-address-book"></i></label>
                                        <textarea class="form-control" id="direccion" name="direccion" ></textarea>
                                    </div>
                                    <!-- FIELD BUTTONS--->
                                    <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                                    <button type="button" class="btn btn-primary next-step">Siguiente</button>
                                </div>
                                <!-- FIELD UBICACION LABORAL--->
                                <div id="step6" class="form-section">
                                    <h2 class="card-subtitle mb-4 text-body-secondary">Ubicacion Laboral</h2>
                                    <!--- FIELD DIRECCION GENERAL--->
                                    <div class="form-group mb-3 col-md-4 mb-3">
                                        <label for="ubicacionGeneral" class="form-label fs-6">Direccion General <i class="fa-solid fa-people-roof"></i></label>
                                        <select class="form-control" id="ubicacionGeneral" style="width: 75%" name="ubicacionGeneral" required>
                                            <option value="">Seleccione</option>
                                            <?php while ($row = $queryDireccionGeneral->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $row['cod_ubicadmin']; ?>"><?php echo $row['desc_ubicadmin']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--- FIELD DIRECCION ESPECIFICA--->
                                    <div class="form-group mb-3 col-md-4 mb-3">
                                        <label for="ubicacionEspecifica" class="form-label fs-6">Ubicacion Especifica <i class="fa-solid fa-people-roof"></i></label>
                                        <select class="form-control" id="ubicacionEspecifica" style="width: 75%" name="ubicacionEspecifica" required > 
                                            <option value="">Seleccione</option>
                                            <?php
                                            while ($row = $queryDireccionEspecifica->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?php echo $row['cod_ubicafisica']; ?>"><?php echo $row['desc_ubicafisica']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!---FIELD INSTRUCCION-->
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="instruccion" class="form-label fs-6">Grado Academico <i class="fa-solid fa-user-graduate"></i></label>
                                        <select class="form-control" id="instruccion" name="instruccion" >
                                            <option selected>Abra este menu</option>
                                            <?php
                                            while ($row = $queryAcademico->fetch()) { ?>
                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['grado_academico']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!--- FIELD SEDE--->
                                    <div class="form-group mb-3 col-md-4">
                                        <label for="ubicacion" class="form-label fs-6">Sede <i class="fa-solid fa-school-flag"></i></label>
                                        <select name="ubicacion" class="form-control" id="ubicacion" required>
                                            <option value=""></option>
                                            <?php while($row = $querySede->fetch()) { ?>
                                            <option value="<?php echo $row['codigo_sede'];?>"><?php echo $row['nombre_sede'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!-- FIELD BUTTONS-->
                                    <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                                    <button type="submit" class="btn btn-success"  id="registrarTrabajador" name="registrarTrabajador">Enviar Formulario</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal fade" id="modalPariente" tabindex="-1" aria-labelledby="modalParienteLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark">
                                        <h4 class="modal-title fw-bold text-white" id="modalParienteLabel">Registrar Pariente</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formPariente">
                                            <div class="form-group mb-3">
                                                <label for="cedulaTrabajador" class="form-label fs-6">Cedula del Trabajador: <i class="fa-solid fa-address-card"></i></label>
                                                <input type="text" class="form-control" pattern="[0-9]{6,8}" required minlength="7" maxlength="8" id="cedulaTrabajador" placeholder="Ingrese cedula del Trabajador" name="trabajadorId">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cedulaPariente" class="form-label fs-6">Cedula del Pariente (Opcional): <i class="fa-regular fa-address-card"></i></label>
                                                <input type="text" class="form-control" pattern="[0-9]{6,8}" minlength="6" maxlength="8" id="cedulaPariente" placeholder="Ingrese cedula del Pariente (opcional)" name="cedulaPariente">
                                            </div>
                                            <div id="cedulaParienteError">

                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="nombrePariente" class="form-label fs-6">Nombre del Pariente: <i class="fa-solid fa-id-card-clip"></i></label>
                                                <input type="text" class="form-control" id="nombrePariente" required placeholder="Ingrese el nombre del pariente" name="nombrePariente" >
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="apellidoPariente" class="form-label fs-6">Apellido del Pariente: <i class="fa-solid fa-id-card-clip"></i></label>
                                                <input type="text" class="form-control" id="apellidoPariente" required placeholder="Ingrese el apellido del pariente" name="apellidoPariente" >
                                            </div>
                                            <!-- FIELD FECHA NACIMIENTO--->
                                            <div class="form-group mb-3">
                                                <label for="fechaNacimientoPariente" class=" form-label fs-6">Fecha de Nacimiento: <i class="fa-regular fa-calendar-days"></i></label>
                                                <input type="date" class="form-control" id="fechaNacimientoPariente" required name="fechaNacimientoPariente">
                                            </div>
                                            <!--- FIELD PARENTESCO--->
                                            <div class="form-group mb-3">
                                                <label for="parentesco" class="form-label fs-6">Parentesco: <i class="fa-solid fa-users"></i></label>
                                                <select class="form-control" id="parentesco" name="parentesco" required >
                                                    <option value="">Seleccione el parentesco</option>
                                                    <option value="padre">Padre</option>
                                                    <option value="madre">Madre</option>
                                                    <option value="hijo">Hijo</option>
                                                    <option value="hija">Hija</option>
                                                    <option value="esposo">Esposo</option>
                                                    <option value="esposa">Esposa</option>
                                                    <option value="abuelo">Abuelo</option>
                                                    <option value="abuela">Abuela</option>
                                                    <option value="otro">Otro</option>
                                                </select>
                                            </div>
                                            <!--- FIELD GENERO DEL PARIENTE--->
                                            <div class="form-group mb-3">
                                                <label for="generoPariente" class="form-label fs-6">Genero <i class="fa-solid fa-venus-mars"></i></label>
                                                <select name="generoPariente" id="generoPariente" class="form-control" required>
                                                    <option value="O">Seleccione</option>
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Femenino</option>
                                                </select>
                                            </div>
                                            <!--- FIELD DISCAPACIDAD--->
                                            <div class="form-group mb-3">
                                                <label for="discapacidad" class="fs-6">Discapacidad: <i class="fa-solid fa-wheelchair"></i></label>
                                                <select class="form-control" id="discapacidadPariente" name="discapacidadPariente" required>
                                                    <option value="">Seleccione una opción</option>
                                                    <option value="ninguna">Ninguna</option>
                                                    <option value="fisica">Física</option>
                                                    <option value="visual">Visual</option>
                                                    <option value="auditiva">Auditiva</option>
                                                    <option value="intelectual">Intelectual</option>
                                                    <option value="otra">Otra</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" id="guardarPariente" name="guardarPariente">Guardar Pariente</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="../Public/script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>

            $(document).ready(function() {

                
                $('#codCargo').select2({
                    theme:"classic"
                });
                $('#cargoDirector').select2({
                    theme:"classic"
                });
                $('#ubicacionGeneral').select2({
                    theme:"classic"
                });
                $('#ubicacionEspecifica').select2({
                    theme:"classic"
                });

                //codigo para rellenar un input de forma dinamica en tiempo real usando javascript
                const cedula = document.getElementById('cedula')
                const trabajadorCedula = document.getElementById('cedulaTrabajador')
               

                cedula.addEventListener('input',() =>{
                    
                    trabajadorCedula.value = cedula.value
                })

                // Obtener referencias a los elementos HTML

                const cedulaError = document.getElementById('cedulaError');
                

                // Variable para controlar el retraso en la petición AJAX (debounce)
                let debounceTimer;

                // --- Función para realizar la validación de formato inicial (local) ---
                // La dejamos casi igual, pero ahora solo para validaciones rápidas del formato.
                function validarFormatoCedulaLocal(cedula) {
                    const cedulaLimpia = cedula.replace(/[^0-9VEJvej]/gi, ''); // Permite números y letras V, E, J
                    if (cedulaLimpia.length === 0) {
                        return 'La cédula no puede estar vacía.';
                    }
                    // Considera una longitud mínima razonable antes de enviar al backend
                    if (cedulaLimpia.length < 5) { // Por ejemplo, 5 dígitos mínimos para empezar a validar con backend
                        return 'Cédula muy corta.';
                    }
                    
                }


                // --- Añadir el 'event listener' al campo de la cédula ---
                cedula.addEventListener('keyup', () => {
                    const cedulaValor = cedula.value.trim(); // Obtiene el valor actual y elimina espacios

                    // Limpia cualquier temporizador anterior
                    clearTimeout(debounceTimer);

                    // 1. Primero, valida el formato localmente
                    const formatoError = validarFormatoCedulaLocal(cedulaValor);

                    if (formatoError) {
                        cedulaError.textContent = formatoError;
                        // Si hay un error de formato local, no enviamos al backend
                        return;
                    } else {
                        cedulaError.textContent = ''; // Limpiamos el error de formato si ya no existe
                    }

                    // 2. Si el formato es válido, establece un temporizador para enviar la solicitud al backend
                    // Esto se llama "debounce": espera un momento (ej. 500ms) después de que el usuario deja de escribir
                    // para no saturar el servidor con peticiones por cada tecla.
                    if (cedulaValor.length >= 7) { // Solo envía al backend si la cédula tiene una longitud razonable
                        cedulaError.textContent = 'Verificando cédula...'; // Mensaje de carga
                        
                        cedulaError.style.color = 'dark'; // Un color temporal para el mensaje de carga

                        debounceTimer = setTimeout(() => {
                            // Construye la URL de la API con la cédula como parámetro
                            // Asegúrate de codificar la cédula para URLs seguras
                    
                            const apiUrl = `http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=validar_cedula&id=` + cedulaValor;

                            fetch(apiUrl)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`Error de red: ${response.statusText}`);
                                    }
                                    return response.json(); // Espera una respuesta JSON
                                })
                                .then(data => {
                                    // Procesar la respuesta del backend
                                    console.log(data)
                                    if (data.success) {
                                        if (data.existe) {
                                            cedulaError.textContent = '¡Cédula ya registrada!';
                                            
                                            cedulaError.style.color = 'red';
                                            cedulaError.style.fontSize = '25px'
                                            
                                          
                                            
                                            // Opcional: podrías deshabilitar el botón de enviar o resaltar el campo
                                        } else {
                                            cedulaError.textContent = '*¡Cedula Disponible!*';
                                            
                                            cedulaError.style.color = 'green';
                                            cedulaError.style.fontSize = '25px'
                                        
                                            
                                        }
                                    } else {
                                        // Si success es false, el backend envió un mensaje de error
                                        cedulaError.textContent = `Error del servidor: ${data.message}`;
                                        cedulaError.classList.add('alert-danger')
                                        cedulaError.style.color = 'dark';
                                    }   
                                })
                                .catch(error => {
                                    console.error('Error al verificar cédula:', error);
                                    cedulaError.textContent = 'Error al verificar. Intenta de nuevo.';
                                    
                                    cedulaError.style.color = 'red';
                                    cedulaError.style.font = '25px'

                                });
                        }, 500); // Espera 500 milisegundos (0.5 segundos) antes de enviar la petición
                    } else {
                        // Si la cédula es demasiado corta para enviar al backend (según tu criterio)
                        cedulaError.textContent = ''; // O un mensaje como "Continúa escribiendo..."
                    }
                });

                // Opcional: Validar al cargar la página si ya hay un valor en el input
                document.addEventListener('DOMContentLoaded', () => {
                    if (cedula.value) {
                        cedula.dispatchEvent(new Event('keyup')); // Dispara el evento keyup para una validación inicial
                    }
                });

                
                

                $('#estado').change(function() {
                    $('#parroquia').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
                    $('#estado option:selected').each(function() {
                        var id_estado = $(this).val();
                        console.log(id_estado)
                        $.post('../Models/fetch_ciudad.php', {
                            id_estado: id_estado
                        }, function(data) {
                            $('#ciudad').html(data);
                        })
                    })
                })
                $('#ciudad').change(function() {
                    $('#ciudad option:selected').each(function() {
                        var ID_ciudad = $(this).val();
                        $.post('../Models/fetch_municipio.php', {
                            ID_ciudad: ID_ciudad
                        }, function(data) {
                            $('#municipio').html(data)
                        })
                    })
                })
                $("#municipio").change(function() {
                    $('#municipio option:selected').each(function() {
                        var id_municipio = $(this).val();
                        $.post('../Models/fetch_parroquia.php', {
                            id_municipio: id_municipio
                        }, function(data) {
                            $('#parroquia').html(data)
                        })
                    })
                })
                $("#parroquia").change(function() {
                    $('#parroquia option:selected').each(function() {
                    })
                })
                

                var $formSections = $('.form-section');
                var $progressBar = $('.progress-bar');
                var currentSectionIndex = 0;

                function updateProgressBar() {
                    var progress = ((currentSectionIndex + 1) / $formSections.length) * 100;
                    $progressBar.css('width', progress + '%').attr('aria-valuenow', progress).text(Math.round(progress) + '%');
                }

                function showCurrentSection() {
                    $formSections.removeClass('current').eq(currentSectionIndex).addClass('current');
                    updateProgressBar();
                    // Optional: Focus the first visible input of the newly visible section for accessibility
                    $formSections.eq(currentSectionIndex).find('input, select, textarea').not(':disabled, [type="hidden"]').first().focus();
                }

                // --- Validation Function for a Section ---
                // This function now uses the browser's checkValidity()
                function validateCurrentSection() {
                    var $currentVisibleSection = $formSections.eq(currentSectionIndex);
                    // Find all immediate form controls within the current section
                    // Use :input to select all form elements (input, textarea, select)
                    var $formControls = $currentVisibleSection.find(':input:visible'); // Only visible and required inputs

                    let sectionIsValid = true;

                    $formControls.each(function() {
                        if (!this.checkValidity()) { // checkValidity() is a native browser method
                            sectionIsValid = false;
                            // The browser will usually handle the visual feedback (red border, tooltip)
                            // You might want to add a custom class here for consistency if needed:
                            // $(this).addClass('is-invalid');
                            return false; // Break from .each() loop
                        } else {
                            // $(this).removeClass('is-invalid'); // Remove if valid
                        }
                    });

                    return sectionIsValid;
                }

                // --- Handler for "Next" button click ---
                $('.next-step').click(function(e) {
                    e.preventDefault();

                    // Validate the current section
                    if (!validateCurrentSection()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Validación',
                            text: 'Por favor, complete todos los campos requeridos en esta sección antes de continuar.',
                        });
                        // The browser's native validation should have already focused the first invalid element
                        // No explicit focus needed here unless you have custom validation not covered by HTML5
                        return; // Stop if validation fails
                    }

                    // If validation passes, proceed to the next step
                    if (currentSectionIndex < $formSections.length - 1) {
                        currentSectionIndex++;
                        showCurrentSection();
                    }
                });

                // --- Handler for "Previous" button click ---
                $('.prev-step').click(function() {
                    if (currentSectionIndex > 0) {
                        currentSectionIndex--;
                        showCurrentSection();
                    }
                });

                // Show the first section on page load
                showCurrentSection();


                // --- Final Form Submission Handler ---
                // Assuming formularioPrincipal is your <form> element
                const formularioPrincipal = document.getElementById('personaForm');

                // Flag to prevent infinite submission loop
                formularioPrincipal.isSubmitting = false;

                formularioPrincipal.addEventListener('submit', function(evento) {
                    if (formularioPrincipal.isSubmitting) {
                        return; // If already submitting, let it go through
                    }

                    evento.preventDefault(); // Prevent default browser submission initially

                    let formIsValid = true;
                    let firstInvalidField = null; // To store the first invalid field found

                    // --- Validate ALL sections on final submit ---
                    // Iterate through all sections, and then all required fields within them
                    for (let i = 0; i < $formSections.length; i++) {
                        let currentSection = $formSections.eq(i);
                        let inputsInCurrentSection = currentSection.find(':input[required]'); // All required inputs in the section

                        for (let j = 0; j < inputsInCurrentSection.length; j++) {
                            let input = inputsInCurrentSection[j];
                            if (!input.checkValidity()) {
                                formIsValid = false;
                                // Store the first invalid field
                                if (!firstInvalidField) {
                                    firstInvalidField = input;
                                }
                                // Add a class for visual feedback (e.g., Bootstrap 'is-invalid')
                                $(input).addClass('is-invalid');
                            } else {
                                $(input).removeClass('is-invalid');
                            }
                        }
                    }

                    // --- Handle Parientes JSON validation (if needed client-side, e.g. min 1 pariente) ---
                    // This is where you'd add custom client-side logic for the parientes array
                    // For example, if parientes is required to not be empty
                    const parientesArrayValue = document.getElementById('parientesArray').value;
                    if (parientesArrayValue === '[]' || parientesArrayValue === '') {
                        // Example: If at least one pariente is required, and none are added
                        // This is a custom rule, not covered by HTML5 'required' on a hidden input.
                        // You'd need to decide where this error appears.
                        // For simplicity, we'll just let backend handle it, or add a specific error to 'errores' for Swal.
                    }


                    if (!formIsValid) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de Envío',
                            text: 'Por favor, complete todos los campos requeridos del formulario antes de enviar.',
                        });

                        // If there's an invalid field, navigate to its section and focus it
                        if (firstInvalidField) {
                            let invalidSectionIndex = $(firstInvalidField).closest('.form-section').index();
                            if (invalidSectionIndex !== -1 && invalidSectionIndex !== currentSectionIndex) {
                                currentSectionIndex = invalidSectionIndex;
                                showCurrentSection(); // Make the section visible
                            }
                            // Give a slight delay if needed for visibility changes to apply, then focus
                            setTimeout(() => {
                                firstInvalidField.focus(); // Focus the field
                            }, 100);
                        }
                        return; // Stop submission
                    }

                    // If all client-side validation passes, prepare and submit the form
                    const parientesJson = JSON.stringify(parientes); // Assuming 'parientes' JS array is managed globally
                    document.getElementById('parientesArray').value = parientesJson;

                    formularioPrincipal.isSubmitting = true; // Set flag
                    formularioPrincipal.submit(); // Now submit the form natively
                });

                // To manage the 'parientes' array in your JS, ensure you have something like this
                // (This is a placeholder, adapt to your actual parientes management)
                // You would add objects to this array as the user adds relatives,
                // and remove them when they are deleted from the temporary list.
                
                //inicio del bloque de codigo encargado del modal de parientes

                var parientes = []; // Array para almacenar los parientes
                
            
                // Lógica para agregar parientes al array y mostrar en la lista
                //Capturamos el ID del boton guardar pariente
                $('#guardarPariente').click(function() {
                    //Capturamos los campos dentro del modal formulario
                    
                    var trabajadorId = $('#cedulaTrabajador').val();
                    var cedula = $('#cedulaPariente').val();
                    var nombre = $('#nombrePariente').val();
                    var apellido = $('#apellidoPariente').val();
                    var fechaNacimiento = $('#fechaNacimientoPariente').val();
                    var parentesco = $('#parentesco').val();
                    var generoPariente = $('#generoPariente').val();
                    var discapacidad = $('#discapacidadPariente').val();
                    //Verificamos que los campos contengan algun valor dentro de ellos
                    if (trabajadorId && nombre && apellido && parentesco &&generoPariente && fechaNacimiento && discapacidad) {
                        //llamamos al array que declaramos vacio, y le agregamos los datos del pariente haciendo uso de la function push
                        parientes.push({
                            trabajadorId: trabajadorId,
                            cedulaPariente: cedula,
                            nombrePariente: nombre,
                            apellidoPariente: apellido,
                            fechaNacimientoPariente: fechaNacimiento,
                            parentesco: parentesco,
                            generoPariente:generoPariente,
                            discapacidadPariente: discapacidad
                        });
                        actualizarListaParientes();
                        $('#modalPariente').modal('hide');
                        $('#formPariente')[0].reset(); // Limpiar el formulario del modal
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos Requeridos',
                            text: 'Por favor, complete el Cedula del trabajador, nombre, apellido, Fecha de Nacimiento, parentesco y genero del pariente.',
                        });
                    }
                });

                function actualizarListaParientes() {
                    var listaHTML = '';

                    parientes.forEach(function(pariente) {
                        // Use a more robust identifier, perhaps cedulaPariente if it's unique, otherwise use an index
                        // For demonstration, let's stick to using cedulaPariente if available, or a combination
                        const uniqueIdentifier = `${pariente.nombrePariente}-${pariente.apellidoPariente}`;

                        listaHTML += `<li>${pariente.nombrePariente} ${pariente.apellidoPariente} (C.I: ${pariente.cedulaPariente || 'N/A'}) - Parentesco: ${pariente.parentesco}`;

                        if (pariente.fechaNacimientoPariente) {
                            listaHTML += ` - Nacimiento: ${pariente.fechaNacimientoPariente}`;
                        }

                        listaHTML += ` - Género: ${pariente.generoPariente} - Discapacidad: ${pariente.discapacidadPariente} - <strong>C.I del Trabajador: ${pariente.trabajadorId}</strong>`;

                        // Change data-cedula to data-identifier for consistency with retrieval
                        listaHTML += ` <button type="button" class="btn btn-danger btn-sm ms-2 eliminar-pariente" data-identifier="${uniqueIdentifier}">Eliminar</button></li>`;
                        
                    });

                    $('#lista-parientes').html(listaHTML);

                    $('.eliminar-pariente').off('click').on('click', function() {
                        // Retrieve the data attribute correctly
                        const identifierToDelete = $(this).data('identifier');
                        console.log(identifierToDelete)

                        // Filter based on the chosen unique identifier
                        parientes = parientes.filter(p => { 
                            const currentIdentifier = `${p.nombrePariente}-${p.apellidoPariente}`;
                            console.log(currentIdentifier)
                            return currentIdentifier !== identifierToDelete;
                        });

                        actualizarListaParientes();
                    });
                }
                // Cuando se oculta el modal, limpiar el formulario
                $('#modalPariente').on('hidden.bs.modal', function() {
                    //Accedemos al indice [0] ya que el selector de ID osea se $ siempre devuelve 1 elemento el indice siempre sera 0 
                    $('#formPariente')[0].reset();
                });

                formularioPrincipal.addEventListener('submit', function(evento){
                    
                    console.log(formularioPrincipal);
                    const formData = new FormData(formularioPrincipal);
                    //Construir la URL actual de action del formulario
                    let currentAction = formularioPrincipal.getAttribute('action');
                    
                      // Serializa el array de parientes a una cadena JSON
                    const parientesJson = JSON.stringify(parientes);
                    console.log(parientesJson);


                    // Asigna la cadena JSON al input hidden
                    document.getElementById('parientesArray').value = parientesJson;

                    
                })
            });
            
        </script>
        <script defer>
            document.addEventListener('DOMContentLoaded', () => {
            const listaTrabajadoresDiv = document.getElementById('reporte');
            

            fetch(`http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=obtenerUltimosTrabajadores`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        listaTrabajadoresDiv.innerHTML = ''; // Limpiar el mensaje de carga
                        if (data.data.length > 0) {
                            data.data.forEach(trabajador => {
                                const div = document.createElement('div');
                                div.classList.add('trabajador');
                                div.innerHTML = ` 
                                <ol>
                                    <li><strong>Hora Registro :</strong> ${trabajador.horaRegistro}</li>
                                    <li><strong>Cédula:</strong> ${trabajador.cedula}</li>
                                    <li><strong>Nombre:</strong> ${trabajador.nombres}</li>
                                    <li><strong>Apellido:</strong> ${trabajador.apellidos}</li>
                                    
                                </ol>`;
                                listaTrabajadoresDiv.appendChild(div);
                            });
                        } else {
                            listaTrabajadoresDiv.innerHTML = '<p>No se encontraron trabajadores.</p>';
                        }
                    } else {
                        listaTrabajadoresDiv.innerHTML = `<p>Error: ${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                    listaTrabajadoresDiv.innerHTML = `<p>Hubo un problema al cargar los trabajadores: ${error.message}</p>`;
                });
        });
        </script>
        <script>
                    document.addEventListener("DOMContentLoaded", () => {
                // These should be your actual HTML element IDs
                const totalesContainer = document.getElementById('totales'); // Main container for all totals (or maybe specific sections)
                const generalStatsContainer = document.getElementById('totalPersonas'); // Specific container for general totals

                fetch('http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=totalRegistros')
                    .then(response => {
                        if (!response.ok) {
                            // Throw an error with the response status for better debugging
                            throw new new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(apiResponse => {
                        if (apiResponse.success) {
                            console.log('API Response:', apiResponse); // Log the full API response to see its structure

                            const data = apiResponse.data; // Access the actual data object

                            // Clear previous content in both containers
                            generalStatsContainer.innerHTML = '';
                            totalesContainer.innerHTML = '';

                            // --- Display General Totals (totalTrabajadores, totalParientes) ---
                            if (data && data.totalPersonas) {
                                console.log(data.totalPersonas)
                                const generalHtml = `
                                    <div class="list-group">
                                        <a href="listarTrabajadores.php" class="list-group-item list-group-item-action fs-5" aria-current="true">
                                            Total Trabajadores:  ${data.totalPersonas.totalTrabajadores} <i class="fa-solid fa-person"></i>
                                        </a>
                                        <a href="listarParientes" class="list-group-item list-group-item-action fs-5">
                                            Total Parientes:  ${data.totalPersonas.totalParientes} <i class="fa-solid fa-users"></i>
                                        </a>
                                    </div>
                                `;
                                generalStatsContainer.innerHTML = generalHtml; // Assign directly to its container
                            } else {
                                generalStatsContainer.innerHTML = `<p>No se pudieron cargar los totales generales.</p>`;
                            }

                            // --- Display Personal per Sede (por_sede array) ---
                            if (data && data.por_sede && data.por_sede.length > 0) {
                                let tableHtml = `
                                    
                                    <table class="table align-middle table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre Sede</th>
                                                <th scope="col">Personal por Sede</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                `;

                                data.por_sede.forEach(sede => {
                                    tableHtml += `
                                            <tr>
                                                <th scope="row">${sede.nombre_sede}</th>
                                                <td>${sede.personalSede}</td>
                                            </tr>
                                    `;
                                });

                                tableHtml += `
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th scope="row" class="fw-bold bg-dark text-white">Total</th>
                                                <td scope="row" class="fw-bold bg-dark text-white">${data.totalPersonas.totalPorSede}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                `;
                                totalesContainer.innerHTML = tableHtml; // Assign to the main container
                            } else if (data && data.por_sede && data.por_sede.length === 0) {
                                // Handle case where there are no sedes or no personal assigned to sedes
                                totalesContainer.innerHTML = `<p>No hay personal asignado por sede disponible.</p>`;
                            } else {
                                // Fallback for when 'por_sede' data structure is missing or malformed
                                totalesContainer.innerHTML = `<p>No se pudieron cargar los detalles por sede.</p>`;
                            }

                        } else {
                            // API returned success: false
                            totalesContainer.innerHTML = `<p>Error del servidor: ${apiResponse.message || 'Mensaje de error desconocido'}</p>`;
                            generalStatsContainer.innerHTML = ''; // Clear if there's an API error
                        }
                    })
                    .catch(error => {
                        // Network error, CORS issue, or JSON parsing error
                        console.error('Fetch error:', error); // Log the actual error for debugging
                        generalStatsContainer.innerHTML = `<p>Error de conexión: ${error.message}.</p>`;
                        totalesContainer.innerHTML = `<p>Hubo un problema al cargar los cálculos. Por favor, revise su conexión o intente de nuevo.</p>`;
                    });
            });
                    /*Variable Renaming: Renamed totales (the HTML element) to totalesContainer to avoid naming conflicts with the data.totales property if you had one, and to better reflect its role as a container. Also renamed data in the second .then() to apiResponse and then extracted const data = apiResponse.data; to clearly distinguish the raw API response from the structured data payload Accessing Data Correctly:
                    The general totals (totalTrabajadores, totalParientes) are now accessed from data.generales.
                    The personal by sede is an array found at data.por_sede. I've added a separate forEach loop specifically for this array to display each sede's information.
                    Improved HTML Structure: Instead of putting everything into a single <ol>, I've separated them into two distinct sections: one for general totals and another for the per-sede breakdown. This makes the displayed information clearer and more organized.
                    Robust Error Handling:
                    The throw new Error() in the first .then() now includes the HTTP status code for better debugging.
                    The catch block now logs the full error object to the console, which is invaluable for debugging network issues.
                    Added checks for data && data.generales and data && data.por_sede && data.por_sede.length > 0 to prevent errors if parts of the data are missing or empty.
                    Clearer User Feedback: Provided more specific messages for different error scenarios (HTTP errors, server-side logical errors, network errors).*/
                    
        </script>
        <script defer>
                const ctx = document.getElementById('myChart');
                let myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: [{
                            font: {
                                size: 12,
                                weight: 'bold',
                                family: 'Poppins',
                                color:'white'
                                
                            },
                            label: 'Personal Nuevo Ingreso',
                            data: [],
                            backgroundColor: ['#8F128F','#5CDADF','#CEED20','#F1CA2E','#5A19F4','#041223','#9B1328','#EF794E', 'red', 'blue', 'gren', 'yellow'],
                            borderColor: ['purple'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                            },
                            title: {
                                display: true,
                                text: 'N° de nuevos ingresos dentro del Consejo Nacional Electoral',
                                color: 'white',
                                family: 'Poppins',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                const mostrar = (dataArray) => { // Renamed parameter for clarity
                    if (!Array.isArray(dataArray)) {
                        console.error("Error: Data passed to mostrar is not an array.", dataArray);
                        // Decide how to handle this:
                        // return; // Stop execution if it's not an array
                        dataArray = []; // Or make it an empty array to avoid crashing map
                    }

                    const labels = dataArray.map(element => element.anoFormato);
                    const values = dataArray.map(element => element.total_personas);

                    myChart.data['labels'] = labels;
                    myChart.data['datasets'][0]['data'] = values;
                    myChart.update();
                };

                fetch('http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=comparativa')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Is not find any response from server');
                        }
                        return response.json();
                    })
                    .then(jsonResponse => { // Renamed parameter to be explicit about the full JSON object
                        if (jsonResponse && jsonResponse.success && Array.isArray(jsonResponse.data)) {
                            mostrar(jsonResponse.data); // Pass only the 'data' array to 'mostrar'
                        } else {
                            console.error("API response structure is not as expected:", jsonResponse);
                            // Optionally call mostrar with an empty array or handle error
                            mostrar([]); 
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            </script>

            <script defer>
            //Script para validar si la cedula del pariente ya se encuentra registrada , antes de hacer dicho registro en la base de datos
                // Obtener referencias a los elementos HTML
                const cedulaPariente = document.getElementById('cedulaPariente');
                const cedulaError = document.getElementById('cedulaParienteError');
                

                // Variable para controlar el retraso en la petición AJAX (debounce)
                let debounceTimerPariente;

                // --- Función para realizar la validación de formato inicial (local) ---
                // La dejamos casi igual, pero ahora solo para validaciones rápidas del formato.
                function validarFormatoCedulaLocalPariente(cedulaPariente) {
                    const cedulaLimpia = cedulaPariente.replace(/[^0-9VEJvej]/gi, ''); // Permite números y letras V, E, J
                    // Considera una longitud mínima razonable antes de enviar al backend
                    if (cedulaLimpia.length < 5) { // Por ejemplo, 5 dígitos mínimos para empezar a validar con backend
                        return 'Cédula muy corta.';
                    }
                    
                }


                // --- Añadir el 'event listener' al campo de la cédula ---
                cedulaPariente.addEventListener('keyup', () => {
                    const cedulaValor = cedulaPariente.value.trim(); // Obtiene el valor actual y elimina espacios

                    // Limpia cualquier temporizador anterior
                    clearTimeout(debounceTimerPariente);

                    // 1. Primero, valida el formato localmente
                    const formatoError = validarFormatoCedulaLocalPariente(cedulaValor);

                    if (formatoError) {
                        cedulaError.textContent = formatoError;
                        // Si hay un error de formato local, no enviamos al backend
                        return;
                    } else {
                        cedulaError.textContent = ''; // Limpiamos el error de formato si ya no existe
                    }

                    // 2. Si el formato es válido, establece un temporizador para enviar la solicitud al backend
                    // Esto se llama "debounce": espera un momento (ej. 500ms) después de que el usuario deja de escribir
                    // para no saturar el servidor con peticiones por cada tecla.
                    if (cedulaValor.length >= 7) { // Solo envía al backend si la cédula tiene una longitud razonable
                        cedulaError.textContent = 'Verificando cédula...'; // Mensaje de carga
                        
                        cedulaError.style.color = 'dark'; // Un color temporal para el mensaje de carga

                        debounceTimerPariente = setTimeout(() => {
                            // Construye la URL de la API con la cédula como parámetro
                            // Asegúrate de codificar la cédula para URLs seguras
                    
                            const apiUrl = `http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=validarCedulaPariente&id=` + cedulaValor;

                            fetch(apiUrl)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`Error de red: ${response.statusText}`);
                                    }
                                    return response.json(); // Espera una respuesta JSON
                                })
                                .then(data => {
                                    // Procesar la respuesta del backend
                                    console.log(data)
                                    if (data.success) {
                                        if (data.existe) {
                                            cedulaError.textContent = '¡Cédula ya registrada!';
                                            
                                            cedulaError.style.color = 'red';
                                            cedulaError.style.fontSize = '25px'
                                            
                                          
                                            
                                            // Opcional: podrías deshabilitar el botón de enviar o resaltar el campo
                                        } else {
                                            cedulaError.textContent = '*¡Cedula Disponible!*';
                                            
                                            cedulaError.style.color = 'green';
                                            cedulaError.style.fontSize = '15px'
                                        
                                            
                                        }
                                    } else {
                                        // Si success es false, el backend envió un mensaje de error
                                        cedulaError.textContent = `Error del servidor: ${data.message}`;
                                        cedulaError.classList.add('alert-danger')
                                        cedulaError.style.color = 'dark';
                                    }   
                                })
                                .catch(error => {
                                    console.error('Error al verificar cédula:', error);
                                    cedulaError.textContent = 'Error al verificar. Intenta de nuevo.';
                                    
                                    cedulaError.style.color = 'red';
                                    cedulaError.style.font = '25px'

                                });
                        }, 500); // Espera 500 milisegundos (0.5 segundos) antes de enviar la petición
                    } else {
                        // Si la cédula es demasiado corta para enviar al backend (según tu criterio)
                        cedulaError.textContent = ''; // O un mensaje como "Continúa escribiendo..."
                    }
                });


            </script>
</body>

</html>