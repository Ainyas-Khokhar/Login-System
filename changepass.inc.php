

<?php
session_start();

if($_SERVER['REQUEST_METHOD']  ==  'POST'){

    if(isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])){

        $old     =  $_POST['oldPassword'];
        $new     =  $_POST['newPassword'];
        $confirm =  $_POST['confirmPassword'];

    }

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

        header("Location: login.php");
        exit();
    }

    if($new  ==  $confirm){
        // $confirmHash = password_hash($confirm,PASSWORD_DEFAULT);

        require_once "dbh.inc.php";
    $query1 = " SELECT email,username,password_hash,user_role FROM users WHERE id=? LIMIT 1; ";
    $stmt1  = $pdo->prepare($query1);
    $stmt1 -> execute([$_SESSION['user_id']]);
    $users = $stmt1 -> fetch(PDO::FETCH_ASSOC);



        try {

                if($users && password_verify($old,$users['password_hash'])){

                    $confirmHash = password_hash($confirm,PASSWORD_DEFAULT);

                    $query  =  "UPDATE users SET password_hash =? WHERE id =? ;";
                    $stmt   =  $pdo->prepare($query);
                    $stmt  -> execute([$confirmHash,$_SESSION['user_id']]);

                    echo "password changed";
                }
                else{
                    echo "Password not changed.";
                    // print_r($_SESSION);
                }
                
        } catch (PDOException $e) {
            die("Query Failed". $e->getMessage());
        }

    }
    else{
        echo "password doesn't match.";
    }
    
}
else{
    echo "All fields are reqired.";
}