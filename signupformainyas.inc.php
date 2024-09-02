

<?php 

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

        $username  =  trim($_POST['username']);
        $email     =  trim($_POST['email']);
        $password  =  trim($_POST['password']);

    } 

    if( !filter_var($email,FILTER_VALIDATE_EMAIL) ){
        die("Invalid email format");
    }

    $passwordHash  =  password_hash($password,PASSWORD_DEFAULT);

    try{
        require_once "dbh.inc.php";

        $query  =  " INSERT INTO users (username,email,password_hash) VALUES (?,?,?); ";
        $stmt   =  $pdo->prepare($query);
        $stmt -> execute([$username,$email,$passwordHash]);

        $_SESSION['signed_in'] = true;
        $_SESSION['username']  = $username;
        $_SESSION['email']     = $email;

        header("Location: login.php");
        exit();

    }catch(PDOException $e){
        header("Location: index.php?error=User_already_exsists");
        // exit();
        die("Query Failed" . $e -> getMessage());
    }

}
else{

    header("Location:signup.php");
    exit();
}