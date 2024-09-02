
<?php
 session_start();

 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

    header("Location: login.php");
    exit();
}

 if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $action  =  $_POST['action'];
    $id      =  $_POST['userid'];
        try{
            require_once "dbh.inc.php";

    if($action == 'delete'){

        $query  =   "DELETE FROM users WHERE id=?;";
        $stmt   =   $pdo->prepare($query);
        $stmt   ->  execute([$id]);


        header("Location:showusers.php");
        echo"hello";

    }
        }catch(PDOException $e){
            die("Query Failed".$e->getMessage());
        }
 }