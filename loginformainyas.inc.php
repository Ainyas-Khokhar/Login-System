

<?php
session_start();
//==================================================================================================

    if($_SERVER['REQUEST_METHOD']=="POST"){

        if(isset($_POST['email']) && isset($_POST['password'])){
            $email    =   trim($_POST['email']);
            $password =   trim($_POST['password']);
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            die("Invaid_Email");
        }

        if(empty($email) || empty($password)){
            die("Credentials are required.");
        }

//==================================================================================================

        try{
            require_once "dbh.inc.php";

        $query = " SELECT id,username,password_hash,user_role FROM users WHERE email=? LIMIT 1; ";
        $stmt  = $pdo->prepare($query);
        $stmt -> execute([$email]);

        $users = $stmt -> fetch(PDO::FETCH_ASSOC);

        if($users){
                if(password_verify($password,$users['password_hash'])){

                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id']   = $users['id'];
                    $_SESSION['username']  = $users['username'];
                    $_SESSION['email']     = $email;
                    $_SESSION['user_role'] = $users['user_role'];
            
                     
                    header("Location: content.php");
                    exit();
                }
                else{
                    header("Location:login.php?error=invalid_credentials");
                    exit();
                }
        }
        else{

            header("Location:login.php?error=invalid_credentials");
            exit();
        }
        }catch(PDOException $e){
            die("Query Failed".$e->getMessage());
        }
    }
    else{
        header("Location:login.php");
        exit();
    }