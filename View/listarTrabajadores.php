<?php

    if(session_status() == PHP_SESSION_NONE){
        if(session_start()){
            if(!isset($_SESSION['rol'])){
                header("location: login.php");
            }else{
                if($_SESSION['rol'] != 1){
                    header("location: login.php");
                }
            }
        }
    }

include_once("../Controllers/trabajadorController.php");
include_once("../Enrutador/enrutador.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado Trabajadores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../Public/styleTable.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.0.4/css/colReorder.dataTables.min.css">
  


</head>
<?php

include_once "../Config/abrir_conexion.php";
$cargos = $pdo->prepare(query: "SELECT cod_cargo, desc_cargo FROM cargos");
$cargos->execute();

$estados = $pdo->prepare(query: "SELECT ID, state FROM estados");
$estados->execute();

$ciudades = $pdo->prepare(query: "SELECT ID_STATE, CITY FROM table_city");
$ciudades->execute();

$municipios = $pdo->prepare(query: "SELECT ID, ID_STATE, municipios FROM tabla_municipios");
$municipios->execute();

$parroquias = $pdo->prepare(query: "SELECT ID, parroquias FROM tabla_parroquias");
$parroquias->execute();

$direccionesGenerales = $pdo->prepare(query: "SELECT cod_ubicadmin, desc_ubicadmin FROM ubicadmin");
$direccionesGenerales->execute();

$direccionesEspecificas = $pdo->prepare(query: "SELECT cod_ubicafisica, desc_ubicafisica FROM ubicafisica");
$direccionesEspecificas->execute();

$sedes = $pdo->prepare("SELECT codigo_sede, nombre_sede FROM tabla_sede");
$sedes->execute();

$instruccion = $pdo->prepare("SELECT id, grado_academico FROM tabla_instruccion");
$instruccion->execute();

$directores = $pdo->prepare("SELECT codigo_cargo, nombre_cargoD FROM tabla_cargodirectores");
$directores -> execute();



?>

<body>
  <div class="wrapper">
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
              <a href="principalPagina.php" class="sidebar-link">
                  <i class="fa-solid fa-list pe-2"></i>
                  Pagina de Inicio
              </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed" data-bs-target="#pages" data-bs-toggle="collapse"
              aria-expanded="false">
              <i class="fa-solid fa-file-lines pe-2"></i>
              MODULOS 
            </a>
            <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="crearFuncionario.php" class="sidebar-link">Carga de Funcionarios</a>
              </li>
              <li class="sidebar-item">                
                <a href="listarParientes.php" class="sidebar-link">Consulta de Parientes & Actualizacion de datos</a>
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
      <main class="col-12 px-3 ">
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="fw-bold text-center">Listado de Funcionarios</h1>
          </div>
          <div class="row shadow-lg">
            <div class="col-12 col-md-6 d-flex">
              <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                  <div class="row g-0 w-100">
                    <div class="col-6">
                      <div class="p-4 m-1">
                        <h4>¡Bienvenido!,<br> <?php 
                                              echo "C.I -" . $_SESSION['user'] . " " . "Analista"
                                            ?></h4>
                        <p class="mb-0">Vista Analista</p>
                      </div>
                    </div>
                    <div class="col-6 align-self-end text-end">
                      <img src="../Public/images/logo-del-cne.jpg" class="img-fluid illustration-img"
                        alt="CNE">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </main>
      <main class="content px-3 py-2">
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="fw-bold text-center"></h1>
          </div>
          <!------- Campo Tabla ------------>
          <div class="card border-3 border-dark">
            <div class="card-header">
              <h3 class="card-title fw-bold">
                Tabla de Seleccion
              </h3>
              <h5 class="card-subtitle text-muted fs-4">
                Base de datos de los funcionarios activos del Consejo Nacional Electoral
              </h5>
            </div>
            <div class="card-body bg-dark text-white">
              <table id="tabla" class="table fs-6 table-dark table-striped table-hover" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col">N°</th>
                    <th scope="col">C.I</th>
                    <th scope="col">Nacionalidad</th>
                    <th scope="col">RIF</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Estatus</th>
                    <th scope="col">Compañia</th>
                    <th scope="col">Fecha de Ingreso</th>
                    <th scope="col">Tipo Trabajador</th>
                    <th scope="col">Direccion General</th>
                    <th scope="col">Direccion Especifica</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Cargo Director</th>

                    <th scope="col">Acciones</th>

                  </tr>
                </thead>
                <tbody id="resultado">

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-moon"></i>
        <i class="fa-regular fa-sun"></i>
      </a>
      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a href="#" class="text-muted">
                  <strong>CodzSwod</strong>
                </a>
              </p>
            </div>
            <div class="col-6 text-end">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Contact</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">About Us</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Terms</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Booking</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <main>
    <div class="modal fade" id="editTrabajadorModal" tabindex="-1" aria-labelledby="editTrabajadorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-4 border-bottom bg-dark text-white">
                        <h5 class="modal-title" id="editTrabajadorModalLabel">Editar Trabajador</h5>
                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditTrabajador">
                            <input type="hidden" id="editTrabajadorId" name="id">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editNacionalidad" class="form-label">Nacionalidad:</label>
                                    <select class="form-select" id="editNacionalidad" name="nacionalidad">
                                        <option value="V">Venezolano(a)</option>
                                        <option value="E">Extranjero(a)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editCedula" class="form-label">C.I:</label>
                                    <input type="text" class="form-control" id="editCedula" name="cedula" >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editNombre" class="form-label">Nombres:</label>
                                    <input type="text" class="form-control" id="editNombre" name="nombre">
                                </div>
                                <div class="col-md-6">
                                    <label for="editApellido" class="form-label">Apellidos:</label>
                                    <input type="text" class="form-control" id="editApellido" name="apellido">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editEstadoCivil" class="form-label">Estado Civil:</label>
                                    <select class="form-select" id="editEstadoCivil" name="estadoCivil">
                                        <option value="Soltero(a)">Soltero(a)</option>
                                        <option value="Casado(a)">Casado(a)</option>
                                        <option value="Divorciado(a)">Divorciado(a)</option>
                                        <option value="Viudo(a)">Viudo(a)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editFechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                                    <input type="date" class="form-control" id="editFechaNacimiento" name="fechaNacimiento">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editGenero" class="form-label">Sexo:</label>
                                    <select class="form-select" id="editGenero" name="genero">
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editNumeroContacto" class="form-label">N° Contacto:</label>
                                    <input type="text" class="form-control" id="editNumeroContacto" name="numeroContacto" autocomplete="off">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editRif" class="form-label">N° RIF:</label>
                                    <input type="text" class="form-control" id="editRif" name="rif" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label for="editFechaIngreso" class="form-label">Fecha Ingreso:</label>
                                    <input type="date" class="form-control" id="editFechaIngreso" name="fechaIngreso">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editEstado" class="form-label">Estado:</label>
                                    <select class="form-select" id="editEstado" name="estado">
                                        <?php foreach ($estados as $estado) { ?>
                                            <option value="<?php echo $estado['ID']; ?>"><?php echo htmlspecialchars($estado['state']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editCiudad" class="form-label">Ciudad:</label>
                                    <select class="form-control" id="editCiudad" name="ciudad">
                                      <?php foreach($ciudades as $ciudad) { ?>
                                        <option value="<?php echo $ciudad['ID_STATE'];?>"><?php echo htmlspecialchars($ciudad['CITY']);?></option>
                                      <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editMunicipio" class="form-label">Municipio:</label>
                                    <select class="form-control" id="editMunicipio" name="municipio">
                                      <?php foreach($municipios as $municipio) { ?>
                                        <option value="<?php echo $municipio['ID'];?>"><?php echo htmlspecialchars($municipio['municipios']);?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editParroquia" class="form-label">Parroquia:</label>
                                    <select type="text" class="form-control" id="editParroquia" name="parroquia">
                                      <?php foreach($parroquias as $parroquia){ ?>
                                        <option value="<?php echo $parroquia['ID'];?>"><?php echo htmlspecialchars($parroquia['parroquias']);?></option>
                                      <?php } ?>
                                      <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editDireccion" class="form-label">Direccion:</label>
                                    <textarea class="form-control" id="editDireccion" name="direccion"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                  <label for="editTipoTrabajador" class="form-label">Tipo Trabajador:</label>
                                  <select class="form-select" id="editTipoTrabajador" name="tipoTrabajador" title="Comision de servicio">
                                    <option value="CMS">CMS (Comision de servicio Pagada por el CNE)</option>
                                    <option value="COM">COM (Comision de servicio) </option>
                                    <option value="COB">COB (Contratado Obrero)</option>
                                    <option value="EMP">EMP (Empleado)</option>
                                    <option value="CON">CON (Contratado)</option>
                                    <option value="REC">REC (Rectores)</option>
                                    <option value="OBR">OBR (Obrero)</option>
                                  </select>
                                </div>

                                <div class="col-md-6">
                                  <label for="editEstatus" class="form-label">Estatus del funcionario</label>
                                  <select class="form-select" name="estatus" id="editEstatus" title="Estatus del funcionario dentro de la organizacion">
                                    <option value="A">Activo</option>
                                    <option value="J">Jubilado</option>
                                    <option value="P">Pensionado</option>
                                    <option value="S">Suspendido</option>
                                  </select>
                                </div>
                              </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                  <label for="editCompania" class="form-label">Compañia</label>
                                  <select class="form-select" name="compania" id="editCompania">
                                    <option value="1">Empleado/Obrero/Rectores</option>
                                    <option value="2">Jubilados/Pensionados/Sobreviviente</option>
                                    <option value="4">Comision de Servicio</option>
                                    <option value="5">Contratados</option>
                                  </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editCargo" class="form-label">Cargo:</label>
                                    <select class="form-select" id="editCargo" name="codCargo">
                                        <?php foreach ($cargos as $cargo) { ?>
                                            <option value="<?php echo $cargo['cod_cargo']; ?>"><?php echo htmlspecialchars($cargo['desc_cargo']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                                <!--- FIELD CARGO DIRECTOR---->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editCargoDirector" class="form-label">Cargo Director:</label>
                                    <select class="form-select" id="editCargoDirector" name="cargoDirector">
                                      <?php foreach ($directores as $director) { ?>
                                        <option value="<?php echo $director['codigo_cargo'];?>"><?php echo htmlspecialchars($director['nombre_cargoD']);?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!--- FIELD UBICACION GENERAL ---->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="editDireccionGeneral" class="form-label">Dirección General:</label>
                                    <select class="form-select" id="editDireccionGeneral" name="direccionGeneral">
                                        <?php foreach ($direccionesGenerales as $dg) { ?>
                                            <option value="<?php echo $dg['cod_ubicadmin']; ?>"><?php echo htmlspecialchars($dg['desc_ubicadmin']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editDireccionEspecifica" class="form-label">Dirección Específica:</label>
                                    <select class="form-select" id="editDireccionEspecifica" name="direccionEspecifica">
                                        <?php foreach ($direccionesEspecificas as $de) { ?>
                                            <option value="<?php echo $de['cod_ubicafisica']; ?>"><?php echo htmlspecialchars($de['desc_ubicafisica']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                              <div class="col-md-6">
                                <label for="editUbicacion" class="form-label">Sede</label>
                                <select class="form-select" name="ubicacion" id="editUbicacion">
                                  <option value=""></option>
                                  <?php while($row = $sedes->fetch(PDO::FETCH_ASSOC)){ ?>
                                    <option value="<?php echo $row['codigo_sede'];?>"><?php echo htmlspecialchars( $row['nombre_sede']);?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label for="editInstruccion" class="form-label">Grado Academico</label>
                                <select name="instruccion" id="editInstruccion" class="form-select">
                                  <option value=""></option>
                                <?php while($row = $instruccion->fetch()){ ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['grado_academico']?></option>
                                <?php } ?>
                                </select>
                              </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardarCambiosTrabajador">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
      </main>
    <!--- END CANVAS--->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../Public/scriptTable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.min.js"></script>
  
    <script>

    $(document).ready(function(){
      
        $('#tabla').DataTable({
            order:[[0,'DESC']],
            processing: true,
            serverSide: false,
            ajax: {
                url: 'http://localhost/sistemaIngresoDGTH/index.php/?api=trabajadores', 
                dataSrc: ''
            },
            columns: [
                
                
                { data: 'id'},
                { data: 'cedula'}, 
                { data: 'nacionalidad' },
                { data: 'rif' },
                { data: 'apellido' },
                { data: 'nombre' },
                { data: 'edad' },
                { data: 'estatus' },
                { data: 'compania' },
                { data: 'fechaIngreso' },
                { data: 'tipoTrabajador' },
                { data: 'ubicacionGeneral' },
                { data: 'ubicacionEspecifica' },
                { data: 'codCargo' },
                { data: 'cargoDirector'},
  
                {
                 
                    data: null, 
                    render: function(data, type, row) {
                       
                        const trabajadorCedula = row.cedula;
                 
                        return `
                            <button type="button" class="btn btn-warning btn-sm editar-btn" data-id="${trabajadorCedula}" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm eliminar-btn" data-id="${trabajadorCedula}" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                    },
                    orderable: false, 
                    searchable: false 
                }
            ],
          
            dom: 'lBfrtip', 
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print',
                'colvis'
            ],
            colReorder: true, 
            responsive: true, 
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.7/i18n/es-ES.json' 
            }
        });
        // Función para abrir el modal de edición y cargar datos
            $(document).on('click', '.editar-btn', function() {
                const cedula = $(this).data('id');
                console.log('Boton de seleccion de funcionario', cedula)
                console.log('URL de la solicitud:', 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=trabajador&id=' + cedula)
                
                // Realizar una solicitud AJAX para obtener los datos del trabajador
                $.ajax({
                    url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=trabajador&id=' + cedula,
                    type: 'GET',
                    success: function(response) {
                      console.log('Respuesta de la API', response)
                        // Validar si la respuesta es un objeto y si tiene la estructura esperada
                        if (response && typeof response === 'object' && !Array.isArray(response) && response.id) {
                            // Si la API devuelve el objeto trabajador directamente
                            const trabajador = response;
                            console.log('Objeto trabajador procesado:', trabajador);
                            // Rellenar los campos del modal de edición
                            $('#editTrabajadorId').val(trabajador.id);
                            $('#editCedula').val(trabajador.cedula);
                            $('#editNacionalidad').val(trabajador.nacionalidad);
                            $('#editRif').val(trabajador.rif);
                            $('#editApellido').val(trabajador.apellido);
                            $('#editNombre').val(trabajador.nombre);
                            $('#editFechaNacimiento').val(trabajador.fechaNacimiento);
                            $('#editEstadoCivil').val(trabajador.estadoCivil);
                            $('#editGenero').val(trabajador.genero);
                            $('#editDiscapacidad').val(trabajador.discapacidad);
                            $('#editNumeroContacto').val(trabajador.numeroContacto);
                            $('#editEstatus').val(trabajador.estatus);
                            $('#editCompania').val(trabajador.compania);
                            $('#editFechaIngreso').val(trabajador.fechaIngreso);
                            $('#editTipoTrabajador').val(trabajador.tipoTrabajador);
                            $('#editDireccionGeneral').val(trabajador.ubicacionGeneral);
                            $('#editDireccionEspecifica').val(trabajador.ubicacionEspecifica);
                            $('#editUbicacion').val(trabajador.ubicacion);
                            $('#editInstruccion').val(trabajador.gradoAcademico);
                            $('#editCargo').val(trabajador.codCargo);
                            $('#editCargoDirector').val(trabajador.cargoDirector);
                            $('#editEstado').val(trabajador.estado);
                            $('#editCiudad').val(trabajador.ciudad);
                            $('#editMunicipio').val(trabajador.municipio);
                            $('#editParroquia').val(trabajador.parroquia);
                            $('#editDireccion').val(trabajador.direccion);

                            

                            // Mostrar el modal
                            var editModal = new bootstrap.Modal(document.getElementById('editTrabajadorModal'));
                            
                            editModal.show();

                        } else {
                            Swal.fire('Error', 'No se encontraron datos para el trabajador.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al obtener los datos del trabajador: ' + xhr.responseText, 'error');
                    }
                });
            });

            // Manejar el envío del formulario de edición
            $('#guardarCambiosTrabajador').on('click', function() {
                const trabajadorCedula = $('#editCedula').val();
                const formData = $('#formEditTrabajador').serializeArray();
               
                const data = {};
                
                formData.forEach(function(item) {
                    data[item.name] = item.value;
                    
                });
            
            

                $.ajax({
                    url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=actualizarTrabajador&id=' + trabajadorCedula, 
                    type: 'PATCH',
                    contentType: 'application/json', 
                    data: JSON.stringify(data), 
                    success: function(response) {
                      console.log('cuerpo del json listo para enviar', data)
                        Swal.fire(
                            '¡Actualizado!',
                            'Los datos del trabajador han sido actualizados.',
                            'success'
                        );
                        // Ocultar el modal
                        $('#editTrabajadorModal').modal('hide');
                        // Recargar la tabla
                        $('#tabla').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Hubo un error al actualizar el trabajador: ' + xhr.responseText,
                            'error'
                        );
                    }
                });
            });

          $(document).on('click', '.eliminar-btn', function() {
              const trabajadorId = $(this).data('id');
              console.log('Boton de eliminar presionado y este es el ID del funcionario', trabajadorId);
              
              Swal.fire({
                  title: '¿Estás seguro?',
                  text: "¡No podrás revertir esto!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sí, eliminarlo!',
                  cancelButtonText: 'Cancelar'
              }).then((result) => {
                  if (result.isConfirmed) {
                 
                      $.ajax({
                          url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=eliminarTrabajador&id=' + trabajadorId, 
                          type: 'DELETE', 
                          success: function(response) {
                              Swal.fire(
                                  '¡Eliminado!',
                                  'El trabajador ha sido eliminado.',
                                  'success'
                              );
                              
                              $('#tabla').DataTable().ajax.reload();
                          },
                          error: function(xhr, status, error) {
                              Swal.fire(
                                  'Error',
                                  'Hubo un error al eliminar el trabajador: ' + xhr.responseText,
                                  'error'
                              );
                          }
                      });
                  }
              });
          });
      });
        
    </script>

</body>

</html>
