<?php
        
    require_once "../Config/abrir_conexion.php";
   

        if(isset($_POST['modificacionBtn'])){

            
            
                if(isset($_POST['user']) && isset($_POST['password'])){

                    $cedula = trim($_POST['user']);
                    $passwordModificado = trim($_POST['password']);
                    $hashed_password = password_hash($passwordModificado, PASSWORD_DEFAULT);
                    $cambio = trim($_POST['modificacionBtn']);
                    $sql = "UPDATE users SET clave = :clave, cambio = :accion WHERE user = :user LIMIT 1";
                        
            
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':user', $cedula);
                    $stmt->bindValue(':clave', $hashed_password);
                    $stmt->bindValue(':accion', $cambio);
                    $stmt->execute();

                    if($stmt == true){
                    echo " <h5 id='success'>Modificacion Exitosa</h5>
                        <h6 class='fw-bold'>Ir al <a href='../View/login.php'>Login</a></h6>
                            ";
                            sleep(seconds: 1);
                        
                        exit();
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                                <span >Hubo un error al momento de realizar la modificacion</span>
                                </div> ";
                    }
                        
                    
                }else{
                    echo "<div class='alert alert-danger' role='alert >
                            <h5>Los parametros que deben ser otorgados , no se han encontrado</h5>
                        </div>";
                }
        }

?>
