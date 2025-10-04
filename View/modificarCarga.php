<?php


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


        include ('config/abrir_conexion.php');

        $query_parentesco = "SELECT ID, parentesco FROM table_parentesco ";
        $parentesco1 = mysqli_query($conexion,$query_parentesco);

        $IDcarga = $_POST['id'];
        $querycarga = "SELECT * FROM carga_familiar WHERE ID = $IDcarga";
        $carga = mysqli_query($conexion,$querycarga);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/select2.js"></script>
</head>
<body class="bg-light">
      <!-- INICIA LA COLUMNA -->
    <h1 class="text-center p-3">Modificar Carga familiar</h1>
    <div class="container-fluid row">
<!--Campo nucleo familiar relacionado al CNE-->
      <form class="col-4 p-3 m-auto" method="POST">
        <input type="hidden" name="IDcarga" value="<?= $_POST['id']?>">
        <?php
        if (isset($_POST['btn_actualizar'])) {
            if (!empty($_POST['ced-persona']) and !empty($_POST['parentesco']) and !empty($_POST['fecha-nacimiento']) and !empty($_POST['nombre-parentesco']) and !empty($_POST['apellido-parentesco']) ) {
                $IDupdate = $_POST['IDcarga'];
                $ced_persona = $_POST['ced-persona'];
                $parentesco = $_POST['parentesco'];
                $fecha_nacimiento = $_POST['fecha-nacimiento'];
                $edad = $_POST['edad'];
                $cedula_parentesco = $_POST['cedula-parentesco'];
                $nombre_parentesco = $_POST['nombre-parentesco'];
                $sexo = $_POST['sexo'];
                $Sqlquery = "UPDATE carga_familiar SET
                ced_persona = '$ced_persona',
                parentesco = '$parentesco',
                fecha_nacimiento = '$fecha_nacimiento',
                edad = '$edad',
                cedula_carga_familiar = '$cedula_parentesco',
                nombre_carga_familiar = '$nombre_parentesco',
                sexo = '$sexo'
                
                WHERE ID = $IDupdate";
                $result = mysqli_query($conexion,$Sqlquery);

                if($result == 1){
                    header("location:registro_cargafamiliar.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al modificar los registros</div>";
                }
            }else{
                echo "<div class='alert alert-warning'>El unico campo opcional es la cedula de la carga familiar</div>";
            }
        }
    ?>
          <h4>Carga Familiar del Funcionario </h4>
          <?php
          while($row=$carga->fetch_object()) { ?>
            <!--- Campo Cedula de persona ---->
          <div class="mb-1">
              <label for="ced-persona">Documento de identidad del funcionario :</label>
          <!--pattern indica que tipo de patron quieres que el usuario use al momento de llenar el input y al agregar un + fuera del rango estamos indicando que los numeros pueden repetirse-->
              <input type="text" disabled value="<?= $row->ced_persona?>" >
              <hr>
              <input type="text" class="form-control" required name="ced-persona" placeholder="Ingrese la cedula del funcionario"  autocomplete="off" id="ced-persona" minlength="7" maxlength="8" pattern="[0-9]+" title = "Indique numero de cedula . use solo numeros">
          </div>
          <!---Campo parentesco del funcionario---->
          <h6 for="parentesco">¿Cual es el parentesco de la persona con el funcionario?</h6>
          <div class="form-selected">
            <label>Parentesco con el funcionario : </label>
            <input type="text" disabled value="<?= $row->parentesco?>">
            <hr>
            <select name="parentesco" id="parentesco">
              <option value="">Seleccione una opcion</option>
              <?php while ($row1 = $parentesco1->fetch_assoc()) { ?>
                <option value="<?php echo $row1['parentesco'];?>"><?php echo $row1['parentesco'];?></option>
                <?php } ?>
            </select>
          </div> 
          <br>
          <!--Campo fecha de nacimiento-->
          <div class="mb-1">
              <label for="fecha-nacimiento">fecha de nacimiento </label>
              <input type="date" value="<?= $row->fecha_nacimiento?>" name="fecha-nacimiento" class="form-control" id="fecha-nacimiento">
          </div>
          <!-- Campo Edad -->
          <div class="mb-3">
              <label for="edad">Edad</label>
              <input type="text" value="<?= $row->edad?>" name="edad" class="form-control" id="edad">
          </div>
          <!--Campo cedula carga familiar-->
          <div class="mb-1">
              <h6>Datos del pariente </h6>
              <p>Cedula de identidad</p>
              <input type="text" class="form-control" value="<?= $row->cedula_carga_familiar?>" name="cedula-parentesco" id="cedula-parentesco" minlength="7" maxlength="8" >
          </div>
          <!--- Campo nombre carga familiar -->
          <div class="mb-1">
              <p>Nombre</p>
              <input type="text" class="form-control" value="<?= $row->nombre_carga_familiar?>" name="nombre-parentesco" id="nombre-parentesco" maxlength="25" >
          </div>
          <br>
          <!---Campo sexo del familiar --->
            <div class="form-control">
                <strong><label for="sexo"> Genero del familiar</label></strong>
                    <select class="form-select " name="sexo" id="sexo">
                        <option value="<?php $sexo;?>">Seleccione el Genero</option>
                        <option value="femenino">Femenino</option>
                        <option value="masculino">Masculino</option>
                    </select>
            </div>
          <br>
          <!--Campo Buttons-->
          <div class="mb-1">
              <input type="submit" value="Actualizar"  class="btn btn-warning" name="btn_actualizar">
          </div>
          <?php }
          ?>
      </form>
    </div>
</body>
</html>

