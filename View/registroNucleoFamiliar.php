<?php
/*
//here we open the session from the user
    session_start();
    //here we verified if the field "id" is empty the user cannot enter into the index page 
    if (!isset($_SESSION['rol'])){
        header("location: login.php");
    }else{
        if($_SESSION['rol'] != 2){  
            header("location: login.php");
        }
    }
*/
?>
<!DOCTYPE html>
<html lang="es">
<form action="index.php" >
    <input type="submit" value="Salir" class="btn-lg btn-secondary" name ="btn_final">
</form>
<?php
    echo  "<table class='table'><thead><tr><th scope='col'></th>"."<th scope='col'>ID : ".$_SESSION["id"]."</th>"."<th scope='col'>Cedula Identidad : ".$_SESSION["cedula_identidad"]."</th>"."</thead></table>";
?>
<head>
  <title>Instrumento CNE</title>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  
</head>

<div class="col-md-2">
  <div class="rounded card text-bg-primary mb-3 bg-dark border border-3 border-warning" style="max-width: 18rem;">
    <div class="card-header text-white"><h5>Enlace a los otros modulos</h5></div>
    <div class="card-body">
      <p class="card-text"><a href="registro.php" class="nav-link active" aria-current="page">Registro Funcionario</a></p>
      <p class="card-text"><a href="registro_cargafamiliar.php" class="nav-link">Carga Familiar</a></p>
    </div>
  </div>
</div>

<body class="bg-light">

<div class="row">
  
  <!-- INICIA LA COLUMNA -->
    <div class="col-md-4"></div>
    <!--Campo nucleo familiar relacionado al CNE-->
    <div class="col-md-4">
      <center><h1 class="rounded-pill border border-3 border-warning text-center p-3 bg-dark text-white">Nucleo Familiar del Funcionario</h1></center>
      <br>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
    
    <form method="POST">
    
      <?php
        $inc = include ('db/abrir_conexion.php');
        $ced_persona = "";
        $estudios_cne = "";
        $familiar_discapacidad_cne = "";
        $conapdis_nucleo = "";
        $padres_comun_cne = "";
        $estatus_funcionario_cne = "";


        if(isset($_POST['btn_consultar']))
        {
            $existe = 0;
            if ($inc) {
                $ced_persona = $_POST['ced-persona'];
                $consulta = "SELECT * FROM nucleo_familiar WHERE ced_persona = '$ced_persona' ";
                $resultado = mysqli_query($conexion,$consulta);
                if ($resultado) {
                    while($row = $resultado->fetch_array()){

                    $estudios_cne = $row['estudios_cne'];
                    $familiar_discapacidad_cne = $row['familiar_discapacidad_cne'];
                    $conapdis_nucleo = $row['conapdis_nucleo'];
                    $padres_comun_cne = $row['padres_comun'];
                    $estatus_funcionario_cne = $row['estatus_funcionario'];
                    $existe ++;
                    }
                    if($existe ==0)
                    {
                        echo "<h5 class='alert alert-danger' >La CI ingresada no posee ningun registro dentro de la Base de datos 'Nucleo Familiar'</h5>";
                    }
                    if ($ced_persona=="") {
                        echo "<h5 class='alert alert-danger'>El campo documento de identidad funcionario no puede estar vacio</h5>";
                    }
                }            
            }
        }
?>
        <center>
        <input type="submit" value="Consultar" class="btn-lg btn-primary" name="btn_consultar">
        </center> 
        <br>
        <div class="mb-3">
            <label for="ced-persona">Documento de identidad del funcionario</label>
        <!--pattern indica que tipo de patron quieres que el usuario use al momento de llenar el input y al agregar un + fuera del rango estamos indicando que los numeros pueden repetirse-->
            <input type="text" required name="ced-persona" autocomplete="off" value="<?php echo @$ced_persona;?>" class="form-control" id="ced-persona" minlength="7" maxlength="8" pattern="[0-9]+" title = "Indique numero de cedula . use solo numeros">
        </div>

        <!---Persona de nucleo familiar activa o jubilada del CNE---->
        
        <!--Campo Estudia-->
        <label for="si-estudios-cne">¿El funcionario del nucleo familiar se encuentra cursando estudios?</label>
        <input type="text" disabled value="<?php echo $estudios_cne;?>">
        <div class="form-check">
            <label class="form-check-label" for="si-estudios-cne">
            <input class="form-check-input" value="Si" type="radio" name="estudios-cne" id="si-estudios-cne">Si
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="no-estudios-cne">
            <input class="form-check-input" value="No" type="radio" name="estudios-cne" id="no-estudios-cne" checked>No
            </label>
        </div>
        <!--Campo Discapacidad del funcionario del nucleo familiar-->
        <label for="si-discapacidad-cne">¿El funcionario dentro del nucleo familiar presenta algun tipo de discapacidad?</label>
        <input type="text" disabled value="<?php echo $familiar_discapacidad_cne;?>">
        <div class="form-check">
            <label class="form-check-label" for="si-discapacidad-cne">
            <input class="form-check-input" value="Si" type="radio" name="familiar-discapacidad-cne" id="si-discapacidad-cne">Si
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="no-discapacidad-cne">
            <input class="form-check-input" value="No" type="radio" name="familiar-discapacidad-cne" id="no-discapacidad-cne" checked> No
            </label>
        </div>
        <!--Campo carnet CONAPDIS del funcionario del nucleo familiar-->
        <div class="mb-3">
            <label for="conapdis-nucleo">Indique el numero del carnet CONAPDIS </label>
            <input type="text" name="conapdis-nucleo"  value="<?php echo $conapdis_nucleo;?>" class="form-control" id="conapdis-nucleo">
        </div>
        <!--Campo nucle familiar familiares jubilado o activo del cne-->
        <h4>Parentesco Interinstitucional por hijos en comun </h4>
        <p>¿El Padre o Madre de algunos de sus hijos
            es funcionario activo o jubilado del CNE?</p>
        <input type="text" disabled value="<?php echo $padres_comun_cne;?>">
        <div class="form-check">
            <label class="form-check-label" for="si-comun-cne">
            <input class="form-check-input" value="Si" type="radio" name="padres-comun-cne" id="si-comun-cne">Si
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="no-comun-cne">
            <input class="form-check-input" value="No" type="radio" name="padres-comun-cne" id="no-comun-cne" checked>No
            </label>
        </div>
        <hr>
        <!--Campo Estatus del familiar que trabaja dentro del CNE y forma parte del -->
        <div class="form-control">
        <input type="text" disabled  value="<?php echo $estatus_funcionario_cne;?>">
        <label for="estatus_funcionario_cne">¿Cual es el estatus del funcionario dentro del organismo?</label>
        <select class="form-select" name="estatus-funcionario-cne" id="estatus-funcionario-cne">
            <option value="0">Seleccione una opcion</option>
            <option value="REC">Rector</option>
            <option value="EMP">Empleado</option>
            <option value="OBR">Obrero</option>
            <option value="JUB">Jubilado</option>
        </select>
        </div>
        <br>
        <!--Campo Buttons-->
        <center>
            <input type="submit" value="Registrar" class="btn-lg btn-success" name ="btn_enviar">
            <input type="submit" value="Actualizar" class="btn-lg btn-warning" name ="btn_actualizar">    
        </center>
        <!--final de la seccion nucleo_familiar-->
    </form>
    </div>
</div>
</html>

<?php
    include('db/abrir_conexion.php');
    //we declared the variables
    $ced_persona="";
    $estudios_cne="";
    $familiar_discapacidad_cne="";
    $conapdis_nucleo="";
    $padres_comun_cne = "";
    $estatus_funcionario_cne="";


    if(isset($_POST['btn_enviar']))
    {
    $ced_persona = $_POST['ced-persona']; 
    $estudios_cne = $_POST['estudios-cne'];
    $familiar_discapacidad_cne = $_POST['familiar-discapacidad-cne'];
    $conapdis_nucleo = $_POST['conapdis-nucleo'];
    $padres_comun_cne = $_POST['padres-comun-cne'];
    $estatus_funcionario_cne = $_POST['estatus-funcionario-cne'];

        if ($ced_persona == "")
        {
            echo "<h5 class='alert alert-warning'> La cedula es un campo obligatorio para continuar con el registro";
        }
        else
        {
            $query = "INSERT INTO $tabla5 (ced_persona, estudios_cne, familiar_discapacidad_cne, conapdis_nucleo, padres_comun, estatus_funcionario)
            VALUES
            ('$ced_persona', '$estudios_cne', '$familiar_discapacidad_cne', '$conapdis_nucleo','$padres_comun_cne','$estatus_funcionario_cne')";
            $resultados6 = mysqli_query($conexion,$query);echo "<h4 class='alert alert-success text-center'> ¡Registro Exitoso!";
            
            
        }
        
    }


    if(isset($_POST['btn_actualizar']))
    {
    $ced_persona = $_POST['ced-persona'];
    $estudios_cne = $_POST['estudios-cne'];
    $familiar_discapacidad_cne = $_POST['familiar-discapacidad-cne'];
    $conapdis_nucleo = $_POST['conapdis-nucleo'];
    $padres_comun_cne = $_POST['padres-comun-cne'];
    $estatus_funcionario_cne = $_POST['estatus-funcionario-cne'];
        
        if ($ced_persona == "")
        {
            echo "<h5 class='alert alert-danger'> La cedula es un campo obligatorio para poder actualizar el formulario";
        }
        else
        {   
            $UPDATE_SQL = "UPDATE $tabla5 Set
            ced_persona = '$ced_persona',
            estudios_cne = '$estudios_cne',
            familiar_discapacidad_cne = '$familiar_discapacidad_cne',
            conapdis_nucleo = '$conapdis_nucleo',
            padres_comun = '$padres_comun_cne',
            estatus_funcionario = '$estatus_funcionario_cne'

            WHERE ced_persona = '$ced_persona'";

            $actualizacion = mysqli_query($conexion,$UPDATE_SQL);
            
            
        }echo "<h5 class='alert alert-success'> La modificacion de los datos ha sido exitosa";
    }
  

?>