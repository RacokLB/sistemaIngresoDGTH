<?php
// Trabajador.php
namespace Models\Repositories;

use Models\Entities\Trabajador;
use PDO;
use PDOException;

class TrabajadorRepository {
    private $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function obtenerTotales():array{
            // Query 1: Get overall totals
            $sqlTotales = "SELECT
                                (SELECT COUNT(*) FROM tabla_personal) AS totalTrabajadores,
                                (SELECT COUNT(*) FROM parientes) AS totalParientes,
                                (SELECT COUNT(ubicacion) FROM tabla_personal) AS totalPorSede";

            // Query 2: Query to get personal for (sede)
            $sqlPersonalPorSede = "SELECT
                                        
                                        ts.nombre_sede,
                                        COUNT(tp.cedula) AS personalSede
                                FROM
                                        tabla_personal tp
                                INNER JOIN
                                        tabla_sede ts ON tp.ubicacion = ts.codigo_sede
                                GROUP BY
                                        ts.nombre_sede";

            try {
                // Execute Query 1
                $stmtTotales = $this->pdo->prepare($sqlTotales);
                $stmtTotales->execute();
                $totales = $stmtTotales->fetch(PDO::FETCH_ASSOC); // Fetch one row for totals

                // Execute Query 2
                $stmtPersonalPorSede = $this->pdo->prepare($sqlPersonalPorSede);
                $stmtPersonalPorSede->execute();
                $personalPorSede = $stmtPersonalPorSede->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows for sede breakdown

                // Combine results into a single array for easier return
                return [
                    'totalPersonas' => $totales,
                    'por_sede' => $personalPorSede
                ];

            } catch (PDOException $e) {
                error_log("Error al obtener los totales: " . $e->getMessage());
                return [];
            }
        }
        

        public function obtenerUltimosTrabajadores(): array { // El método ahora devuelve un array
            $sql = "SELECT cedula, nombres, apellidos, horaRegistro FROM tabla_personal ORDER BY id DESC LIMIT 8";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();

                // Devuelve los datos como un array asociativo
                $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $trabajadores; // <-- ¡Aquí está el cambio!

            } catch(PDOException $e) {
                // En caso de error, registra el mensaje y devuelve un array vacío
                error_log('Error al obtener los últimos trabajadores: ' . $e->getMessage());
                return []; // Devuelve un array vacío en caso de error
            }
        }

        public function comparativaIngresos(): array{
            $sql = "SELECT
                        YEAR(horaRegistro) AS ano,                 -- Extracts the year (e.g., 2023, 2024)
                        MONTH(horaRegistro) AS mes,          -- Extracts the month number (e.g., 1 for January, 2 for February)
                        DATE_FORMAT(horaRegistro, '%Y-%m') AS anoFormato, -- Formats as 'YYYY-MM' (e.g., '2023-01') for easy sorting/labeling
                        DATE_FORMAT(horaRegistro, '%M') AS nombreMes,   -- Gets the full month name (e.g., 'January', 'February')
                        COUNT(*) AS total_personas                    -- Counts the number of people for that month/year
                    FROM
                        tabla_personal
                    GROUP BY
                        ano,
                        anoFormato,
                        nombreMes                                    -- Group by year and month to get distinct monthly counts
                    ORDER BY
                        ano ASC,
                        mes ASC                               -- Order chronologically
                        ";
            try{
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();

                //Devuelve los datos en un array asociativo
                $ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $ingresos;
            }catch(PDOException $e){
                error_log("Error al traer los calculos mensuales de ingresos : " . $e->getMessage());
                return [];
            }
        }

        
        /**
         * Verificacion de existencia de la CI dentro de la base de datos previo a su envio
         * 
         * @param Trabajador es el objeto a ser consultado
         * @return null en caso de que el trabajador no exista y si el trabajador existe retorna sus datos
         */
        public function findByCedula(string $cedula): ?Trabajador {
            $sql = "SELECT * FROM tabla_personal WHERE cedula = :cedula";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':cedula', $cedula);
                $stmt->execute();
                $data = $stmt->fetch();

                if ($data) {
                    // Assuming you have a method to create a Trabajador object from array data
                    // Or you can directly map it if you have a constructor that accepts an array
                    $trabajador = new Trabajador();
                    // Manually map properties for example (better to have a method in entity)
                    $trabajador->id = $data['id'] ?? null; // If you have an ID column
                    $trabajador->cedula = $data['cedula'];
                    $trabajador->nacionalidad = $data['nacionalidad'];
                    // ... map all other properties from $data to $trabajador
                    return $trabajador;
                }
                return null; // No worker found
            } catch (PDOException $e) {
                error_log("Error al buscar trabajador por cédula: " . $e->getMessage());
                return null;
            }
        }

        
        /**
         * Guarda un nuevo trabajador en la base de datos.
         * 
         * @param Trabajador $trabajador El objeto Trabajador a guardar.
         * 
         * @return ?Trabajador El objeto Trabajador a guardar usar el ? significa que puede ser null
         */
        public function guardar(Trabajador $trabajador): ?Trabajador {
                // SQL for main worker data
                $sql = "INSERT INTO tabla_personal (cedula, nacionalidad, rif, apellidos, nombres, fecha_nacimiento, estadoCivil, genero, discapacidad, numeroContacto, estatus, compania, fecha_ingreso, tipo_trabajador, ubicacion_general, ubicacion_especifica, ubicacion, instruccion, cargo, cargo_director) 
                        VALUES (:cedula, :nacionalidad, :rif, :apellidos, :nombres, :fecha_nacimiento, :estadoCivil, :genero, :discapacidad, :numeroContacto, :estatus, :compania, :fecha_ingreso, :tipo_trabajador, :ubicacionGeneral, :ubicacionEspecifica, :ubicacion, :instruccion, :cargo, :cargo_director)";
                
                // SQL for worker's address
                $sqlDireccion = "INSERT INTO direccion_funcionario (ced_persona, estado, ciudad, municipio, parroquia, direccion) 
                                VALUES (:cedula, :estado, :ciudad, :municipio, :parroquia, :direccion)";
                
                // SQL for a single relative (this query is correct, but you'll use it in a loop)
                $sqlPariente = "INSERT INTO parientes (trabajador_id, cedula, nombre, apellido, fechaNacimiento, parentesco, genero, discapacidad) 
                                VALUES (:trabajadorId, :cedula, :nombre, :apellido, :fechaNacimiento, :parentesco, :genero, :discapacidad)";

                try {
                    // Start a transaction to ensure data integrity
                    $this->pdo->beginTransaction();

                    // --- 1. Insert Main Trabajador Data ---
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindValue(':cedula', $trabajador->getCedula());
                    $stmt->bindValue(':nacionalidad', $trabajador->getNacionalidad());
                    $stmt->bindValue(':rif', $trabajador->getRif());
                    $stmt->bindValue(':apellidos', $trabajador->getApellido());
                    $stmt->bindValue(':nombres', $trabajador->getNombre());
                    $stmt->bindValue(':fecha_nacimiento', $trabajador->getFechaNacimiento());
                    $stmt->bindValue(':estadoCivil', $trabajador->getEstadoCivil());
                    $stmt->bindValue(':genero', $trabajador->getGenero());
                    $stmt->bindValue(':discapacidad', $trabajador->getDiscapacidad());
                    $stmt->bindValue(':numeroContacto', $trabajador->getNumeroContacto());
                    $stmt->bindValue(":estatus", $trabajador->getEstatus());
                    $stmt->bindValue(":compania", $trabajador->getCompania());
                    $stmt->bindValue(':fecha_ingreso', $trabajador->getFechaIngreso());
                    $stmt->bindValue(':tipo_trabajador', $trabajador->getTipoTrabajador());
                    $stmt->bindValue(':ubicacionGeneral', $trabajador->getUbicacionGeneral());
                    $stmt->bindValue(':ubicacionEspecifica', $trabajador->getUbicacionEspecifica());
                    $stmt->bindValue(':ubicacion', $trabajador->getUbicacion());
                    $stmt->bindValue(":instruccion", $trabajador->getGradoAcademico()); // Changed getGradoAcademico to getInstruccion based on your Trabajador fields. Confirm this is correct.
                    $stmt->bindValue(':cargo', $trabajador->getCodCargo());
                    $stmt->bindValue(":cargo_director", $trabajador->getCargoDirector());
                    $stmt->execute();

                    // Get the worker's ID (assuming 'cedula' is your primary key or a unique identifier for `tabla_personal`)
                    // If tabla_personal uses an auto-increment ID, you'd use $this->pdo->lastInsertId();
                    // However, since you're using 'cedula' as the foreign key for 'parientes', it's better to use 'cedula' here.
                    $trabajadorIdForRelations = $trabajador->getCedula(); 
                    // If your `trabajador_id` in `parientes` is truly the `id` from `tabla_personal` (auto-increment primary key),
                    // you'd need to fetch that last inserted ID *if* 'cedula' is not the primary key.
                    // For now, assuming 'cedula' is the link. If not, clarify your DB schema for `tabla_personal` primary key.

                    // --- 2. Insert Trabajador's Address Data ---
                    $stmtDireccion = $this->pdo->prepare($sqlDireccion);
                    $stmtDireccion->bindValue(':cedula', $trabajadorIdForRelations); // Use the worker's cedula as FK
                    $stmtDireccion->bindValue(':estado', $trabajador->getEstado());
                    $stmtDireccion->bindValue(':ciudad', $trabajador->getCiudad());
                    $stmtDireccion->bindValue(':municipio', $trabajador->getMunicipio());
                    $stmtDireccion->bindValue(':parroquia', $trabajador->getParroquia());
                    $stmtDireccion->bindValue(':direccion', $trabajador->getDireccion());
                    $stmtDireccion->execute();

                    // --- 3. Insert Parientes Data (Loop through the array) ---
                    // Prepare the pariente statement *once* outside the loop for efficiency
                    $stmtPariente = $this->pdo->prepare($sqlPariente);

                    // Access the parientes array from the Trabajador object
                    // (Assumes you have a public $parientes property or a getParientes() method in Trabajador entity)
                    $parientes = $trabajador->parientes ?? []; // Get the array, default to empty if not set

                    foreach ($parientes as $pariente) {
                        // Bind values for EACH pariente in the loop
                        $stmtPariente->bindValue(':trabajadorId', $trabajadorIdForRelations); // Link to the main worker
                        $stmtPariente->bindValue(':cedula', $pariente['cedulaPariente'] ?? null); // Use null if optional
                        $stmtPariente->bindValue(':nombre', $pariente['nombrePariente'] ?? null);
                        $stmtPariente->bindValue(':apellido', $pariente['apellidoPariente'] ?? null);
                        $stmtPariente->bindValue(':fechaNacimiento', $pariente['fechaNacimientoPariente'] ?? null); // Note: frontend uses 'fechaNacimiento', DB uses 'fechaNacimiento'. Ensure consistency.
                        $stmtPariente->bindValue(':parentesco', $pariente['parentesco'] ?? null);
                        $stmtPariente->bindValue(':genero', $pariente['generoPariente'] ?? null); // Frontend uses 'generoPariente'
                        $stmtPariente->bindValue(':discapacidad', $pariente['discapacidadPariente'] ?? null);
                        
                        // Execute the statement for the current pariente
                        $stmtPariente->execute();
                    }

                    // Commit the transaction if all insertions were successful
                    $this->pdo->commit();

                    // Optionally, if tabla_personal has an auto-increment ID and you need it
                    // $trabajador->setId($this->pdo->lastInsertId());

                    // Return the worker object (now potentially with an ID and populated parientes)
                    return $trabajador;

                } catch (PDOException $e) {
                    // Rollback the transaction on any error
                    $this->pdo->rollBack(); 
                    error_log("Error al guardar el trabajador y/o parientes: " . $e->getMessage());
                    return null; // Return null to indicate failure
                }
            }

    /**
     * obtiene un trabajador por su ID.
     * 
     * @param int $cedula La cedula del trabajador a obtener.
     * @return ?Trabajador El objeto Trabajador encontrado o null si no existe 
     */ 

    public function obtenerPorId(int $cedula): ?Trabajador {
        $sql = "SELECT
                tabla_personal.id,
                tabla_personal.cedula,
                tabla_personal.nacionalidad,
                tabla_personal.rif,
                tabla_personal.apellidos,
                tabla_personal.nombres,
                tabla_personal.fecha_nacimiento,
                tabla_personal.estadoCivil,
                tabla_personal.genero,
                tabla_personal.discapacidad,
                tabla_personal.numeroContacto,
                tabla_personal.estatus,
                tabla_personal.compania,
                tabla_personal.fecha_ingreso,
                tabla_personal.tipo_trabajador,
                tabla_personal.ubicacion_general,
                tabla_personal.ubicacion_especifica,
                tabla_personal.ubicacion,
                tabla_personal.instruccion,
                tabla_personal.cargo,
                tabla_personal.cargo_director,
                direccion_funcionario.estado,
                direccion_funcionario.ciudad,
                direccion_funcionario.municipio,
                direccion_funcionario.parroquia,
                direccion_funcionario.direccion
                FROM tabla_personal
                LEFT JOIN direccion_funcionario ON tabla_personal.cedula = direccion_funcionario.ced_persona
                WHERE tabla_personal.cedula = :cedula";
            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':cedula', $cedula, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row){
                    return new Trabajador(
                        id: $row['id'],
                        cedula: $row['cedula'],
                        nacionalidad: $row['nacionalidad'],
                        rif: $row['rif'],
                        apellido: $row['apellidos'],
                        nombre: $row['nombres'],
                        fechaNacimiento: $row['fecha_nacimiento'],
                        estadoCivil: $row['estadoCivil'],
                        genero: $row['genero'],
                        discapacidad:$row['discapacidad'],
                        numeroContacto: $row['numeroContacto'],
                        estatus:$row['estatus'],
                        compania: $row['compania'],
                        fechaIngreso: $row['fecha_ingreso'],
                        tipoTrabajador: $row['tipo_trabajador'],
                        ubicacionGeneral: $row['ubicacion_general'],
                        ubicacionEspecifica: $row['ubicacion_especifica'],
                        ubicacion:$row['ubicacion'],
                        gradoAcademico:$row['instruccion'],
                        codCargo: $row['cargo'], // Assuming you have this in your constructor
                        cargoDirector:$row['cargo_director'],
                        estado: $row['estado'],
                        ciudad: $row['ciudad'],
                        municipio: $row['municipio'],
                        parroquia: $row['parroquia'],
                        direccion: $row['direccion']
                        
                    );
                }
                return null;
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                error_log("Error al obtener al Funcionario: " . $e->getMessage());
                return null;
            }
        }

    /**
     *Obtiene todos los trabajadores de la base de datos.
     * 
     * @return array<Trabajador> Un array de los datos de los trabajadores, o un array vacio en caso de error o si no hay trabajadores
     */

            public function obtenerTrabajadores(): array {
            $sql = "SELECT 
                tabla_personal.id,
                tabla_personal.cedula,
                tabla_personal.nacionalidad,
                tabla_personal.rif,
                tabla_personal.apellidos,
                tabla_personal.nombres,
                tabla_personal.estatus, 
                tabla_personal.compania,
                tabla_personal.fecha_ingreso,
                tabla_personal.tipo_trabajador,
                tabla_general.nombre_direccion,
                tabla_ubiespecifica.direccionE,
                cargos.desc_cargo,
                tabla_cargodirectores.nombre_cargoD,
                TIMESTAMPDIFF(year, tabla_personal.fecha_nacimiento,NOW()) AS edad
                FROM tabla_personal
                LEFT JOIN tabla_general ON tabla_personal.ubicacion_general = tabla_general.cod_ubiGeneral
                LEFT JOIN tabla_ubiespecifica ON tabla_personal.ubicacion_especifica = tabla_ubiespecifica.cod_ubiEspecifica
                LEFT JOIN cargos ON tabla_personal.cargo = cargos.cod_cargo
                LEFT JOIN tabla_cargodirectores ON tabla_personal.cargo_director = tabla_cargodirectores.codigo_cargo
                WHERE tabla_personal.tipo_trabajador != 'JPV' AND tabla_personal.tipo_trabajador != 'JPS' AND tabla_personal.tipo_trabajador != 'JPI' AND tabla_personal.tipo_trabajador != 'JVA' AND tabla_personal.tipo_trabajador != 'CUF'
                ";
            try {
                

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $trabajadores = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Use FETCH_ASSOC for associative array keys
                    $trabajadores[] = new Trabajador(
                        id: $row['id'],
                        cedula: $row['cedula'],
                        nacionalidad: $row['nacionalidad'],
                        rif: $row['rif'],
                        apellido: $row['apellidos'],
                        nombre: $row['nombres'],
                        edad:$row['edad'],
                        estatus: $row['estatus'],
                        fechaIngreso: $row['fecha_ingreso'],
                        tipoTrabajador: $row['tipo_trabajador'],
                        ubicacionGeneral: $row['nombre_direccion'],
                        ubicacionEspecifica: $row['direccionE'],
                        codCargo: $row['desc_cargo'],
                        cargoDirector: $row['nombre_cargoD'] // Assuming you have this in your constructor
                    );
                }
                
                return $trabajadores;
            } catch (PDOException $e) {
                
                error_log("Error al obtener los trabajadores: " . $e->getMessage());
                return [];
            }
        }
     /**
      *Actualiza la informacion de un trabajador en la base de datos 
      *
      *@param Trabajador busca a un pariente dentro de la base de datos
      *@return bool True si la actualizacion fue exitosa, false en caso contrario
      */

    public function findByCedulaPariente(int $cedulaPariente): ?Trabajador {
            $sql = "SELECT 
                            EXISTS (
                                SELECT 1 FROM tabla_personal WHERE cedula = :cedula)
                                    OR EXISTS (
                                    SELECT 1 FROM parientes WHERE cedula  = :cedula)
                                    AS Existe";

            try {
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':cedula', $cedulaPariente, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch();

                if ($data['Existe']) {
                    // Assuming you have a method to create a Trabajador object from array data
                    // Or you can directly map it if you have a constructor that accepts an array
                    $pariente = new Trabajador();
                    // Manually map properties for example (better to have a method in entity)
                    //$pariente->id = $data['id'] ?? null; // If you have an ID column
                    //$pariente->cedula = $data['cedula'];
                    // ... map all other properties from $data to $trabajador
                    return $pariente;
                }
                return null; // No worker found
            } catch (PDOException $e) {
                error_log("Error al buscar el pariente por cédula: " . $e->getMessage());
                return null;
            }
        }

    public function actualizar(Trabajador $trabajador): bool {
        $sql = "UPDATE tabla_personal SET cedula = :cedula, nacionalidad = :nacionalidad, rif = :rif, apellidos = :apellido, nombres = :nombre, fecha_nacimiento = :fechaNacimiento, estadoCivil = :estadoCivil, genero = :genero, discapacidad = :discapacidad, numeroContacto = :numeroContacto, estatus = :estatus, compania = :compania, fecha_ingreso = :fechaIngreso, tipo_trabajador = :tipoTrabajador, ubicacion_general = :direccionGeneral, ubicacion_especifica = :direccionEspecifica, ubicacion = :ubicacion, instruccion = :instruccion, cargo = :codCargo, cargo_director = :cargoDirector WHERE cedula = :cedula";
        $sqlDireccion = "UPDATE direccion_funcionario SET ced_persona = :cedula, estado = :estado, ciudad = :ciudad, municipio = :municipio, parroquia = :parroquia, direccion = :direccion WHERE ced_persona = :cedula";
        try {
            //Iniciar una transaccion para asegurar la integridad de los datos
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':cedula', $trabajador->getCedula());
            $stmt->bindValue(':nacionalidad', $trabajador->getNacionalidad());
            $stmt->bindValue(':rif', $trabajador->getRif());
            $stmt->bindValue(':apellido', $trabajador->getApellido());
            $stmt->bindValue(':nombre', $trabajador->getNombre());
            $stmt->bindValue(':fechaNacimiento', $trabajador->getFechaNacimiento());
            $stmt->bindValue(':estadoCivil', $trabajador->getEstadoCivil());
            $stmt->bindValue(':genero', $trabajador->getGenero());
            $stmt->bindValue(':discapacidad', $trabajador->getDiscapacidad());
            $stmt->bindValue(':numeroContacto', $trabajador->getNumeroContacto());
            $stmt->bindValue(':estatus',$trabajador->getEstatus());
            $stmt->bindValue(':compania',$trabajador->getCompania());
            $stmt->bindValue(':fechaIngreso',$trabajador->getFechaIngreso());
            $stmt->bindValue(':tipoTrabajador', $trabajador->getTipoTrabajador());
            $stmt->bindValue(':direccionGeneral', $trabajador->getUbicacionGeneral());
            $stmt->bindValue(':direccionEspecifica', $trabajador->getUbicacionEspecifica());
            $stmt->bindValue(':ubicacion', $trabajador->getUbicacion());
            $stmt->bindValue(':instruccion',$trabajador->getGradoAcademico());
            $stmt->bindValue(':codCargo', $trabajador->getCodCargo());
            $stmt->bindValue(':cargoDirector', $trabajador->getCargoDirector());
            
            $stmt->execute();
            $stmt->rowCount();
            error_log("Row affected for update : " . $stmt->rowCount());

            
            $stmtDireccion = $this->pdo->prepare($sqlDireccion);
            $stmtDireccion->bindValue(":cedula", $trabajador->getCedula());
            $stmtDireccion->bindValue(":estado", $trabajador->getEstado());
            $stmtDireccion->bindValue(":ciudad", $trabajador->getCiudad());
            $stmtDireccion->bindValue(":municipio", $trabajador->getMunicipio());
            $stmtDireccion->bindValue(":parroquia",$trabajador->getParroquia());
            $stmtDireccion->bindValue(":direccion",$trabajador->getDireccion());
            $stmtDireccion->execute();

            // Confirmar la transacción
            $this->pdo->commit();
            return true;
        }catch(PDOException $e){
            // Rollback en caso de error para evitar cambios no deseados
            $this->pdo->rollback();
            error_log("Error al actualizar el trabajador: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un trabajador de la base de datos por su cedula.
     * 
     * @param int $cedula la cedula del trabajador a eliminar.
     * @return bool True si la eliminacion fue exitosa, false en caso contrario.
     * 
     */

    public function eliminar(int $cedula): bool {
        $sql = "DELETE FROM tabla_personal WHERE cedula = :cedula";
        $sqlDireccion = "DELETE FROM direccion_funcionario WHERE ced_persona = :cedula";
        try{
            $stmt = $this->pdo->prepare($sql);

            $this->pdo->beginTransaction(); 
            
            $stmt->bindValue(':cedula', $cedula, PDO::PARAM_INT);
            $stmt->execute();
            $stmtDireccion = $this->pdo->prepare($sqlDireccion);
            $stmtDireccion->bindValue(':cedula', $cedula, PDO::PARAM_INT);
            $stmtDireccion->execute();            

            $this->pdo->commit();
            return true;
        }catch(PDOException $e){
            // Rollback en caso de error para evitar cambios no deseados
            $this->pdo->rollback();
            error_log("Error al eliminar el trabajador: " . $e->getMessage());
            return false;
        }
    }

        public function obtenerParienteId(int $id): ?Trabajador {

            $sql ="SELECT * FROM parientes WHERE id = :id";
            try{
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch();
                if($row){
                    return new Trabajador(
                        idPariente:$row['id'],
                        trabajadorId:$row['trabajador_id'],
                        cedulaPariente:$row['cedula'],
                        nombrePariente:$row['nombre'],
                        apellidoPariente:$row['apellido'],
                        fechaNacimientoPariente:$row['fechaNacimiento'],
                        parentesco:$row['parentesco'],
                        generoPariente:$row['genero'],
                        discapacidadPariente:$row['discapacidad']
                        
                    );
                }
                return null;
            }catch(PDOException $e){
                error_log("Error al obtener al Pariente".$e->getMessage());
                return null;
            }
        }

        /**
         * Summary of obtenerParientes
         * @return array<Trabajador> Un array de los datos de los parientes , o un array vacio en caso de no obtener ningun dato 
         */
        public function obtenerParientes(): array{
            $sql = "SELECT id,trabajador_id,cedula,nombre,apellido,parentesco,genero,discapacidad, TIMESTAMPDIFF(year,fechaNacimiento,NOW()) AS edad FROM parientes";
            try{
                $this->pdo->beginTransaction();
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $parientes = [];
                while($row = $stmt->fetch()){
                    $parientes [] = new Trabajador(
                        idPariente:$row['id'],
                        trabajadorId:$row['trabajador_id'],
                        cedulaPariente:$row['cedula'],
                        nombrePariente:$row['nombre'],
                        apellidoPariente:$row['apellido'],
                        fechaNacimientoPariente:$row['edad'],
                        parentesco:$row['parentesco'],
                        generoPariente:$row['genero'],
                        discapacidadPariente:$row['discapacidad']

                    );
                }
                $this->pdo->commit();
                return $parientes;
            }catch(PDOException $e){
                $this->pdo->rollBack();
                error_log('Error al obtener a los parientes: ' . $e->getMessage());
                return [];
            }
        }
        public function actualizarPariente(Trabajador $pariente): bool {
            $stmt = $this->pdo->prepare("UPDATE parientes SET trabajador_id = :trabajadorId, cedula = :cedulaPariente, nombre = :nombrePariente, apellido = :apellidoPariente, fechaNacimiento = :fechaNacimientoPariente, parentesco = :parentesco, genero = :generoPariente, discapacidad = :discapacidadPariente WHERE id = :id");
            $stmt->bindValue(':trabajadorId', $pariente->getTrabajadorId());
            $stmt->bindValue(':cedulaPariente', $pariente->getCedulaPariente());
            $stmt->bindValue(':nombrePariente', $pariente->getNombrePariente());
            $stmt->bindValue(':apellidoPariente', $pariente->getApellidoPariente());
            $stmt->bindValue(':fechaNacimientoPariente', $pariente->getFechaNacimientoPariente());
            $stmt->bindValue(':parentesco', $pariente->getParentesco());
            $stmt->bindValue(':generoPariente' , $pariente->getGeneroPariente());
            $stmt->bindValue(':discapacidadPariente', $pariente->getDiscapacidadPariente());
            $stmt->bindValue(':id', $pariente->getIdPariente());
            return $stmt->execute();
        }

        public function eliminarPariente(int $id): bool {
            $stmt = $this->pdo->prepare("DELETE FROM parientes WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT );
            return $stmt->execute();
        }
    }






?>