<?php

        
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        
        require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php"; 

        if (isset($_POST['id_estado'])) {
            try {
                $estado = $_POST['id_estado'];

            
                $query = $pdo->prepare("SELECT ID_STATE, CITY FROM table_city WHERE ID_STATE = :id ORDER BY CITY ASC");
                
                
                $query->bindValue(':id', $estado, PDO::PARAM_INT); 
              
                $query->execute();

                
                $html = "<option value='0'>Seleccionar Una Ciudad</option>";

                
                if ($query->rowCount() > 0) {
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        
                        $html .= "<option value='" . htmlspecialchars($row['ID_STATE']) . "'>" . htmlspecialchars($row['CITY']) . "</option>";
                    }
                } else {
                    $html .= "<option value=''>No hay ciudades para este estado</option>";
                }
                
                
                echo $html;

            } catch (PDOException $e) {
                
                error_log("Database Error in fetch_ciudad.php: " . $e->getMessage());
                echo "<option value=''>Error al cargar ciudades</option>"; 
            } finally {
             
                $pdo = null;
            }
        } else {
            
            echo "<option value=''>Seleccione un estado</option>";
        }
?>
