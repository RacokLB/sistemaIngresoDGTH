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
         * Muestra la lista de todos los trabajadores.
         * 
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
        $datosTrabajador = $_POST; // Capturar los datos en una variable para luego hacer las validaciones
        $errores = [];

        if (isset($datosTrabajador['nacionalidad'])&& !empty($datosTrabajador['nacionalidad'])) {
            
        }else{
            $errores['nacionalidad'] = 'La nacionalidad es requerida';
        }

        if (isset($datosTrabajador['cedula']) && !empty($datosTrabajador['cedula'])){
            if(mb_strlen($datosTrabajador['cedula'], 'UTF-8') < 7 || mb_strlen($datosTrabajador['cedula'], 'UTF-8') > 8) {
            }
        }else{
            $errores['cedula'] = 'La cédula es requerida';
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

        if (isset($datosTrabajador['estadoCivil']) && !empty($datosTrabajador['estadoCivil'])) {
            if(mb_strlen($datosTrabajador['estadoCivil'],'UTF-8') < 3 || mb_strlen($datosTrabajador['estadoCivil'],'UTF-8') > 15){
            }
        }else{
            $errores['estadoCivil'] = 'El estado civil es requerido';
        }

        if (isset($datosTrabajador['fechaNacimiento'])&& !empty($datosTrabajador['fechaNacimiento'])) {
            
        }else{
            $errores['fechaNacimiento'] = 'La fecha de nacimiento es requerida';
        }

        if (isset($datosTrabajador['genero']) && !empty($datosTrabajador['genero'])) {
            
        }else{
            $errores['genero'] = 'El género es requerido';
        }

        if (isset($datosTrabajador['numeroContacto']) && empty($datosTrabajador['numeroContacto'])) {
            if(mb_strlen($datosTrabajador['numeroContacto'],'UTF-8') < 11 || mb_strlen($datosTrabajador['numeroContacto'],'UTF-8') > 12){

            }
        }else{
            $errores['numeroContacto'] = 'El número de contacto es requerido';
        }

        if (isset($datosTrabajador['rif']) && !empty($datosTrabajador['rif'])) {
            if(mb_strlen($datosTrabajador['rif'], 'UTF-8') < 8 || mb_strlen($datosTrabajador['rif'],'UTF-8') > 9 ){
            }
        }else{
            $errores['rif'] = 'El RIF es requerido';
        }

        if (isset($datosTrabajador['fechaIngreso']) && !empty($datosTrabajador['fechaIngreso'])) {
            
        }else{
            $errores['fechaIngreso'] = 'La fecha de ingreso es requerida';
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

        if (isset($datosTrabajador['tipoTrabajador'])&& !empty($datosTrabajador['tipoTrabajador'])) {
            
        }else{
            $errores['tipoTrabajador'] = 'El tipo de trabajador es requerido';
        }

        if (isset($datosTrabajador['direccionGeneral'])&& !empty($datosTrabajador['direccionGeneral'])) {
            
        }else{
            $errores['direccionGeneral'] = 'La dirección general es requerida';
        }

        if (isset($datosTrabajador['direccionEspecifica'])&& !empty($datosTrabajador['direccionEspecifica'])) {
            
        }else{
            $errores['direccionEspecifica'] = 'La dirección específica es requerida';
        }

        if (isset($datosTrabajador['pensionSobreviviente'])&& !empty($datosTrabajador['pensionSobreviviente'])) {
            
        }else{
            $errores['pensionSobreviviente'] = 'La pensión de sobreviviente es requerida';
        }

        if (isset($datosTrabajador['familiarCNE'])&& !empty($datosTrabajador['familiarCNE'])) {
            
        }else{
            $errores['familiarCNE'] = 'El familiar CNE es requerido';
        }

        if (isset($datosTrabajador['padresComunCNE'])&& !empty($datosTrabajador['padresComunCNE'])) {
            
        }else{
            $errores['padresComunCNE'] = 'Los padres comunes CNE son requeridos';
        }
        
        if (isset($datosTrabajador['codCargo'])&& !empty($datosTrabajador['codCargo'])) {
            
        }else{
            $errores['codCargo'] = 'El código de cargo es requerido';
        }

        //Verficar si existen errores, en caso de que existan devuelve el codigo 400 con los errores en formato JSON
        if (!empty($errores)) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errores]);
            return;
        }


        // 2. Crear una instancia del objeto Trabajador
        $nuevoTrabajador = new \Models\Entities\Trabajador( // Coloca el namespace de la Entidad
            null, // El ID se generará automáticamente
            $datosTrabajador['nacionalidad'] ?? null,
            $datosTrabajador['cedula'] ?? null,
            $datosTrabajador['nombre'] ?? null,
            $datosTrabajador['apellido'] ?? null,
            $datosTrabajador['estadoCivil'] ?? null,
            $datosTrabajador['fechaNacimiento'] ?? null,
            $datosTrabajador['genero'] ?? null,
            $datosTrabajador['numeroContacto'] ?? null,
            $datosTrabajador['rif'] ?? null,
            $datosTrabajador['fechaIngreso'] ?? null,
            $datosTrabajador['estado'] ?? null,
            $datosTrabajador['ciudad'] ?? null,
            $datosTrabajador['municipio'] ?? null,
            $datosTrabajador['parroquia'] ?? null,
            $datosTrabajador['direccion'] ?? null,
            $datosTrabajador['tipoTrabajador'] ?? null,
            $datosTrabajador['direccionGeneral'] ?? null,
            $datosTrabajador['direccionEspecifica'] ?? null,
            $datosTrabajador['codCargo'] ?? null,
            $datosTrabajador['pensionSobreviviente'] ?? null,
            $datosTrabajador['familiarCNE'] ?? null,
            $datosTrabajador['padresComunCNE'] ?? null,
        );

        // 3. Guardar el nuevo trabajador utilizando el Repository
        $trabajadorGuardado = $this->trabajadorRepository->guardar($nuevoTrabajador);

        // 4. Retornar una respuesta (por ejemplo, el trabajador creado o un mensaje de éxito)
         if ($trabajadorGuardado) {
            http_response_code(201); // Código de "Creado"
            header('Content-Type: application/json');
            echo json_encode($trabajadorGuardado);
        } else {
            http_response_code(500); // Código de "Error interno del servidor"
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No se pudo crear el trabajador']);
        }
    }

    /**
     * Procesa la actualización de la información de un trabajador existente.
     *
     * @param int $id El ID del trabajador a actualizar.
     * @return void // No se necesita que regrese algun value
     */
    public function actualizarTrabajador(int $id) {
        // 1. Obtener los datos actualizados del trabajador desde la petición (PUT data, etc.)
        // (Similar a crearTrabajador, pero asegurándote de incluir el ID)
        $datosActualizados = $_POST; // Ejemplo básico

        // 2. Obtener el trabajador existente para asegurarse de que existe
        $trabajadorExistente = $this->trabajadorRepository->obtenerPorId($id);

        if (!$trabajadorExistente) {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Trabajador no encontrado']);
            return;
        }

        // 3. Actualizar las propiedades del objeto Trabajador existente con los nuevos datos
        $trabajadorExistente->setNacionalidad($datosActualizados['nacionalidad'] ?? $trabajadorExistente->getNacionalidad());
        $trabajadorExistente->setCedula($datosActualizados['cedula'] ?? $trabajadorExistente->getCedula());
        $trabajadorExistente->setNombre($datosActualizados['nombre'] ?? $trabajadorExistente->getNombre());
        $trabajadorExistente->setApellido($datosActualizados['apellido'] ?? $trabajadorExistente->getApellido());
        $trabajadorExistente->setEstadoCivil($datosActualizados['estadoCivil'] ?? $trabajadorExistente->getEstadoCivil());
        $trabajadorExistente->setFechaNacimiento($datosActualizados['fechaNacimiento'] ?? $trabajadorExistente->getFechaNacimiento());
        $trabajadorExistente->setGenero($datosActualizados['genero'] ?? $trabajadorExistente->getGenero());
        $trabajadorExistente->setNumeroContacto($datosActualizados['numeroContacto'] ?? $trabajadorExistente->getNumeroContacto());
        $trabajadorExistente->setRif($datosActualizados['rif'] ?? $trabajadorExistente->getRif());
        $trabajadorExistente->setFechaIngreso($datosActualizados['fechaIngreso'] ?? $trabajadorExistente->getFechaIngreso());
        $trabajadorExistente->setEstado($datosActualizados['estado'] ?? $trabajadorExistente->getEstado());
        $trabajadorExistente->setCiudad($datosActualizados['ciudad'] ?? $trabajadorExistente->getCiudad());
        $trabajadorExistente->setMunicipio($datosActualizados['municipio'] ?? $trabajadorExistente->getMunicipio());
        $trabajadorExistente->setParroquia($datosActualizados['parroquia'] ?? $trabajadorExistente->getParroquia());
        $trabajadorExistente->setDireccion($datosActualizados['direccion'] ?? $trabajadorExistente->getDireccion());
        $trabajadorExistente->setTipoTrabajador($datosActualizados['tipoTrabajador'] ?? $trabajadorExistente->getTipoTrabajador());
        $trabajadorExistente->setDireccionGeneral($datosActualizados['direccionGeneral'] ?? $trabajadorExistente->getDireccionGeneral());
        $trabajadorExistente->setDireccionEspecifica($datosActualizados['direccionEspecifica'] ?? $trabajadorExistente->getDireccionEspecifica());
        $trabajadorExistente->setCodCargo($datosActualizados['codCargo'] ?? $trabajadorExistente->getCodCargo());
        $trabajadorExistente->setPensionSobreviviente($datosActualizados['pensionSobreviviente'] ?? $trabajadorExistente->getPensionSobreviviente());
        $trabajadorExistente->setFamiliarCNE($datosActualizados['familiarCNE'] ?? $trabajadorExistente->getFamiliarCNE());
        $trabajadorExistente->setPadresComunCNE($datosActualizados['padresComunCNE'] ?? $trabajadorExistente->getPadresComunCNE());

        // 4. Guardar los cambios utilizando el Repository
        if ($this->trabajadorRepository->actualizar($trabajadorExistente)) {
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
    public function eliminarTrabajador(int $id) {
        if ($this->trabajadorRepository->eliminar($id)) {
            http_response_code(204); // Código de "Sin contenido" (eliminación exitosa)
            // No se suele enviar cuerpo en la respuesta 204
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Trabajador no encontrado']);
        }
    }
}
    

?>