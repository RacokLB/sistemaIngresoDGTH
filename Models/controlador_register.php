<?php
//llamamos a la conexion que establecimos con la base de datos
require_once "/xampp/htdocs/sistemaIngresoDGTH/Config/abrir_conexion.php";

    //aqui indicamos que queremos hacer al momento de que el usuario presione el boton registrarse el name del button es 'registerbtn'
    if(isset($_POST['registerbtn'])) {
        
    //aqui revisamos si los campos estan llenos para continuar con el envio de la informacion , estamos diciendo si el campo 'user' es mayor o igual a 1 es True en php && indica true , aparte hacemos uso de la funcion strlen que nos devuelve la longitud de una cadena determinada de string  
        if(isset($_POST['cedula_identidad']) && isset($_POST['password']) && strlen($_POST['cedula_identidad']) <= 8 && strlen($_POST['password']) >= 4)
        {  
    
            
            
            // usamos la funcion trim para eliminar espacio entre los datos introducidos por el usuario
            $cedula = trim($_POST['cedula_identidad']);
         
            //Verificamos que la cedula no exista dentro de la DB , antes de hacer la creacion del User
            $sql = "SELECT * FROM users WHERE user = :cedula";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":cedula",$cedula,PDO::PARAM_INT);
            $stmt->execute();

            //Agregamos un condicional para corroborar if existe el user redirigir al login.php
            if($stmt == true){

                echo 
                    "    
                        <div class='alert alert-danger' role='alert'>El Usuario ya se encuentra Registrado</div>
                        
                        <a href='../View/login.php' class='fs-4 bg-dark'>Click aqui para ir al login</a>
                    ";
                        
                    
                exit();
            //Aqui se hace la query para la creacion del User 
            }else{
                $password = trim($_POST['password']);
                //convertimos el password con la funcion password_hash y PASSWORD_DEFAULT
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $ip = $_SERVER['REMOTE_ADDR'];
                $cambio = trim($_POST['registerbtn']);

                $query = $pdo->prepare("INSERT INTO users (user, clave, ip, cambio) VALUES (:user, :clave, :ip, :cambio)");
                $query->bindParam(param:":user",var:$cedula);
                $query->bindParam(param:":clave",var:$hashed_password);
                $query->bindParam(param:":ip",var:$ip);
                $query->bindParam(param:":cambio",var:$cambio);
                
                $query->execute();
                
                if ($query == true) {
                    
                    echo "<h5 id='success'>Creacion Exitosa</h5>
                            <div class='d-flex justify-content-center'>
                                <div class='spinner-border text-info' role='status'>
                                    <span class='visually-hidden'>Redirigiendo a login</span>
                                </div>
                            </div>";
                            sleep(seconds: 2);
                    header(header: "location: ../View/login.php");
                    exit();
                    } else {
                        echo "<h5 id='error'>Verifique su Usuario y la contraseña ingresada</h5>";
                    }
            }
        }       
    }
    
?>