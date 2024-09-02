

<?php 
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    $email   = $_POST['deleteEmail'];
    $password = $_POST['deletePassword'];

        try {
            require_once "dbh.inc.php";

            $query1 = " SELECT email,username,password_hash,user_role,profile_pic FROM users WHERE id=? LIMIT 1; ";
            $stmt1  = $pdo->prepare($query1);
            $stmt1 -> execute([$_SESSION['user_id']]);
            $users = $stmt1 -> fetch(PDO::FETCH_ASSOC);


                if( $users['email'] ==  $email && $users && password_verify($password,$users['password_hash'])){

                $query  =  "DELETE FROM users WHERE id=?;";
                $stmt   =  $pdo->prepare($query);
                $stmt  -> execute([$_SESSION['user_id']]);

                session_unset();
                session_destroy();

                header("Location:index.php");
                exit();

                echo "Account Deleted";

                }
        } catch (PDOException $e) {
            die("Query Failed".$e->getMesage());
        }
}