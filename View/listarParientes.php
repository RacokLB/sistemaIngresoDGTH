
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

<body>
  <div class="wrapper">
    <aside id="sidebar" class="js-sidebar">
      <!-- Content For Sidebar -->
      <div class="h-100">
        <div class="sidebar-logo">
          <a href="#">CNE</a>
        </div>
        <ul class="sidebar-nav">
          <li class="sidebar-header">
            <h6>Elementos analista</h6>
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
                <a href="listarTrabajadores.php" class="sidebar-link">Consulta de Funcionarios & Actualizacion de datos</a>
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
                    echo "C.I - ".$_SESSION['user'] . " ". "Analista"
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
          <div class="row shadow-lg bg-dark">
            <div class="col-12 col-md-12 d-flex">
              <div class="card flex-fill border-0 illustration text-dark fs-bold">
                <div class="card-body p-0 d-flex flex-fill">
                  <div class="row g-0 w-100">
                    <div class="col-6">
                      <div class="p-4 m-1">
                        <h2>¡Bienvenido!, <?php 
                                              echo "C.I -" . $_SESSION['user'] . " <br> " . "Analista"
                                            ?></h2>
                        <p class="mb-0 fs-6">Vista Analista</p>
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
                Base de datos de los Parientes de los funcionarios activos del Consejo Nacional Electoral
            </h5>
            </div>
            <div class="card-body bg-dark text-white">
                <table id="tabla" class="table fs-6 table-dark able-striped table-hover" style="width: 100%">
                <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">C.I del trabajador</th>
                    <th scope="col">C.I del pariente</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Parentesco</th>
                    <th scope="col">Genero</th>
                    <th scope="col">Discapacidad</th>
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
                  <strong>Direccion General de Talento Humano</strong>
                </a>
              </p>
            </div>
            <div class="col-6 text-end">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Contacto</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">CNE</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <main>
    <div class="modal fade" id="editParienteModal" tabindex="-1" aria-labelledby="editParienteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-4 border-bottom bg-dark text-white">
                        <h5 class="modal-title" id="editParienteModalLabel">Editar Pariente</h5>
                        <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <di class="modal-body">
                        <form id="formEditPariente">
                            <input type="hidden" id="editParienteId" name="idPariente">

                            <div class="row mb-3">
                                <!--- FIELD CI DEL TRABAJADOR--->
                                <div class="col-md-6">
                                    <label for="editTrabajadorCedula" class="form-label">Cedula del Trabajador</label>
                                    <input type="text" class="form-control" id="editTrabajadorCedula" name="trabajadorId" autocomplete="off">
                                </div>
                                <!--- FIELD CI DEL PARIENTE--->
                                <div class="col-md-6">
                                    <label for="editCedulaPariente" class="form-label">Cedula del pariente</label>
                                    <input type="text" class="form-control" id="editCedulaPariente" name="cedulaPariente" autocomplete="off">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!---FIELD NOMBRE--->
                                <div class="col-md-6">
                                    <label for="editNombrePariente" class="form-label">Nombres:</label>
                                    <input type="text" class="form-control" id="editNombrePariente" name="nombrePariente">
                                </div>
                                <!---FIELD APELLIDO-->
                                <div class="col-md-6">
                                    <label for="editApellidoPariente" class="form-label">Apellidos:</label>
                                    <input type="text" class="form-control" id="editApellidoPariente" name="apellidoPariente">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!--FIELD FECHA DE NACIMIENTO--->
                                <div class="col-md-6">
                                    <label for="editFechaNacimientoPariente" class="form-label">Fecha de Nacimiento:</label>
                                    <input type="date" class="form-control" id="editFechaNacimientoPariente" name="fechaNacimientoPariente">
                                </div>
                                <!--FIELD PARENTESCO-->
                                <div class="col-md-6">
                                    <label for="editParentesco" class="form-label">Parentesco</label>
                                    <select name="parentesco" id="editParentesco" class="form-select">
                                        <option value="Madre">Madre</option>
                                        <option value="Padre">Padre</option>
                                        <option value="Hijo">Hijo</option>
                                        <option value="Hija">Hija</option>
                                        <option value="Esposa">Esposa</option>
                                        <option value="Esposo">Esposo</option>
                                        <option value="Abuelo">Abuelo</option>
                                        <option value="Abuela">Abuela</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <!-- FIELD GENERO-->
                                <div class="col-md-6">
                                    <label for="editGeneroPariente" class="form-label">Sexo:</label>
                                    <select class="form-select" id="editGeneroPariente" name="generoPariente">
                                        <option selected>Seleccione una opcion</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                <!-- FIELD DISCAPACIDAD -->
                                <div class="col-md-6">
                                    <label for="editDiscapacidadPariente" class="form-label">Discapacidad</label>
                                    <select class="form-select" id="editDiscapacidadPariente" name="discapacidadPariente">
                                        <option selected>Seleccione una opción</option>
                                        <option value="ninguna">Ninguna</option>
                                        <option value="fisica">Física</option>
                                        <option value="visual">Visual</option>
                                        <option value="auditiva">Auditiva</option>
                                        <option value="intelectual">Intelectual</option>
                                        <option value="otra">Otra</option>
                                    </select>
                                </div>
                            </div>      
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="guardarCambiosPariente">Guardar Cambios</button>
                        </div>
                      </div>
                    </form>
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
            processing: true,
            serverSide: false, // Keep this as false if your API returns all data at once
            ajax: {
                url: 'http://localhost/sistemaIngresoDGTH/index.php/?api=parientes', // Your API endpoint
                dataSrc: '' // Your API directly returns an array
            },
            columns: [
                // Column 1: N° (ID, but can be a counter if you want to display sequential numbering)
                
                { data: 'idPariente'},
                { data: 'trabajadorId'}, // Assuming your JSON key is 'cedula'
                { data: 'cedulaPariente' },
                { data: 'nombrePariente' },
                { data: 'apellidoPariente' },
                { data: 'fechaNacimientoPariente' },
                { data: 'parentesco' },
                { data: 'generoPariente' },
                { data: 'discapacidadPariente' },
                {
                    // Actions column
                    data: null, // This column doesn't map directly to a data field
                    render: function(data, type, row) {
                        // 'row' contains the full data object for the current row
                        const parienteId = row.idPariente;
                      
                        return `
                            <button type="button" class="btn btn-warning btn-sm editar-btn" data-id="${parienteId}" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm eliminar-btn" data-id="${parienteId}" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                    },
                    orderable: false, // Actions column is not orderable
                    searchable: false // Actions column is not searchable
                }
            ],
            // Optional: DataTables Features
            dom: 'lBfrtip', // Defines the layout of DataTables elements (Length, Buttons, Filter, Table, Info, Pagination)
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print',
                'colvis' // Column visibility toggle
            ],
            colReorder: true, // Enable column reordering
            responsive: true, // Enable responsive design
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.7/i18n/es-ES.json' // Spanish language file
            }
        });
        // Función para abrir el modal de edición y cargar datos
            $(document).on('click', '.editar-btn', function() {
                const ID = $(this).data('id');
                console.log('Boton de seleccion de funcionario', ID)
                console.log('URL de la solicitud:', 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=pariente&id=' + ID)
                
                // Realizar una solicitud AJAX para obtener los datos del trabajador
                $.ajax({
                    url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=pariente&id=' + ID,
                    type: 'GET',
                    success: function(response) {
                      console.log('Respuesta de la API', response)
                        // Validar si la respuesta es un objeto y si tiene la estructura esperada
                        if (response && typeof response === 'object' && !Array.isArray(response) && response.idPariente) {
                            // Si la API devuelve el objeto trabajador directamente
                            const pariente = response;
                            console.log('Objeto pariente procesado:', pariente);
                            // Rellenar los campos del modal de edición
                            $('#editParienteId').val(pariente.idPariente);
                            $('#editTrabajadorCedula').val(pariente.trabajadorId);
                            $('#editCedulaPariente').val(pariente.cedulaPariente);
                            $('#editNombrePariente').val(pariente.nombrePariente);
                            $('#editApellidoPariente').val(pariente.apellidoPariente);
                            $('#editFechaNacimientoPariente').val(pariente.fechaNacimientoPariente);
                            $('#editParentesco').val(pariente.parentesco);
                            $('#editGeneroPariente').val(pariente.generoPariente);
                            $('#editDiscapacidadPariente').val(pariente.discapacidadPariente);
                            
                            // Mostrar el modal
                            var editModal = new bootstrap.Modal(document.getElementById('editParienteModal'));
                            editModal.show();

                        } else {
                            Swal.fire('Error', 'No se encontraron datos del pariente.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error', 'Error al obtener los datos del Pariente ' + xhr.responseText, 'error');
                    }
                });
            });

            // Manejar el envío del formulario de edición
            $('#guardarCambiosPariente').on('click', function() {
                const ID = $('#editParienteId').val();
                const formData = $('#formEditPariente').serializeArray();
                console.log('formulario de actualizacion',formData)
                const data = {};
                console.log('Este es el ID del pariente seleccionado', ID);
                formData.forEach(function(item) {
                    data[item.name] = item.value;
                    
                });
                //console.log for debugging 
                console.log('JSON data being sent to backend:', data)
                console.log('Value of sede in data:', data.trabajadorId)
            

                $.ajax({
                    url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=actualizarPariente&id=' + ID, // Asume que tu API maneja PUT por ID
                    type: 'PATCH', // O 'POST' si tu API asi lo indica
                    contentType: 'application/json', // Importante para enviar JSON
                    data: JSON.stringify(data), // Enviar los datos como JSON
                    success: function(response) {
                      console.log('cuerpo del json listo para enviar', data)
                        Swal.fire(
                            '¡Actualizado!',
                            'Los datos del trabajador han sido actualizados.',
                            'success'
                        );
                        // Ocultar el modal
                        $('#editParienteModal').modal('hide');
                        // Recargar la tabla
                        $('#tabla').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire(
                            'Error',
                            'Hubo un error al actualizar el pariente: ' + xhr.responseText,
                            'error'
                        );
                    }
                });
            });

        $(document).on('click', '.eliminar-btn', function() {
            const ID = $(this).data('id');
            console.log('Boton de eliminar presionado y este es el ID del pariente', ID);
            // Use SweetAlert2 for a confirmation dialog
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
                    // Perform the deletion via AJAX
                    $.ajax({
                        url: 'http://10.100.202.66/sistemaIngresoDGTH/index.php/?api=eliminarPariente&id=' + ID, // Your API endpoint for deletion
                        type: 'DELETE', // Use DELETE HTTP method
                        success: function(response) {
                            Swal.fire(
                                '¡Eliminado!',
                                'El pariente ha sido eliminado.',
                                'success'
                            );
                            // Reload the DataTables table to reflect changes
                            $('#tabla').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error',
                                'Hubo un error al eliminar el pariente: ' + xhr.responseText,
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