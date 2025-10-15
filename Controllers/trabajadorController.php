<?php

namespace sistemaIngresoDGTH\Controllers;

use Models\Repositories\trabajadorRepository;
use PDO;

    class TrabajadorController{
        private $trabajadorRepository;
        private $pdo;

        public function __construct(PDO $pdo){
            $this->pdo = $pdo;
            $this->trabajadorRepository = new trabajadorRepository(pdo: $this->pdo);

        }

        /**
     * Valida si una cédula existe en la base de datos.
     * Retorna JSON con 'success' y 'existe'.
     * @param int $cedula La cédula a verificar.
     */
        public function validarCedula(int $cedula) {
            
            // Opcional: Limpiar y estandarizar la cédula aquí también,
           
            $cedulaLimpia = preg_replace('/[^0-9VEJ]/i', '', $cedula);
            

            if (empty($cedulaLimpia)) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => 'Cédula no proporcionada o con formato inválido.']);
                return;
            }
            $trabajador = $this->trabajadorRepository->findByCedula($cedulaLimpia);
            if($trabajador){
                echo json_encode([
                    'success' => true,
                    'existe' => true,
                    'message' => '¡Cedula ya Registrada'
                ]);
            }else{
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'existe' => false,
                    'message' => 'Cedula Disponible'
                ]);
            }
            
        }

      
        public function estadisticasTotales (){
            $registros = $this->trabajadorRepository->obtenerTotales();
            if(!empty($registros)|| $registros === []){
                    //Envio en formato JSON 
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $registros]);
            }else{
                header('Content-Type: application/json');
                http_response_code(response_code:500);
                echo json_encode(['success' => false, 'message' => 'Error al obtener los calculos.']);
            }
        }

        public function comparativaIngresos(){
            $queryIngresos = $this->trabajadorRepository->comparativaIngresos();
            if(!empty($queryIngresos)||$queryIngresos === []){
                //Envio en formato JSON 
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'data' => $queryIngresos]);

            }else{
                header('Content-Type: application/json');
                http_response_code(response_code:500);
                echo json_encode(['success' => false, 'message' => 'Error al obtener los datos para el grafico']);
            }
        }

        /**
         * Resultados de obtenerTrabajadores
         * @return void
         */
        public function obtenerTrabajadoresRecientes(): void{
            $trabajadores = $this->trabajadorRepository->obtenerUltimosTrabajadores();
           if (!empty($trabajadores) || $trabajadores === []) { 
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'data' => $trabajadores]);
                } else {
                    header('Content-Type: application/json');
                    http_response_code(500); 
                    echo json_encode(['success' => false, 'message' => 'Error al obtener los trabajadores.']);
                }
        }
        /**
         * Muestra la lista de todos los trabajadores.
         * Recopilacion de listarTrabajadores donde traemos a todos los trabajadores
         * @return void
         */
        
        public function listarTrabajadores(){
            $trabajadores = $this->trabajadorRepository->obtenerTrabajadores();
            //Envio en formato JSON:
            header('Content-Type: application/json');
            echo json_encode($trabajadores);
        }

        /**
     * Muestra los detalles de un trabajador específico por su ID.
     *
     * @param int $id El ID del trabajador.
     * @return void //  
     */
    public function mostrarTrabajador(int $id) {
        $trabajador = $this->trabajadorRepository->obtenerPorId($id);

        if ($trabajador) {
            // Ejemplo para retornar como JSON:
            header('Content-Type: application/json');
            echo json_encode($trabajador);
        } else {
            // Manejar el caso en que el trabajador no se encuentra
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Trabajador no encontrado']);
        }
    }

    /**
     * Procesa la creación de un nuevo trabajador.
     *
     * @return void // no es necesario que retorne un valor , ya que solo necesitamos una confirmacion de exito o fracaso
     */
        public function crearTrabajador() {

            // 1. Obtener los datos del nuevo trabajador desde la petición (POST enviada desde el formulario)
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $datosTrabajador = $_POST;
                
                $errores = [];

                if (isset($datosTrabajador['cedula']) && !empty($datosTrabajador['cedula'])){
                    if(mb_strlen($datosTrabajador['cedula'], 'UTF-8') < 7 || mb_strlen($datosTrabajador['cedula'], 'UTF-8') > 8) {
                    }
                }else{
                    $errores['cedula'] = 'La cédula es requerida';
                }

                if (isset($datosTrabajador['nacionalidad'])&& !empty($datosTrabajador['nacionalidad'])) {
                    
                }else{
                    $errores['nacionalidad'] = 'La nacionalidad es requerida';
                }

                
                if (isset($datosTrabajador['rif']) && !empty($datosTrabajador['rif'])) {
                    if(mb_strlen($datosTrabajador['rif'], 'UTF-8') < 8 || mb_strlen($datosTrabajador['rif'],'UTF-8') > 9 ){
                    }
                }else{
                    $errores['rif'] = 'El RIF es requerido';
                }
                
                if (isset($datosTrabajador['nombre']) && !empty($datosTrabajador['nombre'])) {
                    if(mb_strlen($datosTrabajador['nombre'],'UTF-8') < 3 || mb_strlen($datosTrabajador['nombre'],'UTF-8') > 30){

                    }
                    
                }else{
                    $errores['nombre'] = 'El nombre es requerido';
                }

                if (isset($datosTrabajador['apellido'])&& !empty($datosTrabajador['apellido'])) {
                    if(mb_strlen($datosTrabajador['apellido'],'UTF-8') < 5 || mb_strlen($datosTrabajador['apellido'],'UTF-8') > 40){
                    
                    }
                }else{
                    $errores['apellido'] = 'El apellido es requerido';

                }

                if (isset($datosTrabajador['fechaNacimiento'])&& !empty($datosTrabajador['fechaNacimiento'])) {
                    
                }else{
                    $errores['fechaNacimiento'] = 'La fecha de nacimiento es requerida';
                }

                if (isset($datosTrabajador['estadoCivil']) && !empty($datosTrabajador['estadoCivil'])) {
                    if(mb_strlen($datosTrabajador['estadoCivil'],'UTF-8') < 3 || mb_strlen($datosTrabajador['estadoCivil'],'UTF-8') > 15){
                    }
                }else{
                    $errores['estadoCivil'] = 'El estado civil es requerido';
                }

                if (isset($datosTrabajador['genero']) && !empty($datosTrabajador['genero'])) {
                    
                }else{
                    $errores['genero'] = 'El género es requerido';
                }

                if(isset($datosTrabajador['discapacidad']) && !empty($datosTrabajador['discapacidad'])){

                }else{
                    $errores['discapacidad'] = 'Indique si tiene o no alguna discapacidad';
                }

                if(isset($datosTrabajador['estatus']) && !empty($datosTrabajador['estatus'])){

                }else{
                    $errores['estatus'] = 'Debe indicar el estatus del funcionario';
                }

                if(isset($datosTrabajador['compania']) && !empty($datosTrabajador['compania'])){
                }else{
                    $errores['compania'] = 'Debe indicar la compañia del funcionario';
                }

                if (isset($datosTrabajador['fechaIngreso']) && !empty($datosTrabajador['fechaIngreso'])) {
                    
                }else{
                    $errores['fechaIngreso'] = 'La fecha de ingreso es equerida';
                }
                if (isset($datosTrabajador['tipoTrabajador'])&& !empty($datosTrabajador['tipoTrabajador'])) {
                    
                }else{
                    $errores['tipoTrabajador'] = 'El tipo de trabajador es requerido';
                }

                if (isset($datosTrabajador['ubicacionGeneral'])&& !empty($datosTrabajador['ubicacionGeneral'])) {
                    
                }else{
                    $errores['ubicacionGeneral'] = 'La dirección general es requerida';
                }

                if (isset($datosTrabajador['ubicacionEspecifica'])&& !empty($datosTrabajador['ubicacionEspecifica'])) {
                    
                }else{
                    $errores['ubicacionEspecifica'] = 'La dirección específica es requerida';
                }
                if(isset($datosTrabajador['ubicacion']) && !empty($datosTrabajador['ubicacion'])){

                }else{
                    $errores['ubicacion'] = 'Indique en cual sede trabaja el funcionario';
                }

                if(isset($datosTrabajador['instruccion']) && !empty($datosTrabajador['instruccion'])){

                }else{
                    $errores['instruccion'] = 'Debe indicar el nivel de instruccion del funcionario';
                }

                if (isset($datosTrabajador['codCargo'])&& !empty($datosTrabajador['codCargo'])) {
                    
                }else{
                    $errores['codCargo'] = 'El código de cargo es requerido';
                }

                if(isset($datosTrabajador['numeroContacto']) && !empty($datosTrabajador['numeroContacto'])){

                }else{
                    $errores['numeroContacto'] = 'Debe indicar el numero de contacto del funcionario';
                }
                
                if (isset($datosTrabajador['estado'])&& !empty($datosTrabajador['estado'])) {
                    
                }else{
                    $errores['estado'] = 'El estado es requerido';
                }

                if (isset($datosTrabajador['ciudad'])&& !empty($datosTrabajador['ciudad'])) {
                    
                }else{
                    $errores['ciudad'] = 'La ciudad es requerida';
                }

                if (isset($datosTrabajador['municipio'])&& !empty($datosTrabajador['municipio'])) {
                    
                }else{
                    $errores['municipio'] = 'El municipio es requerido';
                }

                if (isset($datosTrabajador['parroquia'])&& !empty($datosTrabajador['parroquia'])) {
                    
                }else{
                    $errores['parroquia'] = 'La parroquia es requerida';
                }

                if (isset($datosTrabajador['direccion'])&& !empty($datosTrabajador['direccion'])) {
                    
                }else{
                    $errores['direccion'] = 'La dirección es requerida';
                }

                
                    // 2. Crear una instancia del objeto Trabajador
                $nuevoTrabajador = new \Models\Entities\Trabajador( 
                    null, // El ID se generará automáticamente
                    $datosTrabajador['cedula'] ?? null,
                    $datosTrabajador['nacionalidad'] ?? null,
                    $datosTrabajador['rif'] ?? null,
                    $datosTrabajador['apellido'] ?? null,
                    $datosTrabajador['nombre'] ?? null,
                    $datosTrabajador['fechaNacimiento'] ?? null,
                    $datosTrabajador['estadoCivil'] ?? null,
                    $datosTrabajador['genero'] ?? null,
                    $datosTrabajador['discapacidad'] ?? null,
                    $datosTrabajador['numeroContacto'] ?? null,
                    $datosTrabajador['estatus'] ?? null,
                    $datosTrabajador['compania'] ?? null,
                    $datosTrabajador['fechaIngreso'] ?? null,
                    $datosTrabajador['tipoTrabajador'] ?? null,
                    $datosTrabajador['ubicacionGeneral'] ?? null,
                    $datosTrabajador['ubicacionEspecifica'] ?? null,
                    $datosTrabajador['ubicacion'] ?? null,
                    $datosTrabajador['instruccion'] ?? null,
                    $datosTrabajador['codCargo'] ?? null,
                    $datosTrabajador['cargoDirector'] ?? null,
                    $datosTrabajador['edad'] ?? null,
                    $datosTrabajador['estado'] ?? null,
                    $datosTrabajador['ciudad'] ?? null,
                    $datosTrabajador['municipio'] ?? null,
                    $datosTrabajador['parroquia'] ?? null,
                    $datosTrabajador['direccion'] ?? null,
                );
                // VALIDACION DE LOS CAMPOS PARIENTES 
                
                //Verficar si existen errores, en caso de que existan devuelve el codigo 400 con los errores en formato JSON
                if (!empty($errores)) {
                    http_response_code(400);
                    header('Content-Type: application/json');
                    echo json_encode(['errors' => $errores]);
                    return;
                }
                // 3. Recibir y decodificar el JSON de parientes 
                $parientesJSON = $_POST['parientesArray'] ?? '[]';
                
               
                error_log("Attempting to decode parientesJSON: '" . $parientesJSON . "'");

                $parientes = json_decode($parientesJSON, true);

                if($parientesJSON){
                    //Validacion de que el JSON no tenga errores y que su formato sea un Array 
                    if(json_last_error() === JSON_ERROR_NONE && is_array($parientes)){
                        
                        //4. Asignar los parientes al objeto Trabajador
                        $nuevoTrabajador->parientes = $parientes;
            
                    }else{
                        // Bloque de codigo para manejar errores en formato JSON.
                        $errorMessage = 'Error al decodificar la información de parientes: ' . json_last_error_msg();
                        error_log($errorMessage . " | Input that failed: '" . $parientesJSON . "'");
                        $errores['parientes'] = $errorMessage;
                        // Si el JSON de parientes está mal formado, debería ser un error fatal.
                        // Retorna un error 400 y detiene la ejecución.
                        http_response_code(400);
                        header('Content-Type: application/json');
                        echo json_encode(['errors' => $errores]);
                        
                        return;
                    }
                }else{
                        // Verifica if $_POST['parientesJson'] es null o avoid ""
                        error_log("parientesJson is empty or null, no relatives to process.");
                        
                        // Asegura $nuevoTrabajador->parientes es inicializado como un array vacio
                        $nuevoTrabajador->parientes = []; 
                }

                //El campo parientes es el nombre del input hidden en el formulario HTML
                
                 // 3. Guardar el nuevo trabajador utilizando el Repository
                $trabajadorGuardado = $this->trabajadorRepository->guardar($nuevoTrabajador);

                // 4. Retornar una respuesta (por ejemplo, el trabajador creado o un mensaje de éxito)
                if ($trabajadorGuardado) {
                    header("Location: ../sistemaIngresoDGTH/View/listarTrabajadores.php");
                    exit();
                } else {
                    http_response_code(500); // Código de "Error interno del servidor"
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'No se pudo crear el trabajador']);
                }
            }
        
            

        
        }
    

    /**
     * Procesa la actualización de la información de un trabajador existente.
     *
     * @param int $id El ID del trabajador a actualizar.
     * @return void // No se necesita que regrese algun value
     */
    public function actualizarTrabajador(int $cedula) {
        // 1. Obtener los datos actualizados del trabajador desde la petición (PUT data, etc.)
        // (Similar a crearTrabajador, pero se debe incluir el ID)

            // Leer el cuerpo de la petición (InputStream) que contiene el JSON
        $jsonDatos = file_get_contents(filename: 'php://input');

        //DEBUGGING IN THE START 
        //Log the raw JSON data to the PHP error log
        error_log("Raw JSON received for actualizarTrabajador: ". $jsonDatos);

        // Decodificar el JSON a un array asociativo de PHP
        $datosActualizados = json_decode($jsonDatos, true);

       
        error_log("Decoded data for actualizarTrabajador: ". print_r($datosActualizados, true));

        

        // Verificar si la decodificación JSON fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400); // Bad Request
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Formato de JSON invalido']);
            return;
        }

        // 2. Obtener el trabajador existente para asegurarse de que existe
        $trabajadorExistente = $this->trabajadorRepository->obtenerPorId($cedula);

        if (!$trabajadorExistente) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Trabajador no encontrado']);
            return;
        }

        // 3. Actualizar las propiedades del objeto Trabajador existente con los nuevos datos
        $trabajadorExistente->setCedula($datosActualizados['cedula'] ?? $trabajadorExistente->getCedula());
        $trabajadorExistente->setNacionalidad($datosActualizados['nacionalidad'] ?? $trabajadorExistente->getNacionalidad());
        $trabajadorExistente->setRif($datosActualizados['rif'] ?? $trabajadorExistente->getRif());
        $trabajadorExistente->setApellido($datosActualizados['apellido'] ?? $trabajadorExistente->getApellido());
        $trabajadorExistente->setNombre($datosActualizados['nombre'] ?? $trabajadorExistente->getNombre());
        $trabajadorExistente->setFechaNacimiento($datosActualizados['fechaNacimiento'] ?? $trabajadorExistente->getFechaNacimiento());
        $trabajadorExistente->setEstadoCivil($datosActualizados['estadoCivil'] ?? $trabajadorExistente->getEstadoCivil());
        $trabajadorExistente->setGenero($datosActualizados['genero'] ?? $trabajadorExistente->getGenero());
        $trabajadorExistente->setDiscapacidad($datosActualizados['discapacidad'] ?? $trabajadorExistente->getDiscapacidad());
        $trabajadorExistente->setNumeroContacto($datosActualizados['numeroContacto'] ?? $trabajadorExistente->getNumeroContacto());
        $trabajadorExistente->setEstatus($datosActualizados['estatus'] ?? $trabajadorExistente->getEstatus());
        $trabajadorExistente->setCompania($datosActualizados['compania'] ?? $trabajadorExistente->getCompania());
        $trabajadorExistente->setFechaIngreso($datosActualizados['fechaIngreso'] ?? $trabajadorExistente->getFechaIngreso());
        $trabajadorExistente->setTipoTrabajador($datosActualizados['tipoTrabajador'] ?? $trabajadorExistente->getTipoTrabajador());
        $trabajadorExistente->setUbicacionGeneral($datosActualizados['direccionGeneral'] ?? $trabajadorExistente->getUbicacionGeneral());
        $trabajadorExistente->setUbicacionEspecifica($datosActualizados['direccionEspecifica'] ?? $trabajadorExistente->getUbicacionEspecifica());
        $trabajadorExistente->setUbicacion($datosActualizados['ubicacion'] ?? $trabajadorExistente->getUbicacion());
        $trabajadorExistente->setGradoAcademico($datosActualizados['instruccion'] ?? $trabajadorExistente->getGradoAcademico());
        $trabajadorExistente->setCodCargo($datosActualizados['codCargo'] ?? $trabajadorExistente->getCodCargo());
        $trabajadorExistente->setCargoDirector($datosActualizados['cargoDirector'] ?? $trabajadorExistente->getCargoDirector());
        $trabajadorExistente->setEstado($datosActualizados['estado'] ?? $trabajadorExistente->getEstado());
        $trabajadorExistente->setCiudad($datosActualizados['ciudad'] ?? $trabajadorExistente->getCiudad());
        $trabajadorExistente->setMunicipio($datosActualizados['municipio'] ?? $trabajadorExistente->getMunicipio());
        $trabajadorExistente->setParroquia($datosActualizados['parroquia'] ?? $trabajadorExistente->getParroquia());
        $trabajadorExistente->setDireccion($datosActualizados['direccion'] ?? $trabajadorExistente->getDireccion());
        
        // 4. Guardar los cambios utilizando el Repository
        if ($this->trabajadorRepository->actualizar($trabajadorExistente)) {
            error_log("valor enviado por front: ". $trabajadorExistente->getUbicacion());
            error_log("valor enviado por el front: ". $trabajadorExistente->getNumeroContacto());
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Trabajador actualizado con éxito']);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No se pudo actualizar el trabajador']);
        }
    }     
    /**
     * Elimina un trabajador por su ID.
     *
     * @param int $id El ID del trabajador a eliminar.
     * @return void // la function en caso de fallar devuelve un codigo directo al navegador 404 y lo mismo sucede si la function se ejecuta codigo 204
     */
    public function eliminarTrabajador(int $cedula) {
        if ($this->trabajadorRepository->eliminar($cedula)) {
            http_response_code(204); // Código de "Sin contenido" (eliminación exitosa)
            
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Trabajador no encontrado']);
        }
    }
    

    /**
     * Valida si una cédula existe en la base de datos.
     * Retorna JSON con 'success' y 'existe'.
     * @param int $cedula La cédula a verificar.
     */
        public function validarPariente(int $cedulaPariente) {
            
          
            $cedulaDepurada = preg_replace('/[^0-9VEJ]/i', '', $cedulaPariente);
            

            if (empty($cedulaDepurada)) {
                http_response_code(400); // Bad Request
                echo json_encode(['success' => false, 'message' => 'Cédula no proporcionada o con formato inválido.']);
                return;
            }
            $pariente = $this->trabajadorRepository->findByCedulaPariente($cedulaDepurada);
            if($pariente){
                echo json_encode([
                    'success' => true,
                    'existe' => true,
                    'message' => '¡Cedula ya Registrada'
                ]);
            }else{
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'existe' => false,
                    'message' => 'Cedula Disponible'
                ]);
            }
            
        }

    public function listarParientes(){
            $parientes = $this->trabajadorRepository->obtenerParientes();

            if($parientes){
                header('Content-type: application/json');
                echo json_encode($parientes);
            }else{
                http_response_code(404);
                header('Content-type: application/json');
                echo json_encode(['error' => 'No se encontraron parientes para el trabajador']);
            }
        }

        /**
         * Muestra los detales de un pariente en especifico por su ID
         * @param int $id el ID del pariente que se quiere obtener
         * @return void //
         * 
         */
        public function mostrarPariente(int $idPariente): void{
            $pariente = $this->trabajadorRepository->obtenerParienteId($idPariente);
        

            if($pariente){
                //Ejemplo para retornar como JSON:
                header('Content-Type: application/json');
                echo json_encode($pariente);
            }else{
                //Manejar el caso de que el pariente no se encuentre
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Pariente no encontrado']);
            }
            
        }

        /**
         * @param int $id el ID del  pariente a Actualizar
         * @return void // No se necesita que regrese algun value
         * 
         */
        
        public function actualizarPariente(int $idPariente){
                //1. obtener los datos actualizados del pariente desde el formulario de actualizacion
                
                //Leer el cuerpo de la peticion(InputStream) que contiene el JSON
                $jsonDatos = file_get_contents(filename:'php://input');

                // --- DEBUGGING START ---
                // Log the raw JSON data to the PHP error log
                error_log("Raw JSON received for actualizarPariente: " . $jsonDatos);
                
                //Decodificar el JSON a un array asociativo de PHP
                $datosActualizados = json_decode($jsonDatos, true);
                
              
                error_log("Decoded data for actualizarPariente: " . print_r($datosActualizados, true));

                //verificar si la decodificacion del JSON fue exitosa
                if(json_last_error() !== JSON_ERROR_NONE){
                    http_response_code(400);
                    header('Content-Type: applicacion/json');
                    echo json_encode(['error' => 'Formato de JSON invalido']);

                }
                
        
                //2. Obtener la lista de parientes del trabajador
                $parienteExistente = $this->trabajadorRepository->obtenerParienteId($idPariente);
        
                if(!$parienteExistente){
                    http_response_code(404);
                    header(header:'Content-Type: application/json');
                    echo json_encode(['error' => 'No se encontraron parientes para este trabajador.']);
                    return;
                }
        
                //4. Actualizar las propiedades del objeto Pariente existente con los nuevos datos
                //NOTA estos campos son los nombres traidos del JSON , no son los datos dentro de la DB 
                $parienteExistente->setTrabajadorId($datosActualizados['trabajadorId'] ?? $parienteExistente->getTrabajadorId());
                $parienteExistente->setCedulaPariente($datosActualizados['cedulaPariente'] ?? $parienteExistente->getCedulaPariente());
                $parienteExistente->setNombrePariente($datosActualizados['nombrePariente'] ?? $parienteExistente->getNombrePariente());
                $parienteExistente->setApellidoPariente($datosActualizados['apellidoPariente'] ?? $parienteExistente->getApellidoPariente());
                $parienteExistente->setFechaNacimientoPariente($datosActualizados['fechaNacimientoPariente'] ??
                    $parienteExistente->getFechaNacimientoPariente());
                $parienteExistente->setParentesco($datosActualizados['parentesco'] ??
                    $parienteExistente->getParentesco());
                $parienteExistente->setGeneroPariente($datosActualizados['generoPariente'] ??
                    $parienteExistente->getGeneroPariente());
                $parienteExistente->setDiscapacidadPariente($datosActualizados['discapacidadPariente'] ??
                    $parienteExistente->getDiscapacidadPariente());
        
                //5. Guardar los cambios utilizando el Repository
                if($this->trabajadorRepository->actualizarPariente($parienteExistente)){
                    header(header:'Content-Type: application/json');
                    echo json_encode(['message' => 'Pariente actualizado con exito']);
                }else{
                    http_response_code(response_code: 500);
                    header(header:'Content-Type: application/json');
                    echo json_encode(['error' => 'No se pudo actualizar el pariente']);
                }
            }
            
        

        /**
         * 
         * @param int $id El ID del pariente a eliminar
         * @return void // la function en caso de fallar devuelve un codigo directo al navegador 404
         * 
         *  */   

            public function eliminarPariente(int $id){
                if($this->trabajadorRepository->eliminarPariente($id)){
                    http_response_code(204);
                    //No se suele enviar cuerpo en la respuesta 204
                }else{
                    http_response_code(404);
                    header(header: 'Content-Type: application/json');
                    echo json_encode(['error' => 'Pariente no encontrado']);
                }
            }
    }
    

?>
