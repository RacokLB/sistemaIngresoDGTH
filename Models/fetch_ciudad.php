<?php
//aqui creamos un script para hacer la consulta a la tabla de ciudad 
require "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";

$ciudad = $_POST['ID_ciudad']; 
echo $ciudad;
$query = $pdo->prepare("SELECT ID, ID_STATE, municipios FROM tabla_municipios WHERE ID_STATE = ':id'");
$query->bindParam(param:':id',var:$ciudad);
$query->execute();

$html = "<option value ='0'>Seleccionar un Municipio</option>";

while($row = $query->fetch(PDO::FETCH_ASSOC))
{
    $html.="<option value='".$row['ID'].$row['municipios']."</option>";

}
echo $html;
?>