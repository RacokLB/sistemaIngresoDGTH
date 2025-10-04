<?php
//en este script creamos una consulta a la base de datos para traer las parroquias
require "/xampp/htdocs/login23.9.24/Config/abrir_conexion.php";

$parroquia = $_POST['id_parroquia'];

$query = $pdo->prepare("SELECT ID, ID_municipio, parroquias FROM tabla_parroquias WHERE ID_municipio = ':id");
$query->bindParam(param:':id',var:$parroquia);
$query->execute();

$html = "<option value='0'>Seleccionar una Parroquia</option>";

while($row = $resultado->fetch_assoc())
{
    $html.="<option value='".$row['ID'].$row['parroquias']."</option>";

}
echo $html;
?>
