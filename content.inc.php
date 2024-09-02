


<?php
session_start(); 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    header("Location: login.php");
    exit();
}

if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == true) {
   
    try{
        require_once "dbh.inc.php";

    $query = " SELECT id,username,password_hash,user_role,profile_pic FROM users WHERE email=? LIMIT 1; ";
    $stmt  = $pdo->prepare($query);
    
    $users = $stmt -> fetch(PDO::FETCH_ASSOC);

    if($users){
            if(password_verify($password,$users['password_hash'])){
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id']   = $users['id'];
                $_SESSION['username']  = $users['username'];
                $_SESSION['email']     = $email;
                $_SESSION['user_role'] = $users['user_role'];
                $_SESSION['profile_pic']= $users['profile_pic'];
        
                header("Location: content.php");
                exit();
            }
    }
    }
    catch(PDOException $e){
        die("Query Failed".$e->getMessage());
    }

}
