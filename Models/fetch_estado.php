<?php
    //en este script creamos una consulta a la base de datos en la tabla estados 
    require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";

    $query = $pdo->prepare(query:"SELECT ID_STATE, CITY  FROM table_city");
    $query->execute();
    
    $resultado = $query->fetchAll(mode:PDO::FETCH_ASSOC);
    print_r($resultado);    


    if(isset($_POST['id_estado'])){
        try{
            $estado = $_POST['id_estado'];
            $query = $pdo->prepare("SELECT ID_STATE, CITY FROM table_city WHERE ID_STATE = ':id'");
            $query->bindParam(param:':id',var:$estado);
            $query->execute();
    
            $html = "<option value='0'>Seleccionar Una Ciudad</option>";
    
            while($row = $query->fetch(mode:PDO::FETCH_ASSOC))
            {
                $html.="<option value='".$row['ID_STATE'].$row['CITY']."</option>";
    
            }
            echo $html;

        }catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>Error: No se encontraron datos</div>".$e->getMessage();
        }finally{
            $pdo = null;
            }
        }else{
            echo "NO SE HA RECIBIDO NADA DEL SCRIPT ";
        }

    
?>