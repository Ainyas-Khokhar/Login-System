
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

   header("Location: login.php");
   exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

   $action  =  $_POST['action'];
   $id      =  $_POST['taskid'];
       try{
           require_once "dbh.inc.php";

   if($action == 'delete'){

       $query  =   "DELETE FROM userActivity WHERE taskId=?;";
       $stmt   =   $pdo->prepare($query);
       $stmt   ->  execute([$id]);


       header("Location:showtask.php");
       echo"hello";

   }
       }catch(PDOException $e){
           die("Query Failed".$e->getMessage());
       }
}