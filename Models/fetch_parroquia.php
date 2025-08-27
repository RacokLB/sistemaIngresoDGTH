<?php

    // Set up error reporting for development
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Ensure your connection script makes $pdo available in this scope
    require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php"; // Adjust path as necessary

    if (isset($_POST['id_municipio'])) {
        try {
            $municipio = $_POST['id_municipio'];

            // Prepare the query without quotes around the placeholder
            // Assuming table_city has an ID_CITY column for the option value
            $query = $pdo->prepare("SELECT ID, parroquias FROM tabla_parroquias WHERE ID_municipio = :id ORDER BY parroquias ASC");
            
            // Bind the value
            $query->bindValue(':id', $municipio, PDO::PARAM_INT); // Assuming ID_STATE is an integer

            // Execute the query
            $query->execute();

            // Initialize the HTML string with a default option
            $html = "<option value='0'>Seleccionar Una parroquia</option>";

            // Fetch results and build options
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    // Ensure the option value is ID_CITY and the display text is CITY
                    $html .= "<option value='" . htmlspecialchars($row['ID']) . "'>" . htmlspecialchars($row['parroquias']) . "</option>";
                }
            } else {
                $html .= "<option value=''>No hay parroquias para este municipio</option>";
            }
            
            // Echo the generated HTML back to the frontend
            echo $html;

        } catch (PDOException $e) {
            // Log the actual error message for debugging, but provide a generic user message
            error_log("Database Error in fetch_parroquia.php: " . $e->getMessage());
            echo "<option value=''>Error al cargar parroquia</option>"; // A more user-friendly error
        } finally {
            // Close the PDO connection
            $pdo = null;
        }
    } else {
        // If id_estado is not received, provide a default or error option
        echo "<option value=''>Seleccione una parroquia</option>";
    }
?>

