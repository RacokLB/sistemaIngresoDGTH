<?php

if(isset($_POST['btn_enviar']))
      {
        $send = $_POST['btn_enviar'];
        $user_cedula = $_SESSION['cedula_identidad'];
        $user_email = $_SESSION['email'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $ced_persona = $_POST['ced-persona'];
        $rif = $_POST['rif'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $id_sexo = $_POST['id-sexo'];
        $numero_contacto = $_POST['numero-contacto'];
        $fecha_nac = $_POST['fecha-nac'];
        $fecha_ing = $_POST['fecha-ing'];
        $estados = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $municipio = $_POST['municipio'];
        $parroquia = $_POST['parroquia'];
        $direccion = $_POST['direccion'];
        $tipo_trabaj = $_POST['tipo-trabaj'];
        $cod_cargo = $_POST['cod_cargo'];
        $cod_ubica = $_POST['cod_ubica'];
        $cod_ubicaf = $_POST['cod_ubicaf'];
        $presenta_discapacidad = $_POST['presenta-discapacidad'];
        $tipo_discapacidad = $_POST['tipo-discapacidad'];
        $conapdis_funcionario = $_POST['conapdis-funcionario'];
        $pension_sobreviviente = $_POST['pension-sobreviviente'];
        $ced_causante = $_POST['cedula-causante'];
        $nombre_causante = $_POST['nombre-causante'];
        $apellido_causante = $_POST['apellido-causante'];
        $titulo = $_POST['titulo'];
        $grado_instruccion = $_POST['grado-instruccion'];
        $institucion_egreso = $_POST['institucion-egreso'];
        $profesion = $_POST['profesion'];
        $curso_realizado = $_POST['curso-realizado'];
        $deporte = $_POST['deporte'];
        $familia_parte_cne = $_POST['familia-parte-cne'];
        $padres_comun_cne = $_POST['padres-comun-cne']; 
        
        if($ced_persona == ""||$nombres==""||$apellidos == "")
        {
          echo "<h5 class='alert alert-danger''> El campo cedula, nombre, apellido, sexo, fecha de nacimiento, y fecha de ingreso no pueden estar vacios </h5>";
        }
        else
        {
          
          $query = "INSERT INTO $tabla (ced_persona,rif,tipo_trabaj,apellidos,nombres,cod_cargo,numero_contacto,fecha_ing,fecha_nac,ID_sexo,ID_estado,ID_ciudad,ID_municipio,ID_parroquia,cod_ubica,cod_ubicaf,presenta_discapacidad,pension_sobreviviente,familia_parte_cne,padres_comun_cne)
          VALUES
          ('$ced_persona','$rif','$tipo_trabaj','$apellidos','$nombres','$cod_cargo','$numero_contacto','$fecha_ing','$fecha_nac','$id_sexo','$estados','$ciudad','$municipio','$parroquia','$cod_ubica','$cod_ubicaf','$presenta_discapacidad','$pension_sobreviviente','$familia_parte_cne','$padres_comun_cne')";
          $resultados = mysqli_query($conexion,$query);

          $querydireccion = "INSERT INTO direccion_funcionario (ced_persona, direccion)
          VALUES
          ('$ced_persona','$direccion')";
          $resultdireccion = mysqli_query($conexion,$querydireccion);
          
          //insert into de la tabla discapacidad funcionario
          $query1 = "INSERT INTO $tabla1 (ced_persona, tipo_discapacidad, conapdis_funcionario)
            VALUES
            ('$ced_persona', '$tipo_discapacidad', '$conapdis_funcionario')";
          $resultados1 = mysqli_query($conexion,$query1);
            
          //insert into de la tabla sobreviviente
          $query2 = "INSERT INTO $tabla2 (ced_persona, ced_causante, nombre_causante, apellido_causante)
            VALUES
            ('$ced_persona','$ced_causante','$nombre_causante','$apellido_causante')";
          $resultados2 = mysqli_query($conexion,$query2);
            
            //insert into de la table instruccion
          $query3 = "INSERT INTO $tabla3 (ced_persona, grado_instruccion, titulo, institucion_educativa, profesion, curso_reciente)
            VALUES
            ('$ced_persona','$grado_instruccion','$titulo','$institucion_egreso','$profesion','$curso_realizado')";
            $resultados3 = mysqli_query($conexion,$query3);
          
          $query4 = "INSERT INTO $tabla4 (ced_persona, deporte)
            VALUES
            ('$ced_persona','$deporte')";
          $resultados4 = mysqli_query($conexion,$query4);
            
          $query7 = "INSERT INTO users (cedula_identidad, ip, email, cambio)
            VALUES
            ('$user_cedula','$ip','$user_email','$send')";
          $resultados7 = mysqli_query($conexion,$query7);
          echo "<h5 class='alert alert-success'> REGISTRO REALIZADO </h5>";
          
        }
      
      }
?>