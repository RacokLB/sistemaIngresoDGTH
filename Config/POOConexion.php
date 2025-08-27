<?php


class Database {
    private $host = "10.100.202.66"; 
    private $dbName = "desarrollo"; 
    private $username = "root";
    private $password = ""; 
    private $pdo;
    private $error;

    public function __construct() {
        // Configuración del DSN (Data Source Name) DSN define el tipo de BASE DE DATOS en este caso MYSQL
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;

        // Opciones para PDO (manejo de errores, modo de fetch por defecto, etc.)
        $options = array(
            PDO::ATTR_PERSISTENT => true,//Intenta usar una conexion persistente con las DB para mejora del rendimiento 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//configura el PDO para que arroje las excepciones en caso de error, lo cual es una buena practica al usar PDO
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC//Establece por defecto que el manejo de las consultas devuelva un array associative 
        );

        // Intenta crear una instancia de PDO
            //Se usa try para tratar de capturar alguna excepcion en caso de un error con las crendenciales o si la base de datos no existe , error es capturado y almacenado en la variable $error
        try {
            $this->pdo = new PDO(dsn: $dsn, username: $this->username, password: $this->password, options: $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Error de conexión a la base de datos: " . $this->error;
        }
    }

    // Método para obtener la instancia de PDO
        //Este metodo permite llamar a la instancia de la conexion PDO($this->pdo)desde fuera de la clase , sirve para que las otras partes de la aplicacion interactuen con la DB
    public function getPDO(): PDO {
        return $this->pdo;
    }

    // Método para manejar errores (opcional, pero útil)
        //En caso de que haya un fallo con la conexion esta function permite acceder al mensaje de error
    public function getError() {
        return $this->error;
    }
}
?>