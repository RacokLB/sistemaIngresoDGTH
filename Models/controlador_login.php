<?php
//we call the connection we established with the database

    session_start();

        if(isset($_SESSION['rol'])){
            switch ($_SESSION['rol']){

                case 1:
                    sleep(2);
                    header("location: index.php");
                    exit();
                    break;
                case 2:
                    header("location: view/registro.php");
                    exit();
                    break;
                default:
                    header("location: login.php");
                    exit();
                    break;
            }
        }
        

//Here we indicate what we want to do when the login button that has name="signupbtn" is pressed.
    if(isset($_POST['signupbtn'])){

        require_once "config/abrir_conexion.php";

     
        //Here we indicate what we are going to do when we enter the user and password data, we also indicate what will be reflected in case no data is entered within the fields
        if (isset($_POST["user"]) && strlen($_POST['user']) >= 6 && strlen($_POST['user']) <= 8 && isset($_POST["password"])) {
            //Here the data extracted from the global variable $_POST is stored in our local variables $user, $password 
            $user = $_POST["user"];
           
            $password = $_POST["password"];
            
            //the object this query is verificate user exits in the database
            $query = $pdo->prepare("SELECT id, clave, rol FROM users WHERE user = :user");
            $query->bindParam(param:':user',var:$user);
            $query->execute();
            $user_data = $query->fetch(PDO::FETCH_ASSOC);
            print_r($user_data);
            //if the user exits catch the clave from the database
            if($user_data){
                $hash = $user_data['clave'];
                echo $hash; 
                
                //verification the password vs hash password in the database and if have match
                
                if(password_verify(password: $password, hash: $hash)){
                   
                    try{
                        $query_role = $pdo->prepare(query:"SELECT id, user, rol FROM users WHERE user = :user");
                        $query_role->bindParam(param:':user',var:$user);
                        $query_role->execute();
                        $user_role_data = $query_role->fetch(mode:PDO::FETCH_ASSOC);
                        print_r($user_role_data);
                        
                        // catch the user and rol and store into $_SESSION
                        if($user_role_data){
                            
                                $rol = $user_role_data['rol'];
                                $cedula = $user_role_data['user'];
                                //insert into $_SESSION the data from the user for display in the index page
                                $_SESSION['rol']= $rol;
                                $_SESSION['user']= $cedula;
        
                                switch ($_SESSION['rol']){
        
                                    case 1:
                                        header("location: index.php");
                                        exit();
                                        break;
                                    case 2:
                                        header("location: view/registro.php");
                                        exit();
                                        break;
                                    default:
                                        header("location: login.php");
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