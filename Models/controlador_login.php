<?php


    session_start();

        if(isset($_SESSION['rol'])){
            switch ($_SESSION['rol']){

                case 1:
                    sleep(2);
                    header("location: ../View/principalPagina.php");
                    exit();
                    break;
                case 2:
                    header("location: ../View/principalPagina.php");
                    exit();
                    break;
                default:
                    header("location: ../View/login.php");
                    exit();
                    break;
            }
        }
        

//Aqui indicamos que va a suceder cuando se valide que se presiono el boton signupboton.
    if(isset($_POST['signupbtn'])){

        require_once "../Config/abrir_conexion.php";

     
       
        if (isset($_POST["user"]) && strlen($_POST['user']) >= 6 && strlen($_POST['user']) <= 8 && isset($_POST["password"])) {
            
            $user = $_POST["user"];
           
            $password = $_POST["password"];
            
           
            $query = $pdo->prepare("SELECT id, clave, rol FROM users WHERE user = :user");
            $query->bindParam(param:':user',var:$user);
            $query->execute();
            $user_data = $query->fetch(PDO::FETCH_ASSOC);
            
       
            if($user_data){
                $hash = $user_data['clave'];
              
                
               
                
                if(password_verify(password: $password, hash: $hash)){
                   
                    try{
                        $query_role = $pdo->prepare(query:"SELECT id, user, rol FROM users WHERE user = :user");
                        $query_role->bindParam(param:':user',var:$user);
                        $query_role->execute();
                        $user_role_data = $query_role->fetch(mode:PDO::FETCH_ASSOC);
                        
                        
                      
                        if($user_role_data){
                            
                                $rol = $user_role_data['rol'];
                                $cedula = $user_role_data['user'];
                               
                                $_SESSION['rol']= $rol;
                                $_SESSION['user']= $cedula;
        
                                switch ($_SESSION['rol']){
        
                                    case 1:
                                        header("location: ../View/principalPagina.php");
                                        exit();
                                        break;
                                    case 2:
                                        header("location: ../View/principalPagina.php");
                                        exit();
                                        break;
                                    default:
                                        header("location: ../View/login.php");
                                        exit();
                                        break;
                                }
                            }
                        }catch(PDOException $e){
                            echo "<div class='alert alert-danger' role='alert'>Error: Hay datos que no coinciden </div>".$e->getMessage();
                        }finally{
                            $pdo = null;
                            echo "RIGHT";
                        }
                               
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>Contraseña incorrecta</div>";
                    }
                    
                }else{
                    echo "<div class='alert alert-danger' role='alert'>no coinciden las contraseñas</div>";
                }
                
            }
                
        }else{
            echo "<div class='alert alert-warning' role='alert'>Minimo son 6 digitos el usuario</div>";
        }
    
?>
