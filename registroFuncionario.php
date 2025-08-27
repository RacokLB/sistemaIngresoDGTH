<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Persona con Barra de Progreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="public/style.css">
    <style>
       
        .formulario-container {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
        .form-section {
            display: none; /* Ocultar todas las secciones por defecto */
        }
        .form-section.current {
            display: block; /* Mostrar la sección actual */
        }
        .form-group label {
            font-weight: bold;
        }
        
    </style>
</head>
        <?php

            require_once "config/abrir_conexion.php";
            $queryCargo = $pdo->prepare(query:"SELECT cod_cargo, desc_cargo FROM cargos");
            $queryCargo->execute();

            $queryEstado = $pdo->prepare(query:"SELECT ID, state FROM estados");
            $queryEstado->execute();


        ?>
<body>
    
    <div class="container-fluid">
        <div class="row shadow-lg">
            <div class="container formulario-container bg-light text-dark">
                    <h2 class="fw-bold">Nuevo Ingreso</h2>
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                    <form id="personaForm">
<!--- FIELD DATOS Identificación--->
                        <div id="step1" class="form-section current">
                            <input type="hidden" id="parientesArray" name="parientesArray">
                            <h2 class="card-subtitle mb-4 text-body-secondary">Datos de Identificación</h2>
                            <div class="form-group mb-3">
                                <label for="nacionalidad" class="form-label">Nacionalidad</label>             
                                    <select id="nacionalidad" class="form-control col-sm-12" aria-describedby="nacionalidadHelpInline" name="nacionalidad">
                                        <option selected>Abre este menu</option>
                                        <option value="V">Venezolano</option>
                                        <option value="E">Extranjero</option>
                                    </select>
                            </div>
                            <!--- FIELD CEDULA--->
                            <div class="form-group">
                                <label for="cedula" class="form-label">Cedula</label>
                                <input type="text" id="cedula" class="form-control mb-3" aria-describedby="cedulaHelpInline" name="cedula" placeholder="Cedula">
                            </div>
                            <!--- FIELD NOMBRES & APELLIDOS--->
                            <div class="form-group">
                                <div class="input-group row-md-3 mb-3">
                                    <span class="input-group-text bg-dark text-white">Nombres y Apellidos</span>
                                    <input type="text" aria-label="First name" class="form-control" name="nombre" id="nombre" placeholder="Nombres...">
                                    <input type="text" aria-label="Last name" class="form-control" name="apellido" name="apellido" placeholder="Apellidos...">
                                </div>
                            </div>
                            <!--- FIELD ESTADO CIVIL--->
                            <div class="form-group mb-4 col-md-5">
                                <label for="estado_civil">Estado Civil:</label>
                                <select class="form-control" id="estado_civil">
                                    <option selected>Seleccione una opción</option>
                                    <option value="soltero">Soltero(a)</option>
                                    <option value="casado">Casado(a)</option>
                                    <option value="divorciado">Divorciado(a)</option>
                                    <option value="viudo">Viudo(a)</option>
                                    <option value="union_estable_de_hechos">Unión Estable de Hechos</option>
                                </select>
                            </div>
                            <!---- FIELD BUTTON---->
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
<!---- FIELD DATOS LABORALES--->
                        <div id="step2" class="form-section">
                            <h2 class="card-subtitle mb-4 text-body-secondary">Datos Personales</h2>
                            <!--- FIELD RIF--->
                            <div class="form-group">
                                <label for="rif" class="form-label">Rif</label>
                                <input type="text" id="rif" class="form-control mb-3" aria-describedby="rifHelpInline" name="rif" placeholder="RIF">
                            </div>
                            <!--- FIELD TIPO TRABAJADOR--->
                            <div class="form-group">
                                <label for="tipo_trabaj">Tipo de Trabajador</label>
                                <select class="form-control col-md-9 mb-3" id="tipo_trabaj" name="tipo_trabaj" >
                                    <option selected>Abre este menu</option>
                                    <option value="alto nivel">Alto Nivel</option>
                                    <option value="contratado">Contratado</option>
                                    <option value="comision de servicio">Comision de Servicio</option>
                                    <option value="empleado">Empleado</option>
                                </select>
                            </div>
                            <!--- FIELD TIPO DE CARGO--->
                            <div class="form-group">
                                <label for="cod_cargo">Cargo del Funcionario</label>
                                <select class="form-control col-md-9 mb-3" aria-describedby="cod_cargoHelpInline" name="cod_cargo">
                                    <option selected>Abre este menu</option>
                                    <?php
                                    while($row = $queryCargo->fetch(mode:PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row['cod_cargo'];?>"><?php echo $row['desc_cargo'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!---- N° DE CONTACTO--->
                            <div class="form-group">
                                <label for="numero_contacto">Número de Contacto</label>
                                <input type="tel" class="form-control col-md-8 mb-3" id="numero_contacto" name="numero_contacto">
                            </div>
                            <!--- FIELD BUTTONS--->
                            <button type="button" class="btn btn-secondary prev-step mb-3">Anterior</button>
                            <button type="button" class="btn btn-primary next-step mb-3">Siguiente</button>
                        </div>
<!--- FIELD INFORMACION RELEVANTE--->
                        <div id="step3" class="form-section">
                            <h2>Datos de Nacimiento e Ingreso</h2>
                            <!--- FIELD FECHA DE NACIMIENTO--->
                            <div class="form-group">
                                <label for="fecha_nac">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nac" name="fecha_nac">
                            </div>
                            <!--- FIELD FECHA DE INGRESO--->
                            <div class="form-group">
                                <label for="fecha_ing">Fecha de Ingreso</label>
                                <input type="date" class="form-control" id="fecha_ing" name="fecha_ing">
                            </div>
                            <!--- FIELD SEXO--->
                            <div class="form-group mb-3">
                                <label for="ID_sexo">Sexo</label>
                                <select class="form-control" id="ID_sexo" name="ID_sexo">
                                    <option selected>Seleccionar</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <!--- FIELD BUTTONS--->
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
<!--- FIELD PARIENTES--->
                        <div id="family-info" class="form-section">
                            <h3>Información Familiar</h3>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPariente">Agregar Pariente</button>
                            <!--- FIELD PARIENTES REGISTRADOS-->
                            <div id="parientes-container">
                                <h4>Parientes Registrados:</h4>
                                <ul id="lista-parientes">
                                    </ul>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
<!--- FIELD UBICACION--->
                        <div id="step4" class="form-section">
                            <h2>Ubicación Geográfica</h2>
                            <!--- FIELD ESTADO--->
                            <div class="form-group mb-3">
                                <label for="ID_estado">Estado</label>
                                <select class="form-control" id="ID_estado" name="ID_estado">
                                    <option selected>Abra este menu</option>
                                    <?php
                                    while($row = $queryEstado->fetch(mode:PDO::FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row['ID'];?>"><?php echo $row['state'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!--- FIELD CIUDAD--->
                            <div class="form-group mb-3">
                                <label for="ID_ciudad">Ciudad</label>
                                <select class="form-control" id="ID_ciudad" name="ID_ciudad">
                                    <option></option>
                                </select>
                            </div>
                            <!--- FIELD MUNICIPIO--->
                            <div class="form-group mb-3">
                                <label for="ID_municipio">Municipio</label>
                                <select class="form-control" id="ID_municipio" name="ID_municipio">
                                    <option></option>
                                </select>
                            </div>
                            <!--- FIELD PARROQUIA--->
                            <div class="form-group mb-3">
                                <label for="ID_parroquia">Parroquia</label>
                                <select class="form-control" id="ID_parroquia" name="ID_parroquia">
                                    <option></option>
                                </select>
                            </div>
                            <!--- FIELD DIRECCION PARTICULAR --->
                            <div class="form-group">
                                <label for="direccion">Dirección de la residencia</label>
                                <textarea class="form-control" id="direccion" name="direccion"></textarea>
                            </div>
                            <!-- FIELD BUTTONS--->
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
<!-- FIELD UBICACION LABORAL--->
                        <div id="step5" class="form-section">
                            <h2>Ubicacion Laboral</h2>
                            <!--- FIELD DIRECCION GENERAL--->
                            <div class="form-group">
                                <label for="cod_ubica">Direccion General</label>
                                <input type="text" class="form-control" id="cod_ubica" name="cod_ubica">
                            </div>
                            <!--- FIELD DIRECCION ESPECIFICA--->
                            <div class="form-group">
                                <label for="cod_ubicaf">Ubicacion Especifica</label>
                                <input type="text" class="form-control" id="cod_ubicaf" name="cod_ubicaf">
                            </div>
                            <!-- FIELD BUTTONS-->
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-primary next-step">Siguiente</button>
                        </div>
<!--- FIELD DATOS CNE--->
                        <div id="step6" class="form-section">
                            <h2>Datos CNE</h2>
                            <!-- FIELD PENSION SOBREVIVIENTE-->
                            <label for="pension_sobreviviente">Percibe Pensión de Sobreviviente</label>
                            <div class="form-check mb-3">
                                <input type="radio" name="pension_sobreviviente" class="form-check-input bg-dark" value="1" id="tiene_pension" >
                                <label for="tiene_pension" class="form-check-label"> SI </label>
                            </div>

                            <div class="form-check mb-3">
                                <input type="radio" name="pension_sobreviviente" class="form-check-input bg-dark" value="0" id="no_tiene_pension" >
                                <label for="no_tiene_pension" class="form-check-label"> NO </label>
                            </div>
                            <!-- FIELD FAMILIAR DENTRO DEL CNE--->
                            <label for="familia_parte_cne" >Tiene un familiar dentro del CNE</label>
                            <div class="form-check mb-3">
                                <input type="radio" name="familia_parte_cne" class="form-check-input bg-dark" value="1" id="tiene_familiar" >
                                <label for="tiene_familiar" class="form-check-label"> SI </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="familia_parte_cne" class="form-check-input bg-dark" value="0" id="no_tiene_familiar" >
                                <label for="no_tiene_familiar" class="form-check-label"> NO </label>
                            </div>
                            <!-- FIELD PADRES COMUN EN EL CNE-->
                            <div class="form-group mb-3">
                                <label for="padres_comun_cne">Padres Común en el CNE</label>
                                <select class="form-control" id="padres_comun_cne" name="padres_comun_cne">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                            <!--- FIELD BUTTONS -->
                            <button type="button" class="btn btn-secondary prev-step">Anterior</button>
                            <button type="button" class="btn btn-success" id="registrarTrabajador" name="registrarTrabajador">Enviar Formulario</button>
                        </div>
                    </div>
                </form>

                <div class="modal fade" id="modalPariente" tabindex="-1" aria-labelledby="modalParienteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title fw-bold" id="modalParienteLabel">Registrar Pariente</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formPariente">
                                    <div class="form-group">
                                        <label for="cedulaPariente">Cedula del Pariente::</label>
                                        <input type="text" class="form-control" pattern="[0-9]{6,8}" minlength="6" maxlength="8" id="cedulaPariente" placeholder="Ingrese cedula del Pariente" name="cedulaPariente">
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre_pariente">Nombre del Pariente:</label>
                                        <input type="text" class="form-control" id="nombrePariente" placeholder="Ingrese el nombre del pariente" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido_pariente">Apellido del Pariente:</label>
                                        <input type="text" class="form-control" id="apellidoPariente" placeholder="Ingrese el apellido del pariente" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="parentesco">Parentesco:</label>
                                        <select class="form-control" id="parentesco" required>
                                            <option value="">Seleccione el parentesco</option>
                                            <option value="padre">Padre</option>
                                            <option value="madre">Madre</option>
                                            <option value="hijo">Hijo</option>
                                            <option value="hija">Hija</option>
                                            <option value="esposo">Esposo</option>
                                            <option value="esposa">Esposa</option>
                                            <option value="hermano">Hermano</option>
                                            <option value="hermana">Hermana</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="discapacidad">Discapacidad:</label>
                                        <select class="form-control" id="discapacidadPariente" name="discapacidadPariente">
                                            <option value="">Seleccione una opción</option>
                                            <option value="ninguna">Ninguna</option>
                                            <option value="fisica">Física</option>
                                            <option value="visual">Visual</option>
                                            <option value="auditiva">Auditiva</option>
                                            <option value="intelectual">Intelectual</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaPariente">Fecha de Nacimiento:</label>
                                        <input type="date" class="form-control" id="fechaPariente" name="fechaPariente">
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
    </div>

    <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            const parientesArrayInput = document.getElementById('parientesArray');
            const formularioPrincipal = document.getElementById('personaForm');

        


            $('#ID_estado').change(function(){
                $('#parroquia').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
                $('#ID_estado option:selected').each(function(){
                    const id_estado = $(this).val();
                    console.log(id_estado)
                    $.post('Controllers/fetch_estado.php',{id_estado:id_estado},function(data){
                        $('#ID_ciudad').html(data);
                    })
                })
            })
            $('#ID_ciudad').change(function(){
                $('#ID_ciudad option:selected').each(function(){
                    const ID_ciudad = $(this).val();
                    $.post('Controllers/fetch_ciudad.php',{ID_ciudad:ID_ciudad},function(data){
                        $('#ID_municipio').html(data)
                    })
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
            }

            $('.next-step').click(function() {
                if (currentSectionIndex < $formSections.length - 1) {
                    currentSectionIndex++;
                    showCurrentSection();
                }
            });

            $('.prev-step').click(function() {
                if (currentSectionIndex > 0) {
                    currentSectionIndex--;
                    showCurrentSection();
                }
            });

            // Mostrar la primera sección al cargar la página
            showCurrentSection();
            //inicio del bloque de codigo encargado del modal de parientes

            var parientes = []; // Array para almacenar los parientes

            // Lógica para agregar parientes al array y mostrar en la lista
                //Capturamos el ID del boton guardar pariente
            $('#guardarPariente').click(function() {
                //Capturamos los campos dentro del modal formulario
                var cedula = $('#cedulaPariente').val();
                var nombre = $('#nombrePariente').val();
                var apellido = $('#apellidoPariente').val();
                var parentesco = $('#parentesco').val();
                var discapacidad = $('#discapacidadPariente').val();
                var fechaNacimiento = $('#fechaPariente').val();
                //Verificamos que los campos contengan algun valor dentro de ellos
                if (nombre && apellido && parentesco && fechaNacimiento) {
                    //llamamos al array que declaramos vacio, y le agregamos los datos del pariente haciendo uso de la function push
                    parientes.push({
                        cedula: cedula,
                        nombre: nombre,
                        apellido: apellido,
                        parentesco: parentesco,
                        discapacidad:discapacidad,
                        fecha_nacimiento: fechaNacimiento
                    });
                    actualizarListaParientes();
                    $('#modalPariente').modal('hide');
                    $('#formPariente')[0].reset(); // Limpiar el formulario del modal
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos Requeridos',
                        text: 'Por favor, complete el nombre, apellido, Fecha de Nacimiento y parentesco del pariente.',
                    });
                }
            });
            // Función para actualizar la lista de parientes en el modal
            function actualizarListaParientes() {
                //variable que contendra la lista de parientes
                var listaHTML = '';
                //Iteramos sobre el array parientes y le pasamos el nuevo no
                parientes.forEach(function(pariente) {
                    listaHTML += `<li>${pariente.nombre} <span class="math-inline"> \ C.I: ${pariente.cedula} \ ${pariente.apellido} \ ( ${pariente.parentesco} </span>)`;
                    if (pariente.fecha_nacimiento) {
                        listaHTML += ` - Nacimiento: ${pariente.fecha_nacimiento}`;
                    }
                    listaHTML += '</li>';
                });
                $('#lista-parientes').html(listaHTML);
            }

            // Cuando se oculta el modal, limpiar el formulario
            $('#modalPariente').on('hidden.bs.modal', function() {
                //Accedemos al indice [0] ya que el selector de ID osea se $ siempre devuelve 1 elemento el indice siempre sera 0 
                $('#formPariente')[0].reset();
            });

            formularioPrincipal.addEventListener('submit', function(evento) {
                // Antes de enviar, convierte el array de parientes a JSON y lo asigna al campo oculto
                parientesArrayInput.value = JSON.stringify(parientes);
                // El formulario principal ahora enviará el campo 'parientes' con la cadena JSON
            });
        });
        
    </script>

</body>
</html>