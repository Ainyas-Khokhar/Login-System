

<?php  

session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {

        header("Location: login.php");
        exit();
    }
    if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == true) {

        if(isset($_POST['title']) && isset($_POST['description']) && $_POST['status'] ){
            $title        =   trim($_POST['title']);
            $description  =   trim($_POST['description']);
            $userid       =   $_SESSION['user_id'];
            $status       =   $_POST['status'];
            $taskid       =   $_SESSION['taskId'];
        }
        else{

            echo"Fill all the Fields.";
        }

        try{
            require_once "dbh.inc.php";
    
        $query =  "INSERT INTO userActivity (title, description, userId,status) VALUES (?, ?,?, ?);";
        $stmt  =  $pdo->prepare($query);
        $stmt->execute([$title, $description, $userid,$status]);
    
            header("Location: addtask.php");
        }
        catch(PDOException $e){
            die("Query Failed".$e->getMessage());
        }
    } 

}
else{
    header("Location:content.php");
    exit();
}