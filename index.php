<?php

                // Ensure session_start() is at the very beginning if not in an included file
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            if(!isset($_SESSION['rol'])){
                header(header:"location login.php");
            }else{
                if(isset($_SESSION['rol'])){
                    header(header: "location index.php");
                }
            }
        }

        // Set CORS headers
        header("Access-Control-Allow-Origin: http://10.100.202.66"); // ONLY allow requests from this specific IP
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE"); // Allow these HTTP methods
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); // Allow these headers

        // Handle preflight OPTIONS requests
        // Browsers send an OPTIONS request before certain cross-origin requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            http_response_code(200);
            exit();
        }

       


        require_once 'Config/abrir_conexion.php'; 
        require_once 'Enrutador/enrutador.php';
        
        require_once 'Controllers/TrabajadorController.php'; 
        
        require_once 'Models/Repositories/trabajadorRepository.php'; 
        require_once 'Models/Entities/Trabajador.php'; 
        


        //Obten la conexion PDO

        $database = new Database();
        $pdo = $database->getPDO();
        $error = $database->getError();

        
        //Instancia el enrutador, pasando la conexion PDO
        $enrutador = new Enrutador($pdo);
        $enrutador->enrutar();//llama al metodo principal del enrutador
        
?>
