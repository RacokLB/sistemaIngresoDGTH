<?php

    require "POOConexion.php";

    $database = new Database();
    $pdo = $database->getPDO();
    $error = $database->getError();

    if(!$pdo){
        die ("No fue posible establecer la conexion con la base de datos" . $database->getError());
    }



?>