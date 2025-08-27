<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <!-- Table Element -->
     <div class="container-fluid">

        <div class="card border-3">
            <div class="card-header">
                <h4 class="card-title fw-bold">
                    Tabla de Seleccion
                </h4>
                <h6 class="card-subtitle text-muted">
                    Base de datos de los trabajadores activos del Consejo Nacional Electoral.
                </h6>
            </div>
            <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                <label for="buscar" class="form-label fw-bold fs-5">Introduzca CI o Nombre</label>
                <p class="placeholder-glow col-6 bg-dark">
                <span class="placeholder col-12">
                <input type="text" autocomplete="off"  name="buscar" id="buscar" class="form-control bg-light text-dark fw-bold fs-4" placeholder="Buscar..." title="Introduzca Nombre, Apellido o CI">
                </span>                    
                </p>
                </div>
            </form>
            <div class="">
                <table class="table able-striped table-hover shadow-lg">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Cedula</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Estado Civil</th>
                            <th scope="col">Fecha Nacimiento</th>
                            <th scope="col">Genero</th>
                            <th scope="col">Numero de Contacto</th>
                            <th scope="col">Rif</th>
                            <th scope="col">Fecha de Ingreso</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Ciudad</th>
                            <th scope="col">Municipio</th>
                            <th scope="col">Parroquia</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">Tipo de Trabajador</th>
                            <th scope="col">Direccion General</th>
                            <th scope="col">Direccion Especifica</th>
                            <th scope="col">Pension Sobreviviente</th>
                            <th scope="col">Familia en el CNE</th>
                            <th scope="col">Padres en el CNE</th>
                            <th scope="col">Nacionalidad</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Accion</th>
                        </tr>
                    </thead>
                    <tbody id="tablaTrabajadores">
                        
                    </tbody>
                </table>
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
        document.addEventListener('DOMContentLoaded', () => {
            const tablaTrabajadoresBody = document.getElementById('tablaTrabajadores');
            const apiUrl = 'Controllers/trabajadorController.php'; // Coloca el path de la API

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(trabajadores => {
                    console.log(trabajadores)
                    // 'trabajadores' es el array de objetos JSON que devuelve la API

                    if (trabajadores && trabajadores.length > 0) {
                        trabajadores.forEach(trabajador => {
                            // Crear una nueva fila (<tr>) para cada trabajador
                            const fila = tablaTrabajadoresBody.insertRow();

                            // Crear las celdas (<script>) para cada columna
                            const celdaId = fila.insertCell();
                            const celdaCedula = fila.insertCell();
                            const celdaNombre = fila.insertCell();
                            const celdaApellido = fila.insertCell();
                            const celdaEstadoCivil = fila.insertCell();
                            const celdaFechaNacimiento = fila.insertCell();
                            const celdaGenero = fila.insertCell();
                            const celdaNumeroContacto = fila.insertCell();
                            const celdaRif = fila.insertCell();
                            const celdaFechaIngreso = fila.insertCell();
                            const celdaEstado = fila.insertCell();
                            const celdaCiudad = fila.insertCell();
                            const celdaMunicipio = fila.insertCell();
                            const celdaParroquia = fila.insertCell();
                            const celdaDireccion = fila.insertCell();
                            const celdaTipoTrabajador = fila.insertCell();
                            const celdaDireccionGeneral = fila.insertCell();
                            const celdaDireccionEspecifica = fila.insertCell();
                            const celdaPensionSobreviviente = fila.insertCell();
                            const celdaFamiliaEnCNE = fila.insertCell();
                            const celdaPadresEnCNE = fila.insertCell();
                            const celdaNacionalidad = fila.insertCell();
                            const celdaCargo = fila.insertCell();
                            
                            // Crea más celdas según los campos de tu objeto trabajador

                            // Insertar los datos del trabajador en las celdas
                            celdaId.textContent = trabajador.id;
                            celdaCedula.textContent = trabajador.cedula;
                            celdaNombre.textContent = trabajador.nombre;
                            celdaApellido.textContent = trabajador.apellido;
                            celdaEstadoCivil.textContent = trabajador.estadoCivil;
                            celdaFechaNacimiento.textContent = trabajador.fechaNacimiento;
                            celdaGenero.textContent = trabajador.genero;
                            celdaNumeroContacto.textContent = trabajador.numeroContacto;
                            celdaRif.textContent = trabajador.rif;
                            celdaFechaIngreso.textContent = trabajador.fechaIngreso;
                            celdaEstado.textContent = trabajador.estado;
                            celdaCiudad.textContent = trabajador.ciudad;
                            celdaMunicipio.textContent = trabajador.municipio;
                            celdaParroquia.textContent = trabajador.parroquia;
                            celdaDireccion.textContent = trabajador.direccion;
                            celdaTipoTrabajador.textContent = trabajador.tipoTrabajador;
                            celdaDireccionGeneral.textContent = trabajador.direccionGeneral;
                            celdaDireccionEspecifica.textContent = trabajador.direccionEspecifica;
                            celdaPensionSobreviviente.textContent = trabajador.pensionSobreviviente;
                            celdaFamiliaEnCNE.textContent = trabajador.familiaEnCNE;
                            celdaPadresEnCNE.textContent = trabajador.padresEnCNE;
                            celdaNacionalidad.textContent = trabajador.nacionalidad;
                            celdaCargo.textContent = trabajador.cargo;

                            // Asigna los valores de los otros campos a sus respectivas celdas
                        });
                    } else {
                        // Si no hay trabajadores, mostrar un mensaje en la tabla
                        const fila = tablaTrabajadoresBody.insertRow();
                        const celda = fila.insertCell();
                        celda.colSpan = 23; // Ajusta el colSpan al número de columnas de tu tabla
                        celda.textContent = 'No se encontraron trabajadores.';
                        celda.style.textAlign = 'center';
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los trabajadores:', error);
                    const fila = tablaTrabajadoresBody.insertRow();
                    const celda = fila.insertCell();
                    celda.colSpan = 23; // Ajusta el colSpan al número de columnas de tu tabla
                    celda.textContent = 'Error al cargar los datos.';
                    celda.style.textAlign = 'center';
                });
        })
    </script>
</body>

</html>