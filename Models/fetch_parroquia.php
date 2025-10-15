<?php

   
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

 
    require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php"; 

    if (isset($_POST['id_municipio'])) {
        try {
            $municipio = $_POST['id_municipio'];

            
            $query = $pdo->prepare("SELECT ID, parroquias FROM tabla_parroquias WHERE ID_municipio = :id ORDER BY parroquias ASC");
            
       
            $query->bindValue(':id', $municipio, PDO::PARAM_INT); 

         
            $query->execute();

          
            $html = "<option value='0'>Seleccionar Una parroquia</option>";

            
            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                   
                    $html .= "<option value='" . htmlspecialchars($row['ID']) . "'>" . htmlspecialchars($row['parroquias']) . "</option>";
                }
            } else {
                $html .= "<option value=''>No hay parroquias para este municipio</option>";
            }
            
            
            echo $html;

        } catch (PDOException $e) {
            
            error_log("Database Error in fetch_parroquia.php: " . $e->getMessage());
            echo "<option value=''>Error al cargar parroquia</option>"; 
        } finally {
        
            $pdo = null;
        }
    } else {
      
        echo "<option value=''>Seleccione una parroquia</option>";
    }
?>

