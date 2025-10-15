<?php

    require_once '/xampp/htdocs/sistemaIngresoDGTH/Config/POOConexion.php'; 

        header('Content-Type: application/json');

        $cantidad_a_mostrar = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 5; 

        try {
            // Consulta SQL para obtener los últimos trabajadores
            $stmt = $pdo->prepare("SELECT cedula, nombre, apellido FROM tabla_personal ORDER BY id DESC LIMIT :cantidad");
            $stmt->bindParam(':cantidad', $cantidad_a_mostrar, PDO::PARAM_INT);
            $stmt->execute();

            // Obtener todos los resultados como un array asociativo
            $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Devolver los datos en formato JSON
            echo json_encode(['success' => true, 'data' => $trabajadores]);

        } catch(PDOException $e) {
            // En caso de error, devolver un JSON con el mensaje de error
            echo json_encode(['success' => false, 'message' => 'Error al obtener los trabajadores: ' . $e->getMessage()]);
        }

    $pdo = null; // Cierra la conexión
?>
