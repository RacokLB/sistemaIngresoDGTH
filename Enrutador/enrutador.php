<?php
// Set CORS headers
        header("Access-Control-Allow-Origin: *"); 
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); 
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 

        
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }

// Incluir el namespace correcto del controlador

use sistemaIngresoDGTH\Controllers\TrabajadorController;




class Enrutador {

    private $trabajadorController;


   
    public function __construct(PDO $pdo) {
        // Inyecta la dependencia de PDO al instanciar el controlador
    
        $this->trabajadorController = new TrabajadorController($pdo);
    }


    public function cargarVistas() {
        if (isset($_GET['cargar'])) {
            $vista = $_GET['cargar'];
            if ($this->validarVista($vista)) {
                include_once('View/' . $vista . '.php');
            } else {
                include_once('index.php'); // O manejar de otra manera
            }
        } else {
            include_once('index.php');
            
        }
    }

        public function validarVista($vista) {
            $vistasValidas = ["crearTrabajador","listarTrabajadores", "actualizarTrabajador","validarCedula","estadisticasTotales", "comparativaIngresos","obtenerUltimosTrabajadores","eliminarTrabajador", "mostrarTrabajador", "validarPariente","crearPariente","listarParientes","actualizarPariente","mostrarPariente"];
            return in_array($vista, $vistasValidas);
        }

    // Método para manejar las llamadas a la API
        public function cargarAPI() {
        if (isset($_GET['api'])) {
            $apiLlamada = $_GET['api'];
            $rutasAPI = [
                
                "trabajadores"       => [$this->trabajadorController, 'listarTrabajadores'],
                "trabajador"         => [$this->trabajadorController, 'mostrarTrabajador'],
                "validar_cedula" =>[$this->trabajadorController, 'validarCedula'],
                "crearTrabajador"    => [$this->trabajadorController, 'crearTrabajador'],
                "obtenerUltimosTrabajadores" => [$this->trabajadorController, 'obtenerTrabajadoresRecientes'],
                "totalRegistros" => [$this->trabajadorController, 'estadisticasTotales'],
                "comparativa" =>[$this->trabajadorController, 'comparativaIngresos'],
                "actualizarTrabajador" => [$this->trabajadorController, 'actualizarTrabajador'],
                "eliminarTrabajador" => [$this->trabajadorController, 'eliminarTrabajador'],
                "validarCedulaPariente" =>[$this->trabajadorController,"ValidarPariente"],
                "parientes"          => [$this->trabajadorController, 'listarParientes'],
                "crearPariente"      => [$this->trabajadorController, 'crearPariente'],
                "pariente"           => [$this->trabajadorController, 'mostrarPariente'],
                "actualizarPariente" => [$this->trabajadorController, 'actualizarPariente'],
                "eliminarPariente"   => [$this->trabajadorController, 'eliminarPariente']
                
            ];
            

                if(array_key_exists($apiLlamada, $rutasAPI)){
                    $handler = $rutasAPI[$apiLlamada];
                    // Validacion de parametros que solicitan de un ID o cedula para su ejecucion
                    if ($apiLlamada === "trabajador" || $apiLlamada === "actualizarTrabajador" ||$apiLlamada === "validar_cedula"||$apiLlamada === "validarCedulaPariente"|| $apiLlamada === "eliminarTrabajador" || $apiLlamada === "pariente" || $apiLlamada === "actualizarPariente" || $apiLlamada === "eliminarPariente") {
                        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                            call_user_func($handler, $_GET['id']);
                            
                        } else {
                            http_response_code(400);
                            header('Content-Type: application/json');
                            echo json_encode(['error' => 'Se requiere el parámetro "id" para esta operación']);
                        }
                    }else{
                        call_user_func($handler);
                    }
                }
                        
            } else {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Endpoint de API no encontrado']);
            }
            exit();
        }
    

        // Método principal para enrutar la petición
        public function enrutar() {
            // Primero, intentar cargar la API
            $this->cargarAPI();

            // Si no fue una llamada a la API, intentar cargar una vista
            $this->cargarVistas();
        }
    }


    
?>
