<?php

    require_once '/xampp/htdocs/sistemaIngresoDGTH/Config/POOConexion.php'; // Incluye tu archivo de conexión

        header('Content-Type: application/json'); // Indica que la respuesta será JSON

        $cantidad_a_mostrar = isset($_GET['cantidad']) ? (int)$_GET['cantidad'] : 5; // Obtener la cantidad de la URL, por defecto 5

        try {
            // Consulta SQL para obtener los últimos trabajadores
            // ORDER BY id DESC: Ordena por el ID de forma descendente (los más nuevos tienen IDs más altos)
            // o puedes usar ORDER BY fecha_registro DESC si tienes esa columna.
            // LIMIT $cantidad_a_mostrar: Limita el número de resultados.
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
