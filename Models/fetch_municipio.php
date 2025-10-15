<?php

        
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

       
        require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php"; 

        if (isset($_POST['ID_ciudad'])) {
            try {
                $ciudad = $_POST['ID_ciudad'];

              
                $query = $pdo->prepare("SELECT ID, municipios FROM tabla_municipios WHERE ID_STATE = :id ORDER BY municipios ASC");
                
            
                $query->bindValue(':id', $ciudad, PDO::PARAM_INT); 

               
                $query->execute();

               
                $html = "<option value='0'>Selecciona un Municipio</option>";

                
                if ($query->rowCount() > 0) {
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                       
                        $html .= "<option value='" . htmlspecialchars($row['ID']) . "'>" . htmlspecialchars($row['municipios']) . "</option>";
                    }
                } else {
                    $html .= "<option value=''>No hay municipio para esta ciudad</option>";
                }
                
                
                echo $html;

            } catch (PDOException $e) {
               
                error_log("Database Error in fetch_municipio.php: " . $e->getMessage());
                echo "<option value=''>Error al cargar los municipios</option>"; 
            } finally {
              
                $pdo = null;
            }
        } else {
           
            echo "<option value=''>Seleccione un municipio</option>";
        }
?>
    
