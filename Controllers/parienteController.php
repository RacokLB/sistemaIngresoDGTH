<?php
    
namespace sistemaIngresoDGTH\Controllers;

use Models\Repositories\parienteRepository;
use PDO;

    class ParienteController{

        private $parienteRepository;
        private $pdo;

        public function __construct(PDO $pdo){
            $this->pdo = $pdo;
            $this->parienteRepository = new ParienteRepository(pdo: $this->pdo);

        }

        public function listarParientes(){
            $parientes = $this->parienteRepository->obtenerParientes();

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
         * Proceso de creacion de un nuevo pariente
         * 
         * @return void//0 no tiene que devolver ningun dato, solo necesitamos una confirmacion de exito o fracaso
         */

        public function crearPariente(){
            //1. Obtener los datos de los parientes del nuevo trabajador
            $datosPariente = $_POST;
            $errores = [];

            if(isset($datosPariente['trabajadorId']) && !empty($datosPariente['trabajadorId'])){
            
            }else{

            }

            if(isset($datosPariente['nombre']) && !empty($datosPariente['nombre'])){
                if(mb_strlen($datosPariente['nombre'], 'UTF-8') > 3);
                
            }else{
                $errores['nombre'] = 'El nombre es requerido';
            }
            
            if(isset($datosPariente['apellido'])&& !empty($datosPariente['apellido'])){
                if(mb_strlen($datosPariente['apellido'], 'UTF-8') > 5){

                }

            }else{
                $errores['apellido'] = 'El apellido es requerida';
            }

            if(isset($datosPariente['fechaNacimiento']) && !empty($datosPariente['fechaNacimiento'])){
                if(mb_strlen($datosPariente['fechaNacimiento'], 'UTF-8') > 4){

                }
            }else{
                $errores['fechaNacimiento'] = 'La fecha de nacimiento es requerida';
            }


            if(isset($datosPariente['parentesco']) && !empty($datosPariente['parentesco'])){

            }else{
                $errores['parentesco'] = 'El parentesco es requerido';
            }
            if(isset($datosPariente['genero']) && !empty($datosPariente['genero'])){

            }else{
                $errores['genero'] = "Debe indicar el genero del pariente";
            }

            if(isset($datosPariente['discapacidad']) && !empty($datosPariente['discapacidad'])){

            }else{
                $errores['discapacidad'] = 'La discapacidad es requerida';
            }

            if(!empty($errores)){
                http_response_code(response_code: 400);
                header('Content-Type: application/json');
                echo json_encode(['errors' => $errores]);
                return;
            }

            //2. Crear una instancia del objeto Pariente
            $nuevoPariente = new \Models\Entities\Pariente(
                null,
                $datosPariente['trabajadorId'] ?? null,
                $datosPariente['cedula'] ?? null,
                $datosPariente['nombre'] ?? null,
                $datosPariente['apellido'] ?? null,
                $datosPariente['fechaNacimiento'] ?? null,
                $datosPariente['parentesco'] ?? null,
                $datosPariente['genero'] ?? null,
                $datosPariente['discapacidad'] ?? null
            );

            //3. Guardar a los parientes del trabajador utilizando el parienteRepository
            $parienteGuardado = $this->parienteRepository->guardar($nuevoPariente);

            if($parienteGuardado){
                http_response_code(201);
                header('Content-Type: application/json');
                echo json_encode($parienteGuardado);
            }else{
                http_response_code(500);
                header(header:'Content-Type: application/json');
                echo json_encode(['error' => 'No se pudo crear el pariente']);
            }
        }

        /**
         * Muestra los detales de un pariente en especifico por su ID
         * @param int $id el ID del pariente que se quiere obtener
         * @return void //
         * 
         */
        public function mostrarPariente(int $id): void{
            $pariente = $this->parienteRepository->obtenerParienteId($id);
        

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
        
        public function actualizarPariente(int $id){
                //1. obtener los datos actualizados del pariente desde el formulario de actualizacion
                
                //Leer el cuerpo de la peticion(InputStream) que contiene el JSON
                $jsonDatos = file_get_contents(filename:'php://input');
                
                //Decodificar el JSON a un array asociativo de PHP
                $datosActualizados = json_decode($jsonDatos, true);

                //verificar si la decodificacion del JSON fue exitosa
                if(json_last_error() !== JSON_ERROR_NONE){
                    http_response_code(400);
                    header('Content-Type: applicacion/json');
                    echo json_encode(['error' => 'Formato de JSON invalido']);

                }
                
        
                //2. Obtener la lista de parientes del trabajador
                $parienteExistente = $this->parienteRepository->obtenerParienteId($id);
        
                if(!$parienteExistente){
                    http_response_code(404);
                    header(header:'Content-Type: application/json');
                    echo json_encode(['error' => 'No se encontraron parientes para este trabajador.']);
                    return;
                }
        
                //4. Actualizar las propiedades del objeto Pariente existente con los nuevos datos
                $parienteExistente->setCedula($datosActualizados['cedula'] ?? $parienteExistente->getCedula());
                $parienteExistente->setNombre($datosActualizados['nombre'] ?? $parienteExistente->getNombre());
                $parienteExistente->setApellido($datosActualizados['apellido'] ?? $parienteExistente->getApellido());
                $parienteExistente->setFechaNacimiento($datosActualizados['fechaNacimiento'] ??
                    $parienteExistente->getFechaNacimiento());
                $parienteExistente->setParentesco($datosActualizados['parentesco'] ??
                    $parienteExistente->getParentesco());
                $parienteExistente->setDiscapacidad($datosActualizados['discapacidad'] ??
                    $parienteExistente->getDiscapacidad());
        
                //5. Guardar los cambios utilizando el Repository (asumiendo que tienes un método para actualizar por ID)
                if($this->parienteRepository->actualizar($parienteExistente)){
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
                if($this->parienteRepository->eliminar($id)){
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