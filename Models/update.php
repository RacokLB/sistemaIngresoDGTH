<?php

if(isset($_POST['btn_actualizar']))
      {
        $botton_update = $_POST['btn_actualizar'];
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
        $estado = $_POST['estado'];
        $ciudad = $_POST['ciudad'];
        $municipio = $_POST['municipio'];
        $parroquia = $_POST['parroquia'];
        $direccion = $_POST['direccion'];
        $tipo_trabaj = $_POST['tipo-trabaj'];
        $cod_cargo = $_POST['cod_cargo'];
        $cod_ubica = $_POST['cod_ubica'];
        $cod_ubicaf = $_POST['cod_ubicaf'];
        $tipo_discapacidad = $_POST['tipo-discapacidad'];
        $conapdis_funcionario = $_POST['conapdis-funcionario'];
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
        

        if($ced_persona == "")
        {
          echo "<h5 class='alert alert-danger''> La cedula es un campo obligatorio </h5>" ;
        }
        else
        {
          //ACTUALIZAR 
          $_UPDATE_SQL="UPDATE $tabla Set 
          ced_persona='$ced_persona',
          rif='$rif',
          tipo_trabaj='$tipo_trabaj', 
          apellidos ='$apellidos',
          nombres ='$nombres',
          cod_cargo ='$cod_cargo',
          niveles = '$niveles',
          numero_contacto ='$numero_contacto',
          fecha_ing = '$fecha_ing',
          fecha_nac = '$fecha_nac',
          ID_sexo ='$id_sexo',
          ID_estado = '$estado',
          ID_ciudad = '$ciudad',
          ID_municipio = '$municipio',
          ID_parroquia = '$parroquia',
          cod_ubica = '$cod_ubica',
          cod_ubicaf = '$cod_ubicaf',
          presenta_discapacidad ='$presenta_discapacidad',
          pension_sobreviviente = '$pension_sobreviviente',
          familia_parte_cne ='$familia_parte_cne',
          padres_comun_cne = '$padres_comun_cne'


          WHERE ced_persona ='$ced_persona'"; 

          $actualizacion = mysqli_query($conexion,$_UPDATE_SQL);
          
          $UPDATE_SQL0 = "UPDATE direccion_funcionario Set
          ced_persona = '$ced_persona',
          direccion = '$direccion'
          
          WHERE ced_persona = '$ced_persona'";

          $actualizacion0 = mysqli_query($conexion,$UPDATE_SQL0);
          
          $UPDATE_SQL1 = "UPDATE $tabla1 Set
          tipo_discapacidad='$tipo_discapacidad',
          conapdis_funcionario='$conapdis_funcionario'
          
          WHERE ced_persona = '$ced_persona'";

          $actualizacion1 = mysqli_query($conexion,$UPDATE_SQL1);

          $UPDATE_SQL2 = "UPDATE $tabla2 Set
          ced_causante = '$ced_causante',
          nombre_causante = '$nombre_causante',
          apellido_causante = '$apellido_causante'
          
          WHERE ced_persona = '$ced_persona'";

          $actualizacion2 = mysqli_query($conexion,$UPDATE_SQL2);

          $UPDATE_SQL3 = "UPDATE $tabla3 Set
          titulo='$titulo',
          grado_instruccion = '$grado_instruccion',
          institucion_educativa='$institucion_egreso',
          profesion='$profesion',
          curso_reciente='$curso_realizado'
          
          WHERE ced_persona = '$ced_persona'";

          $actualizacion3 = mysqli_query($conexion,$UPDATE_SQL3);

          $UPDATE_SQL4 = "UPDATE $tabla4 Set
          deporte='$deporte'
          
          WHERE ced_persona = '$ced_persona'";

          $actualizacion4 = mysqli_query($conexion,$UPDATE_SQL4);
          
          $insertbutton = "INSERT INTO users (cedula_identidad,ip,email,cambio)
            VALUES
            ('$user_cedula','$ip','$user_email','$botton_update')";
          
          $resultados8 = mysqli_query($conexion,$insertbutton);
        }echo "<h4 class='alert alert-success''> La Modificacion fue realizada con exito </h5>" ;
      }

      
        if(isset($_POST['btn_salir']))
        {
          $btn_salir = $_POST['btn_salir'];
          $user_cedula = $_SESSION['cedula_identidad'];
          $ip = $_SERVER['REMOTE_ADDR'];
          $user_email = $_SESSION['email'];
          if($btn_salir == true)
          {
            $insertbutton = "INSERT INTO users (cedula_identidad, ip, email, cambio)
            VALUES
            ('$user_cedula','$ip','$user_email','$btn_salir')";

            $resultados9 = mysqli_query($conexion,$insertbutton);
          }
          else 
            echo "<h5 class='alert alert-danger''> ohh.NOOOO....Ha ocurrido un error al intentar cerrar la sesion </h4>" ;
        }

?>